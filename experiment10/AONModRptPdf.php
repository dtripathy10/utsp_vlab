<?php 
// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
$m_NodeFile = $_POST['NodeFile'];
$m_ODFile = $_POST['ODFile'];	 


require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment: All or Nothing Assignment');
$pdf->SetSubject('Experiment');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------



 //do not show header or footer
 $pdf->SetPrintHeader(true); $pdf->SetPrintFooter(true);

 // add a page - landscape style
 
 $pdf->AddPage("L");

date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");



 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, 'Experiment No. 8 ', '', 0, 'L', false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);
 
$pdf->Write(0, 'All or Nothing Assignment', '', 0, 'C', true, 0, false, false, 0);
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);
//$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
//$pdf->Ln(); //new row


   $pdf->Write(0, 'Result : ', '', 0, 'L', true, 0, false, false, 0);
   $pdf->Ln(); //new row 
   
   $pdf->Cell(120,10,"Final Assignment",1,0,'C');
   $pdf->Ln(); //new row ;    
   $pdf->Cell(40,10,"From",1,0,'C');
   $pdf->Cell(40,10,"to",1,0,'C');
   $pdf->Cell(40,10,"Link Flow(Xi)",1,0,'C');
   $pdf->Ln(); //new row 
   for ($i = 2; $i <= $m_nlinks+1; $i++)
   {           	           
        for ($j = 1; $j < $m_nlinks-2; $j++)
        {
        		$pdf->Cell(40,10,$m_TripMtx[$i][$j],1,0,'C');
        		
        }
        $pdf->Cell(40,10,$y[$i],1,0,'C');
        $pdf->Ln(); //new row 
   }
   $pdf->Ln(); //new row 
   $pdf->Ln(); //new row 

$pdf->Output($folder.'AllorNothingModel.pdf',"F");
//============================================================+
// END OF FILE
//============================================================+
?>
</html>