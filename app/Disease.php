<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Disease extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    public function hasManyVaccineDisease ()
    {
        return $this->hasMany('App\VaccineDisease', 'vaccine_id', 'id');
    }
}
