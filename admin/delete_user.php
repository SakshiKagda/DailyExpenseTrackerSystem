<?php
// Ensure session is started
session_start();

// Check if user_id is provided and if the request method is POST
if(isset($_POST['user_ids']) && is_array($_POST['user_ids'])) {
    // Assuming you have your database connection established
    include 'connect.php';

    // Prepare a SQL statement to delete multiple users
    $userIds = implode(',', $_POST['user_ids']);
    $sql = "DELETE FROM users WHERE user_id IN ($userIds)";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Selected users deleted successfully";
        header("Location: user.php");
       
    } else {
        echo "Error deleting users: " . $conn->error;
    }
} else {
    echo "No user IDs provided";
}
?>
