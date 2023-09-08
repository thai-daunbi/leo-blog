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
         <!-- Existing checkboxes for button1 and button2 -->
         <div class="checkbox-container" id="checkbox1">
            <input type="checkbox" id="button1" name="button1"{{ $schedule->button1 ? 'checked' : '' }}>
            <label for="button1">ゆ</label>
            <button type="button" class="removeCheckboxButton" onclick="removeCheckbox('checkbox1')">X</button>
         </div>
         
         <div class="checkbox-container" id="checkbox2">
            <input type="checkbox" id="button2" name="button2"{{ $schedule->button2 ? 'checked' : '' }}>
            <label for="button2">う</label>
            <button type="button" class="removeCheckboxButton" onclick="removeCheckbox('checkbox2')">X</button>
         </div>
      </div>

      <!-- Submit Button -->
      <button type='submit'>Update Schedule</button>
    </form>

    <!-- Add JavaScript code to submit the form and handle adding/removing checkboxes -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const addCheckboxButton = document.getElementById('addCheckboxButton');
            const additionalCheckboxes = document.getElementById('additionalCheckboxes');

            addCheckboxButton.addEventListener('click', function () {
                const checkboxLabel = prompt('Enter checkbox label:');
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
                    checkbox.name = checkboxId;
                    checkbox.value = '1';

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
                // Set the values of checkboxes based on their checked state
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function (checkbox) {
                    document.querySelector('input[name="' + checkbox.name + '"]').value = checkbox.checked ? '1' : '0';
                });
            });

            fetch('/add-student', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                label: checkboxLabel,
                // Add other data you want to send to the server
                })
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response, e.g., show a success message
                console.log(data);
            })
            .catch(error => {
                // Handle errors
                console.error(error);
            });
        });

        function removeCheckbox(checkboxContainerId) {
            const checkboxContainer = document.getElementById(checkboxContainerId);
            if (checkboxContainer) {
                checkboxContainer.remove();
            }
        }
    </script>
</body>
</html>
