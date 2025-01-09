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
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <h1>Exercises Page</h1>

    <!-- Display User Information -->
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>

    <h3>Your Exercises:</h3>
    <?php if (!empty($userExercises)): ?>
        <ul>
            <?php foreach ($userExercises as $exercise): ?>
                <li><?php echo htmlspecialchars($exercise['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no custom exercises yet.</p>
    <?php endif; ?>

    <h3>Global Exercises:</h3>
    <?php if (!empty($globalExercises)): ?>
        <ul>
            <?php foreach ($globalExercises as $exercise): ?>
                <li><?php echo htmlspecialchars($exercise['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No global exercises available.</p>
    <?php endif; ?>

    <!-- Add a form for creating exercises if needed -->
    <h3>Create New Exercise</h3>
    <form action="/addExercise" method="POST">
        <label for="name">Exercise Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Add Exercise</button>
    </form>
</body>
</html>
