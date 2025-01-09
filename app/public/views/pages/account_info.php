<?php
session_start();
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
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <h1>Account Info Page</h1>
</body>
</html>
