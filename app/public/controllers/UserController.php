<?php

require_once(__DIR__ . "/../models/UserModel.php");

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Set user session variables after login or registration.
     */
    private function setUserSession($user)
    {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'] ?? 'Not provided';
        $_SESSION['type'] = $user['type'] ?? 'User';
    }

    /**
     * Render a view with optional data.
     */
    private function renderView($view, $data = [])
    {
        $viewFile = __DIR__ . '/../views/pages/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die('View not found: ' . htmlspecialchars($viewFile));
        }
        extract($data); // Extract data array to variables
        require $viewFile;
    }

    /**
     * User login.
     */
    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Validation
            if (empty($username) || empty($password)) {
                $_SESSION['login_error'] = 'Username and password are required.';
                header('Location: /login');
                exit();
            }

            // Authenticate user
            $user = $this->userModel->findByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $this->setUserSession($user);
                $redirect = $_SESSION['type'] === 'Manager' ? '/management/dashboard' : '/user/dashboard';
                header("Location: $redirect");
                exit();
            }

            // Invalid credentials
            $_SESSION['login_error'] = 'Invalid username or password.';
            header('Location: /login');
            exit();
        }

        // Render login form
        $this->renderView('login');
    }

    /**
     * User registration.
     */
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validation
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

            if ($this->userModel->findByUsername($username)) {
                $_SESSION['register_error'] = 'Username is already taken.';
                header('Location: /register');
                exit();
            }

            if ($this->userModel->findByEmail($email)) {
                $_SESSION['register_error'] = 'Email is already registered.';
                header('Location: /register');
                exit();
            }

            // Register the user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if ($this->userModel->createUser($username, $email, $hashedPassword)) {
                $user = $this->userModel->findByUsername($username);
                $this->setUserSession($user);
                header('Location: /user/dashboard');
                exit();
            }

            // Registration failed
            $_SESSION['register_error'] = 'An error occurred. Please try again.';
            header('Location: /register');
            exit();
        }

        // Render registration form
        $this->renderView('register');
    }

    /**
     * Display user dashboard or account info.
     */
    public function index($view = 'dashboard')
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $user = $this->userModel->get($_SESSION['user_id']);
        if (!$user) {
            $_SESSION['error_message'] = 'User data not found.';
            header('Location: /login');
            exit();
        }

        $this->renderView($view, ['user' => $user]);
    }
}
