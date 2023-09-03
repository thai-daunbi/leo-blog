<!-- add-event.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add schedule</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function submitForm(event) {
            event.preventDefault();
            var form = document.getElementById("add-event-form");
            var _token = form.querySelector("input[name='_token']").value;
            var title = form.querySelector("input[name='title']").value;
            var startDate = form.querySelector("input[name='start-date']").value;
            var endDate = form.querySelector("input[name='end-date']").value;
            var startTime = form.querySelector("input[name='start-time']").value;
            var endTime = form.querySelector("input[name='end-time']").value;

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
    </script>
</head>
<body>
    <h1>Add schedule</h1>
    <form id="add-event-form" onsubmit="submitForm(event)">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start-date" required><br><br>
        <label for="end-date">End date:</label>
        <input type="date" id="end-date" name="end-date" required><br><br>
        <label for="start-time">Start time:</label>
        <input type="time" id="start-time" name="start-time" required><br><br>
        <label for="end-time">End time:</label>
        <input type="time" id="end-time" name="end-time" required><br><br>
        <input type="submit" value="Add schedule">
    </form>
</body>
</html>
