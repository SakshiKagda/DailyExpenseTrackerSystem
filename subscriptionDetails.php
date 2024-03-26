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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subscription - Subscription Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('assets/images/istockphoto-1342223620-612x612.jpg');
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
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Add Subscription</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" name="end_date" id="end_date" required>
            </div>

            <div class="form-group">
                <label for="amount_paid">Amount Paid</label>
                <input type="number" class="form-control" name="amount_paid" id="amount_paid" placeholder="Enter amount paid" required>
            </div>

            <div class="form-group">
                <label for="subscription_plan">Subscription Plan</label>
                <input type="text" class="form-control" name="subscription_plan" id="subscription_plan" placeholder="Enter subscription plan" required>
            </div>

            <div class="form-group">
                <label for="billing_frequency">Billing Frequency</label>
                <select class="form-select" name="billing_frequency" id="billing_frequency" required>
                    <option value="" disabled selected>Select billing frequency</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <input type="text" class="form-control" name="payment_method" id="payment_method" placeholder="Enter payment method" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Subscription</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Fetch other form data
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];
            $amount_paid = $_POST["amount_paid"];
            $subscription_plan = $_POST["subscription_plan"];
            $billing_frequency = $_POST["billing_frequency"];
            $payment_method = $_POST["payment_method"];

            // Construct SQL query to insert subscription
            $sql = "INSERT INTO subscription (user_id, start_date, end_date, amount, subscription_plan, billing_frequency, payment_method) 
                    VALUES ('$user_id', '$start_date', '$end_date', '$amount_paid', '$subscription_plan', '$billing_frequency', '$payment_method')";

            // Execute SQL query to insert subscription
            if ($conn->query($sql) === TRUE) {
                echo "Subscription added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            var start_date = document.getElementById('start_date').value;
            var end_date = document.getElementById('end_date').value;
            var amount_paid = document.getElementById('amount_paid').value;
            var subscription_plan = document.getElementById('subscription_plan').value;
            var billing_frequency = document.getElementById('billing_frequency').value;
            var payment_method = document.getElementById('payment_method').value;

            if (start_date.trim() === '' || end_date.trim() === '' || amount_paid.trim() === '' || subscription_plan.trim() === '' || billing_frequency.trim() === '' || payment_method.trim() === '') {
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
