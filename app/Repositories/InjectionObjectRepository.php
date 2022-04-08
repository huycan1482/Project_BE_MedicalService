<?php

namespace App\Repositories;

use App\District;
use App\Priority;
use App\Province;
use App\Session;
use App\User;
use App\Vaccine;
use App\Ward;

class InjectionObjectRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\InjectionObject::class;
    }

    public function getObjectsWithTrashed ($session_id) {
        $query = $this->_model->onlyTrashed()->where('objects.session_id', $session_id);
        
        if (!empty(request()->query('name'))) {
            $query->join('residents', 'residents.id', '=', 'objects.resident_id')
            ->where([['residents.name', 'like', '%' . request()->query('name') . '%']]);
        }

        if (!empty(request()->query('identity'))) {
            $query->join('residents', 'residents.id', '=', 'objects.resident_id')
            ->where([['residents.identity_card', 'like', '%' . request()->query('identity') . '%']]);
        }

        if (request()->query('status') == 'da-tiem') {
            $query->where('objects.status_id', 1);
        } else if (request()->query('status') == 'chua-tiem') {
            $query->where('objects.status_id', 0);
        }
        
        if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('objects.id', 'desc');
        } else {
            $query->orderBy('objects.id', 'asc');
        }
        return $query->paginate(10);
    }

    public function getPaginate10($id, $ward_id)
    {
        if ($ward_id == 0) {
            return $this->_model->select('objects.*')->where('session_id', $id)->paginate(10);
        } else {
            return $this->_model->select('objects.*')->join('sessions', 'objects.session_id', '=', 'sessions.id')
            ->where([['objects.session_id', '=', $id], ['sessions.ward_id', '=', $ward_id]])
            ->paginate(10);
        }
       
    }

    public function getFilter10($id, $ward_id)
    {
        if ($ward_id == 0) {
            $query = $this->_model->select('objects.*')->where('objects.session_id', $id);
        } else {
            $query = $this->_model->select('objects.*')->join('sessions', 'objects.session_id', '=', 'sessions.id')
            ->where([['objects.session_id', '=', $id], ['sessions.ward_id', '=', $ward_id]]);
        }

        if (!empty(request()->query('name'))) {
            $query->join('residents', 'residents.id', '=', 'objects.resident_id')
            ->where([['residents.name', 'like', '%' . request()->query('name') . '%']]);
        }

        if (!empty(request()->query('identity'))) {
            $query->join('residents', 'residents.id', '=', 'objects.resident_id')
            ->where([['residents.identity_card', 'like', '%' . request()->query('identity') . '%']]);
        }

        if (request()->query('status') == 'da-tiem') {
            $query->where('objects.status_id', 1);
        } else if (request()->query('status') == 'chua-tiem') {
            $query->where('objects.status_id', 0);
        }
        
        if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('objects.id', 'desc');
        } else {
            $query->orderBy('objects.id', 'asc');
        }

        return $query->paginate(10);
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

    public function getActiveVaccines ($session_id) {
        $session = Session::find($session_id);
        return $session->belongsToManyActiveVaccines;
    }

    public function getActiveInjectors ($ward_id) {
        return User::select('users.*')->join('roles', 'users.role_id', '=', 'roles.id')->where([['users.is_active', '=', 1], ['roles.ward_id', '=', $ward_id], ['roles.level', '!=', 1], ['roles.level', '!=', 1]])->get();
    }

    public function getActivePriorities () {
        return Priority::where('is_active', 1)->get();
    }
}