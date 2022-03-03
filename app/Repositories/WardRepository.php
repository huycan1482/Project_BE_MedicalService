<?php

namespace App\Repositories;

use App\District;

class WardRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Ward::class;
    }

    public function getPaginate10()
    {
        // return $this->_model->orderBy('id', 'asc')->paginate(10);
        return $this->_model->latest()->paginate(10);
    }

    public function getActiveDistricts() 
    {
        return District::where('is_active', 1)->get();
    }
}