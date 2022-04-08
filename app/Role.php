<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = "roles";

    protected $dates = ['deleted_at'];

    protected static $relations_to_users = ['hasManyUsers'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($role) {
        //     $role->hasManyUsers()->delete();
        // });

        // static::restoring(function($role) {
        //     $role->hasManyUsers()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_users as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_users as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    protected $fillable = [
        'name', 'level', 'ward_id', 'description', 'is_active'
    ];

    public function belongsToWard () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id');
    }

    public function belongsToWardTrashed () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id')->withTrashed();
    }

    public function hasManyUsers () {
        return $this->hasMany('App\User', 'role_id', 'id');
    }
}
