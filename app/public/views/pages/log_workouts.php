<?php
//session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] === 'Manager') {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Workouts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <div class="container my-4">
        <h1 class="text-center">Log a New Workout</h1>

        <!-- Logged Workouts -->
        <div class="mb-4">
            <h3>Your Logged Workouts:</h3>
            <?php if (!empty($userWorkouts)): ?>
                <ul class="list-group">
                    <?php foreach ($userWorkouts as $workout): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($workout['name']); ?> on <?php echo htmlspecialchars($workout['date']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">You have no logged workouts yet.</p>
            <?php endif; ?>
        </div>

        <!-- Log a New Workout Form -->
        <div class="card">
            <div class="card-header">
                <h3>Log a New Workout</h3>
            </div>
            <div class="card-body">
                <form action="/addWorkout" method="POST" id="workoutForm">
                    <!-- Date Input -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Workout Date:</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <!-- Exercises Section -->
                    <div id="exercisesSection">
                        <h4>Exercises</h4>
                        <div class="exercise mb-3 border p-3 rounded">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <label for="exerciseName" class="form-label">Exercise Name:</label>
                                    <input type="text" name="exercises[0][name]" class="form-control" placeholder="Exercise Name" readonly required>
                                    <button type="button" class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#exerciseModal">Select Exercise</button>
                                </div>
                                <div class="col-md-2">
                                    <label for="sets" class="form-label">Sets:</label>
                                    <input type="number" name="exercises[0][sets]" class="form-control" placeholder="Sets" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="reps" class="form-label">Reps:</label>
                                    <input type="number" name="exercises[0][reps]" class="form-control" placeholder="Reps" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="weight" class="form-label">Weight:</label>
                                    <input type="number" name="exercises[0][weight]" class="form-control" placeholder="Weight (kg)" required>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-exercise">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Exercise Button -->
                    <button type="button" class="btn btn-secondary mb-3" id="addExercise">Add Exercise</button>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Log Workout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Exercise Selection Modal -->
    <div class="modal fade" id="exerciseModal" tabindex="-1" aria-labelledby="exerciseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exerciseModalLabel">Select an Exercise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="exerciseSearch" class="form-control mb-3" placeholder="Search exercises...">
                    <ul class="list-group" id="exerciseList">
                        <?php foreach ($allExercises as $exercise): ?>
                            <li class="list-group-item exercise-item" data-name="<?php echo htmlspecialchars($exercise['name']); ?>">
                                <?php echo htmlspecialchars($exercise['name']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
                            <input type="text" name="exercises[${exerciseCount}][name]" class="form-control" placeholder="Exercise Name" readonly required>
                            <button type="button" class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#exerciseModal">Select Exercise</button>
                        </div>
                        <div class="col-md-2">
                            <label for="sets" class="form-label">Sets:</label>
                            <input type="number" name="exercises[${exerciseCount}][sets]" class="form-control" placeholder="Sets" required>
                        </div>
                        <div class="col-md-2">
                            <label for="reps" class="form-label">Reps:</label>
                            <input type="number" name="exercises[${exerciseCount}][reps]" class="form-control" placeholder="Reps" required>
                        </div>
                        <div class="col-md-2">
                            <label for="weight" class="form-label">Weight:</label>
                            <input type="number" name="exercises[${exerciseCount}][weight]" class="form-control" placeholder="Weight (kg)" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-exercise">Delete</button>
                        </div>
                    </div>
                `;
                exercisesSection.appendChild(newExercise);
                exerciseCount++;
            });

            exercisesSection.addEventListener('click', (event) => {
                if (event.target.classList.contains('remove-exercise')) {
                    event.target.closest('.exercise').remove();
                }
            });

            const exerciseList = document.getElementById('exerciseList');
            const exerciseSearch = document.getElementById('exerciseSearch');

            exerciseSearch.addEventListener('input', () => {
                const searchValue = exerciseSearch.value.toLowerCase();
                document.querySelectorAll('.exercise-item').forEach(item => {
                    const exerciseName = item.dataset.name.toLowerCase();
                    if (exerciseName.includes(searchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            exerciseList.addEventListener('click', (event) => {
                if (event.target.classList.contains('exercise-item')) {
                    const exerciseName = event.target.dataset.name;
                    const activeInput = document.querySelector('.exercise input[readonly]');
                    if (activeInput) {
                        activeInput.value = exerciseName;
                    }
                    const modal = bootstrap.Modal.getInstance(document.getElementById('exerciseModal'));
                    modal.hide();
                }
            });
        });
    </script>
</body>

</html>
