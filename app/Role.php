<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = "roles";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'level', 'ward_id', 'description', 'is_active'
    ];

    public function belongsToWard () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id');
    }
}
