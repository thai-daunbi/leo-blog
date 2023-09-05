<!-- add-event.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add schedule</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">

    <script>
        function submitForm(event) {
            event.preventDefault();
            var form = document.getElementById("add-event-form");
            var _token = form.querySelector("input[name='_token']").value;
            var title = form.querySelector("input[name='title']").value;
            var startDate = form.querySelector("input[name='start-date']").value;
			var endDateInput = form.querySelector("input[name='end-date']");
			var startTime = "09:00 AM";
			
			// Calculate end time based on start time + 1 hour
			var startHour = parseInt(startTime.split(':')[0]);
			var endHour = (startHour + 1) % 12; // Ensure it stays within a 12-hour range
			if (endHour === 0) {
				endHour = 12;
			}
			
			var endTimeMeridiem = startTime.split(' ')[1];
			var endTime = ('00' + endHour).slice(-2) + ':00 ' + endTimeMeridiem;
            if (startDate !== "") {
                endDateInput._flatpickr.setDate(startDate); // start date 값을 end date에 할당
                endDateInput.dispatchEvent(new Event('change')); // change 이벤트 트리거
            }

            $.ajax({
                type: 'POST',
                url: '/api/save-event',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'title': title,
                    'start_date': startDate,
                    'end_date': endDate,
                    'start_time': startTime,
                    'end_time': endTime,
                },
                success: function (data) {
                    alert('Schedule added!');
                    window.location.href = '/schedule';
                },
                error: function (data) {
                    alert('Failed to add event!');
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
          var todayDate = new Date().toISOString().slice(0, 10);
          $('#start-date').val(todayDate);
          $('#end-date').val(todayDate);
          $('#start-time').val('09:00 AM');
          
          flatpickr("#start-date", {
              dateFormat: "F j, Y",
              locale: "en",
              onChange: function(selectedDates, dateStr, instance) { 
                  if ($('#end-date').val() === '') { 
                      instance.setDate(selectedDates[0], false); 
                  } 
              }
          });
          
          flatpickr("#end-date", { 
              dateFormat: "F j, Y",
              locale: "en"
          });
          flatpickr("#start-time", { 
			  enableTime: true,
			  noCalendar:true,
			  dateFormat:"h:i K",
			  defaultDate:"09:00 AM"
		  });
          flatpickr("#end-time", { 
		  	  enableTime:true,
		  	  noCalendar:true,
		  	  dateFormat:"h:i K",
		  	  defaultDate:"+1 hour"
		  });
          
        });
    </script>
</head>
<body>
    <h1>Add schedule</h1>
    <form id="add-event-form" onsubmit="submitForm(event)">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="start-date">Start Date:</label>
        <input type="text" id="start-date" name="start-date"><br><br>
        <label for="end-date">End date:</label>
        <input type ="text"id ="end-date"name ="end -date"value="" readonly><br ><br >
        <label for="start-time">Start time:</label>
        <input type="time" id="start-time" name="start-time" required><br><br>
        <label for="end-time">End time:</label>
        <input type="time" id="end-time" name="end-time" required><br><br>
        <input type="submit" value="Add schedule">
    </form>
    <script src='https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js'></script> 

</body>
</html>
