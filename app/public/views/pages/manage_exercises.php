<?php
// Check if the user is logged in and is a manager
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'Manager') {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exercises</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include Header -->
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Manage Exercises</h1>
        <p class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <!-- Add New Exercise Section -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Add New Exercise
            </div>
            <div class="card-body">
                <form method="POST" action="/add_exercise">
                    <div class="mb-3">
                        <label for="exerciseName" class="form-label">Exercise Name</label>
                        <input type="text" class="form-control" id="exerciseName" name="exercise_name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Exercise</button>
                </form>
            </div>
        </div>

        <!-- List of Exercises (Global) -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                Existing Exercises
            </div>
            <ul class="list-group list-group-flush">
                <?php if (isset($data['exercises']) && count($data['exercises']) > 0): ?>
                    <?php foreach ($data['exercises'] as $exercise): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong><?php echo htmlspecialchars($exercise['name']); ?></strong>
                            </span>
                            <div class="d-flex">
                                <!-- Edit Button (Link to Edit Exercise Page or Modal) -->
                                <a href="/edit_exercise/<?php echo $exercise['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>

                                <!-- Delete Button -->
                                <form method="POST" action="/delete_exercise" style="margin: 0;">
                                    <input type="hidden" name="exercise_id" value="<?php echo $exercise['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No exercises available.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
