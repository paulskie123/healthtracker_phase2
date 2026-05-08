<?php
require_once APP_PATH . '/models/UserModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;

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
                if (!empty($user['two_fa_enabled']) && !empty($user['two_fa_secret'])) {
                    $_SESSION['2fa_pending'] = $user;
                    $this->redirect('verify-2fa');
                } else {
                    $_SESSION['user'] = $user;
                    $this->redirect('dashboard');
                }
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

    public function setup2fa() {
        if (!isset($_SESSION['user'])) $this->redirect('login');

        $google2fa = new Google2FA();
        $user      = $_SESSION['user'];
        $error     = '';
        $success   = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $secret = $_POST['secret'] ?? '';
            $code   = trim($_POST['code'] ?? '');

            $valid = $google2fa->verifyKey($secret, $code);

            if ($valid) {
                $this->userModel->update2FA($user['id'], $secret, 1);
                $_SESSION['user'] = $this->userModel->findById($user['id']);
                $success = '2FA enabled successfully!';
            } else {
                $error = 'Invalid code. Please try again.';
            }
        }

        $secret  = $_POST['secret'] ?? $google2fa->generateSecretKey();
        $qrUrl   = $google2fa->getQRCodeUrl(
            'HealthTracker',
            $user['email'],
            $secret
        );

        $this->view('auth/setup2fa', [
            'secret'  => $secret,
            'qrUrl'   => $qrUrl,
            'error'   => $error,
            'success' => $success,
            'user'    => $user,
        ]);
    }

    public function verify2fa() {
        if (empty($_SESSION['2fa_pending'])) $this->redirect('login');

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $google2fa = new Google2FA();
            $user      = $_SESSION['2fa_pending'];
            $code      = trim($_POST['code'] ?? '');

            $valid = $google2fa->verifyKey($user['two_fa_secret'], $code);

            if ($valid) {
                unset($_SESSION['2fa_pending']);
                $_SESSION['user'] = $user;
                $this->redirect('dashboard');
            } else {
                $error = 'Invalid code. Please try again.';
            }
        }

        $this->view('auth/verify2fa', ['error' => $error]);
    }
}