<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../errorlog.inc.php';
function showPostForm() {
    // if (!isset($_SESSION["user"])) {
    //     header("Location: /login?error=" . urlencode("Login to submit a ticket!"));
    //     exit();
    // }
    require __DIR__ . '/../views/forgotPassword.view.php';
}

function storePost() {
    global $conn;
    include 'mailer.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        header("Location: forgotPassword?error=" . urlencode("Enter your email."));
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forgotPassword?error=" . urlencode("Invalid email format."));
        exit();
    }

    // Check if email exists in DB
    $stmt = $conn->prepare("SELECT userid FROM user WHERE email = ?");
    
    if (!$stmt) {
        logError("Prepare statement failed: " . $conn->error, __FILE__, __LINE__);
        header("Location: /project/forgotPassword?error=" . urlencode("Something went wrong. Please try again."));
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        header("Location: /project/forgotPassword?error=" . urlencode("Email not registered."));
        exit();
    }

    $stmt->bind_result($userid);
    $stmt->fetch();
    $stmt->close();

    // Generate token and expiry time
    $token = bin2hex(random_bytes(32)); 
    $expires_at = date("Y-m-d H:i:s", strtotime("+3 hours")); 

    // Store token in DB
    $stmt = $conn->prepare("UPDATE user SET reset_token = ?, reset_token_expiry = ? WHERE userid = ?");
    if (!$stmt) {
        logError("Prepare statement failed: " . $conn->error, __FILE__, __LINE__);
        header("Location: /project/forgotPassword.php?error=" . urlencode("Something went wrong. Please try again."));
        exit();
    }

    $stmt->bind_param("ssi", $token, $expires_at, $userid);
    if (!$stmt->execute()) {
        logError("SQL execution failed: " . $stmt->error, __FILE__, __LINE__);
        header("Location: /project/forgotPassword.php?error=" . urlencode("Something went wrong. Please try again."));
        exit();
    }
    $stmt->close();
    include_once __DIR__. '/../mailer.inc.php';
    // Send reset email
    $reset_link = "http://localhost/project/resetPassword?token=" . $token;
    $subject = "Password Reset Request";
    $message = "Click the link below to reset your password:\n\n$reset_link\n\nThis link is valid for 3 hours.";

    if (sendUserEmail($email, $subject, $message)) {
        header("Location: /project/forgotPassword?success=" . urlencode("Password reset link sent! Check your email."));
    } else {
        header("Location: /project/forgotPassword?error=" . urlencode("Failed to send email. Try again later."));
    }
    exit();
}
}