<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
    use SoftDeletes;

    protected $table = "nationalities";

    protected $dates = ['deleted_at'];

    protected static $relations_to_residents = ['hasManyResidents'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($nationality) {
        //     $nationality->hasManyResidents()->delete();
        // });

        // static::restoring(function($nationality) {
        //     $nationality->hasManyResidents()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_residents as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_residents as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    protected $fillable = [
        'name', 'abbreviation', 'is_active'
    ];

    public function hasManyResidents () {
        return $this->hasMany('App\Resident', 'nationality_id', 'id');
    }
}
