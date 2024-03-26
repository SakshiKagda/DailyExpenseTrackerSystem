<?php
// Include TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Start session to access session variables
session_start();

// Include database connection
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Fetch user information
$userSql = "SELECT * FROM users WHERE email = '$email'";
$userResult = $conn->query($userSql);

// Check if user information was fetched successfully
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
} else {
    // Handle error if user information not found
    echo "Error: User information not found.";
    exit();
}

// Check if the user is subscribed
if ($userData['pricing_status'] != 1) {
    // If the user is not subscribed, set the warning message
    $warningMessage = "You are not subscribed to download the report. Please subscribe to access this feature.";
} else {
    // Fetch expenses for the logged-in user
    $expenseSql = "SELECT * FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
    $expenseResult = $conn->query($expenseSql);

    // Create new TCPDF instance
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Expenses Report');
    $pdf->SetHeaderData('', '', 'Expenses Report', '');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->SetFont('helvetica', '', 10);

    // Start PDF content
    $pdf->AddPage();

    // Add user information to PDF
    $html = '<p><strong>User Name:</strong> ' . $userData['username'] . '</p>';
    $html .= '<p><strong>User Email:</strong> ' . $userData['email'] . '</p>';

    // Add expenses table to PDF
    $html .= '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Image</th>
                </tr>';
    while ($row = $expenseResult->fetch_assoc()) {
        $html .= '<tr>
                    <td>'.$row['expense_id'].'</td>
                    <td>'.$row['expenseName'].'</td>
                    <td>'.$row['expenseAmount'].'</td>
                    <td>'.$row['expenseCategory'].'</td>
                    <td>'.$row['expenseDescription'].'</td>
                    <td>'.$row['expenseDate'].'</td>
                    <td>'.$row['billImage'].'</td>
                </tr>';
    }
    $html .= '</table>';

    // Write HTML content to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Set the PDF filename with the login username
    $username = $userData['username'];
    $pdf_filename = "Expenses_report_$username.pdf";

    // Output PDF as download with the dynamically generated filename
    $pdf->Output($pdf_filename, 'D');
}

// Close database connection
$conn->close();

// Output warning message if user is not subscribed
if (isset($warningMessage)) {
    echo "<script>
            var confirmation = confirm('$warningMessage');
            if (confirmation) {
                window.location.href = 'pricing.php';
            }
         </script>";
}
?>