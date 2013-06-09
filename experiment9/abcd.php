<?php
include_once("../util/system.php");
session_start();	//To check whether the session has started or not

$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment9/";
// Retrieving the values of variables

$fn = $_SESSION['fname'];			//First Name
$mdn = $_SESSION['mname'];		//Middle Name
$ln = $_SESSION['lname'];			//Last Name
$emlid = $_SESSION['EmlId'];	//Email Id
$ColUniName = $_SESSION['ColUniName'];			//College/University Name
$City = $_SESSION['City'];		//City Name
$ExpName = $_SESSION['ExpName'];			//Experiment Name

$m_Exp = $_REQUEST['Exp'];



	include_once('pdfMaker.php');
	//Create the pdf object and configure it
	$pdf = new PDFmaker();
	$pdf->configPdfFile();
 
	$pdf->SetCreator("Virtual Lab");
	$pdf->SetAuthor("Virtual Lab");
	$pdf->SetTitle("Virtual Lab");
	$pdf->SetSubject("Virtual Lab");

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
	//$pdf->AddPage();
 //	$pdf->Bookmark("", 0, 0);

   $pdf->addPdfText("<h1>Report</h1>");
   $pdf->addPdfText("User :".$UploadFile);
   $pdf->addPdfText("Name :".$fn." ".$mdn." ".$ln);
   $pdf->addPdfText("Email ID :".$emlid);
   $pdf->addPdfText("University/College Name :".$ColUniName);


	$dir ="../user/".$UploadFile."/Experiment9";
	if ($handle = opendir($dir)) {
	
    /* This is the correct way to loop over the directory. */
    $i=1;
    while (false !== ($file = readdir($handle))) {
    
    if(substr($file, strripos($file, '.'))==".pdf")
    {
    	if($file != "pdf_file_name.pdf")
    	{
    	$a[$i] = "$file";
    	$i++;
    	}
    }

    }
   
    for($j=1;$j< $i;$j++)
    {
    	
    	$pdf->addPdfFile($folder.$a[$j]);
    	
    }

    closedir($handle);
	}
	

 
	//Close and output PDF document
	//$dir1= "../VLab/".$UploadFile."/pdf_file_name.pdf";
	$pdf->Output($folder."TestReport.pdf", 'FI');
	
	
	?>