<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Start the session
session_start();

// Check if the confirm_payment button was clicked
if (isset($_POST['confirm_payment'])) {
    // Admin's email address
    $admin_email = 'kagdasakshi09@gmail.com';

    // Get the logged-in user's email address from the session
    $user_email = $_SESSION['email']; // Change 'email' to the key used to store the user's email address in the session

    // Get the payment method selected by the user
    $paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 'Unknown';

    // SMTP configuration
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
        $mail->send();
        echo 'Email sent successfully';

        // Database connection
        include 'connection.php'; // Include your database connection file

        // Fetch user ID and pricing status based on email from the database
        $sql = "SELECT user_id, pricing_status FROM users WHERE email = '$user_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $pricing_status = $row['pricing_status'];

            // Calculate start and end date
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+1 year', strtotime($startDate)));

            // Other subscription details (assumed constants)
            $subscriptionPlan = 'Premium';
            $billingFrequency = 'Yearly';
            $amount = 100;

            // Determine status based on pricing status
            $status = $pricing_status == 1 ? 'Active' : 'Pending';

            // Insert into database
            $sql = "INSERT INTO subscription (user_id, start_date, end_date, payment_method, subscription_plan, billing_frequency, amount, status) 
                    VALUES ('$user_id', '$startDate', '$endDate', '$paymentMethod', '$subscriptionPlan', '$billingFrequency', $amount, '$status')";

            // Execute SQL query
            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Email sent successfully! Payment is confirmed. Subscription information added to the database.");</script>';
                // Redirect to another page
                header('Location: bankdetails.php');
                exit; // Terminate script execution after redirect
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "User not found";
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
