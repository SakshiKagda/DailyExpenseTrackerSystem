<?php
session_start();

include 'connect.php';
// Get the admin's ID from the session
$adminId = $_SESSION['id'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name']; // Change 'username' to 'name'
    $email = $_POST['email'];
    $mobile = $_POST['mobile']; // Change 'mobile_number' to 'mobile'
   

    // Check if a new profile picture was uploaded
    if ($_FILES['profile_image']['size'] > 0) {
        // Get the file details
        $file_name = $_FILES['profile_image']['name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_type = $_FILES['profile_image']['type'];

        // Check if the file is an image
        $file_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_parts));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            die("Error: Only JPEG, JPG, and PNG files are allowed.");
        }

        // Move the uploaded file to the uploads directory
        move_uploaded_file($file_tmp, "uploads/" . $file_name);

        // Update the admin's profile picture in the database
        $sql = "UPDATE admins SET profile_image = '$file_name' WHERE id = $adminId";
        if ($conn->query($sql) === false) {
            die("Error updating profile picture: " . $conn->error);
        }
    }

    // Update the admin's name, email, mobile number, and gender in the database
    $sql = "UPDATE admins SET username = '$name', email = '$email', mobile_number = '$mobile'  WHERE id = $adminId";
    if ($conn->query($sql) === false) {
        die("Error updating profile: " . $conn->error);
    }

    // Redirect to the profile page
    header("Location: index.php");
    exit();
}
?>
