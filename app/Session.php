<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    protected $table = 'sessions';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_at', 'end_at', 'disease_id', 'address', 'ward_id', 'status_id'
    ];

    public function belongsToDisease () {
        return $this->belongsTo('App\Disease', 'disease_id', 'id');
    }

    public function hasManySessionVaccine () {
        return $this->hasMany('App\SessionVaccine', 'session_id', 'id');
    }

    public function belongsToManyVaccines () {
        return $this->belongsToMany('App\Vaccine', 'session_vaccine', 'session_id', 'vaccine_id')->withPivot('id', 'session_id', 'vaccine_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n vaccines

    public function belongsToManyActiveVaccines () {
        return $this->belongsToMany('App\Vaccine', 'session_vaccine', 'session_id', 'vaccine_id')->where('is_active', 1)->withPivot('id', 'session_id', 'vaccine_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n vaccines

    public function hasManyObject () {
        return $this->hasMany('App\InjectionObject', 'session_id', 'id');
    }
}
