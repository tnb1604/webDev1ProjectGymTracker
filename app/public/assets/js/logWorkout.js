document.addEventListener('DOMContentLoaded', () => {
    const exercisesSection = document.getElementById('exercisesSection');
    const addExerciseButton = document.getElementById('addExercise');
    let exerciseCount = 1;

    addExerciseButton.addEventListener('click', () => {
        const newExercise = document.createElement('div');
        newExercise.classList.add('exercise', 'mb-3', 'border', 'p-3', 'rounded');
        newExercise.innerHTML = `
            <div class="row mb-2">
                <div class="col-md-3">
                    <label for="exerciseName" class="form-label">Exercise Name:</label>
                    <select name="exercises[${exerciseCount}][name]" id="exerciseName" class="form-select" required>
                        <option value="" disabled selected>Select an Exercise</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <h5>Sets</h5>
                    <div class="sets-section">
                        <div class="set mb-2 d-flex align-items-center">
                            <input type="number" name="exercises[${exerciseCount}][sets][0][reps]" class="form-control me-2" placeholder="Reps" required>
                            <input type="number" step="0.01" name="exercises[${exerciseCount}][sets][0][weight]" class="form-control me-2" placeholder="Weight (kg)" required>
                            <button type="button" class="btn btn-danger remove-set">Remove</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary add-set">Add Set</button>
                </div>
            </div>
        `;
        exercisesSection.appendChild(newExercise);

        // Populate the exercise name dropdown with all available exercises
        const select = newExercise.querySelector('select');
        allExercises.forEach(exercise => {
            const option = document.createElement('option');
            option.value = exercise.name;
            option.textContent = exercise.name;
            select.appendChild(option);
        });

        exerciseCount++;
    });

    exercisesSection.addEventListener('click', (event) => {
        if (event.target.classList.contains('add-set')) {
            const setsSection = event.target.closest('.exercise').querySelector('.sets-section');
            const setCount = setsSection.querySelectorAll('.set').length;
            const exerciseIndex = event.target.closest('.exercise').querySelector('select').name.match(/\d+/)[0];

            const newSet = document.createElement('div');
            newSet.classList.add('set', 'mb-2', 'd-flex', 'align-items-center');
            newSet.innerHTML = `
                <input type="number" name="exercises[${exerciseIndex}][sets][${setCount}][reps]" class="form-control me-2" placeholder="Reps" required>
                <input type="number" step="0.01" name="exercises[${exerciseIndex}][sets][${setCount}][weight]" class="form-control me-2" placeholder="Weight (kg)" required>
                <button type="button" class="btn btn-danger remove-set">Remove</button>
            `;
            setsSection.appendChild(newSet);
        } else if (event.target.classList.contains('remove-set')) {
            const set = event.target.closest('.set');
            const setsSection = set.closest('.sets-section');
            set.remove();
            if (setsSection.children.length === 0) {
                setsSection.closest('.exercise').remove();
            }
        }
    });

    exercisesSection.addEventListener('input', (event) => {
        if (event.target.type === 'number') {
            const value = event.target.value;
            const errorElementId = `${event.target.id}-error`; // Unique ID for the error message

            // Check if the value length exceeds 7
            if (value.length > 7) {
                // Find or create an error message element
                let errorElement = document.getElementById(errorElementId);
                if (!errorElement) {
                    errorElement = document.createElement('div');
                    errorElement.id = errorElementId;
                    errorElement.style.color = 'red';
                    errorElement.style.fontSize = '0.9em';
                    errorElement.style.marginTop = '5px';
                    event.target.parentNode.appendChild(errorElement); // Append error message after the input
                }

                // Set the error message and clear the invalid input
                errorElement.textContent = 'The number is too long. Please enter a valid number.';
                event.target.value = ''; // Clear the input
            } else {
                // Remove the error message if the input is valid
                const existingErrorElement = document.getElementById(errorElementId);
                if (existingErrorElement) {
                    existingErrorElement.remove();
                }
            }
        }
    });

});

