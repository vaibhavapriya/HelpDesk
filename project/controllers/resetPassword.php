<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../errorlog.inc.php';
function showPostForm() {
    require __DIR__ . '/../views/resetpassword.view.php';
}

function storePost() {
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get user inputs
        $email = trim($_POST['email']);
        $newPassword = trim($_POST['password']);
        $confirmPassword = trim($_POST['password1']);
        $token = trim($_POST['token']);
    
        // Validate token
        if (empty($token)) {
            header("Location: /project/resetPassword?error=" . urlencode("Something went wrong. Try again."));
            exit();
        }
    
        // Validate email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Enter valid email.";
        }
    
        // Validate password
        if (empty($newPassword)) {
            $errors['password_error'] = "Enter your password.";
        }
        if (!empty($errors)) {
            header("Location: /project/resetPassword?" . http_build_query($errors));
            exit();
        }
        // Confirm password match
        if ($newPassword !== $confirmPassword) {
            header("Location: /project/resetPassword?error=" . urlencode("Passwords do not match."));
            exit();
        }
    
        // Check token in the database
        $stmt = $conn->prepare("SELECT userid, reset_token_expiry FROM user WHERE reset_token = ? AND email = ?");
        if (!$stmt) {
            logError("Prepare failed: " . $conn->error, __FILE__, __LINE__);
            header("Location: /project/forgotPassword?error=Something went wrong. Try again.");
            exit();
        }
    
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        $stmt->store_result();
    
        // If token not found or expired
        if ($stmt->num_rows === 0) {
            header("Location: /project/forgotPassword?error=" . urlencode("Invalid or expired token."));
            exit();
        }
    
        // Get user ID and token expiry time
        $stmt->bind_result($userid, $resetTokenExpiry);
        $stmt->fetch();
        $stmt->close();
    
        // Check if token is expired
        if (strtotime($resetTokenExpiry) < time()) {
            header("Location: /project/forgotPassword?error=" . urlencode("Token expired. Please request a new one."));
            exit();
        }
    
        // Securely hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        // Update password and remove reset token
        $stmt = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE userid = ?");
        if (!$stmt) {
            logError("Prepare failed: " . $conn->error, __FILE__, __LINE__);
            header("Location: /project/forgotPassword.php?error=Something went wrong. Try again.");
            exit();
        }
    
        $stmt->bind_param("si", $hashedPassword, $userid);
        if ($stmt->execute()) {
            header("Location: /project/login?success=" . urlencode("Password updated successfully!"));
        } else {
            logError("execution failed: " . $stmt->error, __FILE__, __LINE__);
            header("Location: /project/forgotPassword.php?error=" . urlencode("Failed to update password. Try again."));
        }
    
        $stmt->close();
        exit();
    }
}