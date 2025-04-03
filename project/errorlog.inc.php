<?php
require_once __DIR__ . '/database/db.php'; 

function logError($message, $file, $line) {
    global $conn;

    if (!$conn) { 
        error_log("Database connection error: " . mysqli_connect_error());
        return;
    }

    $stmt = $conn->prepare("INSERT INTO error_logs (error_message, error_file, error_line) VALUES (?, ?, ?)");

    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return;
    }

    $stmt->bind_param("ssi", $message, $file, $line);

    if ($stmt->execute()) {
        $conn->commit();
    } else {
        error_log("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}

// Custom error handler to catch all PHP warnings/errors
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    logError("PHP Error [$errno]: $errstr", $errfile, $errline);
}
set_error_handler("customErrorHandler");
?>
