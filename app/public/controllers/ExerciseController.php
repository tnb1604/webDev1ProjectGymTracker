<?php

require_once 'models/ExerciseModel.php';
require_once 'models/UserModel.php';

class ExerciseController
{
    private $exerciseModel;
    private $userModel;

    public function __construct()
    {
        $this->exerciseModel = new ExerciseModel();
        $this->userModel = new UserModel(); // Initialize the UserModel
    }

    public function index($action = 'create')
    {
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Fetch user data
        $user = $this->userModel->get($_SESSION['user_id']);
        if (!$user) {
            echo "Error: User not found!";
            exit();
        }

        // Fetch exercises for the user
        $userExercises = $this->exerciseModel->getUserExercises($user['user_id']);
        $globalExercises = $this->exerciseModel->getGlobalExercises();
        $allExercises = $this->exerciseModel->getAllExercises($user['user_id']);



        // Pass data to the view based on the action (create or manage)
        if ($action === 'manage') {
            // If the action is 'manage', show the manage exercises page
            require __DIR__ . '/../views/pages/manage_exercises.php';
        } else {
            // Default action is 'create', show the create exercises page
            require __DIR__ . '/../views/pages/create_exercises.php';
        }
    }

    public function getAllExercises()
    {
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $user = $this->userModel->get($_SESSION['user_id']);
        if (!$user) {
            echo "Error: User not found!";
            exit();
        }

        // Fetch all exercises
        $allExercises = $this->exerciseModel->getAllExercises($user["user_id"]);

        // Debugging: Check if exercises were fetched
        if (!$allExercises || empty($allExercises)) {
            echo "Error: No exercises found!";
            exit();
        }

        // Pass data to the log workouts view
        //require __DIR__ . '/../views/pages/log_workouts.php';
        return $allExercises;
    }


    public function createExercise()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exerciseName = trim($_POST['name']);
            if (empty($exerciseName)) {
                $_SESSION['error_message'] = "Error: Exercise name cannot be empty!";
                header('Location: /user/exercises');
                exit();
            }

            if (strlen($exerciseName) > 255) {
                $_SESSION['error_message'] = "Error: Exercise name is too long!";
                header('Location: /user/exercises');
                exit();
            }

            $userId = $_SESSION['user_id'];
            $this->exerciseModel->createUserExercise($exerciseName, $userId);
            header('Location: /user/exercises');
            exit();
        }
    }


    public function deleteExercise()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exerciseId = $_POST['id'];
            $result = $this->exerciseModel->deleteExercise($exerciseId);

            // If the result is an error message, show it to the user
            if ($result && strpos($result, 'cannot delete') !== false) {
                $_SESSION['error_message'] = $result;
            }

            header('Location: /user/exercises');
            exit();
        }
    }
    public function editExercise($exerciseId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exerciseName = trim($_POST['name']);
            if (empty($exerciseName)) {
                $_SESSION['error_message'] = "Error: Exercise name cannot be empty!";
                header('Location: /user/exercises');
                exit();
            }

            if (strlen($exerciseName) > 255) {
                $_SESSION['error_message'] = "Error: Exercise name is too long!";
                header('Location: /user/exercises');
                exit();
            }

            $this->exerciseModel->updateExercise($exerciseId, $exerciseName);
            header('Location: /user/exercises');
            exit();
        }
    }

    public function createGlobalExercise()
    {
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Manager') {
            header('Location: /login');
            exit();
        }

        // Handle POST request for creating a global exercise
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exerciseName = trim($_POST['name']);

            if (empty($exerciseName)) {
                $_SESSION['error_message'] = "Error: Exercise name cannot be empty!";
                header('Location: /manage/exercises');
                exit();
            }

            if (strlen($exerciseName) > 255) {
                $_SESSION['error_message'] = "Error: Exercise name is too long!";
                header('Location: /manage/exercises');
                exit();
            }

            // Create global exercise with user_id set to NULL (since it's global)
            $this->exerciseModel->createGlobalExercise($exerciseName, NULL);
            header('Location: /manage/exercises');
            exit();
        }
    }

    public function deleteGlobalExercise()
    {
        // Ensure the user is logged in and is a Manager
        if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Manager') {
            header('Location: /login');
            exit();
        }

        // Handle POST request for deleting a global exercise
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exerciseId = $_POST['id'];
            $result = $this->exerciseModel->deleteExercise($exerciseId);

            // If the result is an error message, show it to the user
            if ($result && strpos($result, 'cannot delete') !== false) {
                $_SESSION['error_message'] = $result;
            }

            header('Location: /manage/exercises');
            exit();
        }
    }



    public function editGlobalExercise($exerciseId)
    {
        // Ensure the user is logged in and is a Manager
        if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Manager') {
            header('Location: /login');
            exit();
        }

        // Handle POST request for editing a global exercise
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exerciseName = trim($_POST['name']);

            if (empty($exerciseName)) {
                $_SESSION['error_message'] = "Error: Exercise name cannot be empty!";
                header('Location: /manage/exercises');
                exit();
            }

            if (strlen($exerciseName) > 255) {
                $_SESSION['error_message'] = "Error: Exercise name is too long!";
                header('Location: /manage/exercises');
                exit();
            }

            // Update the global exercise
            $this->exerciseModel->updateExercise($exerciseId, $exerciseName);
            header('Location: /manage/exercises');
            exit();
        }
    }

}