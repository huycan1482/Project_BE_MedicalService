<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Repositories\ResidentRepository;
use App\Resident;
use App\User;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
