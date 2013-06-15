<?php

$m_FunctionsVal = $_POST['FunctionsVal'];

$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];   

$m_CostFile = $_POST['CostFile'];
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];
$m_FunctionsVal = $_POST['FunctionsVal'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];

$m_numItr = $_POST['numItr'];

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment: Calibration of Singly Constrained Gravity Model');
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
 $pdf->SetPrintHeader(true);
 $pdf->SetPrintFooter(true);

 // add a page - landscape style
 
 $pdf->AddPage("L");


//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
	<script language="javascript">
   		alert("invalid file format");
    	location="DoubGravMod.php";    
	</script>
<?php 
}
//----------------------------------------------------------------------------------------------
date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");




 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, 'Experiment No. 4 ', '', 0, 'L', false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);
$pdf->Write(0, 'Doubly Constrained Gravity Model', '', 0, 'C', true, 0, false, false, 0);
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);
$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row

//----------------------- Reading Xls file -------------------------------------
if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{

	// Cost File

	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$n=$dataBaseF->sheets[0]['numRows'];
	
	
	$pdf->Cell((($n+1)*25),10,' Base Year Origin-Destination Cost Matrix ',1,0,'C');
	$pdf->Ln(); //new row

	$pdf->Cell(25,10,'Zone',1,0,'C');
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
	      $pdf->Cell(25,10,$i,1,0,'C');
	}
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
	   	$pdf->Ln(); //new row
    	$pdf->Cell(25,10,$i,1,0,'C');
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{ 
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	$pdf->Cell(25,10,$m_BaseMtx[$i][$j],1,0,'C');         
    	}
  		
	}
	 $pdf->Ln(); //new row;
	 $pdf->Ln(); //new row;

	// Origin File
               
   	$dataOriginF = new Spreadsheet_Excel_Reader();
  	$dataOriginF->setOutputEncoding('CP1251');
   	$dataOriginF->read($folder.$m_OriginFile);
   	error_reporting(E_ALL ^ E_NOTICE);
   
   	$pdf->Cell((($n+1)*25),10,' Future Year Origins Total ',1,0,'C');
   	$pdf->Ln(); //new row
   	$pdf->Cell(25,10,'Zone',1,0,'C');
   
        for ($i = 1; $i <= $n; $i++)
        {
            $pdf->Cell(25,10,$i,1,0,'C');
        }
        $pdf->Ln(); //new row;
        
        //$m_TotalSum=0;
        for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        {        
            $pdf->Cell(25,10,'',1,0,'C');
            for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            {
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                $pdf->Cell(25,10,$m_OriginMtx[$i][$j],1,0,'C'); 

            }    
            $pdf->Ln(); //new row;  
             $err[$i] = 99;            
        }
        $pdf->Ln(); //new row;
        $pdf->Ln(); //new row;
  
       
		 // Destination File
		 
        
        
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        $dataDestF->read($folder.$m_DestFile);
        error_reporting(E_ALL ^ E_NOTICE);

        $pdf->Cell((($n+1)*25),10,' Future Year Destinations Total ',1,0,'C');
   		$pdf->Ln(); //new row
   		$pdf->Cell(25,10,'Zone',1,0,'C');
        for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        {
            $pdf->Cell(25,10,$i,1,0,'C');
        }
        $pdf->Ln(); //new row;
        
        $m_TotalSum=0;
        for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        {
            $pdf->Cell(25,10,'',1,0,'C');
            for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
            {
                 
               $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
               $pdf->Cell(25,10,$m_DestMtx[$i][$j],1,0,'C');
               $djk[$j] = $m_DestMtx[$i][$j];
               $m_TotalSum += $m_DestMtx[$i][$j];
                   
            }
            $pdf->Ln(); //new row;;  
        }
        $pdf->Ln(); //new row;
        $pdf->Ln(); //new row;


        
}
//---------------------------------------------------------------------------------


