<?php

if (!isset ($_SESSION)) {
  session_start();
}

include 'connect.php';

// Fetch user details from the users table with filtering
$filterCondition = "";
if (isset ($_GET['username']) && !empty ($_GET['username'])) {
  $filterCondition .= " AND username LIKE '%" . $_GET['username'] . "%'";
}
if (isset ($_GET['email']) && !empty ($_GET['email'])) {
  $filterCondition .= " AND email LIKE '%" . $_GET['email'] . "%'";
}
if (isset ($_GET['gender']) && !empty ($_GET['gender'])) {
  $filterCondition .= " AND gender = '" . $_GET['gender'] . "'";
}

$sql = "SELECT * FROM users WHERE 1=1" . $filterCondition;
$result = $conn->query($sql);

// Initialize an empty array for users
$users = array();

// Check if there are any users
if ($result->num_rows > 0) {
  // Fetch user details and populate the $users array
  while ($row = $result->fetch_assoc()) {
    $user = $row;
    // Fetch total expense for the user
    $sqlExpense = "SELECT SUM(expenseAmount) AS total_expense FROM expenses WHERE user_id = " . $user['user_id'];
    $resultExpense = $conn->query($sqlExpense);
    $user['total_expense'] = $resultExpense->fetch_assoc()['total_expense'];

    // Fetch total income for the user
    $sqlIncome = "SELECT SUM(incomeAmount) AS total_income FROM incomes WHERE user_id = " . $user['user_id'];
    $resultIncome = $conn->query($sqlIncome);
    $user['total_income'] = $resultIncome->fetch_assoc()['total_income'];

    // Add user details to the $users array
    $users[] = $user;
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Expense Tracker System</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
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

    .stretch-card .card .card-body {
      width: 68%;
      min-width: 65%;
    }

    .card-title {
      margin-bottom: 20px;
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .table th {
      background-color: #f8f9fa;
    }

    .table th,
    .table td {
      border: 1px solid #dee2e6;
    }

    .table th,
    .table td {
      padding: 12px;
    }

    .table th {
      font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .table tbody tr:hover {
      background-color: #e2e2e2;
    }

    .table img {
      max-width: 50px;
      max-height: 50px;
      border-radius: 50%;
    }

    .badge {
      border: none;
      width: 70px;
      height: 39px;
      cursor: pointer;
    }

    .badge:hover {
      opacity: 0.8;
    }


    .badge:hover {
      background-color: #007bff;
      color: white;
    }

    .badge {

      width: 70px;
      height: 30px;

    }

    tr {
      color: black;

    }

    .thead {
      background-color: #047edf;
    }

    th {
      color: white;
      padding: 10px !important;

    }

    .pagination .page-item .page-link {
      color: black;
    }

    .mdi-icon {
      font-size: 24px;

      margin-right: 10px;
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
    .text-center{
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
            <span class="page-title-icon text-white me-2">
              <i class="mdi mdi-home"></i>
            </span>
          </a>
          User Details
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
              <div class="form-group col-md-4">
                <label for="genderFilter">Filter by Gender:</label>
                <select class="form-control" id="genderFilter" name="gender">
                  <option value="">Select gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="user.php" class="btn btn-secondary">Reset</a>

          </form>

        </div>
      </div>

      <div class="row">
        <div class="table-wrapper" style="height: 1000px; width: 980px; overflow-y:auto" ;>
          <table class=" table table-bordered table-hover">
            <thead class="thead">
              <tr>
                <th>Select</th>
                <th>Profile Image</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Mobile Number</th>
                <th>Current Status</th>
                <th>Total Expense</th>
                <th>Total Income</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
  <?php if (empty($users)): ?>
    <tr>
      <td colspan="10" class="text-center">Username not found in the list.</td>
    </tr>
  <?php else: ?>
    <?php foreach ($users as $user): ?>
      <tr>
        <td>
          <input type="checkbox" name="selected_users[]" value="<?php echo $user['user_id']; ?>">
        </td>
        <td>
          <img src="<?php echo isset($user['profile_image']) && file_exists($user['profile_image']) ? $user['profile_image'] : 'assets/images/faces/face1.jpg'; ?>" alt="Profile Image" style="width: 50px; height: 50px;">
        </td>
        <td>
          <?php echo $user['username']; ?>
        </td>
        <td>
          <?php echo $user['email']; ?>
        </td>
        <td>
          <?php echo $user['gender']; ?>
        </td>
        <td>
          <?php echo $user['mobile_number']; ?>
        </td>
        <td style="width: 80px;">
          <?php
          if ($user['pricing_status'] == 0) {
            echo '<span class="badge badge-danger badge-sm ">Inactive</span>';
          } else if ($user['pricing_status'] == 1) {
            echo '<span class="badge badge-success">Active</span>';
          } else if ($user['pricing_status'] == 2) {
            echo '<span class="badge badge-warning">Pending</span>';
          }
          ?>
        </td>
        <td>
          <?php
          $totalExpense=isset($user['total_expense']) ? $user['total_expense'] : 0;
          echo($totalExpense == 0) ? '<span style="color:red;">' . $totalExpense . '</span>' : $totalExpense;
          ?>
        </td>
        <td>
          <?php
          $totalIncome = isset($user['total_income']) ? $user['total_income'] : 0;
          echo ($totalIncome == 0) ? '<span style="color: red;">' . $totalIncome . '</span>' : $totalIncome;
          ?>
        </td>
        <td>
          <form method="post" action="update_pricing_status.php">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <input type="hidden" name="pricing_status" id="pricing_status_<?php echo $user['user_id']; ?>">
            <i class="mdi mdi-check-circle mdi-icon" style="cursor: pointer;" onclick="updateStatus('active', <?php echo $user['user_id']; ?>)"></i>
            <i class="mdi mdi-close-circle mdi-icon" style="cursor: pointer;" onclick="updateStatus('inactive', <?php echo $user['user_id']; ?>)"></i>
            <i class="mdi mdi-help-circle mdi-icon" style="cursor: pointer;" onclick="updateStatus('pending', <?php echo $user['user_id']; ?>)"></i>
            <i class="mdi mdi-delete mdi-icon" style="cursor: pointer;" onclick="deleteUser(<?php echo $user['user_id']; ?>)"></i>
          </form>
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
    function updateStatus(status, userId) {
      document.getElementById('pricing_status_' + userId).value = status;
      document.getElementById('pricing_status_' + userId).closest('form').submit();
      alert('User status updated to ' + status + ' for user ID ' + userId);
    }

    function deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        // Create a form element
        var form = document.createElement('form');
        form.method = 'post';
        form.action = 'delete_user.php';

        // Create an input field to hold the user ID
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_id';
        input.value = userId;

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
      }
    }
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
        form.action = 'delete_user.php';

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