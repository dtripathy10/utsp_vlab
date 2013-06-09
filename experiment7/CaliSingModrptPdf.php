<?php
// Retrieving the values of variables
$m_FunctionsVal = $_POST['FunctionsVal'];
$m_MethodVal = $_POST['MethodVal'];			
$m_CostFile = $_POST['CostFile']; 
$m_TripFile = $_POST['TripFile']; 
$m_choice= $_POST['choice'];

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


//-------------------------------- verifying the format of the file --------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="CaliSingMod.php";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------
date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");




 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, 'Experiment No. 7 ', '', 0, 'L', false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);

if($m_MethodVal == "SinglyOrigin")
{
         $pdf->Write(0, 'Calibration Of Singly Constrained Gravity Model (Origin)', '', 0, 'C', true, 0, false, false, 0);
}
elseif($m_MethodVal == "SinglyDest")
{
         $pdf->Write(0, 'Calibration Of Singly Constrained Gravity Model (Destination)', '', 0, 'C', true, 0, false, false, 0);
}   
//---------------------- Reading Xls file -----------------------------------------
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);
$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row

if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{
	// Cost File

	require_once '../phpExcelReader/Excel/reader.php';
	$dataCostF = new Spreadsheet_Excel_Reader();
	$dataCostF->setOutputEncoding('CP1251');
	$dataCostF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$n=$dataCostF->sheets[0]['numRows'];



if($m_choice == 1)
{	
	
	$pdf->Cell(100,10,' Base Year Origin-Destination Cost Matrix ',1,0,'C');
	$pdf->Ln(); //new row

	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
	       	$pdf->Cell(20,10,' Origin ',1,0,'C');
			$pdf->Cell(20,10,' Destination ',1,0,'C');
			$pdf->Cell(60,10,' Cost ',1,0,'C');
			$pdf->Ln(); //new row
		   for ($j = 1; $j <= $dataCostF->sheets[0]['numRows']; $j++)
		   {	
		   		$pdf->Cell(20,10,$i,1,0,'C');
	            $pdf->Cell(20,10,$j,1,0,'C');
	            $m_CostMtx[$i][$j]=$dataCostF->sheets[0]['cells'][$i][$j];
	        	$pdf->Cell(60,10,$m_CostMtx[$i][$j],1,0,'C');
	            $pdf->Ln(); //new row
	            
	       }
	       $pdf->Ln(); //new row
	       
	}
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row
}	

		
// Trip File
	
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
       	$n=$dataTripF->sheets[0]['numRows'];
     	
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {             
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j]; 
            }              
        }
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            } 
         }   
         $pdf->Ln(); //new row
         $pdf->Ln(); //new row
$b=array();
if($m_choice ==1)
{		
	$pdf->Cell(100,10,' Given Base Year Trip Matrix ',1,0,'C');
	$pdf->Ln(); //new row

	for ($i = 1; $i <= $dataTripF->sheets[0]['numCols']; $i++)
	{
			$pdf->Cell(20,10,' Origin ',1,0,'C');
			$pdf->Cell(20,10,' Destination ',1,0,'C');
			$pdf->Cell(60,10,' No. of Trips ',1,0,'C');
			$pdf->Ln(); //new row
		   for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
		   {	


	        		$pdf->Cell(20,10,$i,1,0,'C');
	            	$pdf->Cell(20,10,$j,1,0,'C');
	            	$m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
	        		$pdf->Cell(60,10,$m_TripMtx[$i][$j],1,0,'C');
	        		$pdf->Ln(); //new row
	        }
			$pdf->Ln(); //new row 
     
	}	
	$pdf->Ln(); //new row 
	$pdf->Ln(); //new row 

	
	$pdf->Cell(100,10,' Sum Totals of Origin ',1,0,'C');
	$pdf->Cell(100,10,' Sum Totals of Destination ',1,0,'C');
	$pdf->Ln(); //new row 
	$pdf->Cell(40,10,' Origin ',1,0,'C');
	$pdf->Cell(60,10,' Totals ',1,0,'C');
	$pdf->Cell(40,10,' Destination ',1,0,'C');
	$pdf->Cell(60,10,' Totals ',1,0,'C');
	$pdf->Ln(); //new row
	for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
	{	
		$pdf->Cell(40,10,"O".$j,1,0,'C');
		$pdf->Cell(60,10,$OriginSum[$j],1,0,'C');
	   	$pdf->Cell(40,10,"D".$j,1,0,'C');
		$pdf->Cell(60,10,$Destsum[$j],1,0,'C');
		$pdf->Ln(); //new row
	} 
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row 
}
		
         
}

