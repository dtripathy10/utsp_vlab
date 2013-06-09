<?php 
// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
$folder = "../user/".$UploadFile."/Experiment5/";


$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_POST['CostFile']; 
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];  
require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment: Singly Constrained Gravity Model');
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

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="SigGravMod.php?Exp=3";
</script>
<?php 
}
date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");




 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, 'Experiment No. 3 ', '', 0, 'L', false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);


if($m_MethodVal == "SinglyOrigin")
{
	$pdf->Write(0, 'Singly Constrained Gravity Model (Origin)', '', 0, 'C', true, 0, false, false, 0);
}
elseif($m_MethodVal == "SinglyDest")
{
    $pdf->Write(0, 'Singly Constrained Gravity Model(Destination)', '', 0, 'C', true, 0, false, false, 0);
} 
$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);

//$pdf->FillColor(0,0,130);
$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row

//------------------------------ Reading Xls file ----------------------------------

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
        }
        $pdf->Ln(); //new row;
        $pdf->Ln(); //new row;
        
        
        // Destination File 
       
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        //$dataDestF->read('base_matrix.xls');
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
                	$m_TotalSum += $m_DestMtx[$i][$j];
                    
            }
            $pdf->Ln(); //new row  
        }
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row
        

//-----------------------------------------------------------------------------
}   

