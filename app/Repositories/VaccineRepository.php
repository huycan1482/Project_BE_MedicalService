<?php

namespace App\Repositories;

use App\Disease;
use App\Producer;
use App\Vaccine;
use App\VaccineDisease;
use App\VaccineProducer;
use Exception;
use Illuminate\Support\Facades\DB;

class VaccineRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Vaccine::class;
    }

    public function getPaginate10()
    {
        // return $this->_model->latest()->paginate(10);
        return $this->_model->orderBy('id', 'asc')->paginate(10);
    }

    public function getFilter10()
    {
        $query = $this->_model::latest();

        if (!empty(request()->query('name'))) {
            $query = $this->_model::where([['name', 'like', '%' . request()->query('name') . '%']]);
        }

        if (request()->query('status') == 'hien-thi') {
            $query->where('is_active', 1);
        } else if (request()->query('status') == 'an') {
            $query->where('is_active', 0);
        }
        
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('id', 'desc');
        }

        return $query->paginate(10);
    }

    public function getActiveProducers () {
        return Producer::where('is_active', 1)->get();
    }

    public function getActiveDiseases () {
        return Disease::where('is_active', 1)->get();
    }

    //trả về id vaccine vừa tạo
    public function createVaccine ($request) {
        $vaccine = new Vaccine();
        $vaccine->name = $request->input('name');
        $vaccine->description = $request->input('description');
        $vaccine->is_active = $request->input('is_active');

        if ($vaccine->save()) {
            return $vaccine->id;
        } else {
            return 0;
        }
    }

    public function createVaccineProducer ($producer_id, $vaccine_id) {
        DB::beginTransaction();

        try {
            foreach ($producer_id as $producer) {
                $vaccine_producer = new VaccineProducer();
                $vaccine_producer->producer_id = $producer;
                $vaccine_producer->vaccine_id = $vaccine_id;

                if ($vaccine_producer->save()) {

                } else {
                    throw new Exception();
                }
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function createVaccineDisease ($disease_id, $vaccine_id) {
        DB::beginTransaction();

        try {
            foreach ($disease_id as $disease) {
                $vaccine_disease = new VaccineDisease();
                $vaccine_disease->disease_id = $disease;
                $vaccine_disease->vaccine_id = $vaccine_id;
                
                if ($vaccine_disease->save()) {

                } else {
                    throw new Exception();
                }
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function updateVaccine ($request, $id) {
        $vaccine = Vaccine::find($id);
        $vaccine->name = $request->input('name');
        $vaccine->description = $request->input('description');
        $vaccine->is_active = $request->input('is_active');

        if ($vaccine->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateVaccineProducer ($producer_id, $id) {
        DB::beginTransaction();

        try {
            $vaccine = Vaccine::find($id);
            
            $arr_result = $vaccine->belongsToManyActiveProducers()->sync($producer_id);

            $result_attached = $arr_result['attached'];
            $result_detached = $arr_result['detached'];
            $result_updated = $arr_result['updated'];

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function updateVaccineDisease ($disease_id, $id) {
        DB::beginTransaction();

        try {
            $vaccine = Vaccine::find($id);
            
            $arr_result = $vaccine->belongsToManyActiveDiseases()->sync($disease_id);

            $result_attached = $arr_result['attached'];
            $result_detached = $arr_result['detached'];
            $result_updated = $arr_result['updated'];

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}