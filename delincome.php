<?php
// delete_income.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $incomeId = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense"; // Change to your income database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the row from the database
    $deleteSql = "DELETE FROM incomes WHERE income_id = $incomeId";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Income deleted successfully.";

        // Redirect to ViewIncome.php after deleting income
        header("Location: ViewIncome.php");
        exit();
    } else {
        echo "Error deleting income: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
