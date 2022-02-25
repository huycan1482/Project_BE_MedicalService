<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
    use SoftDeletes;

    protected $table = "nationalities";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'abbreviation'
    ];
}
