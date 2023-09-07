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

<form method="POST" action="/schedule/update/{{ $schedule->id }}" id="edit-event-form">
    @csrf

    <!-- Start Date -->
    <label for="start-date">Start Date:</label>
    <input type='text' id='start-date' name='start_date' class='date' value="{{ \Carbon\Carbon::parse($schedule->start)->format('Y-m-d') }}"><br><br>

	<!-- End Date -->
	<label for='end-date'>End date:</label>
	<input type='text' id='end-date' name='end_date' class='date' value="{{ \Carbon\Carbon::parse($schedule->end)->format('Y-m-d') }}"><br><br>

	<!-- Start Time -->
	<label for='start-time'>Start time:</label>
	<input type="time" id="start-time" name="start_time" class="time" required value="{{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}"><br><br>

	<!-- End Time-->
	<label for="end-time"> End time:</label>
	<input type="time" id="end-time" name="end_time" class="time" required value="{{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}"><br><br>
   
     <!-- Update Button -->
     <button type="submit">Update</button>
 </form>

   <!-- Delete Button -->
   {{-- Confirm before deleting --}}
  <form method="POST" action="/schedule/{{$schedule->id}}" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
      @csrf
      @method("DELETE")
      <button type="submit">Delete</button>
  </form>

<script>
$(document).ready(function() {
	
	flatpickr('.date', {
	  enableTime: false,
	  dateFormat: "Y-m-d",
});
	
	flatpickr('.time', {
	  enableTime: true,
	  noCalendar: true,
	  dateFormat: "H:i",
});
	
	$("#edit-event-form").submit(function(e) {
        e.preventDefault();
		
		$.ajax({
            type: 'PUT', 
            url: '/schedule/update/{{ $schedule->id }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'start_date': $('#start-date').val(),
                'end_date': $('#end-date').val(),
                'start_time': $('#start-time').val(),
                'end_time': $('#end-time').val()
            },
            success: function(response) {
                alert('Schedule Updated Successfully!');
                window.location.href = '/schedule';
            },
            error: function(response) {
                alert('Failed to Update Schedule');
            }
        });
    });
	
});
</script>
</body>
</html>
