<?php

require(__DIR__ . "/../partials/header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <!-- Hero Section -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4">Track Your Workouts Like Never Before</h1>
                <p class="lead">
                    Welcome to the ultimate platform for fitness enthusiasts!
                    Our website is designed to help you log your workouts, monitor progress, and stay motivated on your
                    weight lifting journey!
                </p>
                <a href="/register" class="btn btn-primary btn-lg">Get Started</a>
                <a href="/login" class="btn btn-outline-secondary btn-lg">Already have an account? Log In.</a>
            </div>
            <div class="col-md-6">
                <!-- Placeholder for an image -->
                <div class="bg-secondary d-flex justify-content-center align-items-center"
                    style="height: 300px; border-radius: 10px; background-image: url('/images/cardiofitnessPendulumPicture.jpeg'); background-size: cover; background-position: center;">
                </div>

            </div>
        </div>

        <!-- Features Section -->
        <div class="row mt-5">
            <div class="col-md-4 text-center">
                <i class="bi bi-calendar-check-fill" style="font-size: 3rem; color: #007bff;"></i>
                <h3 class="mt-3">Log Workouts</h3>
                <p>Track and log your workouts with ease. View your progress over time through a calendar-based
                    interface, helping you stay on top of your fitness journey.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="bi bi-gear-fill" style="font-size: 3rem; color: #28a745;"></i>
                <h3 class="mt-3">Custom Exercises</h3>
                <p>Create and save your own exercises tailored to your fitness goals. Our platform allows full
                    flexibility for any workout routine.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="bi bi-check-square" style="font-size: 3rem; color: #6c757d;"></i>
                <h3 class="mt-3">Custom Workouts</h3>
                <p>Design and log your own workout routines. Whether it's strength training, cardio, or flexibility,
                    personalize your workouts to fit your unique needs.</p>
            </div>
        </div>


        <!-- Call-to-Action Section -->
        <div class="row mt-5 bg-light py-4 text-center">
            <div class="col">
                <h2>Ready to Take Your Fitness to the Next Level?</h2>
                <p class="lead">Sign up today and start your fitness journey with us!</p>
                <a href="/register" class="btn btn-success btn-lg">Sign Up Now</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require(__DIR__ . "/../partials/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>