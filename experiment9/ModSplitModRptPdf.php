<?php
$m_nmode = $_POST['nmode'];

 $m_txtcoTV = $_POST['txtcoTV'];
 $m_txtcoTW = $_POST['txtcoTW'];
 $m_txtcoTT = $_POST['txtcoTT'];
 $m_txtcoFC = $_POST['txtcoFC'];
 $m_txtcoPC = $_POST['txtcoPC'];
 $m_txtcoOP = $_POST['txtcoOP'];
 $m_trip = $_POST['trip'];

	for ($i=0; $i < $m_nmode ;$i++)
	{	
    	$m_ModeName[$i] = $_POST['ModeName'][$i];
	
    	$m_txtTV[$i] = $_POST['txtTV'][$i];
	
    	$m_txtTW[$i] = $_POST['txtTW'][$i];
	
    	$m_txtTT[$i] = $_POST['txtTT'][$i];
	
    	$m_txtFC[$i] = $_POST['txtFC'][$i];
	
    	$m_txtPC[$i] = $_POST['txtPC'][$i];

    	$m_txtOP[$i] = $_POST['txtOP'][$i];
	}
		

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment: Modal Split');
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
$pdf->Write(0, 'Experiment No. 7 ', '', 0, 'L', false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);
 
$pdf->Write(0, 'Modal Split', '', 0, 'C', true, 0, false, false, 0);
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);
$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row






$pdf->Cell((7*25),10,' Trip Characteristics ',1,0,'C');
$pdf->Ln(); //new row

$pdf->Cell(25,10,'',1,0,'C');
$pdf->Cell(25,10,'tu(ij)',1,0,'C');
$pdf->Cell(25,10,'tw(ij)',1,0,'C');
$pdf->Cell(25,10,'tt(ij)',1,0,'C');
$pdf->Cell(25,10,'Fij',1,0,'C');
$pdf->Cell(25,10,'pC',1,0,'C');
$pdf->Cell(25,10,'phi(j)',1,0,'C');
$pdf->Ln(); //new row


// Check for mode type & display the Trip Characteristics according to values

