<?php
session_start();
include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Update the category in the database
    $query = "UPDATE incomes_categories SET category_name='$name' WHERE category_id=$id";
    $result = mysqli_query($conn, $query);

    // Check if the category was updated successfully
    if ($result) {
        echo "Category updated successfully.";
        header("Location:incomecategory.php");
    } else {
        echo "Error updating category: " . mysqli_error($conn);
    }
} else {
    // Check if the id parameter is set in the URL
    if (isset($_GET['id'])) {
        // Get the category ID from the URL
        $id = $_GET['id'];

        // Fetch the category details from the database
        $query = "SELECT * FROM incomes_categories WHERE category_id=$id";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch the category details
            $row = mysqli_fetch_assoc($result);

            // Check if the category exists
            if ($row) {
            } else {
                echo "Category not found.";
            }
        } else {
            echo "Error fetching category details: " . mysqli_error($conn);
        }
    } else {
        echo "Category ID not specified.";
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
        .main{
            display: flex;
            padding-top: 70px ;
        }
        h2{
            color: black;
        }
       
        .box{
            margin-top: -300px !important;
        }
        label{
            font-size: large !important;
        }
        .content-wrapper {
            background-color: #E1EEF2 !important;
        }

        .sidebar .nav.sub-menu .nav-item .nav-link.active {
            color: #2847de !important;

            background: transparent;
        }

        .btn-primary {
            background-color: #047edf !important;
            border-color: #047edf !important;
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
              <h3>Edit Category</h3>
                    <form action="editincome_category.php" method="post">
                        <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $row['category_id']; ?>">
                        </div>
                        <div class="form-group">
                        <label for="name">Name</label><br>
                        <input type="text" id="name"  name="name" value="<?php echo $row['category_name']; ?>" required><br><br>
                        </div>
                       
                        <div class="mt-3 text-center">
                  <button type="submit" name="submit" 
                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Update Category</button>
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
  <?php include("footer.php"); ?>
</body>

</html>