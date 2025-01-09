<!--

<main class="container">
    <h3>username: <?= $user["username"]; ?></h3>
    <p>email: <?= $user["email"]; ?></p>
    <p>id: <?= $user["id"]; ?></p>
</main>

-->

<?php if ($user): ?>
    <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>ID: <?php echo htmlspecialchars($user['user_id']); ?></p>
<?php else: ?>
    <p>User data not available.</p>
<?php endif; ?>
