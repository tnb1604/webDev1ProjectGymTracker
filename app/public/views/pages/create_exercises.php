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
                                <!-- Modify Button -->
                                <a href="/editExercise?exercise_id=<?php echo $exercise['exercise_id']; ?>"
                                    class="btn btn-sm btn-warning me-2">Modify</a>

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
                <form action="/addExercise" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Exercise Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter exercise name"
                            required>
                        <div class="invalid-feedback">
                            Please enter an exercise name.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Exercise</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>