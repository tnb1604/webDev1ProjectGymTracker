<?php

require_once(__DIR__ . "/../models/WorkoutModel.php");
require_once(__DIR__ . "/../models/UserModel.php"); // Include the UserModel

class WorkoutController
{
    private $workoutModel;
    private $userModel; // Declare the userModel
    private ExerciseController $exerciseController;

    public function __construct()
    {
        $this->workoutModel = new WorkoutModel();
        $this->userModel = new UserModel(); // Initialize the userModel
        $this->exerciseController = new ExerciseController();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Fetch user and workouts
        $user = $this->userModel->get($_SESSION['user_id']);
        $userWorkouts = $this->workoutModel->getAllByUser($user['user_id']); // Store workouts in $userWorkouts

        // Fetch all exercises
        $allExercises = $this->exerciseController->getAllExercises();

        // Pass the data to the view
        require(__DIR__ . '/../views/pages/log_workouts.php');
    }



    public function logWorkout()
    {
        //unset($_SESSION['error']);

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        error_log("Form data: " . print_r($_POST, true));
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $workout_name = $_POST['workout_name'] ?? null;
            $date = $_POST['date'] ?? null;
            $exercises = $_POST['exercises'] ?? [];



            // Validate the input
            if (empty($workout_name) || empty($date) || empty($exercises)) {
                $_SESSION['error'] = 'Name, date, and at least one exercise are required!';
                header('Location: /user/workouts');
                exit();
            }

            // Validate exercise details
            foreach ($exercises as $exercise) {
                $exerciseName = $exercise['name'] ?? null;
                $sets = $exercise['sets'] ?? [];

                // Loop through sets and validate details
                foreach ($sets as $set) {
                    $reps = $set['reps'] ?? null;
                    $weight = $set['weight'] ?? null;

                    // Validate reps and weight
                    if (empty($reps) || empty($weight)) {
                        $_SESSION['error'] = 'Reps and weight for each set are required!';
                        header('Location: /user/workouts');
                        exit();
                    }
                }
            }

            // Save the workout in the database
            $workoutId = $this->workoutModel->create($userId, $workout_name, $date);

            // Loop through each exercise and add its sets
            foreach ($exercises as $exerciseData) {
                // Get the exercise ID by name
                $exerciseId = $this->workoutModel->getExerciseIdByName($exerciseData['name']);

                // Loop through each set for the current exercise
                foreach ($exerciseData['sets'] as $setIndex => $set) {
                    $reps = $set['reps'] ?? null;
                    $weight = $set['weight'] ?? null;

                    // Validate set data
                    if (empty($reps) || empty($weight)) {
                        $_SESSION['error'] = 'Reps and weight for each set are required!';
                        header('Location: /user/workouts');
                        exit();
                    }

                    // Add the exercise and set to the workout
                    $this->workoutModel->addExerciseToWorkout($workoutId, $exerciseId, $setIndex + 1, $reps, $weight);
                }
            }

            header('Location: /user/workouts');
            exit();
        }


        // Load the log workout page
        require(__DIR__ . '/../views/pages/log_workouts.php');
    }





}