for ($i = 0; $i < $m_nmode;$i++) 
{
	if($m_ModeName[$i]== 1)
	{
		$pdf->Cell(25,10,'Car',1,0,'C');
	}
	else if($m_ModeName[$i] == 2)
	{
		$pdf->Cell(25,10,'Two Wheeler',1,0,'C');
	}
	else if($m_ModeName[$i] == 3)
	{
		$pdf->Cell(25,10,'Bus',1,0,'C');
	}
	else if($m_ModeName[$i] == 4)
	{
		$pdf->Cell(25,10,'Train',1,0,'C');
	}
	else if($m_ModeName[$i] == 5)
	{
		$pdf->Cell(25,10,'Walk',1,0,'C');
	}	
	else if($m_ModeName[$i] == 6)
	{
		$pdf->Cell(25,10,'Para Transit (Auto Rickshaw,cab,etc)',1,0,'C');
	}
	$pdf->Cell(25,10,$m_txtTV[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtTW[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtTT[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtFC[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtPC[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtOP[$i],1,0,'C');
	$pdf->Ln(); //new row
}
$pdf->Cell(25,10,"ai",1,0,'C');
$pdf->Cell(25,10,$m_txtcoTV,1,0,'C');
$pdf->Cell(25,10,$m_txtcoTW,1,0,'C');
$pdf->Cell(25,10,$m_txtcoTT,1,0,'C');
$pdf->Cell(25,10,$m_txtcoFC,1,0,'C');
$pdf->Cell(25,10,$m_txtcoPC,1,0,'C');
$pdf->Cell(25,10,$m_txtcoOP,1,0,'C');
$pdf->Ln(); //new row
$pdf->Ln(); //new row

// <!-- Calculate the Cost of travel according to selected mode -->

$m_sumexp=0;
for ($i = 0; $i < $m_nmode;$i++) 
{
	$pdf->Write(0, 'Cost of travel by ', '', 0, 'L', false, 0, false, false, 0);
	if($m_ModeName[$i]== 1)
	{
		$pdf->Write(0, 'Car =', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 2)
	{
		$pdf->Write(0, 'Two Wheeler =', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 3)
	{
		$pdf->Write(0, 'Bus =', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 4)
	{
		$pdf->Write(0, 'Train =', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 5)
	{
		$pdf->Write(0, 'Walk =', '', 0, 'L', false, 0, false, false, 0);
	}	
	else if($m_ModeName[$i] == 6)
	{
		$pdf->Write(0, 'Public Transport (Auto Rickshaw,cab,etc) = ', '', 0, 'L', false, 0, false, false, 0);
	}
	$pdf->Write(0, $m_txtcoTV." * ". $m_txtTV[$i]." + ".$m_txtcoTW." * ".$m_txtTW[$i]." + ".$m_txtcoTT." * ".$m_txtTT[$i]." + ".$m_txtcoFC." * ".$m_txtFC[$i]." + ".$m_txtcoPC." * ".$m_txtPC[$i]." + ".$m_txtOP[$i]." * ".$m_txtcoOP, '', 0, 'L', false, 0, false, false, 0);
	$m_cost[$i] = $m_txtcoTV * $m_txtTV[$i] + $m_txtcoTW * $m_txtTW[$i] + $m_txtcoTT * $m_txtTT[$i] + $m_txtcoFC * $m_txtFC[$i] + $m_txtcoPC * $m_txtPC[$i] + $m_txtOP[$i] * $m_txtcoOP;
	$pdf->Write(0, " = ".$m_cost[$i], '', 0, 'L', true, 0, false, false, 0);
	
	$m_exp[$i] = exp(-$m_cost[$i]);
	$m_sumexp = $m_sumexp + $m_exp[$i];
	  
	
}
$pdf->Ln(); //new row ;
$pdf->Ln(); //new row ;

// <!-- Calculate the Probability of choosing mode according to selected mode -->


for ($i = 0; $i < $m_nmode;$i++) 
{
	$pdf->Write(0, 'Probability of choosing mode, ', '', 0, 'L', false, 0, false, false, 0);
	if($m_ModeName[$i]== 1)
	{
		$pdf->Write(0, 'Car = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 2)
	{
		$pdf->Write(0, 'Two Wheeler = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 3)
	{
		$pdf->Write(0, 'Bus = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 4)
	{
		$pdf->Write(0, 'Train = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 5)
	{
		$pdf->Write(0, 'Walk = ', '', 0, 'L', false, 0, false, false, 0);
	}	
	else if($m_ModeName[$i] == 6)
	{
		$pdf->Write(0, 'Public Transport (Auto Rickshaw,cab,etc) = ', '', 0, 'L', false, 0, false, false, 0);
	}
	$m_pij[$i]= $m_exp[$i]/$m_sumexp;
	$pdf->Write(0,$m_pij[$i], '', 0, 'L', true, 0, false, false, 0);
}
$pdf->Ln(); //new row ;
$pdf->Ln(); //new row ;
// <!-- Calculate the Proportion of Trips according to selected mode -->


for ($i = 0; $i < $m_nmode;$i++) 
{	
	$pdf->Write(0, 'Proportion of Trips by  ', '', 0, 'L', false, 0, false, false, 0);
	if($m_ModeName[$i]== 1)
	{
		$pdf->Write(0, 'Car = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 2)
	{
		$pdf->Write(0, 'Two Wheeler = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 3)
	{
		$pdf->Write(0, 'Bus = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 4)
	{
		$pdf->Write(0, 'Train = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 5)
	{
		$pdf->Write(0, 'Walk = ', '', 0, 'L', false, 0, false, false, 0);
	}	
	else if($m_ModeName[$i] == 6)
	{
		$pdf->Write(0, 'Public Transport (Auto Rickshaw,cab,etc) = ', '', 0, 'L', false, 0, false, false, 0);
	}
	$m_proportion[$i] = $m_pij[$i]* $m_trip;
	$pdf->Write(0, $m_pij[$i]." * ".$m_trip." = ".$m_proportion[$i], '', 0, 'L', true, 0, false, false, 0);
}
$pdf->Ln(); //new row ;
$pdf->Ln(); //new row ;

// <!-- Calculate the Fare Collected from selected mode -->



for ($i = 0; $i < $m_nmode;$i++) 
{	
	$pdf->Write(0, 'Fare Collected from ', '', 0, 'L', false, 0, false, false, 0);
	if($m_ModeName[$i]== 1)
	{
		$pdf->Write(0, 'Car = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 2)
	{
		$pdf->Write(0, 'Two Wheeler = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 3)
	{
		$pdf->Write(0, 'Bus = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 4)
	{
		$pdf->Write(0, 'Train = ', '', 0, 'L', false, 0, false, false, 0);
	}
	else if($m_ModeName[$i] == 5)
	{
		$pdf->Write(0, 'Walk = ', '', 0, 'L', false, 0, false, false, 0);
	}	
	else if($m_ModeName[$i] == 6)
	{
		$pdf->Write(0, 'Public Transport (Auto Rickshaw,cab,etc) = ', '', 0, 'L', false, 0, false, false, 0);
	}	$m_fare[$i] = $m_proportion[$i]* $m_cost[$i];
	$pdf->Write(0, $m_proportion[$i]." * ".$m_cost[$i]." = ".$m_fare[$i], '', 0, 'L', true, 0, false, false, 0);
	
}
$pdf->Ln(); //new row ;
$pdf->Ln(); //new row ;



//<!-- Calculation to display into table format -->

$pdf->Cell((11*25),10,' Solutions',1,0,'C');
$pdf->Ln(); //new row

$pdf->Cell(25,10,'',1,0,'C');
$pdf->Cell(25,10,'tu(ij)',1,0,'C');
$pdf->Cell(25,10,'tw(ij)',1,0,'C');
$pdf->Cell(25,10,'tt(ij)',1,0,'C');
$pdf->Cell(25,10,'Fij',1,0,'C');
$pdf->Cell(25,10,'pC',1,0,'C');
$pdf->Cell(25,10,'phi(j)',1,0,'C');
$pdf->Cell(25,10,'C',1,0,'C');
$pdf->Cell(25,10,'eC',1,0,'C');
$pdf->Cell(25,10,'P(ij)',1,0,'C');
$pdf->Cell(25,10,'T(ij)',1,0,'C');
$pdf->Ln(); //new row


for ($i = 0; $i < $m_nmode;$i++) 
{
	if($m_ModeName[$i]== 1)
	{
		$pdf->Cell(25,10,'Car',1,0,'C');
	}
	else if($m_ModeName[$i] == 2)
	{
		$pdf->Cell(25,10,'Two Wheeler',1,0,'C');
	}
	else if($m_ModeName[$i] == 3)
	{
		$pdf->Cell(25,10,'Bus',1,0,'C');
	}
	else if($m_ModeName[$i] == 4)
	{
		$pdf->Cell(25,10,'Train',1,0,'C');
	}
	else if($m_ModeName[$i] == 5)
	{
		$pdf->Cell(25,10,'Walk',1,0,'C');
	}	
	else if($m_ModeName[$i] == 6)
	{
		$pdf->Cell(25,10,'Para Transit (Auto Rickshaw,cab,etc)',1,0,'C');
	}

	$pdf->Cell(25,10,$m_txtTV[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtTW[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtTT[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtFC[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtPC[$i],1,0,'C');
	$pdf->Cell(25,10,$m_txtOP[$i],1,0,'C');
	$pdf->Cell(25,10,$m_cost[$i],1,0,'C');
	$pdf->Cell(25,10,round($m_exp[$i],4),1,0,'C');
	$pdf->Cell(25,10,round($m_pij[$i],4),1,0,'C');
	$pdf->Cell(25,10,round($m_proportion[$i],4),1,0,'C');
	$pdf->Ln(); //new row
}
$pdf->Cell(25,10,"ai",1,0,'C');
$pdf->Cell(25,10,$m_txtcoTV,1,0,'C');
$pdf->Cell(25,10,$m_txtcoTW,1,0,'C');
$pdf->Cell(25,10,$m_txtcoTT,1,0,'C');
$pdf->Cell(25,10,$m_txtcoFC,1,0,'C');
$pdf->Cell(25,10,$m_txtcoPC,1,0,'C');
$pdf->Cell(25,10,$m_txtcoOP,1,0,'C');
$pdf->Cell(25,10,"-",1,0,'C');
$pdf->Cell(25,10,"-",1,0,'C');
$pdf->Cell(25,10,"-",1,0,'C');
$pdf->Cell(25,10,"-",1,0,'C');
$pdf->Ln(); //new row
$pdf->Ln(); //new row


$pdf->Output($folder.'ModeChoice'.date("Ymdhms").'.pdf',"F");
//============================================================+
// END OF FILE
//============================================================+
?>