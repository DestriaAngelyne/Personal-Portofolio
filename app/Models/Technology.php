<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $table = 'technologies';

    protected $fillable = [
        'name',
        'icon_key',
        'icon_source',  
        'color',
        'category',
        'order',
    ];
}
