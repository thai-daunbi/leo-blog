<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Schedule;
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

        $events = Schedule::whereBetween('start', [$start, $end])
            ->orWhereBetween('end', [$start, $end])
            ->get();

        $result_events = [];

        foreach ($events as $event) {
            $result_events[] = array(
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'checkbox1' => $event->checkbox1,
                'checkbox2' => $event->checkbox2
            );
        }

        return response()->json($result_events);
    }

    public function saveEvent(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $schedule = new Schedule([
            'title' => $request->title,
            'start' => $request->start_date . ' ' . $request->start_time,
            'end' => $request->end_date . ' ' . $request->end_time,
        ]);

        $schedule->save();

        return response()->json(['success' => true]);
    }

    public function editSchedule($id)
    {
       // fetch schedule details for given id and pass it to view
       $schedule = Schedule::findOrFail($id);
       return view('schedule.edit',['schedule'=>$schedule]);
    }

    public function updateSchedule(Request $request, $id)
    {
        $this->validate($request, [
            'checkbox1' => 'nullable|boolean',
            'checkbox2' => 'nullable|boolean',
        ]);

        $schedule = Schedule::findOrFail($id);

        if ($request->has('checkbox1')) {
            $schedule->button1 = $request->input('checkbox1') ? 1 : 0;
        }

        if ($request->has('checkbox2')) {
            $schedule->button2 = $request->input('checkbox2') ? 1 : 0;
        }

        $schedule->save();

        return redirect('/schedule');
        // return redirect()->route('schedule.index');
    }

}

