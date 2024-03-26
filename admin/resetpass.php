<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\DETS(main)\vendor\autoload.php';
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_GET["token"];
    
    // Check if "new_password" is set in the POST array
    if (isset($_POST["new_password"])) {
        $password = $_POST["new_password"];

        // Check if the token is valid and not expired
        $checkTokenQuery = "SELECT * FROM admins WHERE reset_token = ? AND reset_token_expiry > NOW()";
        $checkTokenStmt = $conn->prepare($checkTokenQuery);
        if (!$checkTokenStmt) {
            die("Prepare failed: " . $conn->error);
        }
        $checkTokenStmt->bind_param("s", $token);
        if (!$checkTokenStmt->execute()) {
            die("Execute failed: " . $checkTokenStmt->error);
        }
        $checkTokenResult = $checkTokenStmt->get_result();

        if ($checkTokenResult !== false && $checkTokenResult->num_rows > 0) {
            $user = $checkTokenResult->fetch_assoc();
            $email = $user["email"];

            // Update the password and set status and last_password_change fields
            $updatePasswordQuery = $conn->prepare("UPDATE admins SET password = ?, reset_status = 1, last_password_change = NOW() WHERE email = ?");
            if (!$updatePasswordQuery) {
                die("Prepare failed: " . $conn->error);
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updatePasswordQuery->bind_param("ss", $hashedPassword, $email);

            if ($updatePasswordQuery->execute()) {
                // Password reset successfully, redirect to login.php
                header("Location: login.php");
                exit();
            } else {
                echo "Error updating password: " . $conn->error;
            }

            $updatePasswordQuery->close();
        } else {
            echo "Invalid or expired token.";
        }
    } else {
        echo "New password not provided.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daily Expense Tracker System</title>
  
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
    label{
      font-weight: bold;
    }
    .content-wrapper{
      background-color: #E1EEF2 !important;
    }
    .btn-block{
      background-color:#047edf !important;
      border-color: #047edf !important;
      color: white !important;
    }
  </style>
</head>

<body>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="assets/images/image.png">
              </div>
              <h3>Reset Password</h3>
        <form action="" method="post" id="resetPasswordForm">
            <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" class="form-control form-control-lg" placeholder="Password" id="new_password" name="new_password" required>
            </div>
            <div class="mt-3 text-center">
                  <button type="submit" name="submit" 
                    class="btn btn-block  btn-lg font-weight-medium auth-form-btn">Reset Password</button>
                </div>
        </form>
          
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>
  <!-- endinject -->
</body>

</html>
