<?php

namespace App\Repositories;

use App\Injection;
use App\InjectionObject;
use App\User;
use App\Vaccine;

class InjectionRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Injection::class;
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

    public function createInjection ($arr_data) {
        $injection = new Injection();
        $injection->pack_id = $arr_data['pack_id'];
        $injection->resident_id = $arr_data['resident_id'];
        $injection->object_id = $arr_data['object_id'];
        $injection->priority_id = $arr_data['priority_id'];
        $injection->type = $arr_data['type'];
        $injection->dose = $arr_data['dose'];
        $injection->reaction_id = $arr_data['reaction_id'];
        $injection->injector_id = $arr_data['injector_id'];
        $injection->watcher_id = $arr_data['watcher_id'];
        $injection->description = $arr_data['description'];

        $object = InjectionObject::find($arr_data['object_id']);
        
        if ($injection->save()) {
            $object->status_id = 1;
            $object->save();
            return true;
        } else {
            return false;
        }
    }

    public function getActiveVaccines () {
        return Vaccine::where('is_active', 1)->latest()->get();
    }

    public function getActiveUsers ($ward_id) {
        $users = User::select('users.*')
        ->join('roles', 'roles.id', '=', 'users.role_id');

        if (!empty($ward_id)) {
            $users->where('roles.ward_id', $ward_id);
        }

        return $users->get();
    }
}