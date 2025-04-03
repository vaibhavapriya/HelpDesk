<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../errorlog.inc.php';
function showPostForm() {
    global $conn;
    // if (!isset($_SESSION["user"])) {
    //     header("Location: /login?error=" . urlencode("Login to submit a ticket!"));
    //     exit();
    // }
    $user_id = $_SESSION["user_id"];

    // Fetch user details
    $stmt = $conn->prepare("SELECT name, email, phone FROM user WHERE userid = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    require __DIR__ . '/../views/profile.view.php';
}

function storePostProfile() {
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION["user_id"])) {
        header("Location: /project/login?error=" . urlencode("Login required!"));
        exit();
    }
    
    $user_id = $_SESSION["user_id"];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    if (empty($name ) || empty($email) || empty($phone)) {
        header("Location: /project/profile?error=" . urlencode("All fields are required!"));
        exit();
    }
    // Update query
    $stmt = $conn->prepare("UPDATE user SET name=?, email=?, phone=? WHERE userid=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    
    if ($stmt->execute()) {
        header("Location: /project/profile?success=" . urlencode("Profile updated successfully!"));
    } else {
        logError("execution failed: " . $stmt->error, __FILE__, __LINE__);
        header("Location: /project/profile?error=" . urlencode("Error updating profile."));
    }
    
    $stmt->close();
    $conn->close();
}

}
function storePostPass() {
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION["user_id"];
    $old_password = trim($_POST["old_password"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        header("Location: /project/profile?error=" . urlencode("All fields are required!"));
        exit();
    }

    if ($new_password !== $confirm_password) {
        header("Location: /project/profile?error=" . urlencode("Passwords do not match!"));
        exit();
    }

    // Fetch current hashed password
    $stmt = $conn->prepare("SELECT password FROM user WHERE userid = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify old password
    if (!password_verify($old_password, $hashed_password)) {
        header("Location: /project/profile?error=" . urlencode("Old password is incorrect!"));
        exit();
    }

    // Hash new password and update
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE userid = ?");
    $stmt->bind_param("si", $new_hashed_password, $user_id);

    if ($stmt->execute()) {
        header("Location: /project/profile?success=" . urlencode("Password changed successfully!"));
    } else {
        logError("execution failed: " . $stmt->error, __FILE__, __LINE__);
        header("Location: /project/profile?error=" . urlencode("Error updating password."));
    }

    $stmt->close();
    $conn->close();
    }
}