<div class="mb-4 mt-4">
    <h3>Your Logged Workouts:</h3>
    <?php
    // Sort the workouts by date (ascending order)
    usort($userWorkouts, function ($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });
    ?>
    <?php if (!empty($userWorkouts)): ?>
        <ul class="list-group">
            <?php foreach ($userWorkouts as $workout): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>
                        <?php echo htmlspecialchars($workout['name']); ?> on
                        <?php echo htmlspecialchars($workout['date']); ?>
                    </span>

                    <!-- Buttons Container -->
                    <div class="d-flex">
                        <!-- Edit Button (Modal or Link to Edit Global Exercise) -->
                        <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#editWorkoutModal" data-workout-id="<?php echo $workout['workout_id']; ?>">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form method="POST" action="/deleteWorkout" style="margin: 0;">
                            <input type="hidden" name="id" value="<?php echo $workout['workout_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">You have no logged workouts yet.</p>
    <?php endif; ?>
</div>

<!-- Edit Workout Modal -->
<div class="modal fade" id="editWorkoutModal" tabindex="-1" aria-labelledby="editWorkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWorkoutModalLabel">Edit Workout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/user/workouts/update" method="POST" id="editWorkoutForm">

                    <!-- for debugging -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Workout Name Input -->
                    <div class="mb-3">
                        <label for="editWorkoutName" class="form-label">Workout Name:</label>
                        <input type="text" id="editWorkoutName" name="workout_name" class="form-control" value=""
                            required>
                    </div>

                    <!-- Date Input -->
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Workout Date:</label>
                        <input type="date" id="editDate" name="date" class="form-control" value="" required>
                    </div>

                    <!-- Exercises Section -->
                    <div id="editExercisesSection">
                        <h4>Exercises</h4>
                        <!-- Exercises will be populated dynamically -->
                    </div>

                    <!-- Add Exercise Button -->
                    <button type="button" class="btn btn-secondary mb-3" id="addExercise">Add Exercise</button>

                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#editWorkoutModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // The button that triggered the modal
        var workoutId = button.getAttribute('data-workout-id');
        
        // Debug: log the workout_id to the console
        console.log('Workout ID:', workoutId);

        // Make AJAX request to fetch workout details
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/app/public/api/getWorkoutDetails.php?workout_id=' + workoutId, true);


        
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var workout = response.workout;
                var exercises = response.exercises;

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
                            <select name="exercises[${index}][name]" class="form-select" required>
                                <option value="" disabled>Select an Exercise</option>
                                <!-- Dynamic Exercise Options will be added here -->
                                <?php foreach ($allExercises as $availableExercise): ?>
                                        <option value="<?php echo htmlspecialchars($availableExercise['name']); ?>" 
                                            ${exercise.name === '<?php echo $availableExercise['name']; ?>' ? 'selected' : ''}>
                                            <?php echo htmlspecialchars($availableExercise['name']); ?>
                                        </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <h5>Sets</h5>
                            <div class="sets-section">
                                <div class="set mb-2 d-flex align-items-center">
                                    <input type="number" name="exercises[${index}][sets][0][reps]" class="form-control me-2" placeholder="Reps" required>
                                    <input type="number" name="exercises[${index}][sets][0][weight]" class="form-control me-2" placeholder="Weight (kg)" required>
                                    <button type="button" class="btn btn-danger remove-set">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary add-set">Add Set</button>
                        </div>
                    </div>`;

                    exerciseDiv.innerHTML = exerciseContent;
                    exercisesSection.appendChild(exerciseDiv);
                });
            } else {
                // Debugging: alert error and log the status
                alert('Failed to load workout details. Status: ' + xhr.status);
                console.log('Failed to load workout details. Status:', xhr.status);
            }
        };

        xhr.onerror = function () {
            alert('Request failed');
            console.log('AJAX request failed');
        };

        xhr.send();
    });
</script>
