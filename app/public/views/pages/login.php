<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; // Include the header ?>

    <div class="container mt-5">
        <h2 class="text-center">Log in</h2>

        <!-- Display error message if exists -->
        <?php if (!empty($_SESSION['login_error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/user/login" class="mx-auto mt-4" style="max-width: 400px;">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Register link -->
        <div class="text-center mt-3">
            <p class="mb-0">Don't have an account?</p>
            <a href="/register" class="btn btn-link">Register here</a>
        </div>
    </div>
</body>

</html>
