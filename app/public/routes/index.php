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
    $controller->dashboardFunc();
});

Route::add('/management/dashboard', function () {
    $controller = new UserController();
    $controller->dashboardFunc();
});

Route::add('/logout', function () {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
});

Route::add('/account_info', function () {
    require(__DIR__ . '/../views/pages/account_info.php');
});

// Exercise creation page (controller-driven)
Route::add('/user/exercises', function () {

    $controller = new ExerciseController();
    $controller->index();  // This method handles creating exercises
});


Route::add('/user/workouts', function () {
    $controller = new WorkoutController();
    $controller->index();
});

// Manage exercises page (controller-driven)
Route::add('/management/exercises', function () {
    $controller = new ExerciseController();
    $controller->manageExercises();  // This method handles managing exercises
});


