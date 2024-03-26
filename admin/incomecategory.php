<?php
session_start();
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
            color: blueviolet;
        }

        /* Table styles */
        .table {
            color: white; /* Text color for table cells */
        }

        tr {
            color: white;
        }

        td {
            color: black;
        }

        .thead {
      background-color:#047edf;
    }
        th.action {
            vertical-align: middle;
            text-align: center;
            color: black; /* Text color for the "Edit" and "Delete" links */
        }

        /* Icon styles */
        .mdi-icon {
            font-size: 24px;
            color: black;
            margin-right: 10px;
        }

        /* Pagination styles */
        .pagination .page-item .page-link {
            color: black;
        }
        .icon {
            float: right;
            margin-right: 10px;
        }
        .content-wrapper{
      background-color: #E1EEF2 !important;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link.active {
            color: #2847de !important;

     background: transparent;
}
.btn-primary{
      background-color:#047edf !important;
      border-color: #047edf !important;
    }
    .page-title .page-title-icon {
    background-color: #2847de !important;
}
.btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<header>
    <?php include("header.php"); ?>
</header>

<div class="main">
    <sidebar>
        <?php include("sidebar.php"); ?>
    </sidebar>
    <div class="content-wrapper">
    <div class="container mt-5">
    <div class="page-header">
                    <h1 class="page-title">
                        <a href="index.php" style="text-decoration: none; color: inherit;"> <!-- Add this anchor tag -->
                            <span class="page-title-icon  text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span>
                        </a>
                        View Income Category
                    </h1>
                </div>
        <div class="icon">
            <div class="filter-dropdown">
                <label for="filter">Filter by:</label>
                <select id="filter" name="filter">
                    <option value="all">All</option>
                    <?php
                            include 'connect.php';
                            $category_query = "SELECT * FROM incomes_categories";
                            $category_result = $conn->query($category_query);
                            if ($category_result->num_rows > 0) {
                                while ($category_row = $category_result->fetch_assoc()) {
                                    $category_id = $category_row['category_id'];
                                    $category_name = $category_row['category_name'];
                                    echo "<option value='$category_id'>$category_name</option>";
                                }
                            }
                            ?>
                </select>
                <button type="submit" class="btn-sm btn-primary" value="Apply"
                            onclick="applyFilter()">Apply</button><br><br>
            </div>
        </div>

        <script>
            function applyFilter() {
                var filterValue = document.getElementById('filter').value;
                var categories = document.querySelectorAll('.category-row');

                categories.forEach(function (category) {
                    var categoryId = category.getAttribute('data-category-id');
                    if (filterValue === 'all' || categoryId === filterValue) {
                        category.style.display = 'table-row';
                    } else {
                        category.style.display = 'none';
                    }
                });
            }
        </script>


        <?php
      $sql = "SELECT DISTINCT users.user_id AS user_id, users.username AS username, users.email AS email
      FROM users
      INNER JOIN incomes_categories ec ON users.user_id = ec.user_id";

        $result = $conn->query($sql);

      
                // Check if any users who added categories exist
                if ($result->num_rows > 0) {
                    // Output data of each user who added a category
                    while ($row = $result->fetch_assoc()) {
                        $userId = $row["user_id"];
                        $username = $row["username"];
                        $email = $row["email"];
                        echo "<h4>User: $username ($email)</h4>";

                        // Fetch categories for this user
                        $category_sql = "SELECT * FROM incomes_categories WHERE user_id = $userId";
                        $category_result = $conn->query($category_sql);

                        if ($category_result->num_rows > 0) {
                            echo "<table class='table table-bordered table-hover'>"; 
                            echo "<thead class='thead'>";
                            echo "<tr>";
                            echo "<th>Category ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            while ($categoryRow = $category_result->fetch_assoc()) {
                                echo "<tr class='category-row' data-category-id='" . $categoryRow["category_id"] . "'>";
                                echo "<td>" . $categoryRow["category_id"] . "</td>";
                                echo "<td>" . $categoryRow["category_name"] . "</td>";
                                echo "<td class='action' style='text-align: center; vertical-align: middle;'><a href='editincome_category.php?id=" . $categoryRow["category_id"] . "'><i class='mdi mdi-tooltip-edit mdi-icon'></i></a> <a href='deleteexpense_category.php?id=" . $categoryRow["category_id"] . "'><i class='mdi mdi-delete mdi-icon'></i></a></td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "No categories found for this user.";
                        }
                    }
                } else {
                    echo "No users who have added categories found.";
                }

        $results_per_page = 10; // Set the desired number of results per page
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $offset = ($page - 1) * $results_per_page;
        ?>
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
        <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
    </div>
</div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>
