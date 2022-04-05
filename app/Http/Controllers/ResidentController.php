<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Repositories\ResidentRepository;
use App\Resident;
use App\User;
use App\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResidentController extends ResidentRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = User::find(Auth::user()->id);
        
        if ($current_user->can('viewAny', Resident::class)) {
            $check_admin = $current_user->can('viewAny', User::class);
            //kiểm tra có p admin hay ko

            if (empty(request()->all()))
                $residents = $this->getPaginate10($check_admin ? 0 : $current_user->belongsToRole->ward_id);
            else
                $residents = $this->getFilter10($check_admin ? 0 : $current_user->belongsToRole->ward_id); 
            return view ('admin.resident.index', [
                'residents' => $residents,
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(empty(request()->query('province')) ? 0 : request()->query('province')),
                'wards' => $this->getActiveWards(empty(request()->query('district')) ? 0 : request()->query('district')),
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
                'email' => empty(request()->query('email')) ? '' : request()->query('email'),
                'level' => empty(request()->query('level')) ? '' : request()->query('level'),
                'province' => empty(request()->query('province')) ? '' : request()->query('province'),
                'district' => empty(request()->query('district')) ? '' : request()->query('district'),
                'ward' => empty(request()->query('ward')) ? '' : request()->query('ward'),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        } 
    }

    public function getDataWithTrashed () {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            $residents = $this->getResidentsWithTrashed();

            return view('admin.resident.trash', [
                'residents' => $residents,
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_user = User::find(Auth::user()->id);
        
        if ($current_user->can('create', Resident::class)) {
            return view ('admin.resident.create', [
                'nationalities' => $this->getActiveNationality(),
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(0),
                'wards' => $this->getActiveWards(0),
                'ethnics' => $this->getActiveEthnics(),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResidentRequest $request)
    {
        // dd($request->all());
        $current_user = User::find(Auth::user()->id);
        
        if ($current_user->can('create', Resident::class)) {
            if ($this->createResident($request->all(), $current_user->belongsToRole->ward_id) != false) {
                return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
            } else {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502); 
            }
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, bạn không đủ thẩm quyền'], 403); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getListInjections ($id) {
        $resident = Resident::find($id);
        if (!empty($resident))
            return view ('admin.injection.index', [
                'resident' => $resident,
                'diseases' => $this->getActiveDiseases(),
                'list_injections' => $this->getListInjection($id, request()->query('disease')),
                'disease_id' => empty(request()->query('disease')) ? '' : request()->query('disease'),
            ]);
    }

    public function searchResidents ()
    {
        $query = Resident::select('residents.id', 'residents.name', 'residents.date_of_birth', 'residents.phone', 'residents.address');

        if (!empty(request()->query('identity_card')))
            $query->where('identity_card', request()->query('identity_card'));

        if (!empty(request()->query('name')))
            $query->where([['residents.name', 'like', '%' . request()->query('name') . '%']]);

        if (!empty(request()->query('date_of_birth')))
            $query->where('residents.date_of_birth', request()->query('date_of_birth'));

        if (!empty(request()->query('phone')))
            $query->where('residents.phone', request()->query('phone'));

        if (!empty(request()->query('ward_id'))) {
            $query->where('residents.ward_id',  request()->query('ward_id'));
        } else if (!empty(request()->query('district_id'))) {
            $wards = $this->getActiveWards(request()->query('district_id'));
            $query->whereIn('residents.ward_id', $this->getArrWardId($wards));
        } else if (!empty(request()->query('province_id'))) {
            $wards = Ward::select('wards.*')->join('districts', 'districts.id', '=', 'wards.district_id')->join('provinces', 'provinces.id', '=', 'districts.province_id')->where([['provinces.id', '=', request()->query('province')], ['wards.is_active', '=', 1], ['districts.is_active', '=', 1], ['provinces.is_active', '=', 1]])->get();

            $query->whereIn('residents.ward_id', $this->getArrWardId($wards));
        }

        $data = $query->paginate(2);
        
        // dd($data->perPage());
        return response()->json([
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'data' => $data->items(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $current_user = User::find(Auth::user()->id);

        $resident = $this->find($id);

        if (empty($resident)) {
            return redirect()->route('admin.errors.404');
        }

        if ($current_user->can('update', Resident::class)) {
            return view('admin.resident.edit', [
                'resident' => $resident,
                'nationalities' => $this->getActiveNationality(),
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(0),
                'wards' => $this->getActiveWards(0),
                'ethnics' => $this->getActiveEthnics(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResidentRequest $request, $id)
    {
        // dd($request->all());
        if ($this->updateResident($id, $request->all())) {
            return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = User::find(Auth::user()->id);

        if ($currentUser->can('viewAny', User::class)) {
            if ($this->deleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi phục bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi phục bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }
}
