<?php
    // Start output buffering to prevent output from being sent prematurely
    ob_start();

    // Start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Your remaining PHP code goes here
    // ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports - Expenses & Income Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/work-with-magnifying-glass-calculator-papers.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .container {
            width:75% !important;
            /* max-width: 800px; */
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            width: 250px;
            background-color: #111;
            padding-top: 20px;
            height: 100%;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        h2 {
            color: #007bff;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .btn-edit,
        .btn-delete {
            background-color:#007bff;
            text-decoration: none;
            padding: 5px 10px;
            margin-right: 5px;
            /* border: 1px solid #007bff; */
            color: white;
            /* border-radius: 3px; */
            transition: background-color 0.3s;
        }

        .btn-edit:hover,
        .btn-delete:hover {
            background-color: #007bff;
            color: #fff;
        }

       /* Style for the filter dropdown */
       .filter-form {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .filter-form label {
            margin-right: 10px;
            font-weight: bold;
        }

        .filter-form select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        /* Adjust button width and margin */
        .filter-form button {
            min-width: 100px;
            margin-left: 10px;
        }

        /* Adjust date column */
        .date-column {
            white-space: nowrap; /* Prevent line break */
        }

        /* Adjust action buttons */
        .action-buttons {
            display: flex;
            align-items: center;
        }

        /* Add margin between action buttons */
        .action-buttons a {
            margin-right: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3 !important;
        }

        /* Style for the "Go Back" button */
        .container .btn-primary {
            margin-top: 0px; /* Add margin to separate from the table */
            width: fit-content; /* Adjust button width to fit content */
            padding: 5px 10px; /* Adjust padding */
            font-size: 16px; /* Decrease font size */
            background-color: #007bff; /* Change background color */
            border-color: #007bff; /* Change border color */
            color: #fff; /* Change text color */
        }


        /* Adjust table wrapper */
        .table-wrapper {
            height: 500px; /* Set height to 500px */
            width: 100%; /* Set width to 100% */
            overflow-y: auto; /* Add vertical scrollbar */
        }
        .expense {
            color: red;
        }

        .income {
            color: green;
        }

    </style>
</head>
<body>
<div class="sidebar">
    <?php include 'sidebar1.php'; ?>
</div>

<div class="container">
    <h2>Combined Expenses and Income Report</h2>

    <!-- Filter Form -->
   
    <form action="" method="GET" class="filter-form">
            <label for="month">Filter by Month:</label>
            <select name="month" id="month">
                <option value="all">All Months</option>
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                <?php endfor; ?>
            </select>

            
            <button type="submit" class="btn btn-primary">Apply Filter</button>
        </form>
    </form>

    <?php
    // Start session to access session variables
    if (!isset($_SESSION)) {
        session_start();
    }

    // Include database connection
    include 'connection.php';

    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        // Redirect to login page or display an error message
        header("Location: login.php");
        exit();
    }

    // Get the logged-in user's email from the session
    $email = $_SESSION['email'];

    $sql = "SELECT expense_id, expenseName AS Name, expenseAmount AS Amount, expenseCategory AS Category, expenseDescription AS Description, expenseDate AS Date, billImage AS Image, 'Expense' AS Type FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";

// Check if filter is applied
if (isset($_GET['month']) && $_GET['month'] !== 'all') {
    $month = $_GET['month'];
    $sql .= " AND MONTH(expenseDate) = $month";
    $sql .= " UNION ALL SELECT income_id, incomeName AS Name, incomeAmount AS Amount, incomeCategory AS Category, incomeDescription AS Description, incomeDate AS Date, NULL AS Image, 'Income' AS Type FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND MONTH(incomeDate) = $month";
} else {
    $sql .= " UNION ALL SELECT income_id, incomeName AS Name, incomeAmount AS Amount, incomeCategory AS Category, incomeDescription AS Description, incomeDate AS Date, NULL AS Image, 'Income' AS Type FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
}

// Execute SQL query
$result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // Display combined report
        echo "<div class='table-wrapper'>";
        echo "<table>";
        echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Type</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            // Add specific class based on type (expense or income)
            $typeClass = ($row['Type'] === 'Expense') ? 'expense' : 'income';
            echo "<tr class='$typeClass'>
                            <td>{$row['expense_id']}</td>
                            <td>{$row['Name']}</td>
                            <td>{$row['Amount']}</td>
                            <td>{$row['Category']}</td>
                            <td>{$row['Description']}</td>
                            <td>{$row['Date']}</td>
                            <td><img src='{$row['Image']}' alt='Bill Image' style='max-width: 100px;'></td>
                            <td>{$row['Type']}</td>
                        </tr>";
        }

        echo "</table>";

        // PDF download link for combined report
        echo "<a href='download_combined_report.php' class='btn btn-primary'><span class='pdf-symbol'>&#x1F4C4;</span>Download Combined Report (PDF)</a>";
        
    } else {
        echo "<p>No data found for this user.</p>";
    }

    // Close database connection
    $conn->close();
    ?>

    <a href="demo.php" class="btn btn-primary">Go Back</a>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
