<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ethnic extends Model
{
    use SoftDeletes;

    protected $table = "ethnics";

    protected $dates = ['deleted_at'];

    protected static $relations_to_residents = ['hasManyResidents'];


    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($district) {
        //     $district->hasManyResidents()->delete();
        // });

        // static::restoring(function($district) {
        //     $district->hasManyResidents()->withTrashed()->restore();
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
        return $this->hasMany('App\Resident', 'ethnic_id', 'id');
    }
}
