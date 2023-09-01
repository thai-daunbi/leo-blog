<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8"/>
</head>
<body>
   <h3>Edit Event</h3>

   <form action="{{ route('update-schedule', ['id' => $schedule->id]) }}" method="POST">


      @csrf

      <!-- Show Event Date and Time -->
      <p>Date: {{ date("d-m-Y", strtotime($schedule->start)) }}</p> 
      <p>Time: {{ date("H:i:s", strtotime($schedule->start)) }}</p>

      <!-- Checkbox Options -->
      <input type="checkbox" id="button1" name="button1" value="1" {{ $schedule->button1 ? 'checked' : '' }}>
      <label for="button1">ゆ</label><br>
      
      <input type="checkbox" id="button2" name="button2" value="1" {{ $schedule->button2 ? 'checked' : '' }}>
      <label for="button2">う</label><br>

       <!-- Submit Button -->
       <button type='submit'>Update Schedule</button>
    </form>

    <!-- Add JavaScript code to submit the form and redirect to /schedule -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent default form submission
                form.submit(); // Submit the form normally
            });
        });
    </script>

</body>
</html> 

