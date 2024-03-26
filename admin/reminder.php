<?php
session_start();
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:\xampp\htdocs\SMTP\vendor\autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'kagdasakshi09@gmail.com'; // SMTP username
    $mail->Password = 'qmqe rosa rkev qlcw';   // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to

    $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];
    //Recipients
    $mail->setFrom('kagdasakshi09@gmail.com', ' Sakshi');

    include 'connect.php';
    // Get current date
    $current_date = date("2025-03-18");

    // Get users whose subscription is expiring in 3 days
    $sql = "SELECT s.*, u.username, u.email FROM subscription s JOIN users u ON s.user_id = u.user_id WHERE s.end_date = DATE_ADD('$current_date', INTERVAL 3 DAY)";
    // echo"$sql";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $username = $row["username"];
            $email = $row["email"];

            $mail->addAddress($email, $username);
        }

        $mail->Subject = 'Your Exclusive Renewal Offer Awaits!';
        $mail->Body = 'Your subscription is expiring on ' . $current_date . '. Please renew your subscription. Click <a href="C:\xampp\htdocs\DETS(main)\DETS_DEMO\pricing.php">here</a> to view our pricing page.';
        $mail->AltBody = 'Your subscription is expiring on ' . $current_date . '. Please renew your subscription. Visit C:\xampp\htdocs\DETS(main)\DETS_DEMO\pricing.php to view our pricing page.';

        $mail->send();
        echo 'Message has been sent';
        header("Location:index.php");
    } else {
        echo "0 results";
    }

    $conn->close();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>