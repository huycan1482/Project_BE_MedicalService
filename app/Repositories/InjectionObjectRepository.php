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

    public function getPaginate10($id)
    {
        // return $this->_model->latest()->paginate(10);
        return $this->_model->where('session_id', $id)->orderBy('id', 'asc')->paginate(10);
    }

    public function getFilter10($id)
    {
        $query = $this->_model->where('session_id', $id)->orderBy('id', 'asc');

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