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

      <!-- JavaScript Button to Add Checkbox -->
      <button type="button" id="addCheckboxButton">Add Student</button><br>

      <!-- Container to Append New Checkboxes -->
      <div id="additionalCheckboxes"></div>

      <!-- Checkbox Options -->
      <input type="checkbox" id="button1" name="button1" value="1" {{ $schedule->button1 ? 'checked' : '' }}>
      <label for="button1">ゆ</label><br>
      
      <input type="checkbox" id="button2" name="button2" value="1" {{ $schedule->button2 ? 'checked' : '' }}>
      <label for="button2">う</label><br>

      <!-- Submit Button -->
      <button type='submit'>Update Schedule</button>
    </form>

    <!-- Add JavaScript code to submit the form and handle adding checkboxes -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const addCheckboxButton = document.getElementById('addCheckboxButton');
            const additionalCheckboxes = document.getElementById('additionalCheckboxes');

            addCheckboxButton.addEventListener('click', function () {
                const checkboxLabel = prompt('Enter checkbox label:');
                if (checkboxLabel) {
                    const checkboxId = 'button' + (additionalCheckboxes.children.length + 3); // Increment the checkbox id
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = checkboxId;
                    checkbox.name = checkboxId;
                    checkbox.value = '1';

                    const label = document.createElement('label');
                    label.setAttribute('for', checkboxId);
                    label.textContent = checkboxLabel;

                    // Add new checkbox before the "additionalCheckboxes" div
                    additionalCheckboxes.parentNode.insertBefore(checkbox, additionalCheckboxes);
                    additionalCheckboxes.parentNode.insertBefore(label, additionalCheckboxes);
                    additionalCheckboxes.parentNode.insertBefore(document.createElement('br'), additionalCheckboxes);
                }
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault(); 
                form.submit(); 
            });
        });
    </script>
</body>
</html>
