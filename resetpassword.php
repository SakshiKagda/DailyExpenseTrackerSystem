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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_GET["token"];
    
    // Check if "new_password" is set in the POST array
    if (isset($_POST["new_password"])) {
        $password = $_POST["new_password"];

        $checkTokenQuery = "SELECT * FROM users WHERE reset_token = '$token' AND reset_token_expiry > NOW()";
        $checkTokenResult = $conn->query($checkTokenQuery);

        if ($checkTokenResult->num_rows > 0) {
            $user = $checkTokenResult->fetch_assoc();
            $email = $user["email"];

            $updatePasswordQuery = $conn->prepare("UPDATE users SET password = ?, reset_status = 1, last_password_change = NOW() WHERE email = ?");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updatePasswordQuery->bind_param("ss", $hashedPassword, $email);

            if ($updatePasswordQuery->execute()) {
                echo "Password reset successfully.";
            } else {
                echo "Error updating password: " . $conn->error;
            }

            $updatePasswordQuery->close();
        } else {
            echo "Invalid or expired token.";
        }
    } else {
        echo "New password not provided.";
    }
}
?>
<!-- Your HTML code remains the same -->

<!-- Your HTML code remains the same -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        <h2>Reset Password</h2>
        <form action="" method="post" id="resetPasswordForm">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit">Reset Password</button>
        </form>
    </div> <!-- Closing div for the overlay -->
</body>
</html>
