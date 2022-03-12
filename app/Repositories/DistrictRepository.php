<?php

namespace App\Repositories;

use App\District;
use App\Province;

class DistrictRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\District::class;
    }

    public function getPaginate10()
    {
        // return $this->_model->orderBy('id', 'asc')->paginate(10);
        return $this->_model->latest()->paginate(10);
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

    public function getActiveProvinces () 
    {
        return Province::where('is_active', 1)->get();
    }

    public function getActiveDistricts ($province_id) {
        if ($province_id !=0 ) {
            return District::where([['is_active', '=', 1], ['province_id', '=', $province_id]])->get();
        } else { 
            return District::where('is_active', 1)->get();
        }
    }
}