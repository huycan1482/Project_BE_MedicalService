<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends RoleRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(request()->all()))
            $roles = $this->getPaginate10();
        else 
            $roles = $this->getFilter10(); 

        return view ('admin.role.index', [
            'roles' => $roles,
            'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
            'status' => empty(request()->query('status')) ? '' : request()->query('status'),
            'name' => empty(request()->query('name')) ? '' : request()->query('name'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.role.create', [
            'wards' => $this->getActiveWards(0),
            'districts' => $this->getActiveDistricts(0),
            'provinces' => $this->getActiveProvinces(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        if ($this->createModel($request->all()) != false) {
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
        $role = $this->find($id);

        // dd($role->belongsToWard->belongsToDistrict->id);
        if (empty($role)) {
            return redirect()->route('admin.errors.404');
        }

        return view('admin.role.edit', [
            'role' => $role,
            'wards' => $this->getActiveWards(0),
            'districts' => $this->getActiveDistricts(0),
            'provinces' => $this->getActiveProvinces(),
        ]);
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
        if ($this->updateModel($id, $request->all())) {
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

    public function getDistrictsByProvinceId ($id) {
        return response()->json([
            'status' => true,
            'data' => $this->getActiveDistricts($id),
        ]);
    }

    public function getWardsByDistrictId ($id) {
        return response()->json([
            'status' => true,
            'data' => $this->getActiveWards($id),
        ]);
    }
}
