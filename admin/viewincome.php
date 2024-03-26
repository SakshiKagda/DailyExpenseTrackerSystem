<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Income Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <style>
        .main {
            display: flex;
            padding-top: 70px;
        }

        h2 {
            color: black;
        }

        tr {
            color: black;
        }

        .thead {
            background-color: #047edf;
        }

        th {
            color: white;
        }

        .icon {
            float: right;
            margin-right: 10px;
        }

        .pagination .page-item .page-link {
            color: black;
        }

        .content-wrapper {
            background-color: #E1EEF2 !important;
        }

        .sidebar .nav.sub-menu .nav-item .nav-link.active {
            color: #2847de !important;

            background: transparent;
        }

        .btn-primary {
            background-color: #047edf !important;
            border-color: #047edf !important;
        }

        .page-title .page-title-icon {
            background-color: #2847de !important;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        #error-message-container{
            color: red !important;
        }
    </style>
</head>

<body>
    <header>
        <?php include ("header.php"); ?>
    </header>

    <div class="main">
        <div>
            <?php include ("sidebar.php"); ?>
        </div>
        <div class="content-wrapper">
            <div class="container mt-5">
                <div id="error-message-container">

                </div>
                <div class="page-header">
                    <h1 class="page-title">
                        <a href="index.php" style="text-decoration: none; color: inherit;"> <!-- Add this anchor tag -->
                            <span class="page-title-icon text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span>
                        </a>
                        View Incomes
                    </h1>
                </div>
                <div class="icon">
                    <div class="filter-dropdown">
                        <label for="filter">Filter by:</label>
                        <select id="filter" name="filter">
                            <option value="all">All</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <button type="submit" class="btn-sm btn-primary" value="Apply"
                            onclick="applyFilter()">Apply</button><br><br>

                    </div>
                </div>
                <script>
                    function applyFilter() {
                        var filterValue = document.getElementById('filter').value;
                        var incomes = document.querySelectorAll('.income-row');
                        var filteredIncomesCount = 0; // Initialize count of filtered expenses

                        incomes.forEach(function (income) {
                            var date = new Date(income.querySelector('.income-date').textContent);
                            var incomeMonth = date.getMonth() + 1; // Adjusting month to match filter values

                            if (filterValue === 'all' || incomeMonth === parseInt(filterValue)) {
                                income.style.display = 'table-row';
                                filteredIncomesCount++; // Increment count for each expense displayed
                            } else {
                                income.style.display = 'none';
                            }
                        });

                        // If no incomes are found after filtering, display an error message
                        var errorContainer = document.getElementById('error-message-container');
                        if (filteredIncomesCount === 0 && filterValue !== 'all') {
                            errorContainer.innerHTML = '<p class="error-message">No income found for the selected filter.</p>';
                        } else {
                            // Clear any existing error message
                            errorContainer.innerHTML = '';
                        }
                    }

                </script>

                <?php
                include 'connect.php';


                // SQL query to fetch users who have added income
                $sql = "SELECT DISTINCT users.user_id AS user_id, users.username AS username, users.email AS email FROM users INNER JOIN incomes ON users.user_id = incomes.user_id";
                $result = $conn->query($sql);

                // Check for errors in the SQL query
                if (!$result) {
                    die ("Error in SQL query: " . mysqli_error($conn));
                }

                // Check if any users exist
                if ($result->num_rows > 0) {
                    // Output data of each user
                    while ($row = $result->fetch_assoc()) {
                        $userId = $row["user_id"];
                        $username = $row["username"];
                        $email = $row["email"];

                        // SQL query to fetch income for the current user
                        $incomeSql = "SELECT * FROM incomes WHERE user_id = $userId";
                        $incomeResult = $conn->query($incomeSql);

                        // SQL query to fetch expense for the current user
                        $expenseSql = "SELECT * FROM expenses WHERE user_id = $userId";
                        $expenseResult = $conn->query($expenseSql);

                        // Check if any income exist for the current user
                        if ($incomeResult->num_rows > 0) {
                            echo "<h4>User: $username ($email)</h4>";
                            // Output table for income
                            echo "<table class='table table-bordered table-hover'>";
                            echo "<thead class='thead'>";
                            echo "<tr>";
                            echo "<th>User ID</th>";
                            echo "<th>Income Name</th>";
                            echo "<th>Amount</th>";
                            echo "<th>Category</th>";
                            echo "<th>Description</th>";
                            echo "<th>Date</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            // Output data of each income
                            $totalIncome = 0; // Initialize total income for the user
                            while ($incomeRow = $incomeResult->fetch_assoc()) {
                                echo "<tr class='income-row'>"; // Added class for filtering
                                echo "<td>" . $incomeRow["user_id"] . "</td>";
                                echo "<td>" . $incomeRow["incomeName"] . "</td>";
                                echo "<td>" . $incomeRow["incomeAmount"] . "</td>";
                                echo "<td>" . $incomeRow["incomeCategory"] . "</td>";
                                echo "<td>" . $incomeRow["incomeDescription"] . "</td>";
                                echo "<td class='income-date'>" . $incomeRow["incomeDate"] . "</td>"; // Added class for filtering
                                echo "</tr>";

                                // Add the income amount to the total income
                                $totalIncome += $incomeRow["incomeAmount"];
                            }

                            // Output data of each expense
                            $totalExpense = 0; // Initialize total expense for the user
                            while ($expenseRow = $expenseResult->fetch_assoc()) {
                                // Add the expense amount to the total expense
                                $totalExpense += $expenseRow["expenseAmount"];
                            }

                            // Display the total income for the user
                            echo "<tr>";
                            echo "<td colspan='2'>Total Income</td>";
                            echo "<td>$totalIncome</td>";
                            echo "<td colspan='3'></td>"; // colspan='3' to span the remaining columns
                            echo "</tr>";

                            // Display the total expense for the user
                            echo "<tr>";
                            echo "<td colspan='2'>Total Expense</td>";
                            echo "<td>$totalExpense</td>";
                            echo "<td colspan='3'></td>"; // colspan='3' to span the remaining columns
                            echo "</tr>";

                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>No income found for user: $username ($email)</p>";
                        }
                        echo "<br><br><br>";
                    }
                } else {
                    echo "<p>No users found.</p>";
                }

                $results_per_page = 10; // Set the desired number of results per page
                if (!isset ($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }
                $offset = ($page - 1) * $results_per_page;
                ?>
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
                <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>