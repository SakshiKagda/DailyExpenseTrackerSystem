<?php
// Start session
session_start();

// Include TCPDF library
require_once 'C:\xampp\htdocs\SMTP\vendor\tecnickcom\tcpdf\tcpdf.php';

// Include database connection
include 'connect.php';

// Fetch data for the income report grouped by user
$sql = "SELECT users.username, incomes.* FROM users INNER JOIN incomes ON users.user_id = incomes.user_id ORDER BY users.user_id";
$result = $conn->query($sql);

// Initialize variables to store user-wise HTML content
$userIncomes = array();

// Loop through the fetched data and organize it by user
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userId = $row["user_id"];
        
        // If user ID not present in the array, initialize user's data
        if (!isset($userIncomes[$userId])) {
            $userIncomes[$userId] = array(
                'username' => $row['username'],
                'incomes' => array()
            );
        }
        
        // Add income to the user's data
        $userIncomes[$userId]['incomes'][] = $row;
    }
}

// Create new PDF document
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Income Report');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Income Report');
$pdf->SetSubject('Income Report');
$pdf->SetKeywords('Income, Report, PDF');

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

foreach ($userIncomes as $userId => $userData) {
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Income Report for User: ' . $userData['username'], 0, 1, 'C');

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(30, 7, 'Income ID', 1, 0, 'C', 1);
    $pdf->Cell(20, 7, 'User ID', 1, 0, 'C', 1);
    $pdf->Cell(50, 7, 'Income Name', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Amount', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Category', 1, 0, 'C', 1);
    $pdf->Cell(60, 7, 'Description', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Date', 1, 1, 'C', 1);


    foreach ($userData['incomes'] as $income) {
        $pdf->Cell(30, 7, $income["income_id"], 1, 0, 'C');
        $pdf->Cell(20, 7, $income["user_id"], 1, 0, 'C');
        $pdf->Cell(50, 7, $income["incomeName"], 1, 0, 'C');
        $pdf->Cell(40, 7, $income["incomeAmount"], 1, 0, 'C');
        $pdf->Cell(40, 7, $income["incomeCategory"], 1, 0, 'C');
        $pdf->Cell(60, 7, $income["incomeDescription"], 1, 0, 'C');
        $pdf->Cell(40, 7, $income["incomeDate"], 1, 1, 'C');
    }
}

// Close and output PDF
ob_end_clean(); // Clear any previously generated content in the output buffer
$pdf->Output('income_report.pdf', 'D'); // Force download with the given filename
exit; // Terminate script execution after sending the file
?>
