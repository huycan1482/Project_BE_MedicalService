<?php

namespace App\Http\Controllers;

use App\Http\Requests\WardRequest;
use App\Repositories\WardRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WardController extends WardRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            if (empty(request()->all()))
                $wards = $this->getPaginate10();
            else 
                $wards = $this->getFilter10();

            return view ('admin.ward.index', [
                'wards' => $wards,
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    public function getDataWithTrashed () {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            $wards = $this->getWardsWithTrashed();

            return view('admin.ward.trash', [
                'wards' => $wards,
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

        if ($current_user->can('viewAny', User::class)) {
            $active_districts = $this->getActiveDistricts();

            return view ('admin.ward.create', [
                'districts' => $active_districts,
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
    public function store(WardRequest $request)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            if ($this->createModel($request->all()) != false) {
                return response()->json(['mess' => 'Th??m b???n ghi th??nh c??ng', 200]);
            } else {
                return response()->json(['mess' => 'Th??m b???n ghi l???i'], 502); 
            }
        } else {
            return response()->json(['mess' => 'Th??m b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403); 
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

        if ($current_user->can('viewAny', User::class)) {
            $ward = $this->find($id);

            if (empty($ward)) {
                return redirect()->route('admin.errors.404');
            }

            $active_districts = $this->getActiveDistricts();

            return view('admin.ward.edit', [
                'ward' => $ward,
                'districts' => $active_districts,
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WardRequest $request, $id)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            if ($this->updateModel($id, $request->all())) {
                return response()->json(['mess' => 'S???a b???n ghi th??nh c??ng', 200]);
            } else {
                return response()->json(['mess' => 'S???a b???n ghi l???i'], 502);
            }
        } else {
            return response()->json(['mess' => 'S???a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
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
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Kh??i ph???c ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Kh??i ph???c ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'Kh??i ph???c b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function getWardsByDistrictId ($id) {
        return response()->json([
            'status' => true,
            'data' => $this->getActiveWards($id),
        ]);
    }

}
