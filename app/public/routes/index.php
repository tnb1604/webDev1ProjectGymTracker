<?php
require_once __DIR__ . '/../controllers/ExerciseController.php';
require_once __DIR__ . '/../controllers/WorkoutController.php';

Route::add('/', function () {
    // homepage is simply loading a static page
    // view the user routes for example following the MVC pattern
    require(__DIR__ . "/../views/pages/index.php");
});

Route::add('/login', function () {
    require(__DIR__ . '/../views/pages/login.php');
});

Route::add('/user/login', function () {
    $controller = new UserController();
    $controller->loginUser();
}, 'post');

Route::add('/register', function () {
    require(__DIR__ . '/../views/pages/register.php');
});

Route::add('/user/register', function () {
    $controller = new UserController();
    $controller->registerUser();
}, 'post');

Route::add('/user/dashboard', function () {
    $controller = new UserController();
    $controller->index();
});

Route::add('/management/dashboard', function () {
    $controller = new UserController();
    $controller->index();
});

Route::add('/logout', function () {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
});

Route::add('/account', function () {
    $controller = new UserController();
    $controller->index('account_info');
});

// Exercise creation page (controller-driven)
Route::add('/user/exercises', function () {

    $controller = new ExerciseController();
    $controller->index();
});


Route::add('/user/workouts', function () {
    $controller = new WorkoutController();
    $controller->index();
});

// Manage exercises page (controller-driven)
Route::add('/manage/exercises', function () {
    $controller = new ExerciseController();
    $controller->index('manage');
});

Route::add('/addExercise', function () {
    $controller = new ExerciseController();
    $controller->createExercise();
}, 'post');

Route::add('/deleteExercise', function () {
    $controller = new ExerciseController();
    $controller->deleteExercise();
}, 'post');

Route::add('/editExercise', function () {
    $controller = new ExerciseController();
    $controller->editExercise(exerciseId: $_POST['id']);
}, 'post');

Route::add('/addGlobalExercise', function () {
    $controller = new ExerciseController();
    $controller->createGlobalExercise();
}, 'post');

Route::add('/deleteGlobalExercise', function () {
    $controller = new ExerciseController();
    $controller->deleteGlobalExercise();
}, 'post');

Route::add('/editGlobalExercise', function () {
    $controller = new ExerciseController();
    $controller->editGlobalExercise($_POST['id']);
}, 'post');

Route::add('/getAllExercises', function () {
    $controller = new ExerciseController();
    $controller->getAllExercises();
});

/*Route::add('/user/workouts', function () {
    $controller = new WorkoutController();
    $controller->logWorkout();
});*/

Route::add('/user/workouts/submit', function () {
    $controller = new WorkoutController();
    $controller->logWorkout();
}, 'post');

// New route for AJAX (API endpoint)
Route::add('/api/getWorkoutDetails', function () {
    $controller = new WorkoutController();
    $controller->getWorkoutDetails(); // Fetch workout details via AJAX
});