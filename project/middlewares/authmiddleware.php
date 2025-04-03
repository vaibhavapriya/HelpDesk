<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Include JWT library
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt_secret = "your_secret_key"; // Must be the same as in login.php

function authenticate() {
    global $jwt_secret;
    
    $headers = getallheaders();
    if (!isset($headers["Authorization"])) {
        http_response_code(401);
        die(json_encode(["error" => "Authorization header missing"]));
    }

    $token = str_replace("Bearer ", "", $headers["Authorization"]);

    try {
        //return JWT::decode($token, new Key($jwt_secret, "HS256"));
        $decoded = JWT::decode($token, new Key($jwt_secret, "HS256"));
        // Store user data in global variable (instead of $_SESSION)
        $GLOBALS["user"] = [
            "id" => $decoded->sub,
            "email" => $decoded->email,
            "role" => $decoded->role
        ];
    } catch (Exception $e) {
        http_response_code(401);
        die(json_encode(["error" => "Invalid token"]));
    }
}


/**
 * Middleware: Validate CSRF Token (For POST requests)
 */
function csrfMiddleware() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
            header("Location: /error?message=" . urlencode("Invalid CSRF token"));
            exit();
        }
    }
}

/**
 * Generate and store a CSRF token
 */
function generateCsrfToken() {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
    return $_SESSION['_token'];
}


//<input type="hidden" name="_token" value="<?php echo generateCsrfToken(); ?>
