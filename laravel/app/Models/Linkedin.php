<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linkedin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id'
    ];
}