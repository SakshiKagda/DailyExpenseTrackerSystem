<?php
// Include TCPDF library
require_once 'C:\xampp\htdocs\SMTP\vendor\tecnickcom\tcpdf\tcpdf.php';

// Include database connection
include 'connect.php';

// Fetch data for the expense report
$sql = "SELECT * FROM expenses";
$result = $conn->query($sql);

// Create new PDF document
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Expense Report');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Expense Report');
$pdf->SetSubject('Expense Report');
$pdf->SetKeywords('Expense, Report, PDF');

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

// Add a page
$pdf->AddPage();

// Add table headers for the expense report
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(30, 10, 'Expense ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'User ID', 1, 0, 'C');
$pdf->Cell(60, 10, 'Expense Name', 1, 0, 'C');
$pdf->Cell(40, 10, 'Amount', 1, 0, 'C');
$pdf->Cell(30, 10, 'Category', 1, 0, 'C');
$pdf->Cell(50, 10, 'Description', 1, 0, 'C');
$pdf->Cell(40, 10, 'Date', 1, 1, 'C');

// Add expense records to the PDF
$pdf->SetFont('helvetica', '', 10);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row["expense_id"], 1, 0, 'C');
        $pdf->Cell(30, 10, $row["user_id"], 1, 0, 'C');
        $pdf->Cell(60, 10, $row["expenseName"], 1, 0, 'C');
        $pdf->Cell(40, 10, $row["expenseAmount"], 1, 0, 'C');
        $pdf->Cell(30, 10, $row["expenseCategory"], 1, 0, 'C');
        $pdf->Cell(50, 10, $row["expenseDescription"], 1, 0, 'C');
        $pdf->Cell(40, 10, $row["expenseDate"], 1, 1, 'C');
    }
}

// Close and output PDF
ob_end_clean(); // Clear any previously generated content in the output buffer
$pdf->Output('report.pdf', 'D'); // Force download with the given filename
exit; // Terminate script execution after sending the file
?>
