<?php
require_once __DIR__ . '/../controllers/ExerciseController.php';
require_once __DIR__ . '/../controllers/WorkoutController.php';


//------------------------------------------------------------- AUTH ROUTES -------------------------------------------------------------\\


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


//------------------------------------------------------------- EXERCISE ROUTES -------------------------------------------------------------\\


Route::add('/user/exercises', function () {

    $controller = new ExerciseController();
    $controller->index();
});


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


//------------------------------------------------------------- WORKOUT ROUTES -------------------------------------------------------------\\


Route::add('/user/workouts', function () {
    $controller = new WorkoutController();
    $controller->index();
});

Route::add('/user/workouts/submit', function () {
    $controller = new WorkoutController();
    $controller->logWorkout();
}, 'post');

// route for AJAX (API endpoint), fetch workout details via AJAX
Route::add('/api/getWorkoutDetails', function () {
    $controller = new WorkoutController();
    $controller->getWorkoutDetails();
});

Route::add('/user/workouts/update', function () {
    $controller = new WorkoutController();
    $controller->updateWorkout();
}, 'post');

Route::add('/user/workouts/delete', function () {
    $controller = new WorkoutController();
    $controller->deleteWorkout();
}, 'post');

// route for search API
Route::add('/api/searchGlobalExercises.php', function () {
    require __DIR__ . '/../api/searchGlobalExercises.php';
});