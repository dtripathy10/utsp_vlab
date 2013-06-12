<?php

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment:Trip Generation : Regression Analysis');
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




//---------------------------------- verifying the format of the file---------------------------

$file_ext1= substr($m_TripFile, strripos($m_TripFile, '.'));
 

//----------------------------------------------------------------------------------------------
date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");




 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);
$pdf->Write(0, 'Experiment No. 2 ', '', 0, 'P', true, 0, false, false, 0);
$pdf->Write(0, 'Trip Generation: Regression Analysis', '', 0, 'C', true, 0, false, false, 0);

 
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);

$m_AnalysisVar = $_SESSION['AnalysisVar'];     
for($i=0;$i<=count($m_InDep);$i++)
{
	$m_Independent[$i]=  $_SESSION['RegrInpdVar'][$i];
	
}
      
	if($m_AnalysisVar == "DataAna")
	{
		
		$m_DataChoiceVar = $_POST['DataChoiceVar'];
		
	
		if ($m_DataChoiceVar == "Correlation")
		{				
			
        	$pdf->Cell((($SelectCol+1)*25),10,' Correlation Matrix ',1,0,'C');
     		$pdf->Ln(); //new row
     		$pdf->Cell(25,10,' ',1,0,'C');
         	for ($i = 0; $i < $SelectCol; $i++)
         	{
         		$pdf->Cell(25,10,$m_TripMtx[1][$m_CorrDescVar[$i]],1,0,'C');
         	}
         	$pdf->Ln(); //new row
         	for ($j = 0; $j < $SelectCol; $j++)
         	{     
         		$pdf->Cell(25,10,$m_TripMtx[1][$m_CorrDescVar[$j]],1,0,'C');

            	for ($i = 0; $i < $SelectCol; $i++)
            	{
            		$pdf->Cell(25,10,(round($reg[$j][$i],4)),1,0,'C');
            	}
            	$pdf->Ln(); //new row
        	}
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row
		}			
		elseif ($m_DataChoiceVar == "Descriptives")
		{
			        	
        	$pdf->Cell(165,10,'Descriptive Statistics',1,0,'C');
     		$pdf->Ln(); //new row
			$pdf->Cell(25,10," ",1,0,'C');
			$pdf->Cell(25,10,"N",1,0,'C');
			$pdf->Cell(25,10,"Minimum",1,0,'C');
			$pdf->Cell(25,10,"Maximum",1,0,'C');
			$pdf->Cell(25,10,"Mean",1,0,'C');
			$pdf->Cell(40,10,"Standard Deviation",1,0,'C');
			$pdf->Ln(); //new row
        	for ($i = 0; $i < $SelectCol; $i++)
            {
            	  	$pdf->Cell(25,10,$m_TripMtx[1][$m_CorrDescVar[$i]],1,0,'C');
					$pdf->Cell(25,10,($m_finalrow-1),1,0,'C');
					$pdf->Cell(25,10,$min[$i],1,0,'C');
					$pdf->Cell(25,10,$max[$i],1,0,'C');
					$pdf->Cell(25,10,round($avg[$i],4),1,0,'C');
					$pdf->Cell(40,10,round($deltaRoot[$i],4),1,0,'C');
					$pdf->Ln(); //new row
   
          	}  
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row
		}		

	}
	
	else if($m_AnalysisVar == "RegrAna")
	{
		$ans =  $_SESSION['ANS'];
for($i=1;$i<=count($ans);$i++)
{
	$coefficients[$i-1] =  $_SESSION['ANS'][$i];
}

$m_RegrType = $_SESSION['RegrType'];
$m_Dep =  $_SESSION['RegrDepdVar'];
$m_InDep =  $_SESSION['RegrInpdVar'];
$m_type=$_SESSION['Type']; 
		

if($m_type == "Linear")
{
		$pdf->Write(0, "Model Used : Linear Regression :", '', 0, 'L', true, 0, false, false, 0);

		$k=1;
		$html="Equation: ".$m_TripMtx[1][$m_Dep]." = ";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             	$html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
                 
             }
             elseif($i <= count($m_InDep)-2)
             {
             $html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
             }
             else
             {
             	$html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].")";
             	
             }
             $k++;
      	}
      	$pdf->writeHTML($html, true, 0, true, 0);
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row

	$pdf->Cell(50,10,"Trip for each zone(T[i])",1,0,'C');
	$pdf->Cell(50,10,"Number of Trips",1,0,'C');
	$pdf->Ln(); //new row
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <=count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]+$m_TripMtx[$i][$m_Independent[$j]]*$coefficients[$k];
			$k++;
		}
		$pdf->Cell(50,10,"T[".($i-1)."]",1,0,'C');
		$pdf->Cell(50,10,$m_trip[$i],1,0,'C');
		$pdf->Ln(); //new row
	}
	$pdf->Ln(); //new row
    $pdf->Ln(); //new row


	}
	if($m_RegrType=="Quadratic")
	{

        $pdf->Write(0, "Model Used : Quadratic Regression :", '', 0, 'L', true, 0, false, false, 0);

		$k=1;
		$html="Equation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             $html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
             }
             elseif($i <= $SelectCol-2)
             {
              $html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
                
             }
             else
             {
              $html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
             }
             $k++;
      	}
      	for ($i = count($m_InDep); $i < 2*count($m_InDep); $i++)
      	{
            if($i < 2*count($m_InDep)-1)
             {
             	$html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i-count($m_InDep)]].")^2 + ";
             }
             else
             {
               $html .="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i-count($m_InDep)]].")^2 ";
             }
             $k++;
      	}
      	$pdf->writeHTML($html, true, 0, true, 0);
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
        
	
		$counted = count($m_InDep);
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <$counted; $j++)
		{
			
			$m_trip[$i]=$m_trip[$i]+$m_TripMtx[$i][$m_InDep[$j]]*$coefficients[$k];
			$k++;
		}
		for ($j = 0; $j <$counted; $j++)
		{
			
			$m_trip[$i]=$m_trip[$i]+pow($m_TripMtx[$i][$m_InDep[$j]],2)*$coefficients[$k];
			$k++;
			
		}
	}
	$pdf->Cell(50,10,"Trip for each zone(T[i])",1,0,'C');
	$pdf->Cell(50,10,"Number of Trips",1,0,'C');
	$pdf->Ln(); //new row
	for ($i = 2; $i <= $nRow; $i++)
	{
  		$pdf->Cell(50,10,"T[".($i-1)."]",1,0,'C');
		$pdf->Cell(50,10,$m_trip[$i],1,0,'C');
		$pdf->Ln(); //new row
	}
	$pdf->Ln(); //new row
    $pdf->Ln(); //new row
		
		
		
	}
	if($m_RegrType=="Power")
	{
		$pdf->Write(0, "Model Used : Power Regression :", '', 0, 'L', true, 0, false, false, 0);
		$k=1;
		$html="Equation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i <count($m_InDep)-1)
             {
             	$html.= "(".$m_TripMtx[1][$m_InDep[$i]].")^(".$ans[$k].") * ";
             }
             else
             {
                $html.= "(".$m_TripMtx[1][$m_InDep[$i]].")^(".$ans[$k].")  ";
             }
             $k++;
      	}
      	$pdf->writeHTML($html, true, 0, true, 0);
		$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
        
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]*(pow($m_TripMtx[$i][$m_InDep[$j]],$coefficients[$k]));
			$k++;
		}
	}
	$pdf->Cell(50,10,"Trip for each zone(T[i])",1,0,'C');
	$pdf->Cell(50,10,"Number of Trips",1,0,'C');
	$pdf->Ln(); //new row
	for ($i = 2; $i <= $nRow; $i++)
	{
  		$pdf->Cell(50,10,"T[".($i-1)."]",1,0,'C');
		$pdf->Cell(50,10,$m_trip[$i],1,0,'C');
		$pdf->Ln(); //new row
	}
	$pdf->Ln(); //new row
    $pdf->Ln(); //new row
		
	
		
	}
	if($m_RegrType=="Exponential")
	{
		$pdf->Write(0, "Model Used : Exponential Regression :", '', 0, 'L', true, 0, false, false, 0);
		$k=1;
		$html="Equation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             	$html.="exp((".$ans[$k].")* ".$m_TripMtx[1][$m_InDep[$i]].") * ";
             }
             elseif($i <= count($m_InDep)-2)
             {
                  $html.="exp((".$ans[$k].")* ".$m_TripMtx[1][$m_InDep[$i]].") * ";
             }
             else
             {
                  $html.="exp((".$ans[$k].")* ".$m_TripMtx[1][$m_InDep[$i]].")  ";
             }
             $k++;
      	}
      	$pdf->writeHTML($html, true, 0, true, 0);
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
      	
		for ($i = 2; $i <= $nRow; $i++)
		{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]*exp($coefficients[$k]*$m_TripMtx[$i][$m_InDep[$j]]);
			$k++;
		}

		}  	
    	$pdf->Cell(50,10,"Trip for each zone(T[i])",1,0,'C');
		$pdf->Cell(50,10,"Number of Trips",1,0,'C');
		$pdf->Ln(); //new row
		for ($i = 2; $i <= $nRow; $i++)
		{
  			$pdf->Cell(50,10,"T[".($i-1)."]",1,0,'C');
			$pdf->Cell(50,10,$m_trip[$i],1,0,'C');
			$pdf->Ln(); //new row
		}
		$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
     
      
	
    }	
	if($m_RegrType=="Logarithmic")
	{
      
      	$pdf->Write(0, "Model Used : Logarithmic Regression :", '', 0, 'L', true, 0, false, false, 0);
		$k=1;
		$html="Equation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             	$html.="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
             }
             elseif($i <=count($m_InDep)-2)
             {
                 $html.="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ";
             }
             else
             {
                 $html.="(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].")  ";
             }
             $k++;
      	}
      	$pdf->writeHTML($html, true, 0, true, 0);
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
		for ($i = 2; $i <= $nRow; $i++)
		{
			$m_trip[$i]=$coefficients[0];
			$k=1;
			for ($j = 0; $j <count($m_InDep); $j++)
			{
				$m_trip[$i]=$m_trip[$i]+log($m_TripMtx[$i][$m_InDep[$j]])*$coefficients[$k];
				$k++;
			}
		}
      	$pdf->Cell(50,10,"Trip for each zone(T[i])",1,0,'C');
		$pdf->Cell(50,10,"Number of Trips",1,0,'C');
		$pdf->Ln(); //new row
		for ($i = 2; $i <= $nRow; $i++)
		{
  			$pdf->Cell(50,10,"T[".($i-1)."]",1,0,'C');
			$pdf->Cell(50,10,$m_trip[$i],1,0,'C');
			$pdf->Ln(); //new row
		}
		$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
     
      	
	
	}	
}
	$pdf->Output($folder.'RegressionAnalysis'.date("Ymdhms").'.pdf',"F");

//============================================================+
// END OF FILE
//============================================================+
$arr = get_defined_vars();

foreach( $arr as $item ) 
{
			unset($item);
}


?>


