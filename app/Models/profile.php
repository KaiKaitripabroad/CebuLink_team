<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'profile_image_url',
        'bio',
        'birthday',
        'created_at',
        'updated_at',
    ];
}
