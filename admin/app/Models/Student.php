<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // 대량 할당을 허용하는 열 이름 배열

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
