<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InjectionObject extends Model
{
    use SoftDeletes;

    protected $table = "objects";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'session_id', 'resident_id', 'description', 'status_id'
    ];

    public function belongsToResident () {
        return $this->belongsTo('App\Resident', 'resident_id', 'id');
    }

    public function hasOneInjection ($object_id) {
        $resident = \App\Resident::find($object_id);
        return $resident;
    }
}
