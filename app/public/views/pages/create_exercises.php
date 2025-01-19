<?php
//session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] === 'Manager') {
    header('Location: /login');
    exit();
}

// Initialize the search term
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Filter exercises based on the search term
$userExercises = array_filter($userExercises, function ($exercise) use ($search_term) {
    return stripos($exercise['name'], $search_term) !== false;
});

$globalExercises = array_filter($globalExercises, function ($exercise) use ($search_term) {
    return stripos($exercise['name'], $search_term) !== false;
});

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
if ($error_message) {
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container mt-5">
        <!-- Display Error Message if Available -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h1 class="text-center">Your Exercises</h1>

        <!-- Add Search Option -->
        <form method="GET" action="" class="d-flex my-4">
            <input type="text" name="search" class="form-control me-2" placeholder="Search exercises" value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <a href="/user/exercises" class="btn btn-secondary">Reset</a>
        </form>

        <!-- Create New Exercise Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Create New Exercise
            </div>
            <div class="card-body">
                <form action="/addExercise" method="POST" class="needs-validation" id="createExerciseForm" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Exercise Name:</label>
                        <input type="text" id="name" required maxlength="40"  name="name" class="form-control" placeholder="Enter exercise name" required>
                        <div class="invalid-feedback" id="nameError">Please enter an exercise name.</div>
                    </div>
                    <button type="submit" class="btn btn-success">Add Exercise</button>
                </form>
            </div>
        </div>

        <!-- User Exercises Section -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                Your Exercises
            </div>
            <ul class="list-group list-group-flush">
                <?php if (!empty($userExercises)): ?>
                    <?php foreach ($userExercises as $exercise): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo htmlspecialchars($exercise['name']); ?></span>
                            <div>
                                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editExerciseModal" data-id="<?php echo $exercise['exercise_id']; ?>" data-name="<?php echo htmlspecialchars($exercise['name']); ?>">Edit</button>
                                <form action="/deleteExercise" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $exercise['exercise_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No custom exercises available.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Global Exercises Section -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                Global Exercises
            </div>
            <ul class="list-group list-group-flush">
                <?php if (!empty($globalExercises)): ?>
                    <?php foreach ($globalExercises as $exercise): ?>
                        <li class="list-group-item"> <?php echo htmlspecialchars($exercise['name']); ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No global exercises available.</li>
                <?php endif; ?>
            </ul>
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
                                <input type="text" id="exerciseName" required maxlength="40" name="name" class="form-control" required>
                                <input type="hidden" id="exerciseId" name="id">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/create_exercises.js"></script>

</body>

</html>
