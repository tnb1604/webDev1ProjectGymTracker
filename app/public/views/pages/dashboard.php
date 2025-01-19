<?php
if (!isset($_SESSION['username'])) {
    header('Location: /login');
    exit();
}

// Handle dynamic date navigation
$currentDate = $_GET['date'] ?? date('Y-m-d');
$currentMonth = date('m', strtotime($currentDate));
$currentYear = date('Y', strtotime($currentDate));

// Get the first and last day of the month
$firstDayOfMonth = date('Y-m-01', strtotime($currentDate));
$lastDayOfMonth = date('Y-m-t', strtotime($currentDate));

// Fetch logged workouts from database
$workoutModel = new WorkoutModel();
$loggedWorkouts = $workoutModel->getByDate($_SESSION['user_id'], $firstDayOfMonth, $lastDayOfMonth);

// Convert logged workouts to an associative array with dates as keys
$loggedWorkouts = array_column($loggedWorkouts, null, 'date');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/calendar.css">

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <?php require __DIR__ . '/../partials/welcome_message.php'; ?>

    <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'User'): ?>
        <?php require __DIR__ . '/../partials/calendar.php'; ?>
    <?php endif; ?>

</body>
</head>

</html>