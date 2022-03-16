<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends UserRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(request()->all()))
            $users = $this->getPaginate10();
        else
            $users = $this->getFilter10(); 
        
        return view ('admin.user.index', [
            'users' => $users,
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.user.create', [
            'provinces' => $this->getActiveProvinces(),
            'districts' => $this->getActiveDistricts(0),
            'wards' => $this->getActiveWards(0),
            'roles' => $this->getActiveRoles(0),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if ($this->createUser($request->all()) != false) {
            return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502); 
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

        $user = $this->find($id);

        if (empty($user)) {
            return redirect()->route('admin.errors.404');
        }

        if ($current_user->can('update', User::class) || $current_user->can('updateProfile', $user)) {
            return view('admin.user.edit', [
                'user' => $user,
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(0),
                'wards' => $this->getActiveWards(0),
                'roles' => $this->getActiveRoles(0),
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
    public function update(UserRequest $request, $id)
    {
        if ($this->updateUser($id, $request->all())) {
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
        //
    }

    public function forceDelete($id)
    {
        // $currentUser = User::findOrFail(Auth()->user()->id);

        // if ($currentUser->can('forceDelete', ClassRoom::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        // } else {
        //     return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        // }
    }

    public function restore($id)
    {
        // $currentUser = User::findOrFail(Auth()->user()->id);

        // if ($currentUser->can('restore', ClassRoom::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi phục bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi phục bản không thành công'], 400);
            }
        // } else {
        //     return response()->json(['mess' => 'Khôi phục bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        // }
    }
}
