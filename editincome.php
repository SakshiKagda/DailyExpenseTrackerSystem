<?php
session_start();

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Function to establish database connection (customize according to your database credentials)
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense"; // Change to your income database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Check if income ID is provided in the URL
if (isset($_GET["id"])) {
    $incomeId = $_GET["id"];

    // Fetch income details from the database
    $conn = connectToDatabase();
    $sql = "SELECT * FROM incomes WHERE income_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $incomeId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $income = $result->fetch_assoc();
            } else {
                echo "Income not found.";
                exit();
            }
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
            exit();
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $conn->close();
} else {
    echo "Income ID not provided.";
    exit();
}

// Check if the form is submitted for updating the income
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $incomeId = $_POST["incomeId"];
    $incomeName = $_POST["incomeName"];
    $incomeAmount = $_POST["incomeAmount"];
    $incomeCategory = $_POST["incomeCategory"];
    $incomeDescription = $_POST["incomeDescription"];
    $incomeDate = $_POST["incomeDate"];

    $sql = "UPDATE incomes SET
            incomeName = ?,
            incomeAmount = ?,
            incomeCategory = ?,
            incomeDescription = ?,
            incomeDate = ?
            WHERE income_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssi", $incomeName, $incomeAmount, $incomeCategory, $incomeDescription, $incomeDate, $incomeId);

        if ($stmt->execute()) {
            // echo "Income updated successfully.";
        } else {
            echo "Error updating income: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Income - Income Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('assets/images/financial-income-economic-diagram-money-concept.jpg');
            /* Replace 'background.jpg' with your actual background image path */
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            /* Change flex direction to column */
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
        <h2>Edit Income</h2>
        <form method="post" action="" onsubmit="return validateForm()">
            <input type="hidden" name="incomeId" value="<?php echo $income["income_id"]; ?>">

            <!-- Your form fields for updating income details -->
            <div class="form-group">
                <label for="incomeName">Income Name</label>
                <input type="text" class="form-control" name="incomeName" id="incomeName" value="<?php echo $income["incomeName"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="incomeAmount">Income Amount</label>
                <input type="number" class="form-control" name="incomeAmount" id="incomeAmount" value="<?php echo $income["incomeAmount"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="incomeCategory">Income Category</label>
                <select class="form-select" name="incomeCategory" id="incomeCategory" required>
                    <option value="salary" <?php echo ($income["incomeCategory"] === "salary") ? "selected" : ""; ?>>Salary</option>
                    <option value="freelance" <?php echo ($income["incomeCategory"] === "freelance") ? "selected" : ""; ?>>Freelance</option>
                    <option value="investment" <?php echo ($income["incomeCategory"] === "investment") ? "selected" : ""; ?>>Investment</option>
                    <option value="other" <?php echo ($income["incomeCategory"] === "other") ? "selected" : ""; ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="incomeDescription">Income Description</label>
                <textarea class="form-control" name="incomeDescription" id="incomeDescription" rows="3" placeholder="Enter income description"><?php echo $income["incomeDescription"]; ?></textarea>
            </div>

            <div class="form-group">
                <label for="incomeDate">Income Date</label>
                <input type="date" class="form-control" name="incomeDate" id="incomeDate" value="<?php echo $income["incomeDate"]; ?>" required>
            </div>

            <!-- Your submit button -->
            <a href="ViewIncome.php" class="btn btn-secondary btn-go-back">Go Back</a>
            <button type="submit" class="btn btn-primary">Update Income</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // (This part has been moved to the top of the file for clarity)
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
