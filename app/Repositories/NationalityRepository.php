<?php

namespace App\Repositories;

class NationalityRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Nationality::class;
    }

    public function getPaginate10()
    {
        return $this->_model->latest()->paginate(10);
    }
}