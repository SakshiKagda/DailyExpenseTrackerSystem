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

// Fetch user ID and pricing status based on email
$sql_user_info = "SELECT user_id, pricing_status FROM users WHERE email = '$email'";
$result_user_info = $conn->query($sql_user_info);

if ($result_user_info->num_rows > 0) {
    $row_user_info = $result_user_info->fetch_assoc();
    $user_id = $row_user_info['user_id'];
    $pricing_status = $row_user_info['pricing_status'];

    // Fetch expense categories associated with the logged-in user
    $categorySql = "SELECT * FROM expenses_categories WHERE user_id = '$user_id'";
    $categoryResult = $conn->query($categorySql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expenses - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('assets/images/flat-lay-finance-elements-assortment-with-empty-notepad.jpg');
            /* Replace 'background.jpg' with your actual background image path */
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
             margin-right: 56px !important;
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
        .btn-secondary:not(.btn-light) {
    color: #ffffff;
}
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Add Expenses</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()" enctype="multipart/form-data">
            <div class="form-group">
                <label for="expenseName">Expense Name</label>
                <input type="text" class="form-control" name="expenseName" id="expenseName" placeholder="Enter expense name" required>
            </div>

            <div class="form-group">
                <label for="expenseAmount">Expense Amount</label>
                <input type="number" class="form-control" name="expenseAmount" id="expenseAmount" placeholder="Enter expense amount" required>
            </div>

            <div class="form-group">
                <label for="expenseCategory">Expense Category</label>
                <select class="form-select" name="expenseCategory" id="expenseCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="Food">Food</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Transportation">Transport</option>
                    <option value="Hospital">Hospital</option>
                    <option value="Education">Education</option>
                    <option value="Groceries">Groceries</option>
                    <option value="Entertaiment">Entertaiment</option>
                    <option value="Home">Home</option>
                    <option value="Other">Other</option>
                    <option value="Electronic">Electronic</option>
                   
                   
                    <?php
                    // Loop through categories and generate options
                    while ($row = $categoryResult->fetch_assoc()) {
                        echo '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="expenseDescription">Expense Description</label>
                <textarea class="form-control" name="expenseDescription" id="expenseDescription" rows="3" placeholder="Enter expense description"></textarea>
            </div>

            <div class="form-group">
                <label for="expenseDate">Expense Date</label>
                <input type="date" class="form-control" name="expenseDate" id="expenseDate" required>
            </div>

            <div class="form-group">
                <label for="billImage">Bill Image</label>
                <input type="file" class="form-control" name="billImage" id="billImage" <?php if ($pricing_status != 1) echo 'disabled'; ?>>
                <small class="form-text text-muted">You need to subscribe to upload bill images.</small>
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="1" id="notificationCheckbox" name="notificationCheckbox" <?php if ($pricing_status != 1) echo 'disabled'; ?>>
                    Receive daily notifications and reminders
                </label>
            </div>

            <a href="demo.php" class="btn btn-secondary btn-go-back">Go Back</a>
            <button type="submit" class="btn btn-primary">Add Expense</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if the required fields are filled
            if (!empty($_POST["expenseName"]) && !empty($_POST["expenseAmount"]) && !empty($_POST["expenseCategory"]) && !empty($_POST["expenseDate"])) {
                // Fetch other form data
                $expenseName = $_POST["expenseName"];
                $expenseAmount = $_POST["expenseAmount"];
                $expenseCategory = $_POST["expenseCategory"];
                $expenseDescription = $_POST["expenseDescription"];
                $expenseDate = $_POST["expenseDate"];
                $receiveNotifications = isset($_POST["notificationCheckbox"]) ? 1 : 0;

                // Upload bill image if pricing status is 1
                $billImage = '';
                if ($pricing_status == 1 && $_FILES['billImage']['error'] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["billImage"]["tmp_name"];
                    $billImage = "uploads/" . $_FILES["billImage"]["name"];
                    move_uploaded_file($tmp_name, $billImage);
                }

                // Construct SQL query to insert expense
                $sql = "INSERT INTO expenses (expenseName, expenseAmount, expenseCategory, expenseDescription, expenseDate, user_id, receive_notifications, billimage) VALUES ('$expenseName', '$expenseAmount', '$expenseCategory', '$expenseDescription', '$expenseDate', '$user_id', '$receiveNotifications', '$billImage')";

                // Execute SQL query to insert expense
                if ($conn->query($sql) === TRUE) {
                    echo "Expense added successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo '<p>Please fill in all required fields.</p>';
            }
        }
        ?>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            var expenseName = document.getElementById('expenseName').value;
            var expenseAmount = document.getElementById('expenseAmount').value;
            var expenseCategory = document.getElementById('expenseCategory').value;
            var expenseDate = document.getElementById('expenseDate').value;

            if (expenseName.trim() === '' || expenseAmount.trim() === '' || expenseCategory.trim() === '' || expenseDate.trim() === '') {
                alert('Please fill in all required fields.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
<?php
} else {
    echo "<p>User not found.</p>";
}
?>
