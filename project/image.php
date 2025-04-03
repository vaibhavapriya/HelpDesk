<?php
require_once __DIR__ . '/database/db.php'; // Adjust the path if necessary

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    die("Bad Request: No image ID provided.");
}

$ticket_id = intval($_GET['id']); // Ensure ID is an integer

$stmt = $conn->prepare("SELECT attachment, attachment_type FROM tickets WHERE id = ?");
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row || empty($row['attachment'])) {
    http_response_code(404);
    die("No image found.");
}

$attachmentData = base64_decode($row['attachment']); // Decode Base64
$attachmentType = $row['attachment_type'];

header("Content-Type: $attachmentType");
echo $attachmentData;
exit;
?>

