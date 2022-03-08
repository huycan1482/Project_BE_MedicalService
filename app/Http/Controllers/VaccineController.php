<?php

namespace App\Http\Controllers;

use App\Http\Requests\vaccineRequest;
use App\Repositories\VaccineRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineController extends VaccineRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(request()->all()))
            $vaccines = $this->getPaginate10();
        else 
            $vaccines = $this->getFilter10(); 

        return view ('admin.vaccine.index', [
            'vaccines' => $vaccines,
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
        return view ('admin.vaccine.create', [
            'producers' => $this->getActiveProducers(),
            'diseases' => $this->getActiveDiseases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VaccineRequest $request)
    {
        // bắt đầu Rollback
        DB::beginTransaction();

        try {
            $vaccine_id = $this->createVaccine($request);
            //Tao ban ghi moi cho bang vaccine tra ve id ban ghi moi

            if ($vaccine_id == 0) 
                throw new Exception();

            if (!$this->createVaccineProducer($request->input('producer_id'), $vaccine_id))
                throw new Exception();
                //Them du lieu vao bang trung gian vaccine_producer

            if (!$this->createVaccineDisease($request->input('disease_id'), $vaccine_id))
                throw new Exception();    
                //Them du lieu vao bang trung gian vaccine_disease

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
        }

        return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vaccine = $this->find($id);

        if (empty($vaccine)) {
            return redirect()->route('admin.errors.404');
        }

        return view('admin.vaccine.edit', [
            'vaccine' => $vaccine,
            'producers' => $this->getActiveProducers(),
            'diseases' => $this->getActiveDiseases(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(vaccineRequest $request, $id)
    {
        // bắt đầu Rollback
        DB::beginTransaction();

        try {
            if (!$this->updateVaccine($request, $id)) 
                throw new Exception();
                //Sua du lieu bang vaccine 
            if (!$this->updateVaccineProducer($request->input('producer_id'), $id))
                throw new Exception();
                //Sua du lieu vao bang trung gian vaccine_producer

            if (!$this->updateVaccineDisease($request->input('disease_id'), $id))
                throw new Exception();    
                //Sua du lieu vao bang trung gian vaccine_disease

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
        }

        return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
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
