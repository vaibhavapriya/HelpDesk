<?php
require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/../errorlog.inc.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authMiddleware() {
    $jwt_secret = "your_secret_key";
    if (!isset($_SESSION['jwt_token'])) {
        http_response_code(401);
        header("Location: /project/home?error=login to access");
        echo "401 - Unauthorized: JWT Token missing.";
        exit;
    }

    try {
        $decoded = JWT::decode($_SESSION['jwt_token'], new Key($jwt_secret, "HS256"));
        $_SESSION['user_id'] = $decoded->sub;
        $_SESSION['email'] = $decoded->email;
        $_SESSION['role'] = $decoded->role;
    } catch (Exception $e) {
        http_response_code(403);
        echo "403 - Forbidden: Invalid JWT Token.";
        exit;
    }
}
function authRoleAdmin() {
    authRole('admin');
}

function authRole($allowedRoles) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["role"])) {
        header("Location: /project/login?error=" . urlencode("You must log in first!"));
        exit();
    }

    // Convert single role string into an array for flexibility
    $allowedRoles = (array) $allowedRoles;

    // Check if the user's role is allowed
    if (!in_array($_SESSION["role"], $allowedRoles, true)) {
        header("Location: /project/home?error=" . urlencode($_SESSION['role'] . " has no access!"));
        exit();
    }
}

function checkTicketOwnership($ticket_id, $conn)
{
    $requester_id = $_SESSION['user_id']; // Make sure this is set correctly

    // Prepare the SQL query to fetch the requester_id for the given ticket_id
    $query = "SELECT requester_id FROM tickets WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        logError("Prepare statement failed: " . mysqli_error($conn), __FILE__, __LINE__);
        header("Location: /project/home?error=Something went wrong. Please try again.");
        exit();
    }

    // Bind the ticket_id to the query (assuming it's an integer)
    mysqli_stmt_bind_param($stmt, "i", $ticket_id);

    // Execute the statement
    if (!mysqli_stmt_execute($stmt)) {
        logError("Execution failed: " . mysqli_stmt_error($stmt), __FILE__, __LINE__);
        header("Location: /project/home?error=Something went wrong. Please try again.");
        exit();
    }

    // Get the result of the query
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        logError("get_result() failed: " . mysqli_stmt_error($stmt), __FILE__, __LINE__);
        header("Location: /project/home?error=Something went wrong. Please try again.");
        exit();
    }

    // Fetch the ticket as an associative array
    $ticket = mysqli_fetch_assoc($result);

    // Check if the ticket exists and if the requester_id matches the logged-in user
    if (!$ticket || $ticket['requester_id'] != $requester_id) {
        // If no match or ticket not found, deny access
        http_response_code(403); // Forbidden
        header("Location: /project/myTickets?error=Access Denied");
        die(json_encode(["error" => "Access Denied"]));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
