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
                'button1' => $event->button1,
                'button2' => $event->button2
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
    // 체크박스 값이 1인 경우에 true, 그 외에는 false로 설정
    $button1 = $request->has('button1') ? 1 : 0;
    $button2 = $request->has('button2') ? 1 : 0;

    // Schedule 모델을 찾아서 수정
    $schedule = Schedule::findOrFail($id);
    $schedule->button1 = $button1;
    $schedule->button2 = $button2;
    $schedule->save();

    // 리디렉션
    return redirect('/schedule');
}


}

