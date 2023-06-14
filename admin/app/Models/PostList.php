<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostList extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'body',
        // 여기에 다른 fillable 속성이 있다면, 그것도 포함합니다.
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
