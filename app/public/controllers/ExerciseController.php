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

        // Pass data to the view based on the action (create or manage)
        if ($action === 'manage') {
            // If the action is 'manage', show the manage exercises page
            require __DIR__ . '/../views/pages/manage_exercises.php';
        } else {
            // Default action is 'create', show the create exercises page
            require __DIR__ . '/../views/pages/create_exercises.php';
        }
    }


    public function showGlobalExercises()
    {
        return $this->exerciseModel->getGlobalExercises();
    }

    public function showUserExercises($userId)
    {
        return $this->exerciseModel->getUserExercises($userId);
    }

    public function createGlobalExercise($name, $userId = null)
    {
        $this->exerciseModel->createGlobalExercise($name, $userId);
    }

    public function createUserExercise($name, $userId = null)
    {
        $this->exerciseModel->createUserExercise($name, $userId);
    }

 
    public function removeExercise($exerciseId)
    {
        $this->exerciseModel->deleteExercise($exerciseId);
    }

    // Method to manage user exercises (list and remove)

}
