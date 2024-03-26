<?php
session_start(); // Start the session (if not already started)

// Check if the user clicked the Activate button and is logged out
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['activate']) && !isset($_SESSION['email'])) {
    // Redirect user to the login page
    header("Location: login.php");
    exit(); // Make sure to exit after redirecting
}

// Include database connection
include 'connection.php';

// Check if the user clicked the Activate button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['activate'])) {
    // Check if the user is logged in
    if (isset($_SESSION['email'])) {
        // Get user's email
        $email = $_SESSION['email'];

        // Update user's pricing status in the database
        $updateSql = "UPDATE users SET pricing_status = 2 WHERE email = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            // Pricing status updated successfully
            // Redirect user to Bankdetails.php
            header("Location: Bankdetails.php");
            exit(); // Make sure to exit after redirecting
        } else {
            // Error updating pricing status
            echo '<script>alert("Error activating pricing.");</script>';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pricing</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
  <style>
    body {
      font-family: 'Source Sans Pro', Arial, sans-serif;
      color: black;
      text-align: center;
      font-size: 16px;
      background: url('assets/images/top-view-office-desk-with-growth-chart-coins.jpg') center/cover no-repeat fixed;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      text-align: center;
    }

    h1, p {
      margin: 0 0 20px;
    }

    h1 {
      font-size: 2.5em;
    }

    p {
      font-size: 1.1em;
    }

    .snip1517 {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px; /* Adjust the gap as needed */
      margin-top: 20px;
      max-width: 1000px;
      margin-left: auto;
      margin-right: auto;
    }

    .plan {
      flex: 1; /* Each box will grow equally */
      min-width: 300px; /* Minimum width of each plan box */
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      position: relative;
      transition: transform 0.3s ease-in-out;
    }

    .plan:hover {
      transform: scale(1.05);
    }

    header, .plan-title, .plan-cost, .plan-features, .plan-select a {
      text-align: center;
    }

    .plan-title {
      font-size: 1.6em;
      margin: 0;
      padding: 20px;
    }

    .plan-cost {
      font-size: 2.8em;
      margin: 10px 0;
    }

    .plan-features li {
      padding: 8px 20px;
      list-style-type: none;
    }

    .plan-select {
      display: flex;
      justify-content: center; /* Center items horizontally */
      padding: 8px 20px;
    }

    .plan-select a {
      background-color: #156dab;
      border: none;
      color: white;
      padding: 10px 24px;
      text-align: center;
      text-decoration: none;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 12px;
      transition: background-color 0.3s ease;
    }

    .plan-select a:hover {
      background-color: #1b8ad8;
    }

    .plan-select button {
      background-color: #156dab;
      border: none;
      color: white;
      padding: 10px 24px;
      text-align: center;
      text-decoration: none;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 12px;
      transition: background-color 0.3s ease;
    }

    .plan-select button:hover {
      background-color: #1b8ad8;
    }

  </style>

</head>
<body>
<div class="container">
    <h1 class="animate__animated animate__fadeInDown">Our Pricing Plans</h1>
    <p class="animate__animated animate__fadeInUp">Choose the plan that suits you best.</p>
  </div>
  <div class="snip1517">
    <div class="plan animate__animated animate__fadeInLeft">
      <header>
        <h4 class="plan-title">Basic Plan</h4>
        <div class="plan-cost">Free</div>
      </header>
      <ul class="plan-features">
        <li>Keep track of your daily expenses</li>
        <li>Get started for free</li>
        <li>Access basic budgeting tools and expense tracking</li>
        <li>Enjoy free features like manage income, expense, etc.</li>
        <li>Start your journey with our Free Basic Plan</li>
      </ul>
      <div class="plan-select"><a href="#" class="animate__animated animate__fadeInUp">It's Free</a></div>
    </div>

    <div class="plan featured animate__animated animate__fadeInRight">
      <header>
        <h4 class="plan-title">Premium Plan</h4>
        <div class="plan-cost">₹100/month</div>
      </header>
      <ul class="plan-features">
        <li>Upgrade to Premium Plan Today</li>
        <li>Unlock premium features</li>
        <li>Gain access to PDF report generation</li>
        <li>Enjoy expense tracking with our Premium Plan.</li>
        <li>Elevate your expenses with our Premium Plan</li>
      </ul>
      <?php
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
        if ($email) {
            echo '<div class="plan-select"><form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"><input type="hidden" name="activate"><button type="submit">Activate</button></form></div>';
        } else {
            echo '<div class="plan-select"><button disabled>Activate</button></div>';
        }
      ?>
    </div>
  </div>
</body>
</html>
