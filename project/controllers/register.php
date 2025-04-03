<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../errorlog.inc.php';
function showPostForm() {
    // if (!isset($_SESSION["user"])) {
    //     header("Location: /login?error=" . urlencode("Login to submit a ticket!"));
    //     exit();
    // }
    require __DIR__ . '/../views/register.view.php';
}

function storePost() {
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = htmlspecialchars(trim($_POST["user"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = trim($_POST["password"]);
        $password1 = trim($_POST["password1"]);
    
        // Error handling
        $errors = [];
    
        if (empty($username)) {
            $errors['user_error'] = "Enter your name.";
        }
        if (empty($email)) {
            $errors['email_error'] = "Enter your email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password_error'] = "Enter your password.";
        }
        if ($password !== $password1) {
            $errors['error']="Passwords do not match";
        }
    
        // If there are errors, redirect back with errors in GET parameters
        if (!empty($errors)) {
            header("Location: register.php?" . http_build_query($errors));
            exit();
        }
    
        // Check if user already exists
        $stmt = $conn->prepare("SELECT userid FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            header("Location: register.php?error=" . urlencode("User with this email already exists."));
            exit();
        }
        $stmt->close();
    
        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, 'client')");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
    
        if ($stmt->execute()) {
            header("Location: /project/login?success=" . urlencode("User created successfully!"));
            exit();
        } else {
            header("Location: /project/register?error=" . urlencode("Error: " . $stmt->error));
            logError($stmt->error, __FILE__, __LINE__);
            exit();
        }
        $stmt->close();
    }
    
}