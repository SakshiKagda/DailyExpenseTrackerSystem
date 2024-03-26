<?php
session_start(); // Start the session

include 'connect.php';

$usernameFilter = isset ($_GET['username']) ? $_GET['username'] : '';
$emailFilter = isset ($_GET['email']) ? $_GET['email'] : '';

if (!isset ($_SESSION['id'])) {
  // Redirect or handle unauthorized access
}

// Retrieve the admin's current details from the database
$admin_id = $_SESSION['id'];
$selectQuery = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($selectQuery);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Construct SQL query with filters
$selectSubQuery = "SELECT * FROM subscription WHERE 1=1";
if (!empty ($usernameFilter)) {
  $selectSubQuery .= " AND user_id IN (SELECT user_id FROM users WHERE username LIKE ?)";
}
if (!empty ($emailFilter)) {
  $selectSubQuery .= " AND user_id IN (SELECT user_id FROM users WHERE email LIKE ?)";
}

// Prepare the statement
$stmtSub = $conn->prepare($selectSubQuery);

// Bind parameters if filters are provided
if (!empty ($usernameFilter)) {
  $usernameFilter = '%' . $usernameFilter . '%';
  $stmtSub->bind_param("s", $usernameFilter);
}
if (!empty ($emailFilter)) {
  $emailFilter = '%' . $emailFilter . '%';
  $stmtSub->bind_param("s", $emailFilter);
}

// Execute the statement
$stmtSub->execute();
$resultSub = $stmtSub->get_result();
$subscriptions = $resultSub->fetch_all(MYSQLI_ASSOC);
?>

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
    .main {
      display: flex;
      padding-top: 70px;
    }

    h2 {
      color: black;
    }

    th {
      color: white;
    }

    tr {
      color: black;
    }

    .thead {
      background-color: #047edf;
    }

    .active {
      background-color: green;

    }

    .inactive {
      background-color: red;
    }

    .pending {
      background-color: yellow;
    }


    .pagination .page-item .page-link {
      color: black;
    }

    .content-wrapper {
      background-color: #E1EEF2 !important;
    }

    .btn-primary {
      background-color: #047edf !important;
      border-color: #047edf !important;
    }

    .page-title .page-title-icon {
      background-color: #2847de !important;
    }

    .text-center {
      text-align: center !important;
      color: red !important;
    }
  </style>
</head>

<body>
  <header>
    <?php include ("header.php"); ?>
  </header>

  <div class="main">
    <sidebar>
      <?php include ("sidebar.php"); ?>
    </sidebar>
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title">
          <a href="index.php" style="text-decoration: none; color: inherit;"> <!-- Add this anchor tag -->
            <span class="page-title-icon  text-white me-2">
              <i class="mdi mdi-home"></i>
            </span>
          </a>
          Subscription Details
        </h3>
      </div>
      <div class="row mb-3">
        <div class="col">
          <form id="filterForm" method="GET" action="">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="usernameFilter">Filter by Username:</label>
                <input type="text" class="form-control" id="usernameFilter" name="username"
                  placeholder="Enter username">
              </div>
              <div class="form-group col-md-4">
                <label for="emailFilter">Filter by Email:</label>
                <input type="text" class="form-control" id="emailFilter" name="email" placeholder="Enter email">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="sub.php" class="btn btn-secondary">Reset</a>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="table-wrapper" style="height: 1000px; width: 900px; overflow-y:auto" ;>
          <table class=" table table-bordered table-hover">

            <thead class="thead">
              <tr>
                <th>Select</Select></th>
                <th>Profile Image</th>
                <th>Username</th>
                <th>Email</th>
                <th>Subscription ID</th>
                <th>User ID</th>
                <th>Subscription Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Billing Frequency</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty ($subscriptions)): ?>
                <tr>
                  <td colspan="13" class="text-center">No subscriptions found.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($subscriptions as $subscription): ?>
                  <?php
                  // Retrieve user details associated with the subscription
                  $userId = $subscription['user_id'];
                  $selectUserQuery = "SELECT profile_image, username, email FROM users WHERE user_id = ?";
                  $stmtUser = $conn->prepare($selectUserQuery);
                  $stmtUser->bind_param("i", $userId);
                  $stmtUser->execute();
                  $resultUser = $stmtUser->get_result();
                  $user = $resultUser->fetch_assoc();
                  ?>
                  <tr>
                    <td>
                      <input type="checkbox" name="selected_users[]" value="<?php echo $userId; ?>">
                      <!-- Checkbox for user deletion -->
                    </td>
                    <td>
                      <img
                        src="<?php echo isset ($user['profile_image']) && file_exists($user['profile_image']) ? $user['profile_image'] : 'assets/images/faces/face1.jpg'; ?>"
                        alt="Profile Image" style="width: 50px; height: 50px;">
                    </td>
                    <td>
                      <?php echo $user['username']; ?>
                    </td>
                    <td>
                      <?php echo $user['email']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['subscription_id']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['user_id']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['subscription_plan']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['start_date']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['end_date']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['billing_frequency']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['amount']; ?>
                    </td>
                    <td>
                      <?php echo $subscription['payment_method']; ?>
                    </td>
                    <td>
                      <?php
                      $status = $subscription['status'];
                      $badgeClass = '';
                      switch ($status) {
                        case 'Active':
                          $badgeClass = 'badge-success';
                          break;
                        case 'Inactive':
                          $badgeClass = 'badge-danger';
                          break;
                        case 'Pending':
                          $badgeClass = 'badge-warning';
                          break;
                        default:
                          $badgeClass = 'badge-secondary';
                          break;
                      }
                      ?>
                      <span class="badge <?php echo $badgeClass; ?>">
                        <?php echo $status; ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>

          </table>
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
          <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
          <button type="button" class="btn btn-secondary mt-3" onclick="deleteSelectedUsers()">Delete Selected</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <footer>
    <?php include ("footer.php"); ?>
  </footer>
  <script>
    function deleteSelectedUsers() {
      if (confirm('Are you sure you want to delete selected users?')) {
        // Get all selected user IDs
        var selectedUsers = document.querySelectorAll('input[name="selected_users[]"]:checked');
        var userIds = [];

        // Extract user IDs from selected checkboxes
        selectedUsers.forEach(function (checkbox) {
          userIds.push(checkbox.value);
        });

        // Create a form element
        var form = document.createElement('form');
        form.method = 'post';
        form.action = 'delete_sub.php';

        // Create an input field to hold the user IDs
        userIds.forEach(function (userId) {
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'user_ids[]';
          input.value = userId;
          form.appendChild(input);
        });

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</body>

</html>