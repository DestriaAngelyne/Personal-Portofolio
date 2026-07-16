<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'name',
        'school',
        'major',
        'location',
        'phone',
        'email',
        'summary',
        'photo_path',
        'cv_file_path',
    ];
}
