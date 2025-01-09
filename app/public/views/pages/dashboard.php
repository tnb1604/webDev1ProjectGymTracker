<?php
// session_start(); // Uncomment this if session_start() is not done globally

if (!isset($_SESSION['username'])) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJf+7v1giW6tTYpL5VNXv6eS29n62jvD7DWZ5VXvCgeLslzGHZTq3gOS60OU" crossorigin="anonymous">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Welcome to Your Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h5>
                        <p class="card-text">You're successfully logged in and ready to go.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Zk2jZ9Kz2n6c8L1zqQh19Rk44d3FzfybB+a7M6O1TY4k5D2" crossorigin="anonymous"></script>
</body>

</html>
