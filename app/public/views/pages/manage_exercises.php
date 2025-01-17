<?php
// Check if the user is logged in and is a manager
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'Manager') {
    header('Location: /login');
    exit();
}

// Check for error messages in session
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
if ($error_message) {
    // Clear error message after displaying it once
    unset($_SESSION['error_message']);
}

// Handle search query if provided
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search_term) {
    // Filter exercises based on the search term
    $globalExercises = array_filter($globalExercises, function ($exercise) use ($search_term) {
        return stripos($exercise['name'], $search_term) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Global Exercises</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Include Header -->
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Global Exercises</h1>


        <!-- Display Error Message if Available -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Add Search Option -->
        <div class="my-3">
            <form method="GET" action="" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search exercises"
                    value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" class="btn btn-primary me-2">Search</button>
                <a href="/manage/exercises" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <!-- Add New Global Exercise Section -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Add New Global Exercise
            </div>
            <div class="card-body">
                <form method="POST" action="/addGlobalExercise">
                    <div class="mb-3">
                        <label for="exerciseName" class="form-label">Exercise Name</label>
                        <input type="text" class="form-control" id="exerciseName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Exercise</button>
                </form>
            </div>
        </div>

        <!-- List of Global Exercises -->
        <div class="card mt-4 mb-4">
            <div class="card-header bg-secondary text-white">
                Global Exercises
            </div>
            <ul class="list-group list-group-flush">
                <?php if (isset($globalExercises) && count($globalExercises) > 0): ?>
                    <?php foreach ($globalExercises as $exercise): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong><?php echo htmlspecialchars($exercise['name']); ?></strong>
                            </span>
                            <div class="d-flex">
                                <!-- Edit Button (Modal or Link to Edit Global Exercise) -->
                                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#editExerciseModal" data-id="<?php echo $exercise['exercise_id']; ?>"
                                    data-name="<?php echo htmlspecialchars($exercise['name']); ?>">Edit</button>

                                <!-- Delete Button -->
                                <form method="POST" action="/deleteGlobalExercise" style="margin: 0;">
                                    <input type="hidden" name="id" value="<?php echo $exercise['exercise_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No global exercises available.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Edit Exercise Modal -->
        <div class="modal fade" id="editExerciseModal" tabindex="-1" aria-labelledby="editExerciseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExerciseModalLabel">Edit Exercise</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/editGlobalExercise" method="POST" id="editExerciseForm">
                            <div class="mb-3">
                                <label for="editExerciseName" class="form-label">Exercise Name:</label>
                                <input type="text" id="editExerciseName" name="name" class="form-control"
                                    placeholder="Enter new exercise name" required>
                                <input type="hidden" id="exerciseId" name="id">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Fill the modal with the selected exercise data
            const editButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const exerciseId = this.getAttribute('data-id');
                    const exerciseName = this.getAttribute('data-name');

                    // Populate the fields in the modal
                    document.getElementById('exerciseId').value = exerciseId;
                    document.getElementById('editExerciseName').value = exerciseName;
                });
            });
        </script>
</body>

</html>