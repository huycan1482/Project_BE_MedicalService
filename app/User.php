<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static $relations_to_injector = ['hasManyInjectors'];
    protected static $relations_to_watchers = ['hasManyWatchers'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($user) {
        //     $user->hasManyInjectors()->delete();
        //     $user->hasManyWatchers()->delete();
        // });

        // static::restoring(function($user) {
        //     $user->hasManyInjectors()->withTrashed()->restore();
        //     $user->hasManyWatchers()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_injector as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_watchers as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_injector as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_watchers as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'date_of_birth', 'phone', 'identity_card', 'gender', 'ward_id', 'address', 'description', 'email', 'password', 'role_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function belongsToRole () {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function belongsToWard () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id');
    }

    public function hasManyInjectors () {
        return $this->hasMany('App\Injection', 'injector_id', 'id');
    }

    public function hasManyWatchers () {
        return $this->hasMany('App\Injection', 'watcher_id', 'id');
    }
}
