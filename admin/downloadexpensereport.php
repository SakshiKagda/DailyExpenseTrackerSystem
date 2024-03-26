<?php
// Start session
session_start();

// Include TCPDF library
require_once 'C:\xampp\htdocs\SMTP\vendor\tecnickcom\tcpdf\tcpdf.php';

// Include database connection
include 'connect.php';

// Fetch data for the expense report grouped by user
$sql = "SELECT users.username, expenses.* FROM users INNER JOIN expenses ON users.user_id = expenses.user_id ORDER BY users.user_id";
$result = $conn->query($sql);

// Initialize variables to store user-wise HTML content
$userExpenses = array();

// Loop through the fetched data and organize it by user
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userId = $row["user_id"];
        
        // If user ID not present in the array, initialize user's data
        if (!isset($userExpenses[$userId])) {
            $userExpenses[$userId] = array(
                'username' => $row['username'],
                'expenses' => array()
            );
        }
        
        // Add expense to the user's data
        $userExpenses[$userId]['expenses'][] = $row;
    }
}

// Create new PDF document
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Expense Report');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Expense Report');
$pdf->SetSubject('Expense Report');
$pdf->SetKeywords('Expense, Report, PDF');

// // Set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// Add a page
$pdf->AddPage();

foreach ($userExpenses as $userId => $userData) {
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Expense Report for User: ' . $userData['username'], 0, 1, 'C');

    // Create a table
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(30, 7, 'Expense ID', 1, 0, 'C', 1);
    $pdf->Cell(20, 7, 'User ID', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Expense Name', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Amount', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Category', 1, 0, 'C', 1);
    $pdf->Cell(60, 7, 'Description', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Date', 1, 1, 'C', 1);

    foreach ($userData['expenses'] as $expense) {
        $pdf->Cell(30, 7, $expense["expense_id"], 1, 0, 'C');
        $pdf->Cell(20, 7, $expense["user_id"], 1, 0, 'C');
        $pdf->Cell(30, 7, $expense["expenseName"], 1, 0, 'C');
        $pdf->Cell(40, 7, $expense["expenseAmount"], 1, 0, 'C');
        $pdf->Cell(40, 7, $expense["expenseCategory"], 1, 0, 'C');
        $pdf->Cell(60, 7, $expense["expenseDescription"], 1, 0, 'C');
        $pdf->Cell(40, 7, $expense["expenseDate"], 1, 1, 'C');
    }
}

// Close and output PDF
ob_end_clean(); // Clear any previously generated content in the output buffer
$pdf->Output('expense_report.pdf', 'D'); // Force download with the given filename
exit; // Terminate script execution after sending the file
?>
