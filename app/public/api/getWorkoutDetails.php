<?php
// Include necessary files (e.g., database connection, class files)
require_once __DIR__ . '/../lib/env.php';
require_once __DIR__ . '/../models/WorkoutModel.php';

// Assuming the class containing getWorkoutDetails is called 'WorkoutClass' and it is properly set up
$workoutModel = new WorkoutModel();

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Check if workout_id is passed via GET
if (isset($_GET['workout_id'])) {
    // Sanitize input to prevent potential security issues (e.g., SQL Injection)
    $workoutId = filter_var($_GET['workout_id'], FILTER_VALIDATE_INT);

    if ($workoutId) {
        // Call the method to get workout details
        $result = $workoutModel->getWorkoutDetails($workoutId);

        // Return the result as a JSON response
        echo json_encode($result);
    } else {
        // If workout_id is invalid, return an error
        echo json_encode([
            'success' => false,
            'error' => 'Invalid workout ID.'
        ]);
    }
} else {
    // If workout_id is not set in the GET request, return an error
    echo json_encode([
        'success' => false,
        'error' => 'No workout ID provided.'
    ]);
}
?>


