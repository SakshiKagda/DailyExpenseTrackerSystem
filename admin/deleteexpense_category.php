<?php
session_start();
include 'connect.php';
// Check if the category ID is set in the URL
if (isset($_GET['id'])) {
    // Get the category ID from the URL
    $id = $_GET['id'];

    // Delete the category from the database
    $query = "DELETE FROM expenses_categories WHERE category_id=$id";
    $result = mysqli_query($conn, $query);

    // Check if the category was deleted successfully
    if ($result) {
        echo "Category deleted successfully.";
        header("Location:expensecategory.php");
    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }
} else {
    echo "Category ID not specified.";
}
?>