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
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <h1>Log Workouts Page</h1>

    <!-- Display User Information -->
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>

    <h3>Your Logged Workouts:</h3>
    <?php if (!empty($userWorkouts)): ?>
        <ul>
            <?php foreach ($userWorkouts as $workout): ?>
                <li><?php echo htmlspecialchars($workout['name']); ?> on <?php echo htmlspecialchars($workout['date']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no logged workouts yet.</p>
    <?php endif; ?>

    <h3>Global Workouts:</h3>
    <?php if (!empty($globalWorkouts)): ?>
        <ul>
            <?php foreach ($globalWorkouts as $workout): ?>
                <li><?php echo htmlspecialchars($workout['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No global workouts available.</p>
    <?php endif; ?>

    <!-- Add a form for logging workouts -->
    <h3>Log a New Workout</h3>
    <form action="/addWorkout" method="POST">
        <label for="name">Workout Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <button type="submit">Log Workout</button>
    </form>
</body>
</html>
