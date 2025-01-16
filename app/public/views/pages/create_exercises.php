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
    <title>Exercises</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="app\public\assets\js\exercise.js" defer></script>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container my-4">
        <h1 class="alert alert-info text-center">Exercises Page</h1>

        <!-- User Exercises -->
        <div class="mb-4">
            <h3>Your Exercises:</h3>
            <?php if (!empty($userExercises)): ?>
                <ul class="list-group">
                    <?php foreach ($userExercises as $exercise): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($exercise['name']); ?>
                            <div>
                                <!-- Modify Button (now triggering the modal) -->
                                <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editExerciseModal" 
                                    data-id="<?php echo $exercise['exercise_id']; ?>"
                                    data-name="<?php echo htmlspecialchars($exercise['name']); ?>">Modify</button>

                                <!-- Delete Button -->
                                <form action="/deleteExercise" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $exercise['exercise_id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">You have no custom exercises yet.</p>
            <?php endif; ?>
        </div>

        <!-- Global Exercises -->
        <div class="mb-4">
            <h3>Global Exercises:</h3>
            <?php if (!empty($globalExercises)): ?>
                <ul class="list-group">
                    <?php foreach ($globalExercises as $exercise): ?>
                        <li class="list-group-item"><?php echo htmlspecialchars($exercise['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No global exercises available.</p>
            <?php endif; ?>
        </div>

        <!-- Create New Exercise Form -->
        <div class="card">
            <div class="card-header">
                <h3>Create New Exercise</h3>
            </div>
            <div class="card-body">
                <form action="/addExercise" method="POST" class="needs-validation" id="createExerciseForm" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Exercise Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter exercise name" required>
                        <div class="invalid-feedback" id="nameError">
                            Please enter an exercise name.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Exercise</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Exercise Modal -->
    <div class="modal fade" id="editExerciseModal" tabindex="-1" aria-labelledby="editExerciseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExerciseModalLabel">Edit Exercise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/editExercise" method="POST" id="editExerciseForm">
                        <div class="mb-3">
                            <label for="exerciseName" class="form-label">Exercise Name:</label>
                            <input type="text" id="exerciseName" name="name" class="form-control" placeholder="Enter new exercise name" required>
                            <input type="hidden" id="exerciseId" name="id">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    // When the Modify button is clicked, populate the modal with the exercise data
    const editButtons = document.querySelectorAll('.btn-warning');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const exerciseId = this.getAttribute('data-id');
            const exerciseName = this.getAttribute('data-name');

            // Populate the modal with exercise data
            document.getElementById('exerciseId').value = exerciseId;
            document.getElementById('exerciseName').value = exerciseName;
        });
    });

    // Handle form submission for creating an exercise
    const createExerciseForm = document.getElementById('createExerciseForm');
    createExerciseForm.addEventListener('submit', function(event) {
        const nameInput = document.getElementById('name');
        const nameError = document.getElementById('nameError');

        // Check if the name input is empty
        if (nameInput.value.trim() === '') {
            event.preventDefault(); // Prevent form submission
            nameInput.classList.add('is-invalid'); // Add Bootstrap invalid class
            nameError.style.display = 'block'; // Display error message
        } else {
            nameInput.classList.remove('is-invalid'); // Remove invalid class if valid
            nameError.style.display = 'none'; // Hide error message
        }
    });
</script>

</html>
