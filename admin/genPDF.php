<?php

    require 'dompdf/autoload.inc.php';
    use Dompdf\Dompdf;


    $staffs_id =  $_GET['staff_id'];
    $query = "SELECT * FROM `staffs` WHERE `id`='$staffs_id'";

    //instantiate and use the dompdf class
    $dompdf = new Dompdf();
    ob_start();
    require('details_pdf.php');
    $html =ob_get_contents();
    ob_get_clean();



    $dompdf->loadHtml($html);

    //Paper size and orientation
    $dompdf->setPaper('A4','portrait');

    //Render th HTML as PDF
    $dompdf->render();

    //Output the generated PDF to Browser
    $dompdf->stream('print-details.pdf',['Attachment'=>false]);




?>