//---------------------------------------------------------------------------------

//------------------------- Reading csv file --------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' )
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
        	$m_Cost[$n][$c] = $data[$c];        	
     	}
     	$n++;    
    }
    for ($i = 0; $i < $n; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_CostMtx[$i+1][$j+1] = $m_Cost[$i][$j] ;      	
         }    	
    }

if($m_choice == 1)
{    
	$pdf->Cell(100,10,' Base Year Origin-Destination Cost Matrix ',1,0,'C');
	$pdf->Ln(); //new row
	$pdf->Cell(20,10,' Origin ',1,0,'C');
	$pdf->Cell(20,10,' Destination ',1,0,'C');
	$pdf->Cell(60,10,' Cost ',1,0,'C');
	$pdf->Ln(); //new row
	for ($i = 1; $i <= $n; $i++)
	{
	       
		   for ($j = 1; $j <= $n; $j++)
		   {	
		   		$pdf->Cell(20,10,$i,1,0,'C');
	            $pdf->Cell(20,10,$j,1,0,'C');
	        	$pdf->Cell(60,10,$m_CostMtx[$i][$j],1,0,'C');
	            $pdf->Ln(); //new row
	            
	       }
	       
	}
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row
	
}
    // Trip File
    
	$nCol=0; 
	$n = 0;
	$name = $folder.$m_TripFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{    	   
        	$m_Trip[$n][$c] = $data[$c];        	
     	}
     	$n++;    
    }
    for ($i = 0; $i < $n; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j] ;      	
         }    	
    }
        for ($i = 1; $i <= $n; $i++)
        {    
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
                $OriginSum[$i] += $m_TripMtx[$i][$j];
            }                      
        }
             
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
         }   

         
