<?php

namespace App\Repositories;

use App\Disease;
use App\District;
use App\Province;
use App\Session;
use App\SessionVaccine;
use App\Vaccine;
use App\Ward;
use Exception;
use Illuminate\Support\Facades\DB;

class SessionRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Session::class;
    }

    public function getSessionWithTrashed() {
        $query = $this->_model::onlyTrashed()->latest();

        if (!empty(request()->query('start_at'))) {
            $query->where([['start_at', '>=', request()->query('start_at')]]);
        } 

        if (!empty(request()->query('end_at'))) {
            $query->where([['end_at', '<=', request()->query('end_at')]]);
        } 

        if (request()->query('status') == 'hoan-thanh') {
            $query->where('status_id', 2);
        } else if (request()->query('status') == 'chua-hoan-thanh') {
            $query->where('status_id', 1);
        } else if (request()->query('status') == 'hoan') {
            $query->where('status_id', 0);
        }
        
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('id', 'desc');
        }

        return $query->paginate(10);
    }

    public function getPaginate10($ward_id)
    {
        // return $this->_model->latest()->paginate(10);
        if ($ward_id == 0) {
            return $this->_model->orderBy('id', 'asc')->paginate(10);
        } 
        return $this->_model->where('ward_id', $ward_id)->orderBy('id', 'asc')->paginate(10);
    }

    public function getFilter10($ward_id)
    {
        $query = $this->_model::latest();

        if ($ward_id != 0) {
            $query->where('ward_id', $ward_id);
        }

        if (!empty(request()->query('start_at'))) {
            $query->where([['start_at', '>=', request()->query('start_at')]]);
        } 

        if (!empty(request()->query('end_at'))) {
            $query->where([['end_at', '<=', request()->query('end_at')]]);
        } 

        if (request()->query('status') == 'hoan-thanh') {
            $query->where('status_id', 2);
        } else if (request()->query('status') == 'chua-hoan-thanh') {
            $query->where('status_id', 1);
        } else if (request()->query('status') == 'hoan') {
            $query->where('status_id', 0);
        }
        
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('id', 'desc');
        }

        return $query->paginate(10);
    }

    public function getActiveDiseases () {
        return Disease::where('is_active', 1)->latest()->get();
    }

    public function getActiveVaccines ($disease_id) {
        if ($disease_id == 0) {
            return Vaccine::where('is_active', 1)->latest()->get();
        } else {
            $disease = Disease::find($disease_id);
            dd($disease->belongsToManyActiveVaccines);
            return $disease->belongsToManyActiveVaccines();
            // return Vaccine::where('is_active', 1)->latest()->get();
        }
    }

    //trả về id session vừa tạo
    public function createSession ($request, $ward_id) {
        $session = new Session();
        $session->start_at = $request->input('start_at');
        $session->end_at = $request->input('end_at');
        $session->disease_id = $request->input('disease_id');
        $session->ward_id = $ward_id;
        $session->address = $request->input('address');
        $session->status_id = $request->input('status_id');
        if ($session->save()) {
            return $session->id;
        } else {
            return 0;
        }
    }

    public function createSessionVaccine ($session_id, $vaccine_id) {
        DB::beginTransaction();
        try {
            foreach ($vaccine_id as $vaccine) {
                $session_vaccine = new SessionVaccine();
                $session_vaccine->vaccine_id = $vaccine;
                $session_vaccine->session_id = $session_id;

                if ($session_vaccine->save()) {

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

    public function updateSession ($request, $id) {
        $session = Session::find($id);
        $session->start_at = $request->input('start_at');
        $session->end_at = $request->input('end_at');
        $session->disease_id = $request->input('disease_id');
        $session->address = $request->input('address');
        $session->status_id = $request->input('status_id');

        if ($session->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSessionVaccine ($vaccine_id, $id) {
        DB::beginTransaction();

        try {
            $session = Session::find($id);
            
            $arr_result = $session->belongsToManyActiveVaccines()->sync($vaccine_id);

            // $result_attached = $arr_result['attached'];
            // $result_detached = $arr_result['detached'];
            // $result_updated = $arr_result['updated'];

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function getActiveProvinces () {
        return Province::where('is_active', 1)->get();
    }

    public function getActiveDistricts () {
        return District::where('is_active', 1)->get();
    }

    public function getActiveWards () {
        return Ward::where('is_active', 1)->get();
    }
}