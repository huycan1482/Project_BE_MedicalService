<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'date_of_birth', 'phone', 'identity_card', 'gender', 'health_insurance_card', 'nationality_id', 'ethnic_id ', 'ward_id', 'address', 'job', 'work_place', 'description', 'status_id'
    ];

    public function belongsToRole () {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function belongsToWard () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id');
    }

    public function belongsToNationality () {
        return $this->belongsTo('App\Nationality', 'nationality_id', 'id');
    }

    public function belongsToEthnic () {
        return $this->hasMany('App\Ethnic', 'ethnic_id', 'id');
    }
}
