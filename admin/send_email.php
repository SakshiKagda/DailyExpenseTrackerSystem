<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Initialize PHPMailer
$mail = new PHPMailer(true);

// Mock database for demonstration purposes
$users = [
    'sakshikagda08@gmail.com' => [
        'sakshi' => 'sakshi',
        'reset_token' => null,
        'token_expiry' => null,
        'reset_status' => 0,
        'hashed_reset_token' => null,
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (array_key_exists($email, $users)) {
        // Generate a unique token (you might want to use a library for this)
        $token = bin2hex(random_bytes(32));
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);

        // Set token and expiry in the database
        $users[$email]['reset_token'] = $token;
        $users[$email]['token_expiry'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $users[$email]['hashed_reset_token'] = $hashedToken;

        // Send email with reset link
        $resetLink = 'http://yourwebsite.com/reset_password.php?token=' . $token;

        try {
            $mail->isSMTP();
            // ... (configure SMTP settings)

            $mail->setFrom('kagdasakshi09@gmail.com', 'Sakshi');
            $mail->addAddress('sakshikagda08@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body    = 'Click the following link to reset your password: ' . $resetLink;

            $mail->send();

            echo 'Check your email for the password reset link.';
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Email address not found.';
    }
}
?>
