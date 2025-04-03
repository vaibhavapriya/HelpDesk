<?php 
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendUserEmail($toEmail, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'youremail'; // Your email
        $mail->Password = 'your password'; // Use App Password if using Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('vaibhavapriya39@gmail.com', 'Support Team'); // ✅ Correct sender email
        $mail->addAddress($toEmail); // ✅ Correct recipient email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject; 
        $mail->Body = strip_tags($message);
        $mail->AltBody = "<html><body><p>" . nl2br(htmlspecialchars($message)) . "</p></body></html>";
        

        if ($mail->send()) {
            return true;
        } else {
            logError("Email failed: " . $mail->ErrorInfo, __FILE__, __LINE__);
            return false;
        }
    } catch (Exception $e) {
        logError("Email failed: " . $e->getMessage(), __FILE__, __LINE__);
        return false;
    }
}
