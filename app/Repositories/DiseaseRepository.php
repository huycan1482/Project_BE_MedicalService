<?php

namespace App\Repositories;

class DiseaseRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Disease::class;
    }

    public function getPaginate10()
    {
        // return $this->_model->latest()->paginate(10);
        return $this->_model->orderBy('id', 'asc')->paginate(10);
    }
}