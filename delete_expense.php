<?php
// delete_expense.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $expenseId = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the file name to delete from the database
    $sql = "SELECT billImage FROM expenses WHERE expense_id = $expenseId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $billImageToDelete = $row['billImage'];

        // Delete the row from the database
        $deleteSql = "DELETE FROM expenses WHERE expense_id = $expenseId";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Expense deleted successfully.";

            // Delete the corresponding image file
            if (!empty($billImageToDelete)) {
                $fileToDelete = "uploads/" . $billImageToDelete;
                if (file_exists($fileToDelete)) {
                    unlink($fileToDelete);
                    echo " Image file deleted successfully.";
                } else {
                    echo " Image file not found.";
                }
            }
            
            // Redirect to ViewExp.php after deleting expense
            header("Location: ViewExp.php");
            exit();
        } else {
            echo "Error deleting expense: " . $conn->error;
        }
    } else {
        echo "Expense not found.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
