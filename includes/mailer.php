<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendResetEmail($toEmail, $token) {
    $mail = new PHPMailer(true);

    try {
$mail->isSMTP();
$mail->Host       = 'smtp.example.com';      // SMTP server
$mail->SMTPAuth   = true;
$mail->Username   = 'your-email@example.com';
$mail->Password   = 'your-email-password';
$mail->SMTPSecure = 'tls';                   // Or 'ssl'
$mail->Port       = 587;                     // Or 465

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "
            <p>You requested a password reset.</p>
            <p><a href='http://localhost/signup-login-system/auth/reset_password.php?token=$token'>Click here to reset your password</a></p>
            <p>This link will expire in 1 hour.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Optional: show error for debugging
      echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}
?>