<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\SMTP\vendor\autoload.php';

// session_start();
if (!isset($_SESSION)) {
  session_start();
}
include 'connect.php';


// Get the user ID and pricing status from the form
$user_id = $_POST['user_id'];
if (isset($_POST['pricing_status'])) {
  $pricing_status = $_POST['pricing_status'];

  // Update the pricing status in the users table
  if ($pricing_status == 'active') {
    $pricing_status_value = 1; // Change this to 1
  } else if ($pricing_status == 'inactive') {
    $pricing_status_value = 0;
  } else if ($pricing_status == 'pending') {
    $pricing_status_value = 2;
  }
  $sql = "UPDATE users SET pricing_status = '$pricing_status_value' WHERE user_id = $user_id";

  if ($conn->query($sql) === TRUE) {
    echo "Pricing status updated successfully";
    header('Location: user.php');    
    // Send email if the status is updated to "active"
    if ($pricing_status_value == 1) { // Change this to 1
      // Email credentials
      $sender_email = "kagdasakshi09@gmailcom";
      $sender_password = "qmqe rosa rkev qlcw";
      $receiver_email = "sakshikagda8@gmail.com";
      
      // Get user email from the database
      $sql = "SELECT email FROM users WHERE user_id = $user_id";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row['email'];
      } else {
        echo "User not found";
        exit;
      }
      
      // Email content
      $subject = "Congratulations! Your Subscription is Confirmed";
      $emailBody = '
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Subscription Confirmation</title>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 0;
                  background-color: #f8f9fa;
              }
              .container {
                  max-width: 600px;
                  margin: 20px auto;
                  padding: 20px;
                  background-color: #fff;
                  border-radius: 8px;
                  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
              }
              h1 {
                  color: #007bff;
                  margin-top: 0;
              }
              p {
                  margin-bottom: 20px;
              }
              .details {
                  background-color: #f2f3f5;
                  padding: 15px;
                  border-radius: 6px;
              }
              .cta-btn {
                  display: inline-block;
                  padding: 10px 20px;
                  background-color: #007bff;
                  color: #fff;
                  text-decoration: none;
                  border-radius: 4px;
                  transition: background-color 0.3s;
              }
              .cta-btn:hover {
                  background-color: #0056b3;
              }
              .footer {
                  text-align: center;
                  color: #6c757d;
                  margin-top: 20px;
              }
          </style>
      </head>
      <body>
          <div class="container">
              <h1>Congratulations!</h1>
              <p>Your subscription to our service has been successfully confirmed. You are now a valued member of our community.</p>
              <div class="details">
                  <p><strong>Subscription Details:</strong></p>
                  <p><strong>Plan Name:</strong>Premium Plan</p>
                  <p><strong>Subscription Period:</strong> 19/02/2024 - 19/02/2025</p>
                  <p><strong>Billing Cycle:</strong>Yearly</p>
                  <p><strong>Subscription Fee:</strong>₹100</p>
                  <p><strong>Renewal Date:</strong>22/02/2025</p>
              </div>
              <p>We are committed to providing you with seamless service and ensuring your satisfaction throughout your subscription journey.</p>
              <p>Thank you once again for choosing us. We look forward to serving you!</p>
              <p>Warm regards</p>
              <div class="footer">
                  <p>This is an automated message. Please do not reply.</p>
              </div>
          </div>
      </body>
      </html>
      ';
      
      // PHPMailer initialization
      $mail = new PHPMailer(true);
      
      try {
          // Server settings
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com'; // SMTP server
          $mail->SMTPAuth   = true;
          $mail->Username   = 'kagdasakshi09@gmail.com'; // SMTP username
          $mail->Password   = 'qmqe rosa rkev qlcw';   // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
          $mail->Port       = 587; // TCP port to connect to
          
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
          $mail->addAddress($user_email);
    
          // Content
          $mail->isHTML(true);
          $mail->Subject = $subject;
          $mail->Body = $emailBody;
      
          $mail->send();
          echo 'Email sent successfully!';
          header('Location: user.php');
      } catch (Exception $e) {
          echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  } else {
    echo "Error updating pricing status: " . $conn->error;
  }
} else {
  echo "Pricing status not set";
}


?>
