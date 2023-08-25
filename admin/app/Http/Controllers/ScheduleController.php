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

        return response()->json($events);
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
    public function updateCheckbox(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:schedules,id',
            'checkbox1' => 'required|boolean',
            'checkbox2' => 'required|boolean',
        ]);

        $schedule = Schedule::findOrFail($request->input('id'));
        $schedule->checkbox = $request->input('checkbox1');
        $schedule->checkbox = $request->input('checkbox2');
        $schedule->save();

        return response()->json(['success' => true]);
    }
}