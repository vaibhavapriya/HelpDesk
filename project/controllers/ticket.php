<?php


function ticketController() {
    require_once __DIR__ . '/../database/db.php';
    require_once __DIR__ . '/../errorlog.inc.php';
    global $conn;
    // Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error()); // This will print the error message if the connection failed
}

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: /project/myTickets?error=" . urlencode("Invalid ticket ID."));
        exit();
    }
    $ticket_id = $_GET['id'];
    $userEmail = $_SESSION["email"];

    // Fetch ticket and check ownership
    $stmt = $conn->prepare("SELECT id, subject, priority, topic, description, last_replier, status, last_activity, requester FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    
    if (!$stmt->execute()) {
        header("Location: /project/myTickets?error=" . urlencode("Something went wrong. Please try again."));
        exit();
    }

    $result = $stmt->get_result();
    $ticket = $result->fetch_assoc();

    // If ticket does not exist
    if (!$ticket) {
        header("Location: /project/clientTicket?error=" . urlencode("ticket not found"));
        exit();
    }

    // If ticket exists but belongs to another user
    if ($ticket['requester'] !== $userEmail) {
        header("Location: /project/home?error=" . urlencode("access denied"));
        exit();
    }

    require __DIR__ . '/../views/ticket.view.php';
}
