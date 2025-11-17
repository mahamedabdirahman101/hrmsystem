<?php


include('authentication.php');
include('assets/includes/header.php');

include('assets/includes/topbar.php');

include('config/dbcon.php');

require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$id = $_GET['staff_id'];
// $sql = "SELECT * FROM `staffs` WHERE id='$id'";

$query = "SELECT * FROM `staffs` WHERE id='$id'";
$query_run = mysqli_query($con, $query);



$user = mysqli_fetch_assoc($query_run);

// instantiate and use the dompdf class
$dompdf = new Dompdf();
ob_start();
require('staffProfile.php');
$html =ob_get_contents();
ob_get_clean();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('print-details.pdf',['Attachment'=>false]);

?>