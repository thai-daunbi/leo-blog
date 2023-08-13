<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function addEvent(Request $request)
    {
        $title = $request->input('title');
        $startTime = Carbon::parse($request->input('start_time'));
        $endTime = Carbon::parse($request->input('end_time'));

        $event = new Event;
        $event->title = $title;
        $event->start_time = $startTime;
        $event->end_time = $endTime;
        
        // 추가적인 필드 설정

        // start, end 값을 사용하여 Schedule 모델에도 일정을 추가합니다.
        // Schedule 모델에는 FullCalendar에서 사용하는 필드명과 동일한 필드명을 사용합니다.
        
        Schedule::create([
            'title' => $title,
            'start' => date_format($startTime, 'Y-m-d H:i:s'),
            'end' => date_format($endTime, 'Y-m-d H:i:s')
            // 추가적인 필드 설정
         ]);

         // 응답 메시지를 수정합니다.
         return response()->json(['success' => true, 'message' => '일정이 추가되었습니다.']);
    }
}
