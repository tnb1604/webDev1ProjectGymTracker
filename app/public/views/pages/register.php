<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - My Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; // Include the header ?>

    <div class="container mt-5">
        <h2 class="text-center">Register</h2>

        <!-- Error message -->
        <?php if (!empty($_SESSION['register_error'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
            </div>
        <?php endif; ?>

        <form action="/user/register" method="post" class="mx-auto mt-4" style="max-width: 400px;">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <!-- Back to login link -->
        <div class="text-center mt-3">
            <p class="mb-0">Already have an account?</p>
            <a href="/login" class="btn btn-link">Login here</a>
        </div>
    </div>
</body>

</html>
