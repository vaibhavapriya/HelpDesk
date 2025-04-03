<?php
    require_once __DIR__ . '/../database/db.php';
    require_once __DIR__ . '/../errorlog.inc.php';

function ticketsController() {
    global $conn;

    // Fetch tickets for the logged-in user
    $stmt = $conn->prepare("SELECT 
        tickets.id AS ticket_id,
        tickets.requester_id,
        tickets.requester,
        tickets.subject,
        tickets.priority,
        tickets.logs,
        tickets.last_replier,
        tickets.status,
        tickets.created_at AS ticket_created_at,
        user.userid,
        user.name AS requester_name,
        user.phone AS requester_phone
    FROM 
        tickets
    LEFT JOIN 
        user ON tickets.requester_id = user.userid ORDER BY last_activity DESC");
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

    require __DIR__ . '/../views/tickets.view.php';
}
?>
