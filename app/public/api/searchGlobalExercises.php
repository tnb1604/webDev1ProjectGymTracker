<?php
require_once __DIR__ . '/../lib/env.php';
require_once __DIR__ . '/../models/ExerciseModel.php';

header('Content-Type: application/json');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

    $exerciseModel = new ExerciseModel();
    $exercises = $exerciseModel->searchGlobalExercises($search_term);

    echo json_encode($exercises);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
