<?php
// Start output buffering to prevent output from being sent prematurely
ob_start();

// Start the session
session_start();

// Your remaining PHP code goes here
// ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Expenses - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/flat-lay-finance-elements-assortment-with-empty-notepad.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .container {
            width:75% !important;
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
            color: white;
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

        .date-column {
            white-space: nowrap; 
        }

        .action-buttons {
            display: flex;
            align-items: center;
        }

        .action-buttons a {
            margin-right: 5px;
        }

        .container .btn-primary {
            margin-top: 0px; 
            width: fit-content; 
            padding: 5px 10px; 
            font-size: 16px; 
            background-color: #007bff; 
            border-color: #007bff; 
            color: #fff; 
        }
        .btn-primary:hover {
            background-color: #0056b3 !important;
        }

        .table-wrapper {
            height: 500px; 
            width: 100%; 
            overflow-y: auto; 
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>

    <div class="container">
        <h2>Expenses Report</h2>

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

        <?php 
        // Start session to access session variables
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

        // Include database connection
        include  'connection.php';

        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            // Redirect to login page or display an error message
            header("Location: login.php");
            exit();
        }

        // Get the logged-in user's email from the session
        $email = $_SESSION['email'];

        // Fetch expenses for the logged-in user
        $month = isset($_GET['month']) ? $_GET['month'] : 'all';
        $year = isset($_GET['year']) ? $_GET['year'] : 'all';

        $sql = "SELECT * FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";

        if ($month !== 'all') {
            $sql .= " AND MONTH(expenseDate) = $month";
        }

        if ($year !== 'all') {
            $sql .= " AND YEAR(expenseDate) = $year";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display expenses
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
                </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['expense_id']}</td>
                        <td>{$row['expenseName']}</td>
                        <td>{$row['expenseAmount']}</td>
                        <td>{$row['expenseCategory']}</td>
                        <td>{$row['expenseDescription']}</td>
                        <td>{$row['expenseDate']}</td>
                        <td><img src='{$row['billImage']}' alt='Bill Image' style='max-width: 100px;'></td>
                    </tr>";
            }
            echo "</table>";

            // PDF download link
            echo "<a href='download_expenses.php' class='btn btn-primary'><span class='pdf-symbol'>&#x1F4C4;</span>Download Expenses Report (PDF)</a>";
        } else {
            echo "<p>No expenses found for this user.</p>";
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
