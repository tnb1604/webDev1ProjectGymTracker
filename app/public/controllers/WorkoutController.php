<?php

require_once(__DIR__ . "/../models/WorkoutModel.php");
require_once(__DIR__ . "/../models/UserModel.php"); // Include the UserModel

class WorkoutController
{
    private $workoutModel;
    private $userModel; // Declare the userModel

    public function __construct()
    {
        $this->workoutModel = new WorkoutModel();
        $this->userModel = new UserModel(); // Initialize the userModel
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Fetch user and workouts
        $user = $this->userModel->get($_SESSION['user_id']);
        $workouts = $this->workoutModel->getAllByUser($user['user_id']);

        // Load the workouts view
        require __DIR__ . '/../views/pages/log_workouts.php';
    }

    public function logWorkout()
    {
        // Logic for logging a workout
    }
}
