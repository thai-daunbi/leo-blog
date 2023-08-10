<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all(); // 예시로 적은 모델명이니 참고하시고 해당 구문을 해당하는 모델에 맞게 변경 부탁드립니다.
        return view('schedule.index', compact('schedules'));
    }
}
