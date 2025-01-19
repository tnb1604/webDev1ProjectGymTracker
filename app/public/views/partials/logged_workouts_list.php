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
                        <form method="POST" action="/user/workouts/delete" style="margin: 0;">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWorkoutModalLabel">Edit Workout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Error Message Container -->
                <div id="editWorkoutError" class="alert alert-danger d-none" role="alert">
                    <!-- Error message will be populated dynamically -->
                </div>
                <form action="/user/workouts/update" method="POST" id="editWorkoutForm">
                    <input type="hidden" name="workout_id" id="editWorkoutId">

                    <!-- for debugging -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); // Unset the error after displaying ?>
                    <?php endif; ?>

                    <!-- Workout Name Input -->
                    <div class="mb-3">
                        <label for="editWorkoutName" class="form-label">Workout Name:</label>
                        <input type="text" id="editWorkoutName" name="workout_name" class="form-control" value=""
                            required maxlength="30">
                    </div>

                    <!-- Date Input -->
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Workout Date:</label>
                        <input type="date" id="editDate" name="date" class="form-control" value="" required>
                    </div>

                    <!-- Exercises Section -->
                    <div id="editExercisesSection">
                        <h4>Exercises</h4>
                        <!-- Existing exercises will be populated dynamically -->
                    </div>

                    <!-- Add Exercise Button -->
                    <button type="button" class="btn btn-secondary mb-3" id="addExerciseEditModal">Add Exercise</button>

                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/workoutList.js"></script>