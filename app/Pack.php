<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
    use SoftDeletes;

    protected $table = "packs";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'expired', 'vaccine_id', 'producer_id', 'is_active'
    ];

    public function belongsToVaccine () {
        return $this->belongsTo('App\Vaccine', 'vaccine_id', 'id');
    }

    public function belongsToProducers () {
        return $this->belongsTo('App\Producer', 'producer_id', 'id');
    }
}
