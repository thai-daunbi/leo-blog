<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ScheduleController extends Controller

{
    public function index()
    {
        $schedules = Schedule::all();
        return view('schedule.index', ['schedules' => $schedules]);
    }
    public function show()
    {
        return view('schedule.index');
    }

    public function ajax(Request $request)
    {
        dd($request->all());

        $schedule = new Schedule([
            'title' => $request->title,
            'start' => $request->start_date . ' ' . $request->start_time,
            'end' => $request->end_date . ' ' . $request->end_time,
        ]);

        $schedule->save();

        return response()->json(['success' => true]);
    }

    public function getEvents(Request $request): JsonResponse
    {
        $start = Carbon::parse($request->input('start'));
        $end = Carbon::parse($request->input('end'));

        $events = Schedule::with('students')
            ->whereBetween('start', [$start, $end])
            ->orWhereBetween('end', [$start, $end])
            ->get();

        $result_events = [];

        foreach ($events as $event) {
            $students = $event->students->pluck('name')->toArray(); 
            $result_events[] = array(
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'button1' => $event->button1,
                'button2' => $event->button2,
                'students' => $students, 
            );
        }

        return response()->json($result_events);
    }


public function students()
{
    return $this->hasMany(Student::class);
}


    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect('/schedule');
    }

}

