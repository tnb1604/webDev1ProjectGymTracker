<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Welcome to the Gym Workout Tracker Website</h4>
                </div>
                <div class="card-body">
                    <?php if ($_SESSION['type'] === 'User'): ?>
                        <h5 class="card-title">Ready for a workout, <?php echo htmlspecialchars($_SESSION['username']); ?>?</h5>
                        <p class="card-text">In the calendar view below, the green days of the months are days where you completed a workout, and the day in blue is the current day!</p>
                    <?php elseif ($_SESSION['type'] === 'Manager'): ?>
                        <h5 class="card-title">Welcome back, Manager <?php echo htmlspecialchars($_SESSION['username']); ?>!</h5>
                        <p class="card-text">You are able to manage global exercises.</p>
                    <?php else: ?>
                        <h5 class="card-title">Welcome!</h5>
                        <p class="card-text">Please log in.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
