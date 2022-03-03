<?php

namespace App\Repositories;

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

    public function getProvinces () 
    {
        return Province::where('is_active', 1)->get();
    }
}