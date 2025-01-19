<?php
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
    <title>Account Info</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h1 class="text-center">Account Information</h1>
            </div>
            <div class="card-body">
                <h3 class="card-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
                <p class="card-text">Here are your account details:</p>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Username:</strong>
                        <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li class="list-group-item"><strong>Email:</strong>
                        <?php echo htmlspecialchars($_SESSION['email']); ?></li>
                    <li class="list-group-item"><strong>User type:</strong>
                        <?php echo htmlspecialchars($_SESSION['type']); ?></li>
                </ul>
                <div class="d-flex justify-content-between">
                </div>
            </div>
        </div>
    </div>
</body>

</html>