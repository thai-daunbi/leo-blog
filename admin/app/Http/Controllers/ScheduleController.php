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
    public function editSchedule2($id)
    {
       // fetch schedule details for given id and pass it to view
       $schedule = Schedule::findOrFail($id);
       return view('schedule.edit-schedule',['schedule'=>$schedule]);
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

    $students = $request->input('students', []); // 학생 정보 배열 가져오기

    // 스케줄과 연결된 모든 학생 정보를 삭제하고 다시 추가
    $schedule->students()->delete(); // 이 스케줄과 연결된 모든 학생 정보 삭제

    foreach ($students as $studentName) {
        $student = new Student([
            'name' => $studentName,
        ]);
        $schedule->students()->save($student); // 학생 정보를 스케줄에 연결하여 저장
    }

    // 리디렉션
    return redirect('/schedule');
}

public function updateSchedule2(Request $request, $id)
{
    // 체크박스 값이 1인 경우에 true, 그 외에는 false로 설정
    $button1 = $request->has('button1') ? 1 : 0;
    $button2 = $request->has('button2') ? 1 : 0;

    // Schedule 모델을 찾아서 수정
    $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d g:i A', $request->input('start_date') . ' ' . $request->input('start_time'));
    $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d g:i A', $request->input('end_date') . ' ' . $request->input('end_time'));
    
    $schedule = Schedule::findOrFail($id);
    $schedule->start = $startDateTime;
    $schedule->end = $endDateTime;
    $schedule->button1 = $button1;
    $schedule->button2 = $button2;
    $schedule->save();

    $students = $request->input('students', []); // 학생 정보 배열 가져오기

    // 스케줄과 연결된 모든 학생 정보를 삭제하고 다시 추가
    $schedule->students()->delete(); // 이 스케줄과 연결된 모든 학생 정보 삭제

    foreach ($students as $studentName) {
        $student = new Student([
            'name' => $studentName,
        ]);
        $schedule->students()->save($student); // 학생 정보를 스케줄에 연결하여 저장
    }

    // 리디렉션
    return redirect('/schedule');
}


    public function deleteSchedule($id)
    {
        // Find the schedule and delete it
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        // Redirect back to the schedule page
        return redirect('/schedule');
    }

    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect('/schedule');
    }

}

