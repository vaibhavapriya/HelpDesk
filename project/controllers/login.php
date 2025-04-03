<?php
require_once __DIR__ . '/../errorlog.inc.php';
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Include JWT library

use Firebase\JWT\JWT;

function showPostForm() {
    // if (!isset($_SESSION["user"])) {
    //     header("Location: /login?error=" . urlencode("Login to submit a ticket!"));
    //     exit();
    // }
    require __DIR__ . '/../views/login.view.php';
}

function storePost() {
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $errors = []; // Initialize errors array
    
        // Validate email
        if (empty($email)) {
            $errors['email_error'] = "Enter your email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Invalid email format.";
        }
    
        // Validate password
        if (empty($password)) {
            $errors['password_error'] = "Enter your password.";
        }
    
        // If there are errors, redirect back with query parameters
        if (!empty($errors)) {
            header("Location: /project/login?" . http_build_query($errors));
            exit();
        }
    
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT userid, email, password, role FROM user WHERE email = ?");
        
        if (!$stmt) {
            logError("Prepare statement failed: " . $conn->error, __FILE__, __LINE__);
            header("Location: /project/login?error=Something went wrong. Please try again.");
            exit();
        }
    
        $stmt->bind_param("s", $email);
        if(!$stmt->execute()){
            logError("SQL execution failed: " . $conn->error, __FILE__, __LINE__);
        }
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $dbEmail, $hashedPassword, $role);
            $stmt->fetch();
    
            // Verify password
            if (password_verify($password, $hashedPassword)) {
                // Secure session handling
                session_regenerate_id(true);

                $payload = [
                    "iss" => "localhost",
                    "iat" => time(),
                    "exp" => time() + (60 * 60), // Token expires in 1 hour
                    "sub" => $id,
                    "email" => $dbEmail,
                    "role" => $role
                ];
                $jwt_secret = "your_secret_key";
                $jwt = JWT::encode($payload, $jwt_secret, "HS256");

                $_SESSION['jwt_token'] = $jwt;
                $_SESSION['role'] = $role;
                //echo json_encode(["token" => $jwt]); header
    
                if($role === 'client'){
                    header("Location: /project/home?success=" . urlencode("Logged in successfully!"));
                }
                if($role === 'admin'){
                    header("Location: /project/home?success=" . urlencode("Logged in successfully!"));
                }
                exit();
            } else {
                header("Location: /project/login?error=" . urlencode("Invalid password!"));
                exit();
            }
        } else {
            header("Location: /project/login?error=" . urlencode("User not found!"));
            exit();
        }
    
        $stmt->close();
        $conn->close();
    }
}