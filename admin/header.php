<?php
if (!isset ($_SESSION)) {
  session_start();
}

// Check if the user is logged in
if (!isset ($_SESSION['id'])) {
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
  $adminDetails = array(); 
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
    .p-3 {
      margin: 10px !important;
      padding: 10px !important;
    }

    .navbar .navbar-brand-wrapper .navbar-brand img {
      /* width: 100% !important; */
      height: 50px !important;
    }
  </style>
</head>

<body>
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/image.png"
          alt="logo" /></a>
      <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/image2.png"
          alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>

      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="" data-bs-toggle="dropdown"
            aria-expanded="false">
            <div class="nav-profile-img">
              <?php
              // Check if the 'profile_image' column exists and is not empty
              if (isset ($adminDetails['profile_image']) && !empty ($adminDetails['profile_image'])) {
                echo '<img src="uploads/' . $adminDetails['profile_image'] . '" alt="profile">';
              } else {
                // Display a default image if the 'profile_image' column is empty or not found
                echo '<img src="assets\images\faces\face1.jpg" alt="default-profile">';
              }
              ?>
            </div>
            <div class="nav-profile-text">
              <span class="font-weight-bold mb-2 ">
                <?php echo isset ($adminDetails['username']) ? $adminDetails['username'] : ''; ?>
              </span>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">
              <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="mdi mdi-email-outline"></i>
            <span class="count-symbol bg-warning"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
            <h6 class="p-3 mb-0">Messages</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <!-- <img src="assets/images/faces/face4.jpg" alt="image" class="profile-pic"> -->
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">New User Added</h6>
                <p class="text-gray mb-0"> 1 Minutes ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <!-- <img src="C:\xampp\htdocs\DETS(main)\admin\assets\images\faces\face1.jpg" alt="image" class="profile-pic"> -->
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Priya is now your subscriber</h6>
                <p class="text-gray mb-0"> 15 Minutes ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <!-- <img src="assets/images/faces/face3.jpg" alt="image" class="profile-pic"> -->
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">User has added Expense</h6>
                <p class="text-gray mb-0"> 18 Minutes ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <h6 class="p-3 mb-0 text-center">4 new messages</h6>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
            data-bs-toggle="dropdown">
            <i class="mdi mdi-bell-outline"></i>
            <span class="count-symbol bg-danger"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
            aria-labelledby="notificationDropdown">
            <h6 class="p-3 mb-0">Notifications</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-success">
                  <i class="mdi mdi-calendar"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-warning">
                  <i class="mdi mdi-settings"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                <p class="text-gray ellipsis mb-0"> Update dashboard </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-info">
                  <i class="mdi mdi-link-variant"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                <p class="text-gray ellipsis mb-0"> New admin wow! </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <h6 class="p-3 mb-0 text-center">See all notifications</h6>
          </div>
        </li>
        <li class="nav-item nav-login">
          <?php
          // Check if the user's email is set in the session
          if (isset ($_SESSION['id'])) {
            // User is logged in, display Logout option with an icon
            echo '<a class="nav-link" href="logout.php"><i class="mdi mdi-logout"></i></a>';
          } else {
            // User is not logged in, display Login option with an icon
            echo '<a class="nav-link" href="login.php"><i class="mdi mdi-login"></i></a>';
          }
          ?>
        </li>
    </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>

    </div>
  </nav>
</body>

</html>