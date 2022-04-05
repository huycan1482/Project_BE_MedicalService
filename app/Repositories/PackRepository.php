<?php

namespace App\Repositories;

use App\Pack;
use App\Producer;
use App\Vaccine;

class PackRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Pack::class;
    }

    public function getPacksWithTrashed () {
        $query = $this->_model::onlyTrashed()->latest();

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

    public function getActiveVaccines () {
        return Vaccine::where('is_active', 1)->latest()->get();
    }

    public function getActivePacks ($vaccine_id) {
        return Pack::where([['is_active', '=', 1], ['vaccine_id', '=', $vaccine_id]])->latest()->get();
    }

    public function getActiveProducers () {
        return Producer::where('is_active', 1)->latest()->get();
    }
}