<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'start', 'end', 'button1', 'button2', 'button3', 'button4', 'button5']; // 대량 할당을 허용하는 열 이름 배열

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
