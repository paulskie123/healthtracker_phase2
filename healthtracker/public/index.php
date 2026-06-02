<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define('APP_PATH', dirname(__DIR__) . '/app');
require_once dirname(__DIR__) . '/config/config.php';
require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/controllers/AuthController.php';
require_once APP_PATH . '/controllers/PatientController.php';
require_once APP_PATH . '/controllers/HealthRecordController.php';
require_once APP_PATH . '/controllers/MedicationController.php';
require_once APP_PATH . '/controllers/AppointmentController.php';

$page = $_GET['page'] ?? 'login';

$publicPages = ['login', 'register', 'verify-2fa'];

if (!in_array($page, $publicPages) && !isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

if (in_array($page, $publicPages) && isset($_SESSION['user']) && empty($_SESSION['2fa_pending'])) {
    header('Location: index.php?page=dashboard');
    exit;
}

$routes = [
    'login'      => ['AuthController', 'login'],
    'register'   => ['AuthController', 'register'],
    'logout'     => ['AuthController', 'logout'],
    'setup-2fa'  => ['AuthController', 'setup2fa'],
    'verify-2fa' => ['AuthController', 'verify2fa'],

    'dashboard' => ['PatientController', 'dashboard'],
    'progress'  => ['PatientController', 'progress'],
    'reminders' => ['PatientController', 'reminders'],
    'profile'   => ['PatientController', 'profile'],
    'settings'  => ['PatientController', 'settings'],
    'bmi'       => ['PatientController', 'bmi'],

    'health-records'        => ['HealthRecordController', 'index'],
    'health-records-create' => ['HealthRecordController', 'create'],
    'health-records-store'  => ['HealthRecordController', 'store'],
    'health-records-edit'   => ['HealthRecordController', 'edit'],
    'health-records-update' => ['HealthRecordController', 'update'],
    'health-records-delete' => ['HealthRecordController', 'delete'],
    'health-records-view'   => ['HealthRecordController', 'show'],

    'medication'        => ['MedicationController', 'index'],
    'medication-create' => ['MedicationController', 'create'],
    'medication-store'  => ['MedicationController', 'store'],
    'medication-edit'   => ['MedicationController', 'edit'],
    'medication-update' => ['MedicationController', 'update'],
    'medication-delete' => ['MedicationController', 'delete'],

    'appointments'        => ['AppointmentController', 'index'],
    'appointments-create' => ['AppointmentController', 'create'],
    'appointments-store'  => ['AppointmentController', 'store'],
    'appointments-edit'   => ['AppointmentController', 'edit'],
    'appointments-update' => ['AppointmentController', 'update'],
    'appointments-delete' => ['AppointmentController', 'delete'],
];

if (isset($routes[$page])) {
    [$controllerClass, $method] = $routes[$page];
    $controller = new $controllerClass();
    $controller->$method();
} else {
    http_response_code(404);
    echo '<h1>404 - Page Not Found</h1>';
}