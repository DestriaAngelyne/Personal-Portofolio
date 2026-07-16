<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Mengizinkan kolom-kolom ini untuk diisi data secara massal
    protected $fillable = [
        'title',
        'description',
        'features',
        'tags',
        'image'
    ];

    // Otomatis mengubah format JSON dari database menjadi Array PHP / Object JavaScript
    protected $casts = [
        'features' => 'array',
        'tags' => 'array',
    ];
}
