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
    <title>View Budgets - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/account-assets-audit-bank-bookkeeping-finance-concept.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .container {
            width: 75% !important;
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
            background-color: #007bff;
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

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .filter-form label {
            margin-right: 10px;
        }

        .filter-form select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
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

        .over-budget {
            color: red;
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

    </style>
</head>

<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>

    <div class="container">
        <h2>View Budgets</h2>

        <!-- Filter Form -->
        <form action="" method="GET" class="filter-form">
            <label for="month">Filter by Month:</label>
            <select name="month" id="month">
                <option value="all">All Months</option>
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                <?php endfor; ?>
            </select>

            <label for="year">Filter by Year:</label>
            <select name="year" id="year">
                <option value="all">All Years</option>
                <?php 
                // Modify the range of years as per your requirement
                $currentYear = date("Y");
                for ($year = $currentYear; $year >= 2020; $year--) : ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endfor; ?>
            </select>

            <button type="submit" class="btn btn-primary">Apply Filter</button>
        </form>


        <?php 
        if (!isset($_SESSION)) {
            session_start();
        }
        include 'connection.php';

        if (!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }

        $email = $_SESSION['email'];

        $month = isset($_GET['month']) ? $_GET['month'] : 'all';
        $year = isset($_GET['year']) ? $_GET['year'] : 'all';

        $sql = "SELECT b.budget_id, b.planned_amount, b.category, b.start_date, b.end_date, 
        COALESCE(SUM(CASE WHEN ";

        if ($year != 'all') {
            $sql .= "YEAR(e.expenseDate) = '$year'";
        } else {
            $sql .= "1=1"; // Always true condition for all years
        }

        $sql .= " THEN e.expenseAmount ELSE 0 END), 0) AS total_expenses
        FROM budgets b
        LEFT JOIN expenses e ON b.category = e.expenseCategory
        JOIN users u ON b.user_id = u.user_id
        WHERE u.email = '$email'";

        if ($month != 'all') {
            $sql .= " AND MONTH(b.start_date) = $month";
        }

        // Include condition to filter by year if a specific year is selected
        if ($year != 'all') {
            $sql .= " AND YEAR(b.start_date) = $year";
        }

        $sql .= " GROUP BY b.budget_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='table-wrapper'>";
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Planned Amount</th>
                    <th>Category</th>
                    <th>Total Expenses</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                $totalExpensesClass = ($row['total_expenses'] > $row['planned_amount']) ? 'over-budget' : '';
                echo "<tr>
                        <td>{$row['budget_id']}</td>
                        <td>{$row['planned_amount']}</td>
                        <td>{$row['category']}</td>
                        <td class='total-expenses {$totalExpensesClass}'>{$row['total_expenses']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>
                            <a href='editbudget.php?id={$row['budget_id']}' class='btn-edit'>Edit</a>
                            <a href='delbudget.php?id={$row['budget_id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No budgets found for this user.</p>";
        }

        $conn->close();
        ?>
        <a href="AddBudget.php" class="btn btn-primary">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
