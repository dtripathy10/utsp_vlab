<?php

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment: System Optimal Assignment');
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



//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_NodeFile, strripos($m_NodeFile, '.'));
$file_ext2= substr($m_OdFile, strripos($m_OdFile, '.'));

if(!($file_ext1 == '.csv'&& $file_ext2 == '.csv'  || $file_ext1 == '.xls' && $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="SystemOptMod.php";    
</script>
<?php 
}
date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");




 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, 'Experiment No. 12 ', '', 0, 'L',false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);

$pdf->Write(0, 'System Optimal Assignment', '', 0, 'C', true, 0, false, false, 0);
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);
$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row


//echo $ii;
	  $pdf->Write(0, 'Criteria taken for Convergence: ', '', 0, 'L', false, 0, false, false, 0);
	  $pdf->Write(0, $m_ConCriteria, '', 0, 'L', false, 0, false, false, 0);
      $pdf->Ln(); //new row 
      $pdf->Write(0,"Alpha value consdered :".$_SESSION['alphaValue'], '', 0, 'L', true, 0, false, false, 0);
      $pdf->Ln(); //new row ;    
   	  $pdf->Write(0,"Beta value consdered :".$_SESSION['betaValue'], '', 0, 'L', true, 0, false, false, 0);
   	  $pdf->Ln(); //new row ; 
      $pdf->Ln(); //new row 
        
      $pdf->Write(0, 'Final Result : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->Ln(); //new row 
      $pdf->Cell(160,10,"Result",1,0,'C');
      $pdf->Ln(); //new row ; 
      $pdf->Cell(40,10,"From",1,0,'C');
      $pdf->Cell(40,10,"to",1,0,'C');
      $pdf->Cell(40,10,"Xi",1,0,'C');
      $pdf->Cell(40,10,"Travel time",1,0,'C');
      //$pdf->Cell(25,10,"Total System Travel time",1,0,'C');
      $pdf->Ln(); //new row ;

 		for ($i = 1; $i <= $m_nlinks; $i++)
        {      
        	 	$pdf->Cell(40,10,$frm[$i],1,0,'C');
      			$pdf->Cell(40,10,$to[$i],1,0,'C');
      			$pdf->Cell(40,10,$x[$i],1,0,'C');
      			$pdf->Cell(40,10,$t[$i],1,0,'C');
      			//$pdf->Cell(25,10,($x[$i]*$t[$i]),1,0,'C');
      			$sum +=($x[$i]*$t[$i]);
      			$pdf->Ln(); //new row ;     	
     
        }
        $pdf->Ln(); //new row ; 
        $pdf->Ln(); //new row ; 
            
        $pdf->Cell(50,10,"Total System Travel time",1,0,'C');
        $pdf->Cell(50,10,$sum,1,0,'C');
        $pdf->Ln(); //new row ;
        


$pdf->Output($folder.'SystemOptModReport.pdf',"F");


//============================================================+
// END OF FILE
//============================================================+
?>