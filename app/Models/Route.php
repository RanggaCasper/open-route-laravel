<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'routes';

    protected $guarded = [
        'id'
    ];

    protected $casts = ['status' => 'boolean'];
}
