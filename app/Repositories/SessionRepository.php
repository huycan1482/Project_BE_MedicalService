<?php

namespace App\Repositories;

use App\Disease;
use App\Session;
use App\SessionVaccine;
use App\Vaccine;
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
}