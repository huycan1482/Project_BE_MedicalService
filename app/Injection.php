<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Injection extends Model
{
    use SoftDeletes;

    protected $table = "injections";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pack_id', 'resident_id', 'object_id', 'priority_id', 'type', 'dose', 'reaction_id', 'injector_id', 'watcher_id', 'description', 'created_at', 'updated_at'
    ];

    public function belongsToResident () {
        return $this->belongsTo('App\Resident', 'resident_id', 'id');
    }

    public function belongsToObject () {
        return $this->belongsTo('App\InjectionObject', 'object_id', 'id');
    }

    public function belongsToPriority () {
        return $this->belongsTo('App\Object', 'priority_id', 'id');
    }

    public function belongsToInjector () {
        return $this->belongsTo('App\User', 'injector_id', 'id');
    }

    public function belongsToWatcher () {
        return $this->belongsTo('App\User', 'watcher_id', 'id');
    }

    public function belongsToPack () {
        return $this->belongsTo('App\Pack', 'pack_id', 'id');
    }
}
