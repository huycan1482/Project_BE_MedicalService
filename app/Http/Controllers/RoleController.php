<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends RoleRepository
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
                $roles = $this->getPaginate10();
            else 
                $roles = $this->getFilter10(); 

            return view ('admin.role.index', [
                'roles' => $roles,
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(empty(request()->query('province')) ? 0 : request()->query('province')),
                'wards' => $this->getActiveWards(empty(request()->query('district')) ? 0 : request()->query('district')),
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
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
            $roles = $this->getRoleWithTrashed();

            return view('admin.role.trash', [
                'roles' => $roles,
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(empty(request()->query('province')) ? 0 : request()->query('province')),
                'wards' => $this->getActiveWards(empty(request()->query('district')) ? 0 : request()->query('district')),
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
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

        if ($current_user->can('viewAny', User::class)) {
            return view ('admin.role.create', [
                'wards' => $this->getActiveWards(0),
                'districts' => $this->getActiveDistricts(0),
                'provinces' => $this->getActiveProvinces(),
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
    public function store(RoleRequest $request)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            if ($this->createModel($request->all()) != false) {
                return response()->json(['mess' => 'Th??m b???n ghi th??nh c??ng', 200]);
            } else {
                return response()->json(['mess' => 'Th??m b???n ghi l???i'], 502); 
            }
        } else {
            return redirect()->route('admin.errors.4xx');
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
            $role = $this->find($id);

            if (empty($role)) {
                return redirect()->route('admin.errors.404');
            }

            return view('admin.role.edit', [
                'role' => $role,
                'wards' => $this->getActiveWards(0),
                'districts' => $this->getActiveDistricts(0),
                'provinces' => $this->getActiveProvinces(),
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
    public function update(RoleRequest $request, $id)
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

    public function getRoleByWardId ($id) {
        return response()->json([
            'status' => true,
            'data' => $this->getActiveRole($id),
        ]);
    }
}
