<?php
// Include database connection
include 'Connection.php';

// Start session to access session variables
if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    echo "<script>alert('You are not logged in. Please login to view your data.');</script>";
    exit; // Stop further execution
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Initialize data array
$data = array();

// Fetch monthly data for the logged-in user
$sql_monthly_data = "
    SELECT 
        MONTH(incomeDate) AS month,
        SUM(incomeAmount) AS income, 
        SUM(expenseAmount) AS expenses 
    FROM 
        incomes 
    WHERE 
        user_id = (SELECT user_id FROM users WHERE email = '$email') 
    GROUP BY 
        MONTH(incomeDate)
";
$result_monthly_data = $conn->query($sql_monthly_data);

// Process the fetched data
if ($result_monthly_data && $result_monthly_data->num_rows > 0) {
    while ($row = $result_monthly_data->fetch_assoc()) {
        $data['monthlyData'][intval($row['month'])] = array(
            'income' => $row['income'],
            'expenses' => $row['expenses']
        );
    }
}

// Fetch expense categories and their total amounts for the logged-in user
$sql_expense_categories = "
    SELECT 
        expenseCategory, 
        SUM(expenseAmount) AS totalAmount 
    FROM 
        expenses 
    WHERE 
        user_id = (SELECT user_id FROM users WHERE email = '$email') 
    GROUP BY 
        expenseCategory
";
$result_expense_categories = $conn->query($sql_expense_categories);

// Process the fetched expense categories data
if ($result_expense_categories && $result_expense_categories->num_rows > 0) {
    while ($row = $result_expense_categories->fetch_assoc()) {
        $data['expenseCategories'][$row['category']] = $row['totalAmount'];
    }
}

// Close database connection
$conn->close();

// Send the processed data as JSON response
echo json_encode($data);
?>
