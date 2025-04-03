<?php
require_once __DIR__ . '/../errorlog.inc.php';
require_once __DIR__ . '/../models/createTicket.php';

function showPostForm() {
    if ($_SESSION["role"] === 'admin') {
        $queryString = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
        header("Location: /project/adminTicket". $queryString);
        exit(); 
    }
    $dbEmail = $_SESSION["email"] ?? "Guest";
    $dbID = $_SESSION["user_id"] ?? 0 ;
    require __DIR__ . '/../views/submitTicket.php';
}
function showAdminForm() {
    global $conn;
    require __DIR__ . '/../views/adminTicket.view.php';
}

function storeAdminPost(){

}
function storePost() {

    require_once __DIR__ . '/../database/db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $requester = trim($_POST["requester"] ?? '');
    $requester_id = trim($_POST["requester_id"] ?? ''); 
    $subject = trim($_POST["subject"] ?? '');
    $priority = trim($_POST["priority"] ?? '');
    $topic = trim($_POST["topic"] ?? '');
    $description = trim($_POST["description"] ?? '');
    $logs = json_encode([]);
    
    $errors = [];
    if (empty($subject)) $errors['subject_error'] = "Enter a subject.";
    if (empty($priority)) $errors['priority_error'] = "Select a priority.";
    if (empty($topic)) $errors['topic_error'] = "Enter a topic.";
    if (empty($description)) $errors['description_error'] = "Enter a description.";

    if (!empty($errors)) {
        header("Location: /project/newTicket?" . http_build_query($errors));
        exit();
    }

    $attachment = null;
    $attachmentType = null;

    // Handle file upload
    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $fileType = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    
        if (in_array($fileType, $allowedTypes)) {
            //$attachment = file_get_contents($_FILES["attachment"]["tmp_name"]);
            $attachment = base64_encode(file_get_contents($_FILES["attachment"]["tmp_name"]));
            $attachmentType = $_FILES["attachment"]["type"];
        } else {
            header("Location: /project/newTicket?error=" . urlencode("Invalid file type."));
            exit();
        }
    } else {
        $attachment = null;
        $attachmentType = null;
    }
    if($_FILES['attachment']['error'] !== UPLOAD_ERR_OK){
        logError("Upload fail: " .$_FILES['attachment']['error'], __FILE__, __LINE__);
    }
    

    // Save ticket to database
    if (createTicket($requester_id, $requester, $subject, $priority, $topic, $description, $logs, $attachment, $attachmentType)) {
        header("Location: /project/newTicket?success=" . urlencode("Ticket submitted successfully!"));
        include_once __DIR__. '/../mailer.inc.php';
        $message = "<p>Thank you for your interest, <b>$requester</b>. We have received your Ticket:</p><blockquote>$subject</blockquote><p>We will contact you soon.</p>";
        $sub = "Ticket Received - We will contact you soon!";
        sendUserEmail($requester, $sub, $message);

        exit();
    } else {
        header("Location: /project/newTicket?error=" . urlencode("Database error."));
        exit();
    }
    }
}
