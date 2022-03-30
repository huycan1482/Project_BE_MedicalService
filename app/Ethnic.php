<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ethnic extends Model
{
    use SoftDeletes;

    protected $table = "ethnics";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'abbreviation', 'is_active'
    ];
}
