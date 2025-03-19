<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use HasUuids;

    protected $table = 'menu_items';

    protected $guarded = [
        'id'
    ];

    protected $casts = ['status' => 'boolean'];

    public function group()
    {
        return $this->BelongsTo(MenuGroup::class,'menu_group_id');
    }
}
