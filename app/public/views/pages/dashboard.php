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

// Fetch logged workouts from database (mock data for now)
$loggedWorkouts = [
    '2025-02-10' => 'Workout 1',
    '2025-01-15' => 'Workout 2',
];
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Welcome to Your Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h5>
                        <p class="card-text">You're successfully logged in and ready to go.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <?php if ($_SESSION['type'] === 'User'): ?>
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white d-flex justify-content-between">
                    <a href="?date=<?= date('Y-m-d', strtotime("$currentYear-$currentMonth -1 month")) ?>"
                        class="btn btn-light btn-sm">&lt; Previous</a>
                    <h5 class="text-center mb-0"><?= date('F Y', strtotime($currentDate)); ?></h5>
                    <a href="?date=<?= date('Y-m-d', strtotime("$currentYear-$currentMonth +1 month")) ?>"
                        class="btn btn-light btn-sm">Next &gt;</a>
                </div>
                <div class="card-body">
                    <div class="calendar">
                        <?php
                        // Days of the week labels
                        $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                        foreach ($weekDays as $day) {
                            echo "<div class='calendar-day font-weight-bold bg-light'>$day</div>";
                        }

                        // Empty slots before 1st day
                        $startDay = date('w', strtotime($firstDayOfMonth));
                        for ($i = 0; $i < $startDay; $i++) {
                            echo '<div class="calendar-day"></div>';
                        }

                        // Days of the current month
                        $daysInMonth = date('t', strtotime($currentDate));
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $currentDay = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                            $isToday = $currentDay === date('Y-m-d') ? 'today' : '';
                            $hasWorkout = isset($loggedWorkouts[$currentDay]) ? 'logged' : '';
                            echo "<div class='calendar-day $isToday $hasWorkout' data-date='$currentDay'>
                                    <span>$day</span>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</head>

</html>