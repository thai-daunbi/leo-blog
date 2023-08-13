<?php

// namespace App\Http\Controllers;

// use App\Models\Schedule;
// use Illuminate\Http\Request;

// class ScheduleController extends Controller
// {
//     public function index()
//     {
//         $Schedules = Schedule::all(); // 예시로 적은 모델명이니 참고하시고 해당 구문을 해당하는 모델에 맞게 변경 부탁드립니다.
//         return view('schedule.index', compact('schedules'));
//     }
// }

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Schedule;
use App\Models\Event;
use Illuminate\Http\JsonResponse;



class ScheduleController extends Controller

{

/**

    * Write code on Method

    *

    * @return response()

    */

public function index(Request $request)

{



    if($request->ajax()) {

    

            $data = Schedule::whereDate('start', '>=', $request->start)

                    ->whereDate('end',   '<=', $request->end)

                    ->get(['id', 'title', 'start', 'end']);



            return response()->json($data);

    }



    return view('schedule.index');

}



/**

    * Write code on Method

    *

    * @return response()

    */

public function ajax(Request $request): JsonResponse

{



    switch ($request->type) {

        case 'add':

            $Schedule = Schedule::create([

                'title' => $request->title,

                'start' => $request->start,

                'end' => $request->end,

            ]);



            return response()->json($Schedule);

            break;



        case 'update':

            $Schedule = Schedule::find($request->id)->update([

                'title' => $request->title,

                'start' => $request->start,

                'end' => $request->end,

            ]);



            return response()->json($Schedule);

            break;



        case 'delete':

            $Schedule = Schedule::find($request->id)->delete();



            return response()->json($Schedule);

            break;

            

        default:

            # code...

            break;

    }

}

}