//---------------------------- Reading csv file -----------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
{
	// Cost File
    $nCol=0; 
	$n = 0;
	$name = $folder.$m_CostFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{    	   
        	$m_Base[$n][$c] = $data[$c];        	
     	}
     	$n++;    
    }
    for ($i = 0; $i < $n; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_BaseMtx[$i+1][$j+1] = $m_Base[$i][$j] ;      	
         }    	
    }


    
	$pdf->Cell((($nCol+1)*25),10,' Base Year Origin-Destination Cost Matrix ',1,0,'C');
	$pdf->Ln(); //new row
	$pdf->Cell(25,10,'Zone',1,0,'C');
	for ($i = 1; $i <= $nCol; $i++)
	{
	       $pdf->Cell(25,10,$i,1,0,'C');
	}
	for ($i = 1; $i <= $n; $i++)
	{
		$pdf->Ln(); //new row
    	$pdf->Cell(25,10,$i,1,0,'C');
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	$pdf->Cell(25,10,$m_BaseMtx[$i][$j],1,0,'C');        
         
    	}
  
	}
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row


	// Origin File
	
			$nCol = 0; 
			$OriRow = 0;
			$name = $folder.$m_OriginFile;
   			$file = fopen($name , "r");
   			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    		{
    			$nCol = count($data);

    			for ($c=0; $c <$nCol; $c++)
    			{    	   
        			$m_Origin[$OriRow][$c] = $data[$c];        	
     			}
     			$OriRow++;    
    		}
    		for ($i = 0; $i < $OriRow; $i++) 
    		{ 
        		for ($j = 0; $j < $nCol; $j++)
         		{
         			$m_OriginMtx[$i+1][$j+1] = $m_Origin[$i][$j] ;      	
         		}    	
   			}
		
   		$pdf->Cell((($n+1)*25),10,' Future Year Origins Total ',1,0,'C');
   		$pdf->Ln(); //new row
   		$pdf->Cell(25,10,'Zone',1,0,'C');
        for ($i = 1; $i <= $nCol; $i++)
        {
            $pdf->Cell(25,10,$i,1,0,'C');
        }
        $pdf->Ln(); //new row
        for ($i = 1; $i <= $OriRow; $i++)
        {        
            $pdf->Cell(25,10,'',1,0,'C');
            for ($j = 1; $j <= $nCol; $j++)
            {
                 $pdf->Cell(25,10,$m_OriginMtx[$i][$j],1,0,'C');

            }    
            $pdf->Ln(); //new row  
            $err[$i] = 99;           
        }
       	$pdf->Ln(); //new row
       	$pdf->Ln(); //new row
        
        // Destination File 
               
			$nCol = 0; 
			$DestRow = 0;
			$name = $folder.$m_DestFile;
   			$file = fopen($name , "r");
   			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    		{
    			$nCol = count($data);

    			for ($c=0; $c <$nCol; $c++)
    			{    	   
        			$m_Dest[$DestRow][$c] = $data[$c];        	
     			}
     			$DestRow++;    
    		}
    		for ($i = 0; $i < $DestRow; $i++) 
    		{ 
        		for ($j = 0; $j < $nCol; $j++)
         		{
         			$m_DestMtx[$i+1][$j+1] = $m_Dest[$i][$j] ;      	
         		}    	
   			}
        

   		$pdf->Cell((($n+1)*25),10,' Future Year Destination Total ',1,0,'C');
   		$pdf->Ln(); //new row
   		$pdf->Cell(25,10,'Zone',1,0,'C');
        for ($i = 1; $i <= $n; $i++)
        {
            $pdf->Cell(25,10,$i,1,0,'C');
        }
        $pdf->Ln(); //new row
        
        $m_TotalSum=0;
        for ($i = 1; $i <= $DestRow; $i++)
        {
            $pdf->Cell(25,10,' ',1,0,'C');
            for ($j = 1; $j <= $nCol; $j++)
            {
                	$pdf->Cell(25,10,$m_DestMtx[$i][$j],1,0,'C');
                	$djk[$j] = $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                    
            }
            $pdf->Ln(); //new row  
        }
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row
        

