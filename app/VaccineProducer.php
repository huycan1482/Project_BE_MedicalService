<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineProducer extends Model
{
    use SoftDeletes;

    protected $table = "vaccine_producer";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'vaccine_id', 'producer_id'
    ];

    public function belongsToVaccine () {
        return $this->belongsTo('App\Vaccine', 'vaccine_id', 'id');
    }

    public function belongsToProducer () {
        return $this->belongsTo('App\Producer', 'producer_id', 'id');
    }
}
