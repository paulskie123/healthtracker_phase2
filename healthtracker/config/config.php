<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('APP_NAME', 'HealthTracker');
define('APP_VERSION', '2.0.0');
define('APP_ENV', 'development');

if (!defined('APP_PATH')) {
    define('APP_PATH', dirname(__DIR__) . '/app');
}

define('DB_HOST', '127.0.0.1');  // ✅ Changed from 'localhost' to '127.0.0.1'
define('DB_NAME', 'healthtracker');
define('DB_USER', 'root');
define('DB_PASS', '');