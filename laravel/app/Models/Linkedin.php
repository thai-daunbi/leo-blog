<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linkedin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_id',
        'user',
        'email',
        'token',
        'refresh_id',
    ];

    public function user(){
        return $this->belogsTo(User::class);
    }
}
