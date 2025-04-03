<?php

ob_start();
// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

session_start();
// Load the router router.php

require_once __DIR__ . "/routes/routes.php";
ob_end_flush();


