<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
        .main{
            display: flex;
            padding-top: 70px ;
        }
        h2{
            color: black;
        }
       
        .box{
            margin-top: -220px !important;
        }
        .content-wrapper{
      background-color: #E1EEF2 !important;
    }
    .btn-primary{
      background-color:#047edf !important;
      border-color: #047edf !important;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link.active {
            color: #2847de !important;

            background: transparent;
        }
    </style>
</head>
<body> 
<div class="container-scroller">
        <!-- Header -->
        <?php include("header.php"); ?>
        <!-- End Header -->

        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <!-- Sidebar -->
            <?php include("sidebar.php"); ?>
            <!-- End Sidebar -->

            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow justify-content-center">
                    <div class="col-md-6">
                        <div class="box">
                        <div class="auth-form-light text-left p-5">
            <h2>Update Admin Profile</h2>
            
            <?php
          include 'connect.php';
            
            // Get the admin's ID from the session
            $adminId = $_SESSION['id'];
            
            // SQL query to fetch the admin's current information
            $sql = "SELECT * FROM admins WHERE id = $adminId";
            $result = $conn->query($sql);
            
            // Check if the admin exists
            if ($result->num_rows > 0) {
                // Output the form for updating the admin's profile
                while ($row = $result->fetch_assoc()) {
                    echo "<form action='update_admin_profile.php' method='post' enctype='multipart/form-data'>";
                    echo "<div class='form-group'>";
                    echo "<label for='name'>Name:</label>";
                    echo "<input type='text' class='form-control' id='name' name='name' value='" . $row['username'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='email'>Email:</label>";
                    echo "<input type='email' class='form-control' id='email' name='email' value='" . $row['email'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='mobile'>Mobile Number:</label>";
                    echo "<input type='text' class='form-control' id='mobile' name='mobile' value='" . $row['mobile_number'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='profile_image'>Profile Image:</label>";
                    echo "<input type='file' class='form-control-file' id='profile_image' name='profile_image'>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary mr-2'>Update Profile</button>";
                    echo "<a href='index.php' class='btn btn-primary'>Back</a>";
                    echo "</form>";
                }
            } else {
                echo "<p>No admin found.</p>";
            }
            ?>
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
    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- End Footer -->
</body>

</html>
