<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineDisease extends Model
{
    use SoftDeletes;

    protected $table = "vaccine_disease";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'vaccine_id', 'disease_id'
    ];

    public function belongsToVaccine () {
        return $this->belongsTo('App\Vaccine', 'vaccine_id', 'id');
    }

    public function belongsToDisease () {
        return $this->belongsTo('App\Disease', 'disease_id', 'id');
    }
}
