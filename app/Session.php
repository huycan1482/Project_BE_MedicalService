<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    // protected $table = 'sessions';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_at', 'end_at', 'address', 'ward_id', 'quantity', 'actual_quantity', 'status_id'
    ];
}
