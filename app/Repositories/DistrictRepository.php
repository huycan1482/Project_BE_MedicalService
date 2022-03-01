<?php

namespace App\Repositories;

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
        return $this->_model->latest()->paginate(10);
    }
}