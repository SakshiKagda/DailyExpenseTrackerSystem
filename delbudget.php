<?php
// delete_budget.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $budgetId = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense"; // Change to your budget database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the row from the database
    $deleteSql = "DELETE FROM budgets WHERE budget_id = $budgetId";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Budget deleted successfully.";

        // Redirect to ViewBudget.php after deleting budget
        header("Location: ViewBudget.php");
        exit();
    } else {
        echo "Error deleting budget: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
