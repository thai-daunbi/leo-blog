<!-- edit-schedule.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit schedule</title>

    <!-- Add necessary CSS or JavaScript files here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>

</head>

<body>

<h3>Edit Schedule</h3>

<form method="POST" action="{{ route('update-schedule2', ['id' => $schedule->id]) }}" id="edit-event-form">

    @csrf
    @method('PUT')

    <label for="title">Title:</label>
    <input type='text' id='title' name='title' value="{{ $schedule->title }}"><br><br>


    
    <label for="start-date">Start Date:</label>
    <input type='text' id='start-date' name='start_date' class='date' value="{{ \Carbon\Carbon::parse($schedule->start)->format('Y-m-d') }}"><br><br>

    
    <label for='end-date'>End date:</label>
    <input type='text' id='end-date' name='end_date' class='date' value="{{ \Carbon\Carbon::parse($schedule->end)->format('Y-m-d') }}"><br><br>

    
    <label for='start-time'>Start time:</label>
    <input type="time" id="start-time" name="start_time" class="time" required value="{{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}"><br><br>

    
    <label for="end-time"> End time:</label>
    <input type="time" id="end-time" name="end_time" class="time" required value="{{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}"><br><br>

    <label for="students">Students:</label>
    <select id="students" name="students[]" multiple>
        @foreach ($schedule->students as $student)
            <option value="{{ $student->name }}" selected>{{ $student->name }}</option>
        @endforeach
    </select><br><br>
     
     <button type="submit">Update</button>
 </form>

   {{-- Confirm before deleting --}}
  <form method="POST" action="/schedule/{{$schedule->id}}" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
      @csrf
      @method("DELETE")
      <button type="submit">Delete</button>
  </form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var todayDate = new Date().toISOString().slice(0, 10);

    
    $('#start-date').val("{{ \Carbon\Carbon::parse($schedule->start)->format('Y-m-d') }}");
    $('#end-date').val("{{ \Carbon\Carbon::parse($schedule->end)->format('Y-m-d') }}");
    $('#start-time').val("{{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}");
    $('#end-time').val("{{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}");

    var endDate = todayDate;

    flatpickr("#start-date", {
        dateFormat: "Y-m-d",
        defaultDate: todayDate,
        locale: "en",
        onChange: function(selectedDates, dateStr, instance) {
            $('#end-date').val(dateStr);
            updateEndTime(dateStr, $('#start-time').val());
        }
    });

    flatpickr("#end-date", {
        dateFormat: "Y-m-d",
        defaultDate: todayDate,
        locale: "en"
    });

    flatpickr("#start-time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        onChange: function(selectedTime) {
            updateEndTime($('#start-date').val(), selectedTime[0]);
        }
    });

    flatpickr("#end-time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K"
    });

    function updateEndTime(startDate, startTime) {
        startDate = new Date(startDate);
        startTime = startTime || new Date('2023-01-01T09:00:00');
        var endTime = new Date(startDate.getTime() + startTime.getHours() * 60 * 60 * 1000 + startTime.getMinutes() * 60 * 1000);
        endTime.setHours(startTime.getHours() + 1, startTime.getMinutes());
        $('#end-date').val(endTime.toISOString().slice(0, 10));
        $('#end-time').val(endTime.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        }));
    }
});
</script>
</body>
</html>
