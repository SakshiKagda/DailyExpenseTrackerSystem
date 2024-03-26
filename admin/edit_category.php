<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expense_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


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
                // Display the edit category form
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Edit Category</title>
                </head>
                <body>
                    <h2>Edit Category</h2>
                    <form action="edit_category.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['category_id']; ?>">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $row['category_name']; ?>" required><br><br>
                        <input type="submit" value="Update Category">
                    </form>
                </body>
                </html>
                <?php
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
</html>