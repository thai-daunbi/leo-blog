<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeControl extends Model
{
    use HasFactory;

    protected $table = 'like_controls';

    // columns to be allowed in mass-assingment 
    protected $fillable = ['like_user_id', 'like_post_id'];
    public function owner() {
    	return $this->belongsTo(User::class, 'user_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
