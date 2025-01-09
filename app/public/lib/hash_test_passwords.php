<?php
require __DIR__ . '/env.php'; // Include the environment configuration file

try {
    // Database connection using the environment config
    $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset={$_ENV['DB_CHARSET']}";
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all user
    $stmt = $pdo->query("SELECT user_id, password FROM user"); // Correct table name here
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        // Hash the existing plaintext password
        $hashedPassword = password_hash($user['password']);

        // Update the database
        $updateStmt = $pdo->prepare("UPDATE user SET password = :password WHERE user_id = :user_id");
        $updateStmt->execute([
            'password' => $hashedPassword,
            'user_id' => $user['user_id'],
        ]);

        echo "Updated password for User ID {$user['user_id']}<br>";
    }

    echo "Password hashing complete!";
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