//-----------------------------------------------------------------------------
} 
        
      
        $itrbrk=$_POST['Itrbrk'];
		
		if($_POST['first'])
		{
			$itrbrk=1;
		}
		if(empty($itrbrk))
		{
		    $itrbrk=$_POST['Itrbrk'];
		}
        if($_POST['Previous'])
		{
		    if($itrbrk==1000)
		    {
		        $itrOld=$_POST['Itr'];
		        $itrbrk=$itrOld;
		    }
			$itrbrk=$itrbrk-1;
		}
		elseif($_POST['Next'])
		{
			$itrbrk=$itrbrk+1;
		}
		elseif($_POST['FinalRes'])
		{
			$itrbrk = 1000;			
		}
              
	if($m_FunctionsVal == "PowerFun")
    {
    	// Calculation for Power Function
    	
         $m_txtBeta = $_POST['txtBeta'];
                  
    	if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}
		$html = <<<EOD
         <h4> Impedance Function used : Power function </h4><font size=3 color="#990000">[<b>F<sub>ij</sub> =  C<sub>ij</sub><sup>$m_txtBeta</sup><B></font>]<br><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

    	$pdf->Cell((($n+1)*25),10,' Impedance Matrix Calculations (Fij) ',1,0,'C'); 
    	$pdf->Ln(); //new row
    	$pdf->Cell(25,10,'Zone ',1,0,'C'); 

		for($i = 1; $i <= $n; $i++)
		{
    		$pdf->Cell(25,10,$i,1,0,'C');
		}           
		$pdf->Ln(); //new row
		for ($i = 1; $i <= $n; $i++)
		{
    		$pdf->Cell(25,10,$i,1,0,'C');
    		for ($j = 1; $j <= $n; $j++)
    		{            
                    $ImpCost[$i][$j] = pow($m_BaseMtx[$i][$j],$m_txtBeta);
                    $pdf->Cell(25,10,(round($ImpCost[$i][$j],4)),1,0,'C');            
    		}
    		$pdf->Ln(); //new row
	}            
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row
 
        
    }
    elseif($m_FunctionsVal == "ExponentialFun")
    {
    	// Calculation for Exponential Function	
    	
       $m_txtBeta = $_POST['txtBeta'];
       
        if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}

       // Calculation for Exponential Function	
     
 $html = <<<EOD
         <h4> Impedance Function used : Exponential function </h4><font size=3 color="#990000">[<B>F<sub>ij</sub> =  e<sup>-($m_txtBeta)C<sub>ij</sub></sup><B></font>]<br><br>
EOD;

	// Print text using writeHTMLCell()
	$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $pdf->Cell((($n+1)*25),10,' Impedance Matrix Calculations (Fij) ',1,0,'C'); 
    $pdf->Ln(); //new row
    $pdf->Cell(25,10,'Zone ',1,0,'C');
     for($i = 1; $i <= $n; $i++)
     {
            $pdf->Cell(25,10,$i,1,0,'C');
     }           
     $pdf->Ln(); //new row
     for ($i = 1; $i <= $n; $i++)
     {
     		$pdf->Cell(25,10,$i,1,0,'C');
            for ($j = 1; $j <= $n; $j++)
            {    
                $ImpCost[$i][$j] = exp(-(($m_txtBeta)*($m_BaseMtx[$i][$j])));
                $pdf->Cell(25,10,(round($ImpCost[$i][$j],4)),1,0,'C');          
             }
             $pdf->Ln(); //new row
       }            
       $pdf->Ln(); //new row
       $pdf->Ln(); //new row    
       
    }   
    elseif($m_FunctionsVal == "GammaFun")
    {
    	// Calculation for Gamma Function
    
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        if(empty($m_txtBeta1))
		{
			$m_txtBeta = $_POST['txtBeta1'];
		}
    	if(empty($m_txtBeta2))
		{
			$m_txtBeta = $_POST['txtBeta2'];
		}
		 $html = <<<EOD
         <h4> Impedance Function used : Gamma function </h4><font size=3 color="#990000">[<B>F<sub>ij</sub> =  e<sup>-($m_txtBeta1)C<sub>ij</sub></sup> C<sub>ij</sub><sup>'.$m_txtBeta2.'</sup><B></font>]<br><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$pdf->Cell((($n+1)*25),10,' Impedance Matrix Calculations (Fij) ',1,0,'C'); 
    	$pdf->Ln(); //new row
    	$pdf->Cell(25,10,'Zone ',1,0,'C');
    	for($i = 1; $i <= $n; $i++)
    	{
        	$pdf->Cell(25,10,$i,1,0,'C');
    	}           
   	 	$pdf->Ln(); //new row 
    	for ($i = 1; $i <= $n; $i++)
    	{
         	$pdf->Cell(25,10,$i,1,0,'C');
         	for ($j = 1; $j <= $n; $j++)
       	 	{
         	
            	$ImpCost[$i][$j] = ((exp(-($m_txtBeta1)*($m_BaseMtx[$i][$j]))) * (pow($m_BaseMtx[$i][$j],-($m_txtBeta2))));
            	$pdf->Cell(25,10,(round($ImpCost[$i][$j],4)),1,0,'C');           
         	}
         	$pdf->Ln(); //new row 
      }            
      $pdf->Ln(); //new row 
      $pdf->Ln(); //new row     
         
       
    }
    elseif($m_FunctionsVal == "LinearFun")
    {
    	// Calculation for Linear Function
    	
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        if(empty($m_txtBeta1))
		{
			$m_txtBeta = $_POST['txtBeta1'];
		}
    	if(empty($m_txtBeta2))
		{
			$m_txtBeta = $_POST['txtBeta2'];
		}
		$html = <<<EOD
         <h4> Impedance Function used : Linear function </h4><font size=3 color="#990000">[<B>F<sub>ij</sub> =  $m_txtBeta1 + ($m_txtBeta2) C<sub>ij</sub><B></font>]<br><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        echo '';
        $pdf->Cell((($n+1)*25),10,' Impedance Matrix Calculations (Fij) ',1,0,'C'); 
    	$pdf->Ln(); //new row
    	$pdf->Cell(25,10,'Zone ',1,0,'C');
            for($i = 1; $i <= $n; $i++)
            {
                $pdf->Cell(25,10,$i,1,0,'C');
            }           
            $pdf->Ln(); //new row 
            for ($i = 1; $i <= $n; $i++)
            {
                $pdf->Cell(25,10,$i,1,0,'C');
                for ($j = 1; $j <= $n; $j++)
                {   
                    $ImpCost[$i][$j] = ($m_txtBeta1 + ($m_txtBeta2 * $m_BaseMtx[$i][$j]));
                    $pdf->Cell(25,10,(round($ImpCost[$i][$j],4)),1,0,'C');           
                }
                $pdf->Ln(); //new row 
            }            
            $pdf->Ln(); //new row 
            $pdf->Ln(); //new row 
            
                     
}
$html = <<<EOD

     <h3><b>Selected Accuracy : $m_AccuracyVal Cell <b></h3><br>
     <h3><b>Entered Accuracy Level (i.e., percentage of error): $m_txtAccuracy %<b></h3><br><br>
          
