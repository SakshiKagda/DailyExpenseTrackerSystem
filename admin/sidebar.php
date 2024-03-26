<?php
if (!isset($_SESSION)) {
  session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
  // Redirect to the login page if not logged in
  header("Location: login.php");
  exit();
}


include 'connect.php';

// Retrieve user details from the database
$admin_id = $_SESSION['id'];
$sql = "SELECT * FROM admins WHERE id = $admin_id"; // Modify the query based on your database schema

$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
  $adminDetails = $result->fetch_assoc();
} else {
  // Handle the case where user details are not found
  $adminDetails = array(); // Empty array if user not found
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Expense Tracker System</title>
  <link rel="stylesheet" href="assets/scss/_sidebar.scss">
  <link rel="stylesheet" href="assets/css/style.css">

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
  .sidebar .nav .nav-item.active  .nav-link .menu-title{
    color:#2847de !important;
  }
  .sidebar .nav .nav-item.active > .nav-link i {
    color: #2847de !important;
    
}
</style>

</head>

<body>
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="accountsetting.php" class="nav-link">
          <div class="nav-profile-image">
            <?php
            // Check if the 'profile_image' column exists and is not empty
            if (isset($adminDetails['profile_image']) && !empty($adminDetails['profile_image'])) {
              echo '<img src="uploads/' . $adminDetails['profile_image'] . '" alt="profile">';
            } else {
              // Display a default image if the 'profile_image' column is empty or not found
              echo '<img src="assets\images\faces\face1.jpg" alt="default-profile">';
            }
            ?>
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">
              <?php echo isset($adminDetails['username']) ? $adminDetails['username'] : ''; ?>
            </span>
            <span class="text-secondary text-small">
              <?php echo isset($adminDetails['email']) ? $adminDetails['email'] : ''; ?>
            </span>
          </div>
          <!-- <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i> -->
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="user.php">
          <span class="menu-title">User Details</span>
          <i class="mdi mdi-account menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sub.php">
          <span class="menu-title">Subscription Details</span>
          <i class="mdi mdi-bell menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Expense</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-cash-multiple menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="viewexpense.php">View Expense</a></li>
            <!-- <li class="nav-item"> <a class="nav-link" href="manageexpense.php">Manage Expense</a></li> -->
          </ul>
        </div>

      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-1" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Income</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-cash menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-1">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="viewincome.php">View Income</a></li>
            <!-- <li class="nav-item"> <a class="nav-link" href="manageincome.php">Manage Income</a></li> -->
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-2" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Budget</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-briefcase  menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-2">
          <ul class="nav flex-column sub-menu">
            <!-- <li class="nav-item"> <a class="nav-link" href="addbudget.php">Add Budget</a></li> -->
            <li class="nav-item"> <a class="nav-link" href="viewbudget.php">View Budget</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-3" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Category</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-buffer  menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-3">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="expensecategory.php">View Expense Category</a></li>
            <li class="nav-item"> <a class="nav-link" href="incomecategory.php">View Income Category</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-4" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Report</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-file-document menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-4">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="viewexpensereport.php">View Expense Report</a></li>
            <li class="nav-item"> <a class="nav-link" href="viewincomereport.php">View Income Report</a></li>
            <li class="nav-item"> <a class="nav-link" href="viewreport.php">View General Report</a></li>

          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-5" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Settings</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-account-settings  menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-5">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="accountsetting.php">My Profile</a></li>
            <li class="nav-item"> <a class="nav-link" href="changepass.php">Change Password</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <span class="menu-title">Logout</span>
          <i class="mdi mdi-logout menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>

</body>

</html>