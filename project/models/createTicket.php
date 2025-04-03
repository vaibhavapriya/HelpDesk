<?php

require_once __DIR__ . '/../database/db.php';
include_once __DIR__.'/../errorlog.inc.php';

function createTicket($requester_id, $requester, $subject, $priority, $topic, $description, $logs, $attachment = null, $attachmentType = null) {
    global $conn;

    // Convert logs to UTF-8 JSON
    $logs = json_encode(json_decode($logs, true), JSON_UNESCAPED_UNICODE);

    // If no attachment, adjust the query accordingly
    if ($attachment === null || $attachmentType === null) {
        $stmt = $conn->prepare("INSERT INTO tickets (requester_id, requester, subject, priority, topic, description, logs) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $requester_id, $requester, $subject, $priority, $topic, $description, $logs);
    } else {
        $stmt = $conn->prepare("INSERT INTO tickets (requester_id, requester, subject, priority, topic, description, logs, attachment, attachment_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssbs", $requester_id, $requester, $subject, $priority, $topic, $description, $logs, $attachment, $attachmentType);
        $stmt->send_long_data(7, $attachment); // Send binary data
    }

    $result = $stmt->execute();
    if (!$result) {
        die("Error: " . $stmt->error); // Debugging output
        logError("Execution failed: " . $stmt->error, __FILE__, __LINE__);
    }

    $stmt->close();
    return $result;
}

