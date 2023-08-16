<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;



class ScheduleController extends Controller

{
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