// Add Exercise button logic to add new exercise sections
document.getElementById('addExerciseModal').addEventListener('click', function () {
    var exercisesSection = document.getElementById('editExercisesSection');
    var exerciseCount = exercisesSection.querySelectorAll('.exercise').length;

    var newExercise = document.createElement('div');
    newExercise.classList.add('exercise', 'mb-3', 'border', 'p-3', 'rounded');
    newExercise.innerHTML = `
<div class="row mb-2">
    <div class="col-md-3">
        <label for="exerciseName" class="form-label">Exercise Name:</label>
        <select name="exercises[${exerciseCount}][name]" id="exerciseName" class="form-select" required>
            <option value="" disabled selected>Select an Exercise</option>
            <!-- Populate options dynamically using JavaScript -->
        </select>
    </div>
    <div class="col-md-8">
        <h5>Sets</h5>
        <div class="sets-section">
            <div class="set mb-2 d-flex align-items-center">
                <input type="number" name="exercises[${exerciseCount}][sets][0][reps]" class="form-control me-2" placeholder="Reps" required>
                <input type="number" step="0.01" name="exercises[${exerciseCount}][sets][0][weight]" class="form-control me-2" placeholder="Weight (kg)" required>
                <button type="button" class="btn btn-danger remove-set">Remove</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary add-set">Add Set</button>
    </div>
</div>
`;
    exercisesSection.appendChild(newExercise);
});

//loloololol
document.querySelector('#editWorkoutModal').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // The button that triggered the modal
    var workoutId = button.getAttribute('data-workout-id');
    document.getElementById('editWorkoutId').value = workoutId;

    // Debug: log the workout_id to the console
    console.log('Workout ID:', workoutId);

    // Make AJAX request to fetch workout details
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/getWorkoutDetails.php?workout_id=' + workoutId, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Response Text:", xhr.responseText); // Log the raw response
            try {
                var response = JSON.parse(xhr.responseText); // Attempt to parse the response
                var workout = response.workout;
                var exercises = response.exercises;
                var allExercises = response.allExercises; // Get all available exercises

                // Set the workout name and date in the modal
                var modal = document.getElementById('editWorkoutModal');
                modal.querySelector('#editWorkoutName').value = workout.name;
                modal.querySelector('#editDate').value = workout.date;

                // Fill the exercises section dynamically
                var exercisesSection = modal.querySelector('#editExercisesSection');
                exercisesSection.innerHTML = ''; // Clear any existing exercises

                exercises.forEach(function (exercise, index) {
                    var exerciseDiv = document.createElement('div');
                    exerciseDiv.classList.add('exercise', 'mb-3', 'border', 'p-3', 'rounded');

                    var exerciseContent = `
        <div class="row mb-2">
            <div class="col-md-3">
                <label for="exerciseName" class="form-label">Exercise Name:</label>
                <select name="exercises[${index}][name]" id="exerciseName" class="form-select" required>
                    <option value="" disabled>Select an Exercise</option>
                </select>
            </div>
            <div class="col-md-8">
                <h5>Sets</h5>
                <div class="sets-section">
                    <!-- Existing sets will be populated dynamically -->
                </div>
                <button type="button" class="btn btn-secondary add-set">Add Set</button>
            </div>
        </div>
    `;

                    exerciseDiv.innerHTML = exerciseContent;

                    // Populate the exercise name dropdown with all available exercises
                    var select = exerciseDiv.querySelector('select');
                    allExercises.forEach(function (availableExercise) {
                        var option = document.createElement('option');
                        option.value = availableExercise.name;
                        option.textContent = availableExercise.name;
                        if (exercise.exercise_name === availableExercise.name) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });

                    // Populate the sets
                    var setsSection = exerciseDiv.querySelector('.sets-section');
                    exercise.sets.forEach(function (set, setIndex) {
                        var setDiv = document.createElement('div');
                        setDiv.classList.add('set', 'mb-2', 'd-flex', 'align-items-center');
                        setDiv.innerHTML = `
            <input type="number" name="exercises[${index}][sets][${setIndex}][reps]" class="form-control me-2" placeholder="Reps" value="${set.reps}" required>
            <input type="number" step="0.01" name="exercises[${index}][sets][${setIndex}][weight]" class="form-control me-2" placeholder="Weight (kg)" value="${set.weight}" required>
            <button type="button" class="btn btn-danger remove-set">Remove</button>
        `;
                        setsSection.appendChild(setDiv);
                    });

                    exercisesSection.appendChild(exerciseDiv);
                });
            } catch (e) {
                console.error('Error parsing JSON response:', e);
                alert('Failed to load workout details. Please try again later.');
            }
        } else {
            alert('Failed to load workout details. Status: ' + xhr.status);
            console.log('Failed to load workout details. Status:', xhr.status);
        }
    };


    xhr.send();
});

