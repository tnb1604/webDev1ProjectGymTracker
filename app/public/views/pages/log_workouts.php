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
        <h1 class="text-center mb-4">Your Workouts</h1>

        <!-- Log a New Workout Form -->
        <div class="card">
            <div class="card-header">
                <h3>Log a new workout</h3>
            </div>
            <div class="card-body">
                <form action="/user/workouts/submit" method="POST" id="workoutForm">

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
                        <label for="workoutName" class="form-label">Workout Name:</label>
                        <input type="text" required maxlength="30"  id="workoutName" placeholder="e.g. Push Day" name="workout_name"
                            class="form-control" required>
                    </div>

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
                                    <label for="exerciseName" class="form-label" >Exercise Name:</label>
                                    <select name="exercises[0][name]" id="exerciseName" class="form-select" required>
                                        <option value="" disabled selected>Select an Exercise</option>
                                        <?php foreach ($allExercises as $exercise): ?>
                                            <option value="<?php echo htmlspecialchars($exercise['name']); ?>">
                                                <?php echo htmlspecialchars($exercise['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <h5>Sets</h5>
                                    <div class="sets-section">
                                        <div class="set mb-2 d-flex align-items-center">
                                            <input type="number" name="exercises[0][sets][0][reps]"
                                                class="form-control me-2" placeholder="Reps" required>
                                            <input type="number" step="0.01" name="exercises[0][sets][0][weight]"
                                                class="form-control me-2" placeholder="Weight (kg)" required>
                                            <button type="button" class="btn btn-danger remove-set">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary add-set">Add Set</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Exercise Button -->
                    <button type="button" class="btn btn-secondary mb-3" id="addExercise">Add Exercise</button>

                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Log Workout</button>
                    </div>

                </form>
            </div>
        </div>

        <?php require __DIR__ . '/../partials/logged_workouts_list.php'; ?>

        <!-------- Bootstrap JS -------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            var allExercises = <?php echo json_encode($allExercises); ?>;
        </script>
        <script src="/assets/js/logWorkout.js"></script>
</body>

</html>