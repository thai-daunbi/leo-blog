<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8"/>
</head>
<body>
   <h3>Edit Event</h3>

   <form action="{{ route('update-schedule', ['id' => $schedule->id]) }}" method="POST">

      @csrf
      @method('PUT')

      <!-- Show Event Date and Time -->
      <p>Date: {{ date("d-m-Y", strtotime($schedule->start)) }}</p> 
      <p>Time: {{ date("H:i:s", strtotime($schedule->start)) }}</p>

      <!-- JavaScript Button to Add Checkbox -->
      <button type="button" id="addCheckboxButton">Add Student</button><br>

      <!-- Container to Append New Checkboxes -->
      <div id="additionalCheckboxes">
         <!-- Existing checkboxes for students -->
         @foreach($schedule->students as $student)
         <div class="checkbox-container" id="checkbox{{ $student->id }}">
            <input type="checkbox" id="button{{ $student->id }}" name="students[]" value="{{ $student->name }}" checked>
            <label for="button{{ $student->id }}">{{ $student->name }}</label>
            <button type="button" class="removeCheckboxButton" onclick="removeCheckbox('checkbox{{ $student->id }}')">X</button>
         </div>
         @endforeach
      </div>

      <!-- Submit Button -->
      <button type='submit'>Update Schedule</button>
      <button onclick="cancelForm(event)">Cancel</button>
    </form>

    <!-- Add JavaScript code to submit the form and handle adding/removing checkboxes -->
    <script>
    function removeCheckbox(checkboxContainerId) {
        const checkboxContainer = document.getElementById(checkboxContainerId);
        if (checkboxContainer) {
            checkboxContainer.remove();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const addCheckboxButton = document.getElementById('addCheckboxButton');
        const additionalCheckboxes = document.getElementById('additionalCheckboxes');

        addCheckboxButton.addEventListener('click', function () {
            const checkboxLabel = prompt('Enter student name:');
            if (checkboxLabel) {
                const checkboxId = 'button' + (additionalCheckboxes.children.length + 1); // Increment the checkbox id

                // Create a new checkbox container
                const checkboxContainer = document.createElement('div');
                checkboxContainer.className = 'checkbox-container';
                checkboxContainer.id = 'checkbox' + (additionalCheckboxes.children.length + 1);

                // Create a checkbox
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = checkboxId;
                checkbox.name = 'students[]';
                checkbox.value = checkboxLabel;
                checkbox.checked = true;

                // Create a label
                const label = document.createElement('label');
                label.setAttribute('for', checkboxId);
                label.textContent = checkboxLabel;

                // Create a remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'removeCheckboxButton';
                removeButton.textContent = 'X';
                removeButton.onclick = function () {
                    removeCheckbox(checkboxContainer.id);
                };

                // Append elements to the checkbox container
                checkboxContainer.appendChild(checkbox);
                checkboxContainer.appendChild(label);
                checkboxContainer.appendChild(removeButton);

                // Add the new checkbox container to the "additionalCheckboxes" div
                additionalCheckboxes.appendChild(checkboxContainer);
            }
        });

        form.addEventListener('submit', function (event) {
            // Form submission will handle the addition and removal of checkboxes
            // No need for additional JavaScript here
        });
        });
    </script>
</body>
</html>