EOD;

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$itr = 0;   
$erra=99;
$m_a=0;
for ($i = 1; $i <= $n; $i++)
{
	$Bj[$i]=1;
		$errOri[$i]=99;
		$errDest[$i]=99;

}


//-----------------------------------------------------------------------------------------------------------


if(!empty($itrbrk))
 {
  do
  {    
     $m_a=0;
     if($m_AccuracyVal == "Individual")
     {	
     	// Accuracy Level Individual
     	
           for ($j = 1; $j <= $n; $j++)
           {               	
               if($err[$j] > $m_txtAccuracy)
               {
                      $m_a=1;                      
               }                                          
           }           
      }
      else if($m_AccuracyVal == "All")
      {
      	// Accuracy Level All
      	
           if($errOri[$j] > $m_txtAccuracy || $errDest[$j] > $m_txtAccuracy)
           {
                $m_a=1;
           }     
      }      
      if($m_a)
      {
            $itr++;
			$pdf->Ln();
            $pdf->Write(0, "Iteration # ".$itr, '', 0, 'C', true, 0, false, false, 0);
            $pdf->Ln(); //new row
$html = <<<EOD
			<center><b> Calculations </b></center>
EOD;
			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

           
	        for ($i = 1; $i <= $n; $i++)
            {
                $sumBjDjFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$BjDjFcij[$i][$j] = $Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                    $sumBjDjFcij[$i] += $BjDjFcij[$i][$j]; 
                   
                }   
                $Ai[$i]=1/($sumBjDjFcij[$i]);
            }
			
			$pdf->Cell(25,10,'i',1,0,'C');
			$pdf->Cell(25,10,'j',1,0,'C');
			$pdf->Cell(25,10,'Bj',1,0,'C');
			$pdf->Cell(25,10,'Dj',1,0,'C');
			$pdf->Cell(25,10,'F(Cij)',1,0,'C');
			$pdf->Cell(25,10,'BjDjF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'SumBjDjF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'Ai',1,0,'C');
			$pdf->Ln(); //new row
            for($i = 1; $i <= $n; $i++)
            {
            	for ($j = 1; $j <= $n; $j++)
                {  
                 $pdf->Cell(25,10,$i,1,0,'C');
				 $pdf->Cell(25,10,$j,1,0,'C');
				 $pdf->Cell(25,10,round($Bj[$j],4),1,0,'C');
				 $pdf->Cell(25,10,$m_DestMtx[1][$j],1,0,'C');
				 $pdf->Cell(25,10,round($ImpCost[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($BjDjFcij[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($sumBjDjFcij[$i],4),1,0,'C');
			  	 $pdf->Cell(25,10,round($Ai[$i],4),1,0,'C');
			  	 $pdf->Ln(); //new row
                }
            }         
            $pdf->Ln(); //new row
           
            
            for ($i = 1; $i <= $n; $i++)
            {
                $sumAiOiFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$AiOiFcij[$i][$j] = $Ai[$j]*$m_OriginMtx[1][$j]*$ImpCost[$i][$j];
                    $sumAiOiFcij[$i] += $AiOiFcij[$i][$j]; 
                   
                }   
                $Bj[$i]=1/($sumAiOiFcij[$i]);
            }
            
            $pdf->Cell(25,10,'i',1,0,'C');
			$pdf->Cell(25,10,'j',1,0,'C');
			$pdf->Cell(25,10,'Ai',1,0,'C');
			$pdf->Cell(25,10,'Oi',1,0,'C');
			$pdf->Cell(25,10,'F(Cij)',1,0,'C');
			$pdf->Cell(25,10,'AiOiF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'SumAiOiF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'Bj',1,0,'C');
			$pdf->Ln(); //new row
            for($i = 1; $i <= $n; $i++)
            {
            	for ($j = 1; $j <= $n; $j++)
                {  
                 $pdf->Cell(25,10,$i,1,0,'C');
				 $pdf->Cell(25,10,$j,1,0,'C');
				 $pdf->Cell(25,10,round($Ai[$i],4),1,0,'C');
				 $pdf->Cell(25,10,round($m_OriginMtx[1][$j],4),1,0,'C');
				 $pdf->Cell(25,10,round($ImpCost[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($AiOiFcij[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($sumAiOiFcij[$i],4),1,0,'C');
			  	 $pdf->Cell(25,10,round($Bj[$j],4),1,0,'C');
			  	 $pdf->Ln(); //new row
                }
            }         
            $pdf->Ln(); //new row

			$pdf->Ln(); //new row      

            for ($i = 1; $i <= $n; $i++)
            {
                $sumOi[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$T[$i][$j] = $Ai[$i]*$m_OriginMtx[1][$i]*$Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];     
                }   
                
            }
            
            for ($i = 1; $i <= $n; $i++)
            {
                 $sumOi[$i]=0;
               
                for ($j = 1; $j <= $n; $j++)
                {   
                   $sumOi[$i] +=$T[$i][$j];
                   
                   
                }   
            }
            
            for ($i = 1; $i <= $n; $i++)
            {
                $sumDj[$i]=0;
               
                for ($j = 1; $j <= $n; $j++)
                {   
                   $sumDj[$i] += $T[$j][$i] ;
                   
                }   
            }
           
       
$html = <<<EOD
			<center><b>Origin-Destination Matrix [T<sub>ij</sub>] </b></center>
EOD;

			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);   
            $pdf->Cell(25,10,'Zone',1,0,'C');
            for($i = 1; $i <= $n; $i++)
            {
                 $pdf->Cell(25,10,$i,1,0,'C');
            }    
            $pdf->Cell(25,10,'Oi',1,0,'C');
            $pdf->Cell(25,10,"Oi'",1,0,'C');
            $pdf->Ln(); //new row            
            
            for ($i = 1; $i <= $n; $i++)
            {
                $pdf->Cell(25,10,$i,1,0,'C');
                for ($j = 1; $j <= $n; $j++)
                {                
                    $pdf->Cell(25,10,round($T[$i][$j],4),1,0,'C');
                }   
                $pdf->Cell(25,10,round($m_OriginMtx[1][$i],4),1,0,'C');
                $pdf->Cell(25,10,round($sumOi[$i],4),1,0,'C');
                $pdf->Ln(); //new row
            }
          	$pdf->Cell(25,10,'Dj',1,0,'C');
          	for ($i = 1; $i <= $n; $i++)
            {
            	$pdf->Cell(25,10,$m_DestMtx[1][$i],1,0,'C');
            }
            $pdf->Ln(); //new row
      		$pdf->Cell(25,10,"Dj'",1,0,'C');
          	for ($i = 1; $i <= $n; $i++)
            {
            	$pdf->Cell(25,10,$sumDj[$i],1,0,'C');
            }
            
            $erra=0;
            for ($i = 1; $i <= $n; $i++)
            {
              	$errOri[$i] = abs((($m_OriginMtx[1][$i] - $sumOi[$i]) * 100) / $m_OriginMtx[1][$i]);
              
             	$errDest[$i] = abs((($m_DestMtx[1][$i] - $sumDj[$i]) * 100) / $m_DestMtx[1][$i]);
             	$sum = $sumorigin + $m_TotalSum;
               	$erra = abs((($m_OriginMtx[1][$i] - $sumOi[$i])+($m_DestMtx[1][$i] - $sumDj[$i])*100)/$sum);                     
            } 
           
                       
        }       
  }while($m_a==1  && $itr<$itrbrk && $itr < $m_numItr);

 }

//-----------------------------------------------------------------------------------------------------------
 if(!empty($itrbrk))
 {
  do
  {    
     $m_a=0;
     if($m_AccuracyVal == "Individual")
     {
           for ($j = 1; $j <= $n; $j++)
           {               	
               if($err[$j] > $m_txtAccuracy)
               {
                      $m_a=1;                      
               }                                          
           }           
      }
      else if($m_AccuracyVal == "All")
      {
           if($erra > $m_txtAccuracy)
           {
                $m_a=1;
           }     
      }      
      if($m_a)
      {
           $itr++;

           
	        for ($i = 1; $i <= $n; $i++)
            {
                $sumBjDjFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$BjDjFcij[$i][$j] = $Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                    $sumBjDjFcij[$i] += $BjDjFcij[$i][$j]; 
                   
                }   
                $Ai[$i]=1/($sumBjDjFcij[$i]);
            }

            for ($i = 1; $i <= $n; $i++)
            {
                $sumAiOiFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$AiOiFcij[$i][$j] = $Ai[$j]*$m_OriginMtx[1][$j]*$ImpCost[$i][$j];
                    $sumAiOiFcij[$i] += $AiOiFcij[$i][$j]; 
                }   
                $Bj[$i]=1/($sumAiOiFcij[$i]);
            }
           
   
            for ($i = 1; $i <= $n; $i++)
            {
                $sumOi[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$T[$i][$j] = $Ai[$i]*$m_OriginMtx[1][$i]*$Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                }   
                
            }
            for ($i = 1; $i <= $n; $i++)
            {
                 $sumOi[$i]=0;
               
                for ($j = 1; $j <= $n; $j++)
                {   
                   $sumOi[$i] +=$T[$i][$j];
                }   
            }
            for ($i = 1; $i <= $n; $i++)
            {
                $sumDj[$i]=0;
               
                for ($j = 1; $j <= $n; $j++)
                {   
                   $sumDj[$i] += $T[$j][$i] ;
                   
                }   
            }
            
  
                     
            $erra=0;
            for ($i = 1; $i <= $n; $i++)
            {
              $errOri[$i] = abs((($m_OriginMtx[1][$i] - $sumOi[$i]) * 100) / $m_OriginMtx[1][$i]);
              
             $errDest[$i] = abs((($m_DestMtx[1][$i] - $sumDj[$i]) * 100) / $m_DestMtx[1][$i]);
               $sum = $sumorigin + $m_TotalSum;
               $erra = abs((($m_OriginMtx[1][$i] - $sumOi[$i])+($m_DestMtx[1][$i] - $sumDj[$i])*100)/$sum);                      
            }  
            
                     
        }       
  }while($m_a  && $itr<$itrbrk);
  
 }
        if($itr < $itrbrk)
        {
                $pdf->Write(0, 'Final Result', '', 0, '', true, 0, false, false, 0);
                $pdf->Ln(); //new row
        }
        else
        {

        	$pdf->Ln(); //new row
            $pdf->Write(0, "Iteration # ".$itr, '', 0, 'C', true, 0, false, false, 0);
            $pdf->Ln(); //new row
        }
$html = <<<EOD
			<center><b> [D<sub>j</sub>][F<sub>ij</sub>] </b></center>
EOD;

			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
			$pdf->Cell(25,10,'i',1,0,'C');
			$pdf->Cell(25,10,'j',1,0,'C');
			$pdf->Cell(25,10,'Bj',1,0,'C');
			$pdf->Cell(25,10,'Dj',1,0,'C');
			$pdf->Cell(25,10,'F(Cij)',1,0,'C');
			$pdf->Cell(25,10,'BjDjF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'SumBjDjF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'Ai',1,0,'C');
			$pdf->Ln(); //new row
            for($i = 1; $i <= $n; $i++)
            {
            	for ($j = 1; $j <= $n; $j++)
                {  
                 $pdf->Cell(25,10,$i,1,0,'C');
				 $pdf->Cell(25,10,$j,1,0,'C');
				 $pdf->Cell(25,10,round($Bj[$j],4),1,0,'C');
				 $pdf->Cell(25,10,$m_DestMtx[1][$j],1,0,'C');
				 $pdf->Cell(25,10,round($ImpCost[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($BjDjFcij[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($sumBjDjFcij[$i],4),1,0,'C');
			  	 $pdf->Cell(25,10,round($Ai[$i],4),1,0,'C');
			  	 $pdf->Ln(); //new row
                }
            }         
            $pdf->Ln(); //new row
           
            
            $pdf->Cell(25,10,'i',1,0,'C');
			$pdf->Cell(25,10,'j',1,0,'C');
			$pdf->Cell(25,10,'Ai',1,0,'C');
			$pdf->Cell(25,10,'Oi',1,0,'C');
			$pdf->Cell(25,10,'F(Cij)',1,0,'C');
			$pdf->Cell(25,10,'AiOiF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'SumAiOiF(Cij)',1,0,'C');
			$pdf->Cell(25,10,'Bj',1,0,'C');
			$pdf->Ln(); //new row
            for($i = 1; $i <= $n; $i++)
            {
            	for ($j = 1; $j <= $n; $j++)
                { 
                 $pdf->Cell(25,10,$i,1,0,'C');
				 $pdf->Cell(25,10,$j,1,0,'C');
				 $pdf->Cell(25,10,round($Ai[$i],4),1,0,'C');
				 $pdf->Cell(25,10,$m_OriginMtx[1][$j],1,0,'C');
				 $pdf->Cell(25,10,round($ImpCost[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($AiOiFcij[$i][$j],4),1,0,'C');
			 	 $pdf->Cell(25,10,round($sumAiOiFcij[$i],4),1,0,'C');
			  	 $pdf->Cell(25,10,round($Bj[$j],4),1,0,'C');
			  	 $pdf->Ln(); //new row  
                }
            }         
            $pdf->Ln(); //new row      
            $pdf->Ln(); //new row      

       
$html = <<<EOD
			<center><b>Origin-Destination Matrix [T<sub>ij</sub>] </b></center>
EOD;

			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);   
            $pdf->Cell(25,10,'Zone',1,0,'C');
            for($i = 1; $i <= $n; $i++)
            {
                 $pdf->Cell(25,10,$i,1,0,'C');
            }    
            $pdf->Cell(25,10,'Oi',1,0,'C');
            $pdf->Cell(25,10,"Oi'",1,0,'C');
            $pdf->Ln(); //new row            
            
            for ($i = 1; $i <= $n; $i++)
            {
                $pdf->Cell(25,10,$i,1,0,'C');
                $sumTR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                    $pdf->Cell(25,10,round($T[$i][$j],4),1,0,'C');
                }   
                $pdf->Cell(25,10,$m_OriginMtx[1][$i],1,0,'C');
                $pdf->Cell(25,10,round($sumOi[$i],4),1,0,'C');
                $pdf->Ln(); //new row
            }
          	$pdf->Cell(25,10,'Dj',1,0,'C');
          	for ($i = 1; $i <= $n; $i++)
            {
            	$pdf->Cell(25,10,$m_DestMtx[1][$i],1,0,'C');
            }
             $pdf->Ln(); //new row
      		$pdf->Cell(25,10,"Dj'",1,0,'C');
          	for ($i = 1; $i <= $n; $i++)
            {
            	$pdf->Cell(25,10,round($sumDj[$i],4),1,0,'C');
            }
            
          $pdf->Ln(); //new row
          $pdf->Ln(); //new row 
    
  		if($itr < $itrbrk)
        {
        $html = <<<EOD
		<h3>No. of Iteration taken to reach final result : $itr</h3><br><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

        }
        else
        {
                $html = <<<EOD
		<h3>Current Iteration # $itr</h3><br><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

}

$pdf->Output($folder.'DoublyConstrainedGravityModel'.date("Ymdhms").'.pdf',"F");
//============================================================+
// END OF FILE
//============================================================+
?>

