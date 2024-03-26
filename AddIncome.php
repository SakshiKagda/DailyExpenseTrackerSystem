<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Include database connection
include 'Connection.php';

// Fetch user ID based on email
$sql_user_id = "SELECT user_id FROM users WHERE email = '$email'";
$result_user_id = $conn->query($sql_user_id);

if ($result_user_id->num_rows > 0) {
    $row_user_id = $result_user_id->fetch_assoc();
    $user_id = $row_user_id['user_id'];

    // Fetch categories associated with the logged-in user
    $categorySql = "SELECT * FROM incomes_categories WHERE user_id = '$user_id'";
    $categoryResult = $conn->query($categorySql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Income - Income Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('assets/images/financial-income-economic-diagram-money-concept.jpg'); /* Replace 'background.jpg' with your actual background image path */
    background-size: cover;
    background-position: center;
    color: #333;
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

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff !important; /* Change background color */
            border-color: #007bff !important; /* Change border color */
        }

        .btn-primary:hover {
            background-color: #0056b3 !important;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Add Income</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="incomeName">Income Name</label>
                <input type="text" class="form-control" name="incomeName" id="incomeName" placeholder="Enter income name" required>
            </div>

            <div class="form-group">
                <label for="incomeAmount">Income Amount</label>
                <input type="number" class="form-control" name="incomeAmount" id="incomeAmount" placeholder="Enter income amount" required>
            </div>

            <div class="form-group">
                <label for="incomeCategory">Income Category</label>
                <select class="form-select" name="incomeCategory" id="incomeCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="job">Job</option>
                    <option value="business">Business</option>
                    <option value="freelance">Freelance</option>
                    <option value="other">Other</option>
                    <?php
                    // Loop through categories and generate options
                    while ($row = $categoryResult->fetch_assoc()) {
                        echo '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="incomeDescription">Income Description</label>
                <textarea class="form-control" name="incomeDescription" id="incomeDescription" rows="3" placeholder="Enter income description"></textarea>
            </div>

            <div class="form-group">
                <label for="incomeDate">Income Date</label>
                <input type="date" class="form-control" name="incomeDate" id="incomeDate" required>
            </div>

            <a href="demo.php" class="btn btn-secondary btn-go-back">Go Back</a>
            <button type="submit" class="btn btn-primary">Add Income</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Fetch other form data
            $incomeName = $_POST["incomeName"];
            $incomeAmount = $_POST["incomeAmount"];
            $incomeCategory = $_POST["incomeCategory"];
            $incomeDescription = $_POST["incomeDescription"];
            $incomeDate = $_POST["incomeDate"];

            // Construct SQL query to insert income
            $sql = "INSERT INTO incomes (incomeName, incomeAmount, incomeCategory, incomeDescription, incomeDate, user_id) VALUES ('$incomeName', '$incomeAmount', '$incomeCategory', '$incomeDescription', '$incomeDate', '$user_id')";

            // Execute SQL query to insert income
            if ($conn->query($sql) == TRUE) {
                echo "Income added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>

        <script>
            function validateForm() {
                var incomeName = document.getElementById('incomeName').value;
                var incomeAmount = document.getElementById('incomeAmount').value;
                var incomeCategory = document.getElementById('incomeCategory').value;
                var incomeDate = document.getElementById('incomeDate').value;

                if (incomeName.trim() === '' || incomeAmount.trim() === '' || incomeCategory.trim() === '' || incomeDate.trim() === '') {
                    alert('Please fill in all required fields.');
                    return false;
                }

                return true;
            }
        </script>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>