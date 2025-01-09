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

    public function index()
    {
        //session_start();

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

        // Pass user and exercises data to the view
        require __DIR__ . '/../views/pages/create_exercises.php';
    }

    public function showGlobalExercises()
    {
        return $this->exerciseModel->getGlobalExercises();
    }

    public function showUserExercises($userId)
    {
        return $this->exerciseModel->getUserExercises($userId);
    }

    public function addExercise($name, $userId = null)
    {
        $this->exerciseModel->createExercise($name, $userId);
    }

    public function removeExercise($exerciseId)
    {
        $this->exerciseModel->deleteExercise($exerciseId);
    }

    // Method to create an exercise for a specific user
    public function createExercise()
    {
        //method to create an exercise for a specific user
    }


    // Method to manage user exercises (list and remove)
    public function manageExercises()
    {
        //session_start();

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

        // Pass data to the view to manage exercises
        require __DIR__ . '/../views/pages/manage_exercises.php';
    }
}
