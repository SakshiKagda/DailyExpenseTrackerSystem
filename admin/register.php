<?php

include 'connect.php';

if (isset ($_POST['submit'])) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $gender = $_POST["gender"];
    $mobile_number = $_POST["mobile_number"];

    // Validate passwords match
    if ($password !== $confirmPassword) {
        die ("Passwords do not match");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Get the profile image file name
    $profile_image = $_FILES['profile_image']['name'];

    // Move the profile image to the desired location
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        die ("Error uploading file.");
    }

    // Insert admin data into the database using prepared statements
    $sql = "INSERT INTO admins (username, email, password, profile_image, gender, mobile_number) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $hashedPassword, $profile_image, $gender, $mobile_number);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Budget Buddy</title>
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
            display: flex !important;
            justify-content: center !important;
            text-align: center !important;
        }
    </style>

    <script>
        function validate() {
            console.log("Validation function called");
            var username = document.getElementById("exampleInputUsername1").value;
            var email = document.getElementById("exampleInputEmail1").value;
            var password = document.getElementById("exampleInputPassword1").value;
            var confirmPassword = document.getElementById("exampleInputConfirmPassword1").value;
            var mobile_number = document.getElementById("exampleInputnumber1").value;
            var profile_image = document.getElementById("profile_image");
            var allowedExtensions = ["jpg", "jpeg", "png", "gif"];

            // Validate username
            if (!/^[A-Za-z]{1,50}$/.test(username)) {
                alert("Name should only contain letters and have a maximum length of 50 characters.");
                return false;
            }

            // Validate email
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                alert("Invalid email format.");
                return false;
            }

            // Validate password
            if (password.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }

            // Validate confirm password
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            // Validate mobile number
            if (!/^\d{10}$/.test(mobile_number)) {
                alert("Mobile number should have exactly 10 digits.");
                return false;
            }

            // Validate profile image
            var fileName = profile_image.value;
            var fileExtension = fileName.split('.').pop().toLowerCase();

            if (!fileName) {
                alert("Please select a profile image.");
                return false;
            }

            // Check if the file extension is allowed
            if (allowedExtensions.indexOf(fileExtension) === -1) {
                alert("Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF.");
                profile_image.value = ""; // Clear the file input
                return false;
            }

            return true;
        }
    </script>
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
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" method="post"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                enctype="multipart/form-data" onsubmit="return validate();">

                                <div class="form-group">
                                    <label for="profile_image">Profile Image</label>
                                    <input type="file" class="form-control-file" id="profile_image" name="profile_image"
                                        accept="image/*" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputUsername1">Username</label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputUsername1"
                                        placeholder="Username" name="username" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1"
                                        placeholder="Email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label>Gender</label>
                                    <div class="gender-radio">
                                        <input type="radio" id="male" name="gender" value="male" required>
                                        <label for="male">Male</label>

                                        <input type="radio" id="female" name="gender" value="female" required>
                                        <label for="female">Female</label>

                                        <input type="radio" id="other" name="gender" value="other" required>
                                        <label for="other">Other</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputnumber1">Mobile Number</label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputnumber1"
                                        placeholder="Mobile Number" name="mobile_number" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputConfirmPassword1" placeholder="Confirm Password"
                                        name="confirm_password" required>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">I agree to all Terms &
                                            Conditions</label>
                                    </div>
                                </div>

                                <button type="submit" name="submit"
                                    class="btn btn-block btn-lg font-weight-medium auth-form-btn">SIGN
                                    UP</button>


                                <div class="text-center mt-4 font-weight-light"> Already have an account? <a
                                        href="login.php" class="text-primary">Login</a></div>

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