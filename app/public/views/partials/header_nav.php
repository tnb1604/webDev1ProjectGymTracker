<nav class="navbar bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo isset($_SESSION['user_id']) ? '/user/dashboard' : '/'; ?>">Gym Workout
            Tracker</a>
        <div class="d-flex justify-content-center gap-2 flex-grow-1">
            <?php if (isset($_SESSION['username'])): ?>
                <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'Manager'): ?>
                    <a href="/manage/exercises" class="btn btn-primary">Manage Exercises</a>
                <?php else: ?>
                    <a href="/user/workouts" class="btn btn-success">Workouts</a>
                    <a href="/user/exercises" class="btn btn-primary">Exercises</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="/account" class="btn btn-info">Account Info</a>
                <a href="/logout" class="btn btn-danger">Logout</a>
            <?php else: ?>
                <a href="/login" class="btn btn-primary">Login/Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>