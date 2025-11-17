<?php
require_once('tcpdf/tcpdf.php');
include('config/dbcon.php');

if (isset($_GET['leave_id'])) {
    $leave_id = $_GET['leave_id'];

    // Get data from approved_leaves
    $query = "SELECT al.*, s.name, s.department 
              FROM cancelled_leaves al 
              JOIN staff s ON s.id = al.staff_id 
              WHERE al.leave_id = '$leave_id' LIMIT 1";
    $result = mysqli_query($con, $query);
    if (!$result || mysqli_num_rows($result) === 0) {
        die("Leave not found.");
    }

    $leave = mysqli_fetch_assoc($result);

    // Create new PDF
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('HR System');
    $pdf->SetTitle('Cancelled Leave Report');
    $pdf->SetMargins(20, 20, 20);
    $pdf->AddPage();

    // PDF content
    $start = new DateTime($leave['start_date']);
$end = new DateTime($leave['end_date']);
$interval = $start->diff($end);
$total_days = $interval->days + 1;

$html = '
<h2 style="text-align:center;">Cancelled Leave Report</h2>
<hr>
<h4>Staff Name: ' . $leave['name'] . '</h4>
<h4>Department: ' . $leave['department'] . '</h4>
<h4>Leave Type: ' . $leave['leave_type'] . '</h4>
<h4>Status: <span style="color:red;">' . $leave['status'] . '</span></h4>
<h4>Start Date: ' . $leave['start_date'] . '</h4>
<h4>End Date: ' . $leave['end_date'] . '</h4>
<h4>Total Leave Days: ' . $total_days . ' day(s)</h4>
';

    if (!empty($leave['documents'])) {
        $html .= '<p>Document: ' . $leave['documents'] . '</p>';
    }

    $html .= '<hr><p>Generated on: ' . date('Y-m-d H:i') . '</p>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Leave_Report_' . $leave['leave_id'] . '.pdf', 'I');
}
