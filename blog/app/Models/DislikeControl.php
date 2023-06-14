<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DislikeControl extends Model
{
    use HasFactory;

    protected $table = 'dislike_controls';

    // columns to be allowed in mass-assingment 
    protected $fillable = ['dislike_user_id', 'dislike_post_id'];
    public function owner() {
    	return $this->belongsTo(User::class, 'user_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
