<!-- add-event.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add schedule</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
</head>
<body>
    <h1>Add schedule</h1>
    <form id="add-event-form" onsubmit="return submitForm(event)">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start-date" required><br><br>
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" name="end-date" required><br><br>
        <label for="start-time">Start Time:</label>
        <input type="time" id="start-time" name="start-time" required><br><br>
        <label for="end-time">End Time:</label>
        <input type="time" id="end-time" name="end-time" required><br><br>
        <input type="submit" value="Add schedule">
        <button type="button" onclick="cancelForm()">Cancel</button>
    </form>
    <script src='https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js'></script>
    <script>
        function submitForm(event) {
            event.preventDefault();
            
            var title = document.getElementById("title").value;
            var startDate = document.getElementById("start-date").value;
            var endDate = document.getElementById("end-date").value;
            var startTime = document.getElementById("start-time").value;
            var endTime = document.getElementById("end-time").value;

            // 여기에 데이터 유효성 검사 로직 추가
            if (!isValidDate(startDate) || !isValidDate(endDate) || !isValidTime(startTime) || !isValidTime(endTime)) {
                alert('날짜 또는 시간 형식이 올바르지 않습니다.');
                return false;
            }

            $.ajax({
                type: 'PUT',
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

            return false; // 폼 제출 방지
        }

        function isValidDate(dateString) {
            var pattern = /^\d{4}-\d{2}-\d{2}$/;
            return pattern.test(dateString);
        }

        function isValidTime(timeString) {
            var pattern = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
            return pattern.test(timeString);
        }

        function cancelForm() {
            window.location.href = '/schedule';
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            var todayDate = new Date().toISOString().slice(0, 10);
            document.getElementById("start-date").value = todayDate;
            document.getElementById("end-date").value = todayDate;
            document.getElementById("start-time").value = '09:00';
            document.getElementById("end-time").value = '10:00';
            
            flatpickr("#start-date", {
                dateFormat: "Y-m-d",
                defaultDate: todayDate,
                locale: "en",
                onChange: function(selectedDates, dateStr, instance) {
                    document.getElementById("end-date").value = dateStr;
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
                dateFormat: "H:i",
                defaultDate: "09:00"
            });
            
            flatpickr("#end-time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "10:00"
            });
        });
    </script>
</body>
</html>
