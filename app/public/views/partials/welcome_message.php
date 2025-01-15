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