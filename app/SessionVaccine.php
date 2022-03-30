<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionVaccine extends Model
{
    use SoftDeletes;

    protected $table = "session_vaccine";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'vaccine_id', 'session_id'
    ];

    public function belongsToVaccine () {
        return $this->belongsTo('App\Vaccine', 'vaccine_id', 'id');
    }

    public function belongsToSession () {
        return $this->belongsTo('App\Session', 'session_id', 'id');
    }
}
