<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // adjust path if needed

// Optional: you can create a helper function for sending emails
function sendEmail($to, $toName, $subject, $body, $fromEmail = '', $fromName = 'Blite') {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $fromEmail;                  // Gmail
        $mail->Password   = '';    // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        return $mail->send();
    } catch (Exception $e) {
        return "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
