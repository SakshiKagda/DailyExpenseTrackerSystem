<?php
session_start();

// Function to establish database connection (you need to customize this function)
function connectToDatabase() {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "Expense";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Validate the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input (sanitize input if needed)
    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $mobileNumber = $_POST["mobile_number"];
    $gender = $_POST["gender"];

    // Validate password and confirm password match
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Validate file upload for the profile picture
        $profilePicture = $_FILES["profile_picture"];

        // Check if a file was uploaded successfully
        if ($profilePicture["error"] == UPLOAD_ERR_OK) {
            // Check if the uploaded file is an image
            $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = pathinfo($profilePicture["name"], PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedFormats)) {
                $error_message = "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF.";
            }

            // Move the uploaded file to a destination folder (adjust the folder path as needed)
            $uploadPath = "uploads/";
            $uploadedFileName = $profilePicture["name"];
            $targetFilePath = $uploadPath . $uploadedFileName;

            if (move_uploaded_file($profilePicture["tmp_name"], $targetFilePath)) {
                // File upload successful, continue with other data processing

                // Add user to the database
                $conn = connectToDatabase();

                // Escape and sanitize user input to prevent SQL injection
                $username = $conn->real_escape_string($username);
                $email = $conn->real_escape_string($email);
                $password = password_hash($conn->real_escape_string($password), PASSWORD_DEFAULT); // Hash the password
                $mobileNumber = $conn->real_escape_string($mobileNumber);
                $gender = $conn->real_escape_string($gender);
                $targetFilePath = $conn->real_escape_string($targetFilePath);

                // Insert data into the user table
                $sql = "INSERT INTO users (username, email, password, mobile_number, gender, profile_image) 
                        VALUES ('$username', '$email', '$password', '$mobileNumber', '$gender', '$targetFilePath')";

                if ($conn->query($sql) == TRUE) {
                    // Redirect to login page after successful registration
                    header("Location: login.php");
                    exit();
                } else {
                    $error_message = "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
            } else {
                $error_message = "Failed to move the uploaded file.";
            }
        } elseif ($profilePicture["error"] != UPLOAD_ERR_NO_FILE) {
            $error_message = "File upload error: " . $profilePicture["error"];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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

        .gender-radio {
            display: flex;
            margin-top: 5px;
        }

        .gender-radio label {
            margin-right: 10px;
            white-space: nowrap;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var mobileNumber = document.getElementById("mobile_number").value;
            var profilePicture = document.getElementById("profile_picture").value;
            var profilePictureInput = document.getElementById("profile_picture");
            var allowedExtensions = ["jpg", "jpeg", "png", "gif"];

            // Validate name
            if (!/^[a-zA-Z ]{1,10}$/.test(name)) {
                alert("Name should only contain letters and have a maximum length of 10 characters.");
                return false;
            }

            // Validate mobile number
            if (!/^\d{10}$/.test(mobileNumber)) {
                alert("Mobile number should have exactly 10 digits.");
                return false;
            }

            // Validate password and confirm password match
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            // for image
            if (profilePictureInput.files.length === 0) {
                alert("Please select a profile picture.");
                return false;
            }

            // Get the file name and split it to get the extension
            var fileName = profilePictureInput.value;
            var fileExtension = fileName.split('.').pop().toLowerCase();

            // Check if the file extension is allowed
            if (allowedExtensions.indexOf(fileExtension) === -1) {
                alert("Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF.");
                profilePictureInput.value = ""; // Clear the file input
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="overlay">
        <h2>Registration</h2>
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php else: ?>
            <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
                <small>(Accepted formats: JPG, JPEG, PNG, GIF)</small>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="mobile_number">Mobile Number:</label>
                <input type="text" id="mobile_number" name="mobile_number" required>

                <label for="gender">Gender:</label>
                <div class="gender-radio">
                    <label><input type="radio" name="gender" value="male" required> Male</label>
                    <label><input type="radio" name="gender" value="female" required> Female</label>
                    <label><input type="radio" name="gender" value="other" required> Other</label>
                </div>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit">Register</button>
            </form>

            <?php
            // Display success or error messages if any
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
        <?php endif; ?>
    </div>
</body>
</html>
