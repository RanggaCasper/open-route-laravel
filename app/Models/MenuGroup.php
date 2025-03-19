<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasUuids;

    protected $table = 'menu_groups';

    protected $guarded = [
        'id'
    ];

    protected $casts = ['status' => 'boolean'];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
