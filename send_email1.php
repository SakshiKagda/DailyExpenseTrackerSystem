<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Admin email address
    $admin_email = "kagdasakshi09@gmail.com"; // Replace with actual admin email address

    // Create a new PHPMailer instance
    $smtp_host = 'smtp.gmail.com';
    $smtp_port = 587; // Use 587 for TLS
    $smtp_username = '21bcuos093@ddu.ac.in';
    $smtp_password = 'lejz xnsj qtrk nqsr';

    $mail = new PHPMailer(true);
    try {
        // Sender and recipient
        $mail->setFrom($smtp_username);
        $mail->addAddress($admin_email);

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Payment Confirmation';
        $mail->Body = 'Payment method selected: ' . $paymentMethod;

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $smtp_port;

        // Send the email
        $mail->send();                                   // Set email format to plain text
        $mail->Subject = $subject;                                  // Email subject
        $mail->Body    = "Name: $name\nEmail: $email\nPhone Number: $number\nSubject: $subject\nMessage: $message"; // Email body

        // Send email
        $mail->send();
        echo "Your message has been sent successfully!";
        header("Location:index.php");
    } catch (Exception $e) {
        echo "Failed to send your message. Error: {$mail->ErrorInfo}";
    }
}
?>
