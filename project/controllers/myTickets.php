<?php
    require_once __DIR__ . '/../database/db.php';
    require_once __DIR__ . '/../errorlog.inc.php';

function myTicketsController() {
    global $conn;
    $userEmail = $_SESSION["email"];

    // Fetch tickets for the logged-in user
    $stmt = $conn->prepare("SELECT id, subject, requester, last_replier, status, last_activity FROM tickets WHERE requester = ? ORDER BY last_activity DESC");
    $stmt->bind_param("s", $userEmail);
    if (!$stmt) {
        logError("Prepare statement failed: " . $conn->error, __FILE__, __LINE__);
        header("Location: /project/home?error=Something went wrong. Please try again.");
        exit();
    }
    if (!$stmt->execute()) {
        logError("Execution failed:  " . $stmt->error, __FILE__, __LINE__);
        header("Location: /project/home?error=Something went wrong. Please try again.");
        exit();
    }

    $result = $stmt->get_result();

    if (!$result) { 
        logError("get_result() failed: " . $stmt->error, __FILE__, __LINE__);
        header("Location: /project/home?error=" . urlencode("Something went wrong. Please try again."));
        exit();
    }
    $tickets = $result->fetch_all(MYSQLI_ASSOC) ?: [];

    require __DIR__ . '/../views/myTickets.view.php';
}
?>