if($m_FunctionsVal == "PowerFun")
{
$html = <<<EOD
		 Selected Impedence Functions : Power Function [<B>F<sub>ij</sub> = C<sub>ij</sub><sup>B</sup><B></font>]<br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$pdf->Write(0, "B value = ".$_POST['txtBeta'], '', 0, '', true, 0, false, false, 0);
}
elseif ($m_FunctionsVal == "ExponentialFun")   
{
$html = <<<EOD
		 Selected Impedence Functions : Exponential Function [<B>F<sub>ij</sub> = e<sup>-(B)C<sub>ij</sub></sup><B></font> ] <br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$pdf->Write(0, "B value = ".$_POST['txtBeta'], '', 0, '', true, 0, false, false, 0);
}
elseif ($m_FunctionsVal == "GammaFun")  
{
$html = <<<EOD
		 Selected Impedence Functions : Gamma Function [<B>F<sub>ij</sub> = e<sup>-(B1)C<sub>ij</sub></sup> C<sub>ij</sub><sup>B2</sup><B></font>] <br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$pdf->Write(0, "B1 value = ".$_POST['txtBeta1'], '', 0, '', true, 0, false, false, 0);
		$pdf->Write(0, "B2 value= ".$_POST['txtBeta2'], '', 0, '', true, 0, false, false, 0);



}
elseif ($m_FunctionsVal == "LinearFun")   
{
$html = <<<EOD
		Selected Impedence Functions : Linear Function [<B>F<sub>ij</sub> = "B1" + B2*C<sub>ij</sub><B></font>] <br>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$pdf->Write(0, "B1 value = ".$_POST['txtBeta1'], '', 0, '', true, 0, false, false, 0);
		$pdf->Write(0, "B2 value= ".$_POST['txtBeta2'], '', 0, '', true, 0, false, false, 0);


}                   
$pdf->Ln(); //new row 
$pdf->Ln(); //new row
$pdf->Write(0, "Calculations :", '', 0, 'L', true, 0, false, false, 0);   
$pdf->Ln(); //new row 
$pdf->Ln(); //new row  
            
 
if($m_FunctionsVal == "PowerFun")
{
// Calculation for Power Function	
    	
	$m_txtBeta = $_POST['txtBeta'];
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

if($m_MethodVal == "SinglyOrigin")
{         
 
      // Calculation for Singly Constrained Gravity Model (Origin) 
 		        
		$pdf->Cell((($n+2)*25),10,' Dij*Fij ',1,0,'C'); 
    	$pdf->Ln(); //new row
    	$pdf->Cell(25,10,'Zone ',1,0,'C');
        for($i = 1; $i <= $n; $i++)
        {
                $pdf->Cell(25,10,$i,1,0,'C');
        }           
       	$pdf->Cell(25,10,' Sum Dij*Fij ',1,0,'C');
       	$pdf->Ln(); //new row 
       	for ($i = 1; $i <= $n; $i++)
            {
                $pdf->Cell(25,10,$i,1,0,'C');
                $sumR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $DF[$i][$j] = $m_DestMtx[1][$j] * $ImpCost[$i][$j];         
                    $sumR[$i] += $DF[$i][$j];
                    $pdf->Cell(25,10,(round($DF[$i][$j],4)),1,0,'C');
                } 
                $pdf->Cell(25,10,(round($sumR[$i],4)),1,0,'C'); 
                $pdf->Ln(); //new row 
            }
            
            $pdf->Ln(); //new row
            $pdf->Ln(); //new row  

          
            $pdf->Cell((($n+1)*25),10,'Interaction Probabilities (Pij)',1,0,'C'); 
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
                    $PR[$i][$j] = $DF[$i][$j] / $sumR[$i];
                    $pdf->Cell(25,10,(round($PR[$i][$j],4)),1,0,'C');
                }             
                $pdf->Ln(); //new row
            }
            
            $pdf->Ln(); //new row
            $pdf->Ln(); //new row  
 
          	$pdf->Write(0, 'Final Result ', '', 0, 'L', true, 0, false, false, 0);
          	$pdf->Ln(); //new row 
         	$pdf->Cell(175,10,"Origin Destination Matrix Tij",1,0,'C');
          	$pdf->Ln(); //new row 
          	$pdf->Cell(25,10,"Zone",1,0,'C');
            for($i = 1; $i <= $n; $i++)
            {
                 $pdf->Cell(25,10,$i,1,0,'C');
            } 
            $pdf->Cell(25,10,"Sum Dj*Fij",1,0,'C'); 
            
            $pdf->Cell(50,10,"Future year Origins Total",1,0,'C');  
            
            for ($i = 1; $i <= $n; $i++)
            {
            	$pdf->Ln(); //new row 
                $pdf->Cell(25,10,$i,1,0,'C');
                $sumTR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $T[$i][$j] = $m_OriginMtx[1][$i] * $PR[$i][$j];      
                    $sumTR[$i] += $T[$i][$j];  
                    $pdf->Cell(25,10,round($T[$i][$j],4),1,0,'C');
                }    
                $pdf->Cell(25,10,$sumTR[$i],1,0,'C');
                $pdf->Cell(50,10,$m_OriginMtx[1][$i],1,0,'C');
               	
           }
  
            $pdf->Ln(); //new row 
            $pdf->Ln(); //new row 
            
}
elseif($m_MethodVal == "SinglyDest")
{
      	// Calculation for Singly Constrained Gravity Model (Destination) 	

 		        
		$pdf->Cell((($n+1)*25),10,'Oij*Fij ',1,0,'C'); 
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
                    $OF[$i][$j] = $m_OriginMtx[1][$i] * $ImpCost[$i][$j]; 
                    $pdf->Cell(25,10,(round($OF[$i][$j],4)),1,0,'C');
            }                     
            $pdf->Ln(); //new row
       }
       $pdf->Cell(25,10,'Sum Oij*Fij ',1,0,'C');
       for ($j = 1; $j <= $n; $j++)
       {                 
            $sumC[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {   
                    $sumC[$j] += $OF[$i][$j];                      
            }     
            $pdf->Cell(25,10,(round($sumC[$j],4)),1,0,'C');                 
       }
       $pdf->Ln(); //new row
       $pdf->Ln(); //new row
    
       $pdf->Cell((($n+1)*25),10,'Interaction Probabilities (Pij)',1,0,'C'); 
       $pdf->Ln(); //new row
       $pdf->Cell(25,10,'Zone ',1,0,'C');
       for($i = 1; $i <= $n; $i++)
       {
       		$pdf->Cell(25,10,$i,1,0,'C');
       }           
       $pdf->Ln(); //new row
       for ($i = 1; $i <= $n; $i++)
       {
            $pdf->Cell(25,10,$i,1,0,'C');;
            for ($j = 1; $j <= $n; $j++)
            {                 
                    $PR[$i][$j] = $OF[$j][$i] / $sumC[$i]; 
                    $pdf->Cell(25,10,(round($PR[$i][$j],4)),1,0,'C');    
            }                     
            $pdf->Ln(); //new row
       }
       $pdf->Ln(); //new row 
            

        
      $pdf->Write(0, 'Final Result ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->Ln(); //new row 
      $pdf->Cell((55+(($n)*25)),10,"Origin Destination Matrix Tij",1,0,'C');
      $pdf->Ln(); //new row 
      $pdf->Cell(55,10,"Zone",1,0,'C');
      for($i = 1; $i <= $n; $i++)
      {
           $pdf->Cell(25,10,$i,1,0,'C');
      }           
      $pdf->Ln(); //new row 
      for ($i = 1; $i <= $n; $i++)
      {
      		$pdf->Cell(55,10,$i,1,0,'C');                
            for ($j = 1; $j <= $n; $j++)
            {     
                    $T[$i][$j] = $m_DestMtx[1][$i] * $PR[$i][$j];  
                    $pdf->Cell(25,10,round($T[$i][$j],4),1,0,'C');
            }                      
            $pdf->Ln(); //new row 
      }
        
      $pdf->Cell(55,10,"Sum Oi*Fij",1,0,'C');    
      for ($j = 1; $j <= $n; $j++)
      {
      		$sumTC[$j]=0;   
            for ($i = 1; $i <= $n; $i++)
            {
            	$sumTC[$j] += $T[$j][$i];                  
            }
            $pdf->Cell(25,10,round($sumTC[$j],4),1,0,'C');    
     }     
     $pdf->Ln(); //new row ;    
     $pdf->Cell(55,10,'Future year Destinations Total',1,0,'C');  
     for ($i = 1; $i <= $n; $i++)
     {
     			$pdf->Cell(25,10,$m_DestMtx[1][$i],1,0,'C');    
     }     
      $pdf->Ln(); //new row ; 
      $pdf->Ln(); //new row ;  
         
} 

if($m_MethodVal == "SinglyOrigin")
{
	$pdf->Output($folder.$m_MethodVal.date("Ymdhms").'.pdf',"F");
}
else 
{
	$pdf->Output($folder.$m_MethodVal.date("Ymdhms").'.pdf',"F");
}


//============================================================+
// END OF FILE
//============================================================+
?>
