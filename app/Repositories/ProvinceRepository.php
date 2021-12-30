<?php

namespace App\Repositories;

class ProvinceRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Province::class;
    }

    public function getPaginate10()
    {
        return $this->_model->latest()->paginate(10);
    }
}