if($m_choice == 1)
{        
    $pdf->Cell(100,10,' Given Base Year Trip Matrix ',1,0,'C');
	$pdf->Ln(); //new row

	for ($i = 1; $i <= $n; $i++)
	{
			$pdf->Cell(20,10,' Origin ',1,0,'C');
			$pdf->Cell(20,10,' Destination ',1,0,'C');
			$pdf->Cell(60,10,' No. of Trips ',1,0,'C');
			$pdf->Ln(); //new row
		   for ($j = 1; $j <= $n; $j++)
		   {	


	        		$pdf->Cell(20,10,$i,1,0,'C');
	            	$pdf->Cell(20,10,$j,1,0,'C');
	        		$pdf->Cell(60,10,$m_TripMtx[$i][$j],1,0,'C');
	        		$pdf->Ln(); //new row
	        }
			$pdf->Cell(100,10,"O"."(".$i.") = ".$OriginSum[$i],1,0,'C');
	        $pdf->Ln(); //new row
	        $pdf->Ln(); //new row
     
		}	
		$pdf->Cell(100,10,' Sum Totals of Destination ',1,0,'C');
		$pdf->Ln(); //new row 
		$pdf->Cell(40,10,' Destination ',1,0,'C');
		$pdf->Cell(60,10,' Totals ',1,0,'C');
		$pdf->Ln(); //new row
		for ($j = 1; $j <= $n; $j++)
		{	
		   	$pdf->Cell(40,10,"D".$j,1,0,'C');
			$pdf->Cell(60,10,$Destsum[$j],1,0,'C');
		$pdf->Ln(); //new row
	} 
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row 
         
	}      
         
}

	if($m_FunctionsVal == "PowerFun")
    {
    	$html = <<<EOD
		<h3><b> Selected Frictional Functions : Power Function [<font size=3 color='#990000'><B>F<sub>ij</sub> =  C<sub>ij</sub><sup>B</sup><B></font>] <b></h3><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      	
    }

    
    elseif ($m_FunctionsVal == "ExponentialFun")   
    {
    	$html = <<<EOD
		<h3><b> Selected Frictional Functions : Exponential Function [<font size=3 color='#990000'><B>F<sub>ij</sub> =  e<sup>-BC<sub>ij</sub></sup><B></font>] <b></h3><br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);    

    }
         
                  
       
       $l = 1;
          
           //Beta

        for ($bt = 0.001; $bt < 1; $bt = $bt + 0.001)
        {
               $res[$l] = 0 ;
           
              
               if($m_FunctionsVal == "PowerFun")
               {
               		// Calculation for Power Function	
               		
                     for ($i = 1; $i <= $n; $i++)
                        {
                            for ($j = 1; $j <= $n; $j++)
                         {                
                               $ImpCost[$i][$j] = pow($m_CostMtx[$i][$j],$bt);
                          }
                          
                     }            
                }
                
                   elseif($m_FunctionsVal == "ExponentialFun")
                   {
                   		// Calculation for Exponential Function	
                   	
                       for ($i = 1; $i <= $n; $i++)
                        {
                              for ($j = 1; $j <= $n; $j++)
                              {
                                     $ImpCost[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));
                               }
                      }                 
                }    

             //RESIDUAL FOR 'l'th VALUE OF BETA
             
             for ($i = 1; $i <= $n; $i++)
             {
                for ($j = 1; $j <= $n; $j++)
                {
                    $res[$l] = $res[$l] + ($m_TripMtx[$i][$j] - $tijk[$i][$j]) * ($m_TripMtx[$i][$j] - $tijk[$i][$j]);                   
                }
             }
           
            $b[$l]=$bt;
            $l++;   
   }
   
   // Finding Minimum SSE And Optimum Beta

   		$nbt = $l ;  //number of beta value tried   
        $res_min = $res[1];       
        $b_opt = $b[1];
        for ($i = 1; $i <= $l-1; $i++)       
        {
            if($res[$i] < $res_min)
            {
                $res_min = $res[$i];
                $b_opt = $b[$i];
            }
        }
       
        // Finding the Trip Matrix for Optimum value of Beta
         
        $bt = $b_opt;
       
        if($m_FunctionsVal == "ExponentialFun")
        {
        	// Calculation for Exponential Function	   
        	
            for ($i = 1; $i <= $n; $i++)
               {               
                   for ($j = 1; $j <= $n; $j++)
                   {        
                       $ImpCost[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));                   
                   }              
               }
        }
        
        elseif ($m_FunctionsVal == "PowerFun")   
        {
        	// Calculation for Power Function	
        	
            for ($i = 1; $i <= $n; $i++)
               {               
                   for ($j = 1; $j <= $n; $j++)
                   {        
                       $ImpCost[$i][$j] = pow($m_CostMtx[$i][$j],$bt);                
                   }              
               }
        }
        
        if($m_MethodVal == "SinglyOrigin")
        {
        	//Origin Constrained 
        	
               for ($i = 1; $i <= $n; $i++)
               {
                        $sumR[$i]=0;
                           for ($j = 1; $j <= $n; $j++)
                          {                 
                                   $DF[$i][$j] = $Destsum[$j] * $ImpCost[$i][$j];         
                                $sumR[$i] += $DF[$i][$j];  
                        }
                }
                   for ($i = 1; $i <= $n; $i++)
                {
                                for ($j = 1; $j <= $n; $j++)
                                {                 
                                        $PR[$i][$j] = $DF[$i][$j] / $sumR[$i];               
                                }
                 }
                 for ($i = 1; $i <= $n; $i++)
                 {
                             $sumTR[$i]=0;
                             for ($j = 1; $j <= $n; $j++)
                             {                 
                                     $tijk[$i][$j] = $OriginSum[$i] * $PR[$i][$j];      
                                     $sumTR[$i] += $tijk[$i][$j];                 
                          }    
                                   
                 }
                 for ($j = 1; $j <= $n; $j++)
                 {
                              $sumTC[$j]=0;   
                              for ($i = 1; $i <= $n; $i++)
                              {
                                      $sumTC[$j] += $tijk[$i][$j];                  
                              }    
                    }
           }
           elseif($m_MethodVal == "SinglyDest")
           {
           		//Destination Constrained 
           		
                 for ($i = 1; $i <= $n; $i++)
                 {
                            for ($j = 1; $j <= $n; $j++)
                            {             
                                    $OF[$i][$j] = $OriginSum[$i] * $ImpCost[$i][$j];   
                            }
                    }
                 for ($j = 1; $j <= $n; $j++)
                    {                 
                            $sumC[$j]=0;
                            for ($i = 1; $i <= $n; $i++)
                            {   
                                    $sumC[$j] += $OF[$i][$j];                      
                            }              
                  }
                  
                  for ($i = 1; $i <= $n; $i++)
                  {
                        for ($j = 1; $j <= $n; $j++)
                        {                 
                            $PR[$i][$j] = $OF[$j][$i] / $sumC[$i];   
                        }
                  }
                  for ($i = 1; $i <= $n; $i++)
                  {
                         for ($j = 1; $j <= $n; $j++)
                         {     
                                $tijk[$i][$j] = $Destsum[$i] * $PR[$i][$j];    
                        }                            
                  }
                  
         		// Finding Origin & Destination Total

                  for ($j = 1; $j <= $n; $j++)
                   {
                          $sumTC[$j]=0;   
                          $sumTR[$j] = 0;
                        for ($i = 1; $i <= $n; $i++)
                        {
                            $sumTC[$j] += $tijk[$j][$i]; 
                            $sumTR[$j] += $tijk[$i][$j];                            
                           }     
                     }
             }
                  


        $pdf->Write(0,"Solution :", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(); //new row
             
    	$pdf->Cell(120,10,' Trip Matrix with respect to Optimal Beta Value (Minimum SSE) ',1,0,'C');
		$pdf->Ln(); //new row

		for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
		{
			$pdf->Cell(25,10,' Origin ',1,0,'C');
			$pdf->Cell(25,10,' Destination ',1,0,'C');
			$pdf->Cell(70,10,' No. of Trips ',1,0,'C');
			$pdf->Ln(); //new row	       
		   	for ($j = 1; $j <= $n; $j++)
		   	{	
		   		$pdf->Cell(25,10,$i,1,0,'C');
	            $pdf->Cell(25,10,$j,1,0,'C');
	            $pdf->Cell(70,10,(int)$tijk[$i][$j],1,0,'C');
	            $pdf->Ln(); //new row
	            
	       	}
	       	$pdf->Ln(); //new row	
	       
		}
		$pdf->Ln(); //new row
		$pdf->Ln(); //new row
	
	
             
        
		$pdf->Cell(100,10,"Minimum Residual = ".$res_min,1,0,'C');
		$pdf->Cell(100,10,"Optimal Beta = ".$b_opt,1,0,'C');    
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row

        $pdf->Cell(50,10,"Target Oi",1,0,'C');
		$pdf->Cell(50,10,"Modelled Oi",1,0,'C'); 
		$pdf->Cell(50,10,"Target Dj",1,0,'C');
		$pdf->Cell(50,10,"Modelled Dj",1,0,'C');
		$pdf->Ln(); //new row 

          
        for ($i = 1; $i <= $n; $i++)
        {
			$pdf->Cell(50,10,$OriginSum[$i],1,0,'C');
			$pdf->Cell(50,10,$sumTR[$i],1,0,'C'); 
			$pdf->Cell(50,10,$Destsum[$i],1,0,'C');
			$pdf->Cell(50,10,$sumTC[$i],1,0,'C');
			$pdf->Ln(); //new row 
        
        }   
        $pdf->Ln(); //new row 
        $pdf->Ln(); //new row 

		$pdf->Cell(25,10,"Beta",1,0,'C');
		$pdf->Cell(50,10,"Residual SSE",1,0,'C');
		$pdf->Ln(); //new row

        for ($i = 1; $i < $nbt; $i++)
        {
             $pdf->Cell(25,10,$b[$i],1,0,'C');
			 $pdf->Cell(50,10,$res[$i],1,0,'C');
			 $pdf->Ln(); //new row
        }   
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row
$pdf->Output($folder.$m_MethodVal.date("Ymdhms").'.pdf',"F");

//============================================================+
// END OF FILE
//============================================================+
?>
