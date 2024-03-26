<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\DETS(main)\vendor\autoload.php';
include 'connect.php';

$reset_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $checkUserQuery = "SELECT * FROM admins WHERE email = '$email'";
    $checkUserResult = $conn->query($checkUserQuery);

    if ($checkUserResult->num_rows > 0) {
        $token = md5(uniqid(rand(), true));

        $insertTokenQuery = $conn->prepare("UPDATE admins SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $insertTokenQuery->bind_param("ss", $token, $email);

        if ($insertTokenQuery->execute()) {
            $resetLink = "http://localhost/DETS(main)/admin/resetpass.php?token=$token";


            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kagdasakshi09@gmail.com';
                $mail->Password = 'qmqe rosa rkev qlcw';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                // Additional configuration...
                $mail->SMTPSecure = 'tls';
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];

                $mail->setFrom('your_email@gmail.com', 'Your Name');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = "Click on the following link to reset your password: $resetLink";

                $mail->send();

                $reset_message = "An email with instructions to reset your password has been sent to your email address.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $insertTokenQuery->close();
    } else {
        $reset_message = "Email not found in our records. Please try again.";
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
  <script>
    function validateForm() {
      var email = document.getElementById("exampleInputEmail1").value;
      var password = document.getElementById("exampleInputPassword1").value;
      var errorMessage = document.getElementById("error-message");

      // Basic validation
      if (email === "" || password === "") {
        alert("Email and password are required.");
        return false;
      }

      return true;
    }

  </script>
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
    label {
      font-weight: bold;
    }

    .content-wrapper {
      background-color: #E1EEF2 !important;
    }

    .btn-block {
      background-color: #047edf !important;
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
              <h3>Forgot Password</h3>
              <?php if ($reset_message !== ""): ?>
              <p class="reset-message">
                <?php echo $reset_message; ?>
              </p>
              <?php else: ?>
              <form action="" method="post" id="forgetPasswordForm" onsubmit="return validateForm()">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label><br>
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <p id="emailError" class="error-message"></p>
                <div class="mt-3 text-center">
                  <button type="submit" name="submit" class="btn btn-block btn-lg font-weight-medium auth-form-btn">Reset Password</button>
                </div>
              </form>
              <?php endif; ?>
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
