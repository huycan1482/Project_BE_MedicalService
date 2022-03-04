<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producer extends Model
{
    use SoftDeletes;

    protected $table = "producers";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'is_active'
    ];
}
