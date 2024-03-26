<?php
ob_start(); // Start output buffering
session_start();
// Other PHP code follows...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts - Income and Expenses</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-PyGmuM2e8y9rr8rN50IqBe4J2r+mXPH2M6Zpw/jRP1xCj0zqoqjdt0/Jl08DfP93OiA8s5RTh+H6yOr1P7OxcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* CSS code */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/images/creative-business-arrangement-with-colorful-graphics.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
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
            flex-wrap: wrap;
            justify-content: space-between;
            margin-right: 56px !important;
            animation: fadeInDown 1s both;
        }

        .box {
            width: calc(25% - 20px);
            height: auto;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: inline-block;
            vertical-align: top;
            margin-right: 20px;
            animation: fadeInLeft 1s both;
        }

        .box:nth-child(1) { background-color: #fff3cd; }
        .box:nth-child(2) { background-color: #cce5ff; }
        .box:nth-child(3) { background-color: #d1e7dd; }
        .box:nth-child(4) { background-color: #f5c6cb; }

        .box i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #555;
        }

        .box h3 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #333;
        }

        .box p {
            font-size: 18px;
            margin-top: 5px;
            color: #777;
        }

        .charts-container {
            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .chart-container {
            flex-basis: 48%;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInRight 1s both;
        }

        canvas {
            width: 100%;
            height: 350px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .progress-container {
            margin-top: 20px;
            width: 100%;
            animation: fadeInUp 1s both;
        }

        .progress {
            height: 30px;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 100%;
        }

        .progress-bar {
            border-radius: 5px;
            width: 100%;
        }

        .progress-label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .progress-info {
            font-size: 14px;
            color: #777;
        }

        .sidebar {
            width: 250px;
            background-color: #111;
            padding-top: 20px;
            min-height: 100vh;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            animation: slideInLeft 1s both;
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

        /* Define animations */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
<div class="sidebar">
    <!-- Sidebar content -->
    <!-- PHP code for including sidebar -->
    <?php include 'sidebar1.php'; ?>
</div>
<div class="container">
    <!-- PHP code for box content -->
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
        echo "<script>alert('You are not logged in. Please login to view your data.');</script>";
    } else {
        // Get the logged-in user's email from the session
        $email = $_SESSION['email'];
    }
    // Fetch total income for the logged-in user
    $sql_total_income = "SELECT SUM(incomeAmount) AS totalIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
    $result_total_income = $conn->query($sql_total_income);
    $totalIncome = $result_total_income->fetch_assoc()['totalIncome'];

    // Fetch total monthly income for the logged-in user
    $sql_monthly_income = "SELECT SUM(incomeAmount) AS totalMonthlyIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND MONTH(incomeDate) = MONTH(CURRENT_DATE())";
    $result_monthly_income = $conn->query($sql_monthly_income);
    $totalMonthlyIncome = $result_monthly_income->fetch_assoc()['totalMonthlyIncome'];

    // Fetch total expenses for the logged-in user
    $sql_total_expenses = "SELECT SUM(expenseAmount) AS totalExpenses FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
    $result_total_expenses = $conn->query($sql_total_expenses);
    $totalExpenses = $result_total_expenses->fetch_assoc()['totalExpenses'];

    // Fetch total monthly expenses for the logged-in user
    $sql_monthly_expenses = "SELECT SUM(expenseAmount) AS totalMonthlyExpenses FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND MONTH(expenseDate) = MONTH(CURRENT_DATE())";
    $result_monthly_expenses = $conn->query($sql_monthly_expenses);
    $totalMonthlyExpenses = $result_monthly_expenses->fetch_assoc()['totalMonthlyExpenses'];

    // Fetch monthly income vs. expenses data for the logged-in user
    $sql_monthly_data = "SELECT 
                            MONTHNAME(expenseDate) AS month, 
                            SUM(incomeAmount) AS income, 
                            SUM(expenseAmount) AS expenses 
                        FROM 
                            incomes 
                        LEFT JOIN 
                            expenses 
                        ON 
                            MONTH(incomes.incomeDate) = MONTH(expenses.expenseDate) 
                        WHERE 
                            incomes.user_id = (SELECT user_id FROM users WHERE email = '$email') 
                        GROUP BY 
                            MONTH(incomes.incomeDate)";
    $result_monthly_data = $conn->query($sql_monthly_data);

    $monthly_data = [];
    $all_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    // Initialize monthly data array with all months and set initial values to 0
    foreach ($all_months as $month) {
        $monthly_data[$month] = [
            'income' => 0,
            'expenses' => 0
        ];
    }

    // Update monthly data with fetched data from the database
    while ($row = $result_monthly_data->fetch_assoc()) {
        $month_name = $row['month'];
        $monthly_data[$month_name] = [
            'income' => $row['income'],
            'expenses' => $row['expenses']
        ];
    }

    // Fetch expenses by categories for the logged-in user
    $sql_expense_categories = "SELECT 
                                    expenseCategory, 
                                    SUM(expenseAmount) AS totalExpense 
                                FROM 
                                    expenses 
                                WHERE 
                                    user_id = (SELECT user_id FROM users WHERE email = '$email') 
                                AND 
                                    expenseCategory IN 
                                        (SELECT DISTINCT category FROM budgets WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')) 
                                GROUP BY 
                                    expenseCategory";
    $result_expense_categories = $conn->query($sql_expense_categories);
    $expense_categories = [];
    while ($row = $result_expense_categories->fetch_assoc()) {
        $expense_categories[$row['expenseCategory']] = $row['totalExpense'];
    }

    // Calculate percentage of expenses for each category relative to the total expenses
    $total_expenses = array_sum($expense_categories);
    $category_percentages = [];
    foreach ($expense_categories as $category => $amount) {
        $category_percentages[$category] = ($amount / $total_expenses) * 100;
    }

    // Fetch past year and current year budget data for each category
    $past_year_budget = [];
    $current_year_budget = [];

    // Fetch past year budget data
  // Fetch past year budget data
// Fetch past year budget data
$sql_past_year_budget = "SELECT category, COALESCE(planned_amount, 0) AS planned_amount FROM budgets WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND YEAR(start_date) <= YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR)) AND YEAR(end_date) >= YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR))";
$result_past_year_budget = $conn->query($sql_past_year_budget);
while ($row = $result_past_year_budget->fetch_assoc()) {
    $past_year_budget[$row['category']] = $row['planned_amount'];
}


// Fetch current year budget data
// Fetch current year budget data
$sql_current_year_budget = "SELECT category, COALESCE(planned_amount, 0) AS planned_amount FROM budgets WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND YEAR(start_date) <= YEAR(CURRENT_DATE()) AND YEAR(end_date) >= YEAR(CURRENT_DATE())";
$result_current_year_budget = $conn->query($sql_current_year_budget);
while ($row = $result_current_year_budget->fetch_assoc()) {
    $current_year_budget[$row['category']] = $row['planned_amount'];
}


    // Fetch past year and current year income data for the logged-in user
    $sql_past_year_income = "SELECT SUM(incomeAmount) AS pastYearIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND YEAR(incomeDate) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR))";
    $result_past_year_income = $conn->query($sql_past_year_income);
    $pastYearIncome = $result_past_year_income->fetch_assoc()['pastYearIncome'];

    $sql_current_year_income = "SELECT SUM(incomeAmount) AS currentYearIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND YEAR(incomeDate) = YEAR(CURRENT_DATE())";
    $result_current_year_income = $conn->query($sql_current_year_income);
    $currentYearIncome = $result_current_year_income->fetch_assoc()['currentYearIncome'];
    ?>
    <div class="box">
        <i class="fas fa-dollar-sign"></i>
        <h3>Total Income</h3>
        <p id="totalIncome"><?php echo $totalIncome; ?></p>
    </div>

    <div class="box">
        <i class="far fa-calendar-alt"></i>
        <h3>Total Monthly Income</h3>
        <p id="totalMonthlyIncome"><?php echo $totalMonthlyIncome; ?></p>
    </div>
    <div class="box">
        <i class="fas fa-coins"></i>
        <h3>Total Expenses</h3>
        <p id="totalExpenses" <?php echo ($totalExpenses > $totalIncome) ? 'style="color: red;"' : ''; ?>><?php echo $totalExpenses; ?></p>
    </div>

    <div class="box">
        <i class="far fa-calendar-times"></i>
        <h3>Total Monthly Expenses</h3>
        <p id="totalMonthlyExpenses" <?php echo ($totalMonthlyExpenses > $totalMonthlyIncome) ? 'style="color: red;"' : ''; ?>><?php echo $totalMonthlyExpenses; ?></p>
    </div>


    <div class="charts-container">
        <div class="chart-container">
            <!-- Bar Graph for Monthly Income vs Expenses -->
            <canvas id="monthlyBarChart"></canvas>
        </div>
        <div class="chart-container">
            <!-- Pie Chart for Expenses by Categories -->
            <canvas id="pieChart"></canvas>
        </div>
        <div class="chart-container">
            <!-- Line Graph for Budget Comparison -->
            <canvas id="budgetLineChart"></canvas>
        </div>
        <div class="chart-container">
            <!-- Line Graph for Income Comparison -->
            <canvas id="incomeLineChart"></canvas>
        </div>
    </div>

    <!-- Progress bars for expense categories -->
    <div class="progress-container">
    <h2>Budget Status by Category</h2>
    <?php
    // Get all unique categories from the expense categories and budgets
    $all_categories = array_unique(array_merge(array_keys($expense_categories), array_keys($current_year_budget)));

    if (!empty($all_categories)) {
        foreach ($all_categories as $category) {
            // Check if the category has a budget
            $planned_amount = isset($current_year_budget[$category]) ? $current_year_budget[$category] : 0;
            $total_expense = isset($expense_categories[$category]) ? $expense_categories[$category] : 0;

            // Render progress bar for each category
            ?>
            <div class="progress-label"><?php echo $category; ?></div>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($total_expense / max($planned_amount, 1)) * 100; ?>%" aria-valuenow="<?php echo ($total_expense / max($planned_amount, 1)) * 100; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="progress-info">
                <span>Total Expense: ₹<?php echo number_format($total_expense, 2); ?></span> | <span>Planned Amount: ₹<?php echo number_format($planned_amount, 2); ?></span>
            </div>
            <?php
        }
    } else {
        echo "<p>No budgeted categories found.</p>";
    }
    ?>
</div>




<script>
    // JavaScript code for rendering charts
    // Monthly Income vs Expenses Bar Chart
    var ctx1 = document.getElementById('monthlyBarChart').getContext('2d');
    var monthlyBarChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($monthly_data)); ?>,
            datasets: [{
                label: 'Income',
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                data: <?php echo json_encode(array_values(array_column($monthly_data, 'income'))); ?>
            }, {
                label: 'Expenses',
                backgroundColor: 'rgba(220, 53, 69, 0.5)',
                data: <?php echo json_encode(array_values(array_column($monthly_data, 'expenses'))); ?>
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Pie Chart for Expenses by Categories
    var ctx2 = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($expense_categories)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($expense_categories)); ?>,
                backgroundColor: [
                    'rgba(0, 123, 255, 0.5)',
                    'rgba(220, 53, 69, 0.5)',
                    'rgba(255, 193, 7, 0.5)',
                    'rgba(40, 167, 69, 0.5)',
                    'rgba(102, 16, 242, 0.5)',
                    'rgba(23, 162, 184, 0.5)',
                    'rgba(248, 249, 250, 0.5)',
                    'rgba(108, 117, 125, 0.5)',
                    'rgba(52, 58, 64, 0.5)'
                ]
            }]
        }
    });

    // Budget Line Chart
   // Budget Line Chart
var ctx3 = document.getElementById('budgetLineChart').getContext('2d');
var budgetLineChart = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_keys($current_year_budget)); ?>,
        datasets: [{
            label: 'Past Year Budget',
            data: <?php echo json_encode(array_values($past_year_budget)); ?>,
            borderColor: 'rgba(255, 99, 132, 0.5)',
            fill: false
        }, {
            label: 'Current Year Budget',
            data: <?php echo json_encode(array_values($current_year_budget)); ?>,
            borderColor: 'rgba(40, 167, 69, 0.5)',
            fill: false
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


    // Income Line Chart
    var ctx4 = document.getElementById('incomeLineChart').getContext('2d');
    var incomeLineChart = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: ['Past Year', 'Current Year'],
            datasets: [{
                label: 'Past Year Income',
                data: [<?php echo $pastYearIncome; ?>, 0],
                borderColor: 'rgba(255, 99, 132, 0.5)',
                fill: false
            }, {
                label: 'Current Year Income',
                data: [0, <?php echo $currentYearIncome; ?>],
                borderColor: 'rgba(54, 162, 235, 0.5)',
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
</body>
</html>
