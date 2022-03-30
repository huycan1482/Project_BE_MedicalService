<?php

namespace App\Http\Controllers;

use App\Http\Requests\InjectionObjectRequest;
use App\User;
use App\InjectionObject;
use App\Repositories\InjectionObjectRepository;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InjectionObjectController extends InjectionObjectRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function getListObjects ($id) {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', InjectionObject::class)) {
            if (empty(request()->all()))
                $objects = $this->getPaginate10($id);
            else 
                $objects = $this->getFilter10($id); 

            return view ('admin.object.index', [
                'session_id' => $id,
                'objects' => $objects,
                'provinces' => $this->getActiveProvinces(),
                'districts' => $this->getActiveDistricts(),
                'wards' => $this->getActiveWards(),
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),

                'injectors' => $this->getActiveInjectors($current_user->belongsToRole->ward_id),
                'vaccines' => $this->getActiveVaccines($id),
                'priorities' => $this->getActivePriorities(),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InjectionObjectRequest $request)
    {

        $check_obj_exists = InjectionObject::where([['session_id', '=', $request->input('session_id')],['resident_id', '=', $request->input('resident_id')]])->get();
        if (!empty($check_obj_exists->first())) 
            return response()->json(['mess' => 'Thêm bản ghi lỗi, công dân đã tồn tại trong buổi tiêm'], 400);

        $arr_data = [
            'session_id' => $request->input('session_id'),
            'resident_id' => $request->input('resident_id'),
            'status_id' => 0,
        ];

        if ($this->createModel($arr_data) != false) {
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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