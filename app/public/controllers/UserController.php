<?php

require_once(__DIR__ . "/../models/UserModel.php");

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getAll()
    {
        return $this->userModel->getAll();
    }

    public function get($id)
    {
        return $this->userModel->get($id);
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Basic validation
            if (empty($username) || empty($password)) {
                $_SESSION['login_error'] = 'Username and password are required.';
                header('Location: /login');
                exit();
            }

            // Find user by username
            $user = $this->userModel->findByUsername($username);

            // Check if user exists and if password is correct
            if ($user && password_verify($password, $user['password'])) {
                // Successful login, set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['type'] = $user['type'];  // Use `type` field (not `user_type`)

                // Redirect based on user type
                if ($_SESSION['type'] === 'Manager') {
                    // Redirect to admin dashboard if manager
                    header('Location: /management/dashboard');
                    exit();
                } else {
                    // Redirect to user dashboard if regular user
                    header('Location: /user/dashboard');
                    exit();
                }
            } else {
                // Invalid login credentials
                $_SESSION['login_error'] = 'Invalid username or password.';
                header('Location: /login');
                exit();
            }
        } else {
            require '../views/pages/login.php'; // Render the login form
        }
    }




    public function dashboardFunc()
    {
        // Check if user is logged in by verifying session
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login if not logged in
            header('Location: /login');
            exit();
        }

        // Fetch the user data from the database using the user ID in session
        $user = $this->userModel->get($_SESSION['user_id']);

        // Check if user data is returned
        if (!$user) {
            // If no user data found, display an error or redirect
            $_SESSION['error_message'] = 'User data not found.';
            header('Location: /login');  // Redirect to login if no user data
            exit();
        }

        // Pass the user data to the view
        require __DIR__ . '/../views/pages/dashboard.php';
    }





    //this function might be too long
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Basic validation
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $_SESSION['register_error'] = 'All fields are required.';
                header('Location: /register');
                exit();
            }

            if ($password !== $confirm_password) {
                $_SESSION['register_error'] = 'Passwords do not match.';
                header('Location: /register');
                exit();
            }

            // Check if username already exists
            if ($this->userModel->findByUsername($username)) {
                $_SESSION['register_error'] = 'Username is already taken.';
                header('Location: /register');
                exit();
            }

            // Check if email already exists
            if ($this->userModel->findByEmail($email)) {
                $_SESSION['register_error'] = 'Email is already registered.';
                header('Location: /register');
                exit();
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Save user to database
            if ($this->userModel->createUser($username, $email, $hashedPassword)) {
                // After successful registration, find the user by username to log them in
                $user = $this->userModel->findByUsername($username);

                // Log the user in by setting session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to the dashboard (or another page)
                header('Location: /user/dashboard');
                exit();
            } else {
                $_SESSION['register_error'] = 'An error occurred. Please try again.';
                header('Location: /register');
                exit();
            }
        } else {
            require '../views/pages/register.php';  // Render the registration form
        }
    }



}