// Add event listener for add set and remove set buttons
document.getElementById('editWorkoutModal').addEventListener('click', function (event) {
    if (event.target.classList.contains('add-set')) {
        var setsSection = event.target.closest('.exercise').querySelector('.sets-section');
        var setCount = setsSection.querySelectorAll('.set').length;
        var exerciseIndex = event.target.closest('.exercise').querySelector('select').name.match(/\d+/)[0];

        var newSet = document.createElement('div');
        newSet.classList.add('set', 'mb-2', 'd-flex', 'align-items-center');
        newSet.innerHTML = `
    <input type="number" name="exercises[${exerciseIndex}][sets][${setCount}][reps]" class="form-control me-2" placeholder="Reps" required>
    <input type="number" step="0.01" name="exercises[${exerciseIndex}][sets][${setCount}][weight]" class="form-control me-2" placeholder="Weight (kg)" required>
    <button type="button" class="btn btn-danger remove-set">Remove</button>
`;
        setsSection.appendChild(newSet);
    } else if (event.target.classList.contains('remove-set')) {
        var set = event.target.closest('.set');
        var setsSection = set.closest('.sets-section');
        set.remove();
        if (setsSection.children.length === 0) {
            setsSection.closest('.exercise').remove();
        }
    }
});


// Add Exercise button logic to add new exercise sections
document.getElementById('addExerciseEditModal').addEventListener('click', function () {
    var exercisesSection = document.getElementById('editExercisesSection');
    var exerciseCount = exercisesSection.querySelectorAll('.exercise').length;

    var newExercise = document.createElement('div');
    newExercise.classList.add('exercise', 'mb-3', 'border', 'p-3', 'rounded');
    newExercise.innerHTML = `
<div class="row mb-2">
    <div class="col-md-3">
        <label for="exerciseName" class="form-label">Exercise Name:</label>
        <select name="exercises[${exerciseCount}][name]" id="exerciseName" class="form-select" required>
            <option value="" disabled selected>Select an Exercise</option>
        </select>
    </div>
    <div class="col-md-8">
        <h5>Sets</h5>
        <div class="sets-section">
            <div class="set mb-2 d-flex align-items-center">
                <input type="number" name="exercises[${exerciseCount}][sets][0][reps]" class="form-control me-2" placeholder="Reps" required>
                <input type="number" step="0.01" name="exercises[${exerciseCount}][sets][0][weight]" class="form-control me-2" placeholder="Weight (kg)" required>
                <button type="button" class="btn btn-danger remove-set">Remove</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary add-set">Add Set</button>
    </div>
</div>
`;
    exercisesSection.appendChild(newExercise);

    // Populate the exercise name dropdown with all available exercises
    var select = newExercise.querySelector('select');
    allExercises.forEach(function (availableExercise) {
        var option = document.createElement('option');
        option.value = availableExercise.name;
        option.textContent = availableExercise.name;
        select.appendChild(option);
    });
});