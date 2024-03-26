<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Include database connection
include 'Connection.php';

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Fetch user ID based on email
$sql_user_id = "SELECT user_id FROM users WHERE email = '$email'";
$result_user_id = $conn->query($sql_user_id);

// Check if user ID was fetched successfully
if ($result_user_id->num_rows > 0) {
    $row_user_id = $result_user_id->fetch_assoc();
    $user_id = $row_user_id['user_id'];

    // Fetch subscription details associated with the logged-in user
    $subscriptionSql = "SELECT * FROM subscription WHERE user_id = '$user_id'";
    $subscriptionResult = $conn->query($subscriptionSql);

    // Check if subscription details were fetched successfully
    if ($subscriptionResult) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('assets/images/latest-news-subscribe-update (1) (1).jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
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
            color: #fff;
            border-radius: 10px;
            margin-right: 20px;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .subscription-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .subscription-column {
            flex: 1 0 50%;
        }

        .subscription-item {
            padding: 20px;
            border-radius: 10px;
            background-color: #f0f0f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .subscription-column h3 {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .subscription-item div {
            margin-bottom: 15px;
        }

        .subscription-item strong {
    font-weight: bold;
    font-size: 18px;
    color: #333;
    float: left;
    width: 200px; /* Increase label width */
}

.subscription-item span {
    font-size: 18px;
    color: #666;
    margin-left: 220px; /* Increase space between label and detail */
    display: block;
}
        

        .renew-button {
            margin-top: 20px;
            text-align: center;
        }

        .renew-button button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .renew-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Subscription Details</h2>
        <div class="subscription-details">
            <?php
            // Display subscription details
            if ($subscriptionResult->num_rows > 0) {
                while ($row = $subscriptionResult->fetch_assoc()) {
            ?>
            <div class='subscription-column'>
                <div class='subscription-item'>
                    <strong>Start Date:</strong> <span><?= $row['start_date'] ?></span><br>
                    <strong>End Date:</strong> <span><?= $row['end_date'] ?></span><br>
                    <strong>Amount Paid:</strong> <span>₹<?= $row['amount'] ?></span><br>
                    <strong>Subscription Plan:</strong> <span><?= $row['subscription_plan'] ?></span><br>
                    <strong>Billing Frequency:</strong> <span><?= $row['billing_frequency'] ?></span><br>
                    <strong>Payment Method:</strong> <span><?= $row['payment_method'] ?></span><br>
                    <strong>Status:</strong> <span><?= $row['status'] ?></span><br>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No subscription found.</p>";
            }
            ?>
        </div>
        <div class="renew-button">
    <a href="pricing.php"><button>Renew Subscription</button></a>
</div>

    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
    } else {
        echo "Error fetching subscription details: " . $conn->error;
    }
} else {
    echo "<p>User not found.</p>";
}
?>
