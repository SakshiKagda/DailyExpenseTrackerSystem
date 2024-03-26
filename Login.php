<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "Expense") or die("connection failed");

// Validate the form submission
if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select_query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $select_query);
    $rows_count = mysqli_num_rows($result);
    $row_data = mysqli_fetch_assoc($result);

    if ($rows_count > 0) {
        if (password_verify($password, $row_data['password'])) {
            // Set session variables
            //$_SESSION['user_id'] = $row_data['user_id']; // Change 'user_id' to the actual column name in your 'user' table
            $_SESSION['email'] = $email;

            // Redirect to the dashboard or any other page
            header("Location: demo.php");
            exit();
        } else {
            echo "<script>alert('Invalid Credentials for password')</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .links {
            text-align: center;
            margin-top: 10px;
        }

        .links a {
            color: #333;
            text-decoration: underline;
            margin: 0 10px;
            cursor: pointer;
        }

        .links a:hover {
            color: #555;
        }
    </style>
</head>
<body>

<div class="overlay">
    <h2>Login</h2>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="Login">Login</button>
    </form>

    <?php
    // Display error messages if any
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>

    <div class="links">
        <a href="ForgetPassword.php">Forgot Password?</a>
        <span>|</span>
        <a href="SingUp.php">Create Account</a>
    </div>
</div>

</body>
</html>
