<?php
require_once APP_PATH . '/models/UserModel.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($this->isLoggedIn()) $this->redirect('dashboard');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user     = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                $this->redirect('dashboard');
            } else {
                $error = 'Invalid email or password.';
            }
        }
        $this->view('auth/login', ['error' => $error]);
    }

    public function register() {
        if ($this->isLoggedIn()) $this->redirect('dashboard');
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['full_name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if (empty($name)) {
                $error = 'Full name is required.';
            } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'A valid email address is required.';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'That email is already registered.';
            } else {
                try {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $newId = $this->userModel->create($name, $email, $hashedPassword);

                    if ($newId > 0) {
                        $success = 'Account created! You can now sign in.';
                    } else {
                        $error = 'Registration failed. Please try again.';
                    }
                } catch (PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                } catch (Exception $e) {
                    $error = 'Error: ' . $e->getMessage();
                }
            }
        }

        $this->view('auth/register', ['error' => $error, 'success' => $success]);
    }

    public function logout() {
        session_destroy();
        $this->redirect('login');
    }
}