<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "Expense";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$reset_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $checkUserQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkUserResult = $conn->query($checkUserQuery);

    if ($checkUserResult->num_rows > 0) {
        $token = md5(uniqid(rand(), true));

        $insertTokenQuery = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $insertTokenQuery->bind_param("ss", $token, $email);

        if ($insertTokenQuery->execute()) {
            $resetLink = "http://localhost/DETS_DEMO/resetpassword.php?token=$token";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '21bcuos093@ddu.ac.in';
                $mail->Password = 'lejz xnsj qtrk nqsr';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('your_email@gmail.com', 'Your Name');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = "Click on the following link to reset your password: $resetLink";

                $mail->send();
                

                $reset_message = "An email with instructions to reset your password has been sent to your email address.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $insertTokenQuery->close();
    } else {
        echo "Email not found in our records. Please try again.";
    }
}
?>
<!-- Your HTML code remains the same -->

<!-- Rest of your HTML code -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    background: url('assets/images/top-view-office-desk-with-growth-chart-coins.jpg') center/cover no-repeat fixed;
    display: flex;
    align-items: center;
    justify-content: center;
}

.overlay {
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    color: #555;
}

input {
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    padding: 10px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.reset-message {
    color: green;
    text-align: center;
    margin-top: 10px;
}

.error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
}
</style>
</head>
<body>
    <div class="overlay">
        <h2>Forgot Password</h2>
        <?php if ($reset_message !== ""): ?>
              <p class="reset-message">
                <?php echo $reset_message; ?>
              </p>
              <?php else: ?>
            <form action="" method="post" id="forgetPasswordForm">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <p id="emailError" class="error-message"></p>
                <button type="button" onclick="validateForm()">Reset Password</button>
            </form>
            <script>
                function validateForm() {
                    var emailInput = document.getElementById('email');
                    var emailError = document.getElementById('emailError');
                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    // Reset previous errors
                    emailError.textContent = '';
                    // Validate email
                    if (!emailPattern.test(emailInput.value)) {
                        emailError.textContent = 'Enter a valid email address.';
                        return;
                    }
                    // If all validations pass, submit the form
                    document.getElementById('forgetPasswordForm').submit();
                }
            </script>
        <?php endif; ?>
    </div> <!-- Closing div for the overlay -->
</body>
</html>
