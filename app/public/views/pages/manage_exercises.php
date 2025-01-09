<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'Manager') {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exercises</title>
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <h1>Manage Exercises Page</h1>
</body>
</html>
