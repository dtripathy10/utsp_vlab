<?php

session_start();	//To check whether the session has started or not
include "conn.php";	// Database Connection file
//include "userchk.php";	//To check user's session


require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

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

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="DataRegrMod.php";
    
</script>
<?php 
}
 

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
$pdf->Write(0, 'Input Values : ', '', 0, 'P', true, 0, false, false, 0);
$pdf->Ln(); //new row

//------------------------------- Reading Xls file -------------------------------------
if($file_ext1 == '.xls' )
{

	// Trip File


       	require_once 'phpExcelReader/Excel/reader.php';
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read("user/".$UploadFile."/Experiment2/".$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $nRow = $dataTripF->sheets[0]['numRows'];
        $nCol = $dataTripF->sheets[0]['numCols'];
        
        $pdf->Cell(($nCol*25)+25,10,' Observed Socio-Economic Trip Data ',1,0,'C');
        $pdf->Ln(); //new row
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            if($i == 1)
            {
            	$pdf->Cell(25,10,"Zone",1,0,'C');
            	
            }
            else 
            {
            	$pdf->Cell(25,10,($i-1),1,0,'C');
            }         
            for ($j = 1; $j <= $nCol; $j++)
            {
                            
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                //$pdf->Cell(25,10,$m_TripMtx[$i][$j],1,0,'C');
                
                if($i>=2)
                {
                	// Checking for number
                	
               		if(!is_numeric($m_TripMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "DataRegrMod.php";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                    $pdf->Cell(25,10,$m_TripMtx[$i][$j],1,0,'C');
                }
                else
                {    
                    $pdf->Cell(25,10,$m_TripMtx[$i][$j],1,0,'C');
                }        
            }               
            $pdf->Ln(); //new row       
        }  
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row     

        
}
//------------------------------------------------------------------------------

//----------------------------- Reading csv file -------------------------------

elseif($file_ext1 == '.csv' )
{

 	$nCol=0; 
	$nRow = 0;
	$name = "user/".$UploadFile."/Experiment2/".$m_TripFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{    	   
        	$m_Trip[$nRow][$c] = $data[$c];        	
     	}
     	$nRow++;    
    }
    
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		 $m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j];      	
         }
    	
    }
    
     $pdf->Cell(($nCol*25)+25,10,' Observed Socio-Economic Trip Data ',1,0,'C');
     $pdf->Ln(); //new row
     for ($i = 1; $i <= $nRow; $i++)
     {               
            if($i == 1)
            {
            	$pdf->Cell(25,10,"Zone",1,0,'C');
            	
            }
            else 
            {
            	$pdf->Cell(25,10,($i-1),1,0,'C');
            }            
            for ($j = 1; $j <= $nCol; $j++)
            {
                         
                if($i>=2)
                {
               		if(!is_numeric($m_TripMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "DataRegrMod.php";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                	$pdf->Cell(25,10,$m_TripMtx[$i][$j],1,0,'C');
                }
                else
                {    
                     $pdf->Cell(25,10,$m_TripMtx[$i][$j],1,0,'C');
                }        
            }               
            $pdf->Ln(); //new row       
        }  
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row     
}
$pdf->Write(0, 'Output : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row
//------------------------------------------------------------------------------------------------ 
$m_AnalysisVar = $_POST['AnalysisVar'];

	if($m_AnalysisVar == "DataAna")
	{
		$m_DataChoiceVar = $_POST['DataChoiceVar'];
	
		if ($m_DataChoiceVar == "Correlation")
		{				
			for ($i=0; $i < count($_POST['CorrDescVar']);$i++)
			{	
    			$m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];
			}
			
			// Correlation Analysis starts from here
			
			$SelectCol = $i;
		   	$m_finalrow = $nRow;
		   	
    		for ($j = 0; $j < $SelectCol; $j++)
        	{
            	$SumC[$j]=0;
            	$avg[$j]=0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$tripmatrix[$i][$j]=$m_TripMtx[$i][$m_CorrDescVar[$j]];                	
                	$SumC[$j] += $tripmatrix[$i][$j];                                   
            	}
            	$avg[$j] = $SumC[$j] / ($m_finalrow-1);
         	}  
          
         	for ($j = 0; $j < $SelectCol; $j++)
         	{
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{                
                	$delta[$i][$j] =  $tripmatrix[$i][$j] - $avg[$j];               
            	}
         	}  

        	for ($j = 0; $j < $SelectCol; $j++)
        	{     
            	$deltaSum[$j] = 0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$deltaPro[$i][$j] =  $delta[$i][$j] * $delta[$i][$j];
                	$deltaSum[$j] += $deltaPro[$i][$j];
        		}
            	$deltaRoot[$j] = sqrt($deltaSum[$j]);   
        	}       	
                
        	for ($j = 0; $j < $SelectCol; $j++)
        	{     
            	for ($i = 0; $i < $SelectCol; $i++)
            	{
            		$sump[$j][$i]=0;
            		for ($k = 2; $k <= $m_finalrow; $k++)
            		{
            			$sump[$j][$i]+=$delta[$k][$j]*$delta[$k][$i];            
	            	}
    	        }
        	}
        
        	for ($j = 0; $j < $SelectCol; $j++)
        	{    
            	for ($i = 0; $i < $SelectCol; $i++)
            	{
            		if($deltaRoot[$j] == 0)
            		{
            			?>
            			<script>
            				alert("All values in any column can not be same");
            				document.location = "DataRegrMod.php";
            			</script>
            			<?php             	
            		}
            		else 
            		{	
                 		$reg[$i][$j] =  $sump[$j][$i]/($deltaRoot[$j]*$deltaRoot[$i]);
            		}
        		}
        	}
        
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
			for ($i=0; $i < count($_POST['CorrDescVar']);$i++)
			{	
    			$m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];
			}		
			
			// Descriptives Analysis start from here
			
			$SelectCol = $i;
		   	$m_finalrow = $nRow;
		   	
    		for ($j = 0; $j < $SelectCol; $j++)
        	{
            	$SumC[$j]=0;
            	$avg[$j]=0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$tripmatrix[$i][$j]=$m_TripMtx[$i][$m_CorrDescVar[$j]];                	
                	$SumC[$j] += $tripmatrix[$i][$j];                                   
            	}
            	$avg[$j] = $SumC[$j] / ($m_finalrow-1);
         	}    
         	
         	for ($j = 0; $j < $SelectCol; $j++)
        	{
        		$max[$j] = 0;
        		$min[$j] = $tripmatrix[2][1];
        		for ($i = 2; $i <= $m_finalrow; $i++)
            	{
            		if($tripmatrix[$i][$j] > $max[$j])
            		{
            			$max[$j] = $tripmatrix[$i][$j];
            		}
            		elseif ($tripmatrix[$i][$j] < $min[$j])
            		{
            			$min[$j] = $tripmatrix[$i][$j];            			
            		}
        		}
        	}         	
          
         	for ($j = 0; $j < $SelectCol; $j++)
         	{
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{                
                	$delta[$i][$j] =  $tripmatrix[$i][$j] - $avg[$j];               
            	}
         	}  

        	for ($j = 0; $j < $SelectCol; $j++)
        	{     
            	$deltaSum[$j] = 0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$deltaPro[$i][$j] =  $delta[$i][$j] * $delta[$i][$j];
                	$deltaSum[$j] += $deltaPro[$i][$j];
        		}
            	$deltaRoot[$j] = sqrt(($deltaSum[$j])/($m_finalrow-2));   
        	}
        	
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
		$m_RegrType=$_POST['RegrType'];
		$m_RegrDepdVar = $_POST['RegrDepdVar'];
		//echo $m_RegrType."<br>";
		
		for ($i=0; $i < count($_POST['RegrInpdVar']);$i++)
		{	
    		$m_RegrInpdVar[$i] = $_POST['RegrInpdVar'][$i];
		}	
		
		// Regression Analysis start from here
		
		$SelectCol = $i;
        $m_finalrow = $nRow;
            
        
        
        //------------------------------- Reading Xls file---------------------------------------------
		if($file_ext1 == '.xls' )
		{
        	$pdf->Cell(50,10,' Output Variable  ',1,0,'C');
     		$pdf->Ln(); //new row
        	for ($i = 1; $i <= $m_finalrow; $i++)
        	{         
        		if($i==1)
            	{
            		$pdf->Cell(25,10,"Zone",1,0,'C');
            		$pdf->Cell(25,10,$dataTripF->sheets[0]['cells'][$i][$m_RegrDepdVar],1,0,'C');
					$pdf->Ln(); //new row
           		}
            	else
            	{
            		$Y[$i][$m_RegrDepdVar]=$dataTripF->sheets[0]['cells'][$i][$m_RegrDepdVar];
            		
            		$pdf->Cell(25,10,($i-1),1,0,'C');
            		$pdf->Cell(25,10,$Y[$i][$m_RegrDepdVar],1,0,'C');
					$pdf->Ln(); //new row
           		}
       		}
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row

        
         }
		//----------------------------------------------------------------------------------
		
		//----------------------------- Reading csv file -----------------------------------
  
		elseif($file_ext1 == '.csv' )
		{
			$pdf->Cell(60,10,'Output Variable ',1,0,'C');
     		$pdf->Ln(); //new row
        	for ($i = 1; $i <= $m_finalrow; $i++)
        	{         
        		if($i==1)
            	{
            		$pdf->Cell(30,10,"Zone",1,0,'C');
            		$pdf->Cell(25,10,$m_TripMtx[$i][$m_RegrDepdVar],1,0,'C');
					$pdf->Ln(); //new row
           		}
            	else
            	{
            		$Y[$i][$m_RegrDepdVar]=$m_TripMtx[$i][$m_RegrDepdVar];
            		$pdf->Cell(30,10,($i-1),1,0,'C');
            		$pdf->Cell(25,10,$Y[$i][$m_RegrDepdVar],1,0,'C');
					$pdf->Ln(); //new row
 
           		}
       		}
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row
    			
		}
        

		
		//------------------------------------------------------------------------------------------
		
		
		

	if($m_RegrType=="Linear")
	{
		echo $m_RegrType." Regression";
		 $m_finalrow=$m_finalrow-1;
               
        for ($i = 1; $i <= $m_finalrow; $i++)
        {                
        	$X[$i][1] =  1;               
        }
        
        $k=1;
        $m=0;
        
        for ($j = 0; $j < $SelectCol; $j++)
        {
            $k++;
            $m=0;
            for ($i = 2; $i <= $m_finalrow+1; $i++)
            {
                $m++;             
                $X[$m][$k] =  $m_TripMtx[$i][$m_RegrInpdVar[$j]];
            }
        }
        
        $p = $SelectCol + 1;


        
        for ($j = 1; $j <= $p; $j++)
        {
            for ($i = 1; $i <= $m_finalrow; $i++)
            {                
               $X_t[$j][$i]=$X[$i][$j] ;               
            }
        }


        for($i=1;$i<=$p;$i++)
        {
            for($j=1;$j<=$m_finalrow;$j++)
            {
                for($k=1;$k<=$p;$k++)
                {
                    $s=0;
                    $s=$X_t[$i][$j]*$X[$j][$k];
                    $multi[$i][$k]=$multi[$i][$k]+$s;
                }
            }
        }


        //multiplication  of XT and Y
                  
        for($i=1;$i<=$p;$i++)
        {
             for($j=1;$j<=$m_finalrow;$j++)
             {
             	$r=0;
                $r=$X_t[$i][$j]*$Y[$j+1][$m_RegrDepdVar];
                $multiXTY[$i]=$multiXTY[$i]+$r;
             }
       	}


      
	     //INVERSE OF MATRIX
        
    	 for($i = 1; $i <= $p; $i++)
     	{
     		for($j = 1; $j <= $p; $j++)
        	{
        		if($i == $j)
            	{
            		$b[$i][$j]=1;
            	}
            	else
            	{
                	$b[$i][$j]=0;
            	}
        	}
     	}
        for($i = 1; $i <= $p; $i++)
        {
            for($k=1; $k<=$p; $k++)
            {
                 $b[$i][$k];
            }
        }
        
        //IMP
         
        for($k = 1; $k <= $p; $k++)
        {
            for($i = $k+1; $i <= $p; $i++)
            {
                $q = $multi[$i][$k];
                for($j = 1; $j <= $p; $j++)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                }
            }
        }
        
        //checking for determinant to be 0
        
        for($i = 1; $i <= $p; $i++)
        {        
	        if($b[$i][$i] == 0)
            {
                ?>
                <script>
                    alert("Non Singular Matrix");
                    //document.location = "RegrMod.php";
                </script>
                <?php
            }
           $pdf->Ln(); //new row
       	}   

        for($k = $p; $k >0; $k--)
        {
            for($i = $k-1; $i > 0; $i--)
            {
                $q = $multi[$i][$k];
                for($j = $p; $j >= 1; $j--)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                }
            }
        }

        for($i = 1; $i <= $p; $i++)
        {
            $q = $multi[$i][$i];
            for($k=1; $k<=$p; $k++)
            {
                $b[$i][$k] = ($b[$i][$k] / $q);
                $multi[$i][$k] = ($multi[$i][$k] / $q);
            }
        }
        

	   //matrix b is xtx-1
        
	   	for($i=1;$i<=$p;$i++)
       	{
    	   for($j=1;$j<=$p;$j++)
           {
	           $t=0;
               $t=$b[$i][$j]*$multiXTY[$j];
               $ans[$i]=$ans[$i]+$t;
           }
    	}
        
      //ESTIMATED VALUE OF OUTPUTS
      
       	for($i=1;$i<=$m_finalrow;$i++)
       	{
        	for($j=1;$j<=$p;$j++)
            {
                $t=0;
                $t=$X[$i][$j]*$ans[$j];
                $output[$i]=$output[$i]+$t;
            }
		}
       
       // standard variables
      
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	$Res[$i]=$Y[$i+1][$m_RegrDepdVar]-$output[$i];
      	}
      
      	// standard variables
      	$deltaSum = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
            $deltaSum += $Res[$j]*$Res[$j] ;
        }
            
        $deltaSum1=$deltaSum/($m_finalrow-$p);
        $deltaRoot = sqrt($deltaSum1);   
                 
        //
        
        for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$stdres[$j]=$Res[$j]/$deltaRoot;
        }
        
       // for r square value
          
       for ($i = 2; $i <= $m_finalrow+1; $i++)
       {
            $SumC += $Y[$i][$m_RegrDepdVar];                                   
       }
       $avg = $SumC / $m_finalrow;
       
       $deltaSum2 = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$deltaPro1 =  ($avg-$Y[$j+1][$m_RegrDepdVar]) * ($avg-$Y[$j+1][$m_RegrDepdVar]);
            $deltaSum2 += $deltaPro1;
        }

	    $v=$deltaSum/$deltaSum2;
    	$r_sqr=1-$v;
      
    	
    	$pdf->Cell(50,10,' R-Square ',1,0,'C');
    	$pdf->Cell(50,10,' Standard Error ',1,0,'C');
    	$pdf->Ln(); //new row
    	$pdf->Cell(50,10,round($r_sqr,4),1,0,'C');
    	$pdf->Cell(50,10,round($deltaRoot,4),1,0,'C');
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row


      	// fot t value
      
      	for($i = 1; $i <= $p; $i++)
        {
            $msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
        }

        for($i = 1; $i <= $p; $i++)
        {
            $t_value[$i]=$ans[$i]/$msemse[$i];
        }

        $pdf->Cell(200,10,' Coefficients ',1,0,'C');
        $pdf->Ln(); //new row
    	$pdf->Cell(50,10,' ',1,0,'C');
    	$pdf->Cell(50,10,'Estimate',1,0,'C');
    	$pdf->Cell(50,10,'Standard Error of Estimate',1,0,'C');
    	$pdf->Cell(50,10,'T-Stat',1,0,'C');
     	$pdf->Ln(); //new row
     	
      	
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
            		$pdf->Cell(50,10,"Intercept",1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],4),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],4),1,0,'C');
    				$pdf->Cell(50,10,$t_value[$i],1,0,'C');
     				$pdf->Ln(); //new row
            }
            else
            {
            		$pdf->Cell(50,10,$m_TripMtx[1][$m_RegrInpdVar[$k]],1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],4),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],4),1,0,'C');
    				$pdf->Cell(50,10,round($t_value[$i],4),1,0,'C');
     				$pdf->Ln(); //new row
                  	$k++;
            }
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
      
      	$k=1;
      	
      	$pdf->Write(0, "Equation :", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(); //new row
        $pdf->Write(0, $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]." = ".round($ans[$k],4)."  + ", '', 0, 'L', false, 0, false, false, 0);
      	
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") + ", '', 0, 'L', false, 0, false, false, 0);
                
             }
             elseif($i <= $p-3)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") + ", '', 0, 'L', false, 0, false, false, 0);
                
             }
             else
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")", '', 0, 'L', false, 0, false, false, 0);
             }
             $k++;
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
     
      	$pdf->Cell(200,10,'Estimated output values ',1,0,'C');
      	$pdf->Ln(); //new row
      	$pdf->Cell(50,10,'Output variables ',1,0,'C');
      	$pdf->Cell(50,10,'Yi',1,0,'C');
      	$pdf->Cell(50,10,'Residuals',1,0,'C');
      	$pdf->Cell(50,10,'Standard Deviation',1,0,'C');
      	$pdf->Ln(); //new row
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{       
      		$pdf->Cell(50,10,'Y'.$i,1,0,'C'); 
      		$pdf->Cell(50,10,round($output[$i],4),1,0,'C'); 
      		$pdf->Cell(50,10,round($Res[$i],4),1,0,'C');
      		$pdf->Cell(50,10,round($stdres[$i],4),1,0,'C');       
        	$pdf->Ln(); //new row
      	}
    	$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
	}
	if($m_RegrType=="Quadratic")
	{
/*		echo $m_RegrType." Regression";
	
		$m_finalrow=$m_finalrow-1;
	    for ($i = 1; $i <= $m_finalrow; $i++)
        {                
        		$X[$i][1] =  1;    
        		     
       	}
        $k=1;
	    for ($j = 2; $j <= $SelectCol+1; $j++)
        {
            	$k++;
            	$m=0;
            	for ($i = 2; $i <= $m_finalrow+1; $i++)
            	{
                	$m++;           
                	$X[$m][$k] =  $m_TripMtx[$i][$m_RegrInpdVar[$j-2]];
                	echo $X[$m][$k]."<br>";
                	$X[$m][($SelectCol+1 - 2)+1 +$k] =  pow($m_TripMtx[$i][$m_RegrInpdVar[$j-2]],2);
                	
                }
        }
        
*/
        		echo $m_RegrType." Regression";
		$m_finalrow=$m_finalrow-1;
	
	    for ($i = 1; $i <= $m_finalrow; $i++)
        {                
        		$X[$i][1] =  1;    
        		     
       	}
        $k=1;
	    for ($j = 2; $j <= $SelectCol+1; $j++)
        {
            	$k++;
            	$m=0;
            	for ($i = 2; $i <= $m_finalrow+1; $i++)
            	{
                	$m++;    
                		       
                	$X[$m][$k] =  $m_TripMtx[$i][$m_RegrInpdVar[$j-2]];
                	$X[$m][($SelectCol+1 - 2)+1 +$k] =  pow($m_TripMtx[$i][$m_RegrInpdVar[$j-2]],2);
                	
                }
        }
        

        
        
        
		
       
        $p = ($SelectCol)*2+1;

	    for ($j = 1; $j <= $p; $j++)
        {
            for ($i = 1; $i <= $m_finalrow; $i++)
            {             
               		$X_t[$j][$i]=$X[$i][$j] ;
               		
            }
        }
        
		for($i=1;$i<=$p;$i++)
		{
			for($j=1;$j<=$m_finalrow;$j++)
			{
				for($k=1;$k<=$p;$k++)
				{
					$s=0;
					$s=$X_t[$i][$j]*$X[$j][$k];
					$multi[$i][$k]=$multi[$i][$k]+$s;
				}
				 
			}
		}
		

		
        

 //multiplication  of XT and Y
                  
        for($i=1;$i<=$p;$i++)
        {
             for($j=1;$j<=$m_finalrow;$j++)
             {

                $r=0;
                $r=$X_t[$i][$j]*$Y[$j+1][$m_RegrDepdVar];
                $multiXTY[$i]=$multiXTY[$i]+$r;
                
             }
            
       }
       	
	        //INVERSE OF MATRIX
        
		for($i = 1; $i <= $p; $i++)
		{
			for($j = 1; $j <= $p; $j++)
			{
				if($i == $j)
				{
					$b[$i][$j]=1;
				}
				else
				{
					$b[$i][$j]=0;
				}
			}
		}
		for($i = 1; $i <= $p; $i++)
		{
			for($k=1; $k<=$p; $k++)
			{
				 $b[$i][$k];
			}
		} 
		//IMP
 		
		for($k = 1; $k <= $p; $k++)
		{
			for($i = $k+1; $i <= $p; $i++)
			{
				$q = $multi[$i][$k];
				for($j = 1; $j <= $p; $j++)
				{
					$multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
					
					$b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
					
					
				}
				
			}
		}
        
//checking for determinant to be 0
        
        for($i = 1; $i <= $p; $i++)
        {        
	        if($b[$i][$i] == 0)
            {
                ?>
                <script>
                    alert("Non Singular Matrix");
                    //document.location = "RegrMod.php";
                </script>
                <?php
            }
            //echo "<BR>";
       	}   
        
 		for($k = $p; $k >0; $k--)
		{
			for($i = $k-1; $i > 0; $i--)
			{
				
				$q = $multi[$i][$k];
				for($j = $p; $j >= 1; $j--)
				{
					$multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
					$b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
					
				}
				
			}
		}

		for($i = 1; $i <= $p; $i++)
		{
			$q = $multi[$i][$i];
			for($k=1; $k<=$p; $k++)
			{
				$b[$i][$k] = ($b[$i][$k] / $q);
				
				$multi[$i][$k] = ($multi[$i][$k] / $q);
				
				
			}
			
		}
		
        
        
        
   //matrix b is xtx-1

		
  		for($i=1;$i<=$p;$i++)
        {
             for($j=1;$j<=$p;$j++)
             {

                $t=0;
                $t=$b[$i][$j]*$multiXTY[$j];
                $ans[$i]=$ans[$i]+$t;
             }
            
       }
		
      
       

      //ESTIMATED VALUE OF OUTPUTS
      
       for($i=1;$i<=$m_finalrow;$i++)
       {
             for($j=1;$j<=$p;$j++)
             {

                $t=0;
                $t=$X[$i][$j]*$ans[$j];
                $output[$i]=$output[$i]+$t;
                
             }
       }
    
       
// standard variables
      
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	$Res[$i]=$Y[$i+1][$m_RegrDepdVar]-$output[$i];
        	 
      	}
      

        // standard variables 
     	$deltaSum = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
            $deltaSum += $Res[$j]*$Res[$j] ;
        }
        	
        $deltaSum1=$deltaSum/($m_finalrow-$p);
        $deltaRoot = sqrt($deltaSum1);   
             	
        //
        
        for ($j = 1; $j <= $m_finalrow; $j++)
        {     
            $stdres[$j]=$Res[$j]/$deltaRoot;
        }
        

	       // for r square value
       
     
        
            for ($i = 2; $i <= $m_finalrow+1; $i++)
            {
                $SumC += $Y[$i][$m_RegrDepdVar];                                   
            }
            $avg = $SumC / $m_finalrow;
            //echo "<td bgcolor='#B8DBFF'><b>".$SumC[$j]."\t".$avg[$j]."</b></td>";  
        
      
      $deltaSum2 = 0;
      for ($j = 1; $j <= $m_finalrow; $j++)
        {     
           $deltaPro1 =  ($avg-$Y[$j+1][$m_RegrDepdVar]) * ($avg-$Y[$j+1][$m_RegrDepdVar]);
                $deltaSum2 += $deltaPro1;
        	}
     // echo $deltaSum2. "<br><br><br>";
      $v=$deltaSum/$deltaSum2;
      $r_sqr=1-$v;

      // fot t value
      
     
      	for($i = 1; $i <= $p; $i++)
		{
			$msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
			//echo "<br>".$msemse[$i]."<br>";
			
		}

		for($i = 1; $i <= $p; $i++)
		{
			$t_value[$i]=$ans[$i]/$msemse[$i];
		}
		$pdf->Cell(200,10,' Coefficients ',1,0,'C');
        $pdf->Ln(); //new row
    	$pdf->Cell(50,10,' ',1,0,'C');
    	$pdf->Cell(50,10,'Estimate',1,0,'C');
    	$pdf->Cell(50,10,'Standard Error of Estimate',1,0,'C');
    	$pdf->Cell(50,10,'T-Stat',1,0,'C');
     	$pdf->Ln(); //new row
     	
      	
      	$k=0;
      	for ($i = 1; $i <= $SelectCol+1; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
            		$pdf->Cell(50,10,"Intercept",1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],4),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],4),1,0,'C');
    				$pdf->Cell(50,10,$t_value[$i],1,0,'C');
     				$pdf->Ln(); //new row
            }
            else
            {
            		$pdf->Cell(50,10,$m_TripMtx[1][$m_RegrInpdVar[$k]],1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],4),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],4),1,0,'C');
    				$pdf->Cell(50,10,round($t_value[$i],4),1,0,'C');
     				$pdf->Ln(); //new row
                  	$k++;
            }
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Cell(50,10,' R-Square ',1,0,'C');
    	$pdf->Cell(50,10,' Standard Error ',1,0,'C');
    	$pdf->Ln(); //new row
    	$pdf->Cell(50,10,round($r_sqr,4),1,0,'C');
    	$pdf->Cell(50,10,round($deltaRoot,4),1,0,'C');
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      
      	$k=1;
      	
      	$pdf->Write(0, "Equation :", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(); //new row
        $pdf->Write(0, $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]." = ".round($ans[$k],4)."  + ", '', 0, 'L', false, 0, false, false, 0);
      	
      	$k++;
      	for ($i = 0; $i < $SelectCol; $i++)
      	{
            if($i==0)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") + ", '', 0, 'L', false, 0, false, false, 0);
                
             }
             elseif($i <= $SelectCol-2)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") + ", '', 0, 'L', false, 0, false, false, 0);
                
             }
             else
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")", '', 0, 'L', false, 0, false, false, 0);
             }
             $k++;
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
     
      	$pdf->Cell(200,10,'Estimated output values ',1,0,'C');
      	$pdf->Ln(); //new row
      	$pdf->Cell(50,10,'Output variables ',1,0,'C');
      	$pdf->Cell(50,10,'Yi',1,0,'C');
      	$pdf->Cell(50,10,'Residuals',1,0,'C');
      	$pdf->Cell(50,10,'Standard Deviation',1,0,'C');
      	$pdf->Ln(); //new row
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{       
      		$pdf->Cell(50,10,'Y'.$i,1,0,'C'); 
      		$pdf->Cell(50,10,round($output[$i],6),1,0,'C'); 
      		$pdf->Cell(50,10,round($Res[$i],6),1,0,'C');
      		$pdf->Cell(50,10,round($stdres[$i],6),1,0,'C');       
        	$pdf->Ln(); //new row
      	}
    	$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
		
		
		
		
		
		
		
		
		
		
		
		
	}
	if($m_RegrType=="Power")
	{
		echo $m_RegrType." Regression";
		 for ($i = 1; $i <= $m_finalrow; $i++)
        {         
        	$Y[$i][$m_RegrDepdVar]=log($Y[$i][$m_RegrDepdVar]);
        }
		 $m_finalrow=$m_finalrow-1;
               
        for ($i = 1; $i <= $m_finalrow; $i++)
        {                
        	$X[$i][1] =  1;               
        }
        
        $k=1;
        $m=0;
        
        for ($j = 0; $j < $SelectCol; $j++)
        {
            $k++;
            $m=0;
            for ($i = 2; $i <= $m_finalrow+1; $i++)
            {
                $m++;             
                $X[$m][$k] =  log($m_TripMtx[$i][$m_RegrInpdVar[$j]]);
            }
        }
        
        $p = $SelectCol + 1;


        
        for ($j = 1; $j <= $p; $j++)
        {
            for ($i = 1; $i <= $m_finalrow; $i++)
            {                
               $X_t[$j][$i]=$X[$i][$j] ;               
            }
        }


        for($i=1;$i<=$p;$i++)
        {
            for($j=1;$j<=$m_finalrow;$j++)
            {
                for($k=1;$k<=$p;$k++)
                {
                    $s=0;
                    $s=$X_t[$i][$j]*$X[$j][$k];
                    $multi[$i][$k]=$multi[$i][$k]+$s;
                }
            }
        }

	
 //multiplication  of XT and Y
                  
        for($i=1;$i<=$p;$i++)
        {
             for($j=1;$j<=$m_finalrow;$j++)
             {
             	$r=0;
               	$r=$X_t[$i][$j]*$Y[$j+1][$m_RegrDepdVar];
                $multiXTY[$i]=$multiXTY[$i]+$r;
                
                
             }
       	}
//INVERSE OF MATRIX
        
    	 for($i = 1; $i <= $p; $i++)
     	{
     		for($j = 1; $j <= $p; $j++)
        	{
        		if($i == $j)
            	{
            		$b[$i][$j]=1;
            	}
            	else
            	{
                	$b[$i][$j]=0;
            	}
        	}
     	}
        for($i = 1; $i <= $p; $i++)
        {
            for($k=1; $k<=$p; $k++)
            {
                 $b[$i][$k];
            }
        }
 //IMP
         
        for($k = 1; $k <= $p; $k++)
        {
            for($i = $k+1; $i <= $p; $i++)
            {
                $q = $multi[$i][$k];
                for($j = 1; $j <= $p; $j++)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                   
                }
            }
        }
        
 //checking for determinant to be 0
        
        for($i = 1; $i <= $p; $i++)
        {        
	        if($b[$i][$i] == 0)
            {
                ?>
                <script>
                    alert("Non Singular Matrix");
                    //document.location = "RegrMod.php";
                </script>
                <?php
            }
            //echo "<BR>";
       	}   
        
        for($k = $p; $k >0; $k--)
        {
            for($i = $k-1; $i > 0; $i--)
            {
                $q = $multi[$i][$k];
                for($j = $p; $j >= 1; $j--)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                   
                }
              
            }
        }
       	
        
        for($i = 1; $i <= $p; $i++)
        {
            $q = $multi[$i][$i];
            for($k=1; $k<=$p; $k++)
            {
                $b[$i][$k] = ($b[$i][$k] / $q);
                $multi[$i][$k] = ($multi[$i][$k] / $q);
               
            }
        }
        
        
        
        	   //matrix b is xtx-1
        
	   	for($i=1;$i<=$p;$i++)
       	{
    	   for($j=1;$j<=$p;$j++)
           {
	           $t=0;
               $t=$b[$i][$j]*$multiXTY[$j];
               $ans[$i]=$ans[$i]+$t;
              
           }
            
    	}
 //---------extra code---------------       
	  for($j=1;$j<=$p;$j++)
	  {
      		$ans[$j]=round($ans[$j],4);
      }
 //-----------------------------------

      
		
//ESTIMATED VALUE OF OUTPUTS
      
	  for($i=1;$i<=$m_finalrow;$i++)
      {
      		$output[$i]=1;
      }
      
      for($i=1;$i<=$m_finalrow;$i++)
       {
        	for($j=2;$j<=$p;$j++)
            {

                $t=1;
                $t=pow(exp($X[$i][$j]),$ans[$j]);
                $output[$i] = $output[$i]*$t;
                
             }
       }
       
       $ans[1]=exp($ans[1]);
       // echo $ans[1];
       for($i=1;$i<=$m_finalrow;$i++)
       {
      		 $output[$i]=$ans[1]*$output[$i];
      		 // echo $output[$i]=round($output[$i],4);
       }
       
// standard variables
      
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	$Res[$i]=$Y[$i+1][$m_RegrDepdVar]-$output[$i];
        	 
      	}
      
      	// standard variables
      	$deltaSum = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
            $deltaSum += $Res[$j]*$Res[$j] ;
        }
            
      	$deltaSum1=$deltaSum/($m_finalrow-$p);
       	$deltaRoot = sqrt($deltaSum1);   
                 
        //
        
        for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$stdres[$j]=$Res[$j]/$deltaRoot;
        }

 // for r square value
          
       for ($i = 2; $i <= $m_finalrow+1; $i++)
       {
           $SumC += $Y[$i][$m_RegrDepdVar];          
       }
       $avg = $SumC / $m_finalrow;
       
       $deltaSum2 = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$deltaPro1 =  ($avg-$Y[$j+1][$m_RegrDepdVar]) * ($avg-$Y[$j+1][$m_RegrDepdVar]);
            $deltaSum2 += $deltaPro1;
        }

	    $v=$deltaSum/$deltaSum2;
    	$r_sqr=1-$v;
      
// fot t value
      
      	for($i = 1; $i <= $p; $i++)
        {
            $msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
        }

        for($i = 1; $i <= $p; $i++)
        {
            $t_value[$i]=$ans[$i]/$msemse[$i];
        }
      
    	
    	$pdf->Cell(50,10,' R-Square ',1,0,'C');
    	$pdf->Cell(50,10,' Standard Error ',1,0,'C');
    	$pdf->Ln(); //new row
    	$pdf->Cell(50,10,round($r_sqr,4),1,0,'C');
    	$pdf->Cell(50,10,round($deltaRoot,4),1,0,'C');
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row
     	$pdf->Ln(); //new row


      	// fot t value
      
      	for($i = 1; $i <= $p; $i++)
        {
            $msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
        }

        for($i = 1; $i <= $p; $i++)
        {
            $t_value[$i]=$ans[$i]/$msemse[$i];
        }

        $pdf->Cell(200,10,' Coefficients ',1,0,'C');
        $pdf->Ln(); //new row
    	$pdf->Cell(50,10,' ',1,0,'C');
    	$pdf->Cell(50,10,'Estimate',1,0,'C');
    	$pdf->Cell(50,10,'Standard Error of Estimate',1,0,'C');
    	$pdf->Cell(50,10,'T-Stat',1,0,'C');
     	$pdf->Ln(); //new row
     	
      	
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
            		$pdf->Cell(50,10,"Intercept",1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],6),1,0,'C');
    				$pdf->Cell(50,10,$t_value[$i],1,0,'C');
     				$pdf->Ln(); //new row
            }
            else
            {
            		$pdf->Cell(50,10,$m_TripMtx[1][$m_RegrInpdVar[$k]],1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($t_value[$i],6),1,0,'C');
     				$pdf->Ln(); //new row
                  	$k++;
            }
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
      
      	$k=1;
      	
      	$pdf->Write(0, "Equation :", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(); //new row
        $pdf->Write(0, $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]." = ".round($ans[$k],4)."  * ", '', 0, 'L', false, 0, false, false, 0);
      	
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") *", '', 0, 'L', false, 0, false, false, 0);
                
             }
             elseif($i <= $p-3)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") *", '', 0, 'L', false, 0, false, false, 0);
                
             }
             else
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")", '', 0, 'L', false, 0, false, false, 0);
             }
             $k++;
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
     
      	$pdf->Cell(200,10,'Estimated output values ',1,0,'C');
      	$pdf->Ln(); //new row
      	$pdf->Cell(50,10,'Output variables ',1,0,'C');
      	$pdf->Cell(50,10,'Yi',1,0,'C');
      	$pdf->Cell(50,10,'Residuals',1,0,'C');
      	$pdf->Cell(50,10,'Standard Deviation',1,0,'C');
      	$pdf->Ln(); //new row
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{       
      		$pdf->Cell(50,10,'Y'.$i,1,0,'C'); 
      		$pdf->Cell(50,10,round($output[$i],4),1,0,'C'); 
      		$pdf->Cell(50,10,round($Res[$i],4),1,0,'C');
      		$pdf->Cell(50,10,round($stdres[$i],4),1,0,'C');       
        	$pdf->Ln(); //new row
      	}
    	$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
	
		
	}
	if($m_RegrType=="Exponential")
	{
		
		echo $m_RegrType." Regression";
	    for ($i = 1; $i <= $m_finalrow; $i++)
        {         
        	$Y1[$i][$m_RegrDepdVar]=$Y[$i][$m_RegrDepdVar];
        	$Y[$i][$m_RegrDepdVar]=log($Y[$i][$m_RegrDepdVar]);
        }
		$m_finalrow=$m_finalrow-1;
	    for ($i = 1; $i <= $m_finalrow; $i++)
        {                
        		$X[$i][1] =  1;    
        		     
       	}
        $k=1;
        $m=0;
	    for ($j = 0; $j < $SelectCol; $j++)
        {
            	$k++;
            	$m=0;
            	for ($i = 2; $i <= $m_finalrow+1; $i++)
            	{
                	$m++;             
                	$X[$m][$k] =  $m_TripMtx[$i][$m_RegrInpdVar[$j]];
                	
                	
            }
        }
        $p = $SelectCol + 1;

        
	    for ($j = 1; $j <= $p; $j++)
        {
            for ($i = 1; $i <= $m_finalrow; $i++)
            {                
                $X_t[$j][$i]=$X[$i][$j] ;
                  
            }
        }
        
         for($i=1;$i<=$p;$i++)
        {
            for($j=1;$j<=$m_finalrow;$j++)
            {
                for($k=1;$k<=$p;$k++)
                {
                    $s=0;
                    $s=$X_t[$i][$j]*$X[$j][$k];
                   	$multi[$i][$k]=$multi[$i][$k]+$s;
                   	
				     
                }
            }
        }
        


 //multiplication  of XT and Y
                  
        for($i=1;$i<=$p;$i++)
        {
             for($j=1;$j<=$m_finalrow;$j++)
             {
             	$r=0;
               	$r=$X_t[$i][$j]*$Y[$j+1][$m_RegrDepdVar];
                $multiXTY[$i]=$multiXTY[$i]+$r;
                
                
             }
       	}
//INVERSE OF MATRIX
        
    	 for($i = 1; $i <= $p; $i++)
     	{
     		for($j = 1; $j <= $p; $j++)
        	{
        		if($i == $j)
            	{
            		$b[$i][$j]=1;
            	}
            	else
            	{
                	$b[$i][$j]=0;
            	}
        	}
     	}
        for($i = 1; $i <= $p; $i++)
        {
            for($k=1; $k<=$p; $k++)
            {
                 $b[$i][$k];
            }
        }
 //IMP
         
        for($k = 1; $k <= $p; $k++)
        {
            for($i = $k+1; $i <= $p; $i++)
            {
                $q = $multi[$i][$k];
                for($j = 1; $j <= $p; $j++)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                   
                }
            }
        }
        
//checking for determinant to be 0
        
        for($i = 1; $i <= $p; $i++)
        {        
	        if($b[$i][$i] == 0)
            {
                ?>
                <script>
                    alert("Non Singular Matrix");
                    //document.location = "RegrMod.php";
                </script>
                <?php
            }
            //echo "<BR>";
       	}   
        
        for($k = $p; $k >0; $k--)
        {
            for($i = $k-1; $i > 0; $i--)
            {
                $q = $multi[$i][$k];
                for($j = $p; $j >= 1; $j--)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                   
                }
              
            }
        }
       	
        
        for($i = 1; $i <= $p; $i++)
        {
            $q = $multi[$i][$i];
            for($k=1; $k<=$p; $k++)
            {
                $b[$i][$k] = ($b[$i][$k] / $q);
                $multi[$i][$k] = ($multi[$i][$k] / $q);
               
            }
        }
        
        
        
        	   //matrix b is xtx-1
        
	   	for($i=1;$i<=$p;$i++)
       	{
    	   for($j=1;$j<=$p;$j++)
           {
	           $t=0;
               $t=$b[$i][$j]*$multiXTY[$j];
               $ans[$i]=$ans[$i]+$t;
              
           }
            
    	}
/*		
      for($j=1;$j<=$p;$j++){
      $ans[$j]=round($ans[$j],4);
      
      }
       
 */ 
      
		
//ESTIMATED VALUE OF OUTPUTS
      
	  for($i=1;$i<=$m_finalrow;$i++)
      {
      		$output[$i]=1;
      }
      
      for($i=1;$i<=$m_finalrow;$i++)
       {
        	for($j=2;$j<=$p;$j++)
            {

                $t=1;
                
                $t=exp($X[$i][$j]*$ans[$j]);
            
                $output[$i] = $output[$i]*$t;
                
             }
       }
       
       $ans[1]=exp($ans[1]);
       // echo $ans[1];
       for($i=1;$i<=$m_finalrow;$i++)
       {
      		 $output[$i]=$ans[1]*$output[$i];
      		 // echo $output[$i]=round($output[$i],4);
       }
       
// standard variables

      for ($i = 2; $i <= $m_finalrow; $i++)
      {         
       		$Y[$i][$m_RegrDepdVar]=$Y1[$i][$m_RegrDepdVar];
       
      }
       
       
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	$Res[$i]=$Y[$i+1][$m_RegrDepdVar]-$output[$i];
        	 
      	}
      
      	// standard variables
      	$deltaSum = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
            $deltaSum += $Res[$j]*$Res[$j] ;
        }
            
      	$deltaSum1=$deltaSum/($m_finalrow-$p);
       	$deltaRoot = sqrt($deltaSum1);   
                 
        //
        
        for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$stdres[$j]=$Res[$j]/$deltaRoot;
        }

 // for r square value
          
       for ($i = 2; $i <= $m_finalrow+1; $i++)
       {
           $SumC += $Y[$i][$m_RegrDepdVar];          
       }
       $avg = $SumC / $m_finalrow;
       
       $deltaSum2 = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$deltaPro1 =  ($avg-$Y[$j+1][$m_RegrDepdVar]) * ($avg-$Y[$j+1][$m_RegrDepdVar]);
            $deltaSum2 += $deltaPro1;
        }

	    $v=$deltaSum/$deltaSum2;
    	$r_sqr=1-$v;
      
// fot t value
      
      	for($i = 1; $i <= $p; $i++)
        {
            $msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
        }

        for($i = 1; $i <= $p; $i++)
        {
            $t_value[$i]=$ans[$i]/$msemse[$i];
        }

        $pdf->Cell(200,10,' Coefficients ',1,0,'C');
        $pdf->Ln(); //new row
    	$pdf->Cell(50,10,' ',1,0,'C');
    	$pdf->Cell(50,10,'Estimate',1,0,'C');
    	$pdf->Cell(50,10,'Standard Error of Estimate',1,0,'C');
    	$pdf->Cell(50,10,'T-Stat',1,0,'C');
     	$pdf->Ln(); //new row
     	
      	
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
            		$pdf->Cell(50,10,"Intercept",1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],6),1,0,'C');
    				$pdf->Cell(50,10,$t_value[$i],1,0,'C');
     				$pdf->Ln(); //new row
            }
            else
            {
            		$pdf->Cell(50,10,$m_TripMtx[1][$m_RegrInpdVar[$k]],1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($t_value[$i],6),1,0,'C');
     				$pdf->Ln(); //new row
                  	$k++;
            }
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
      
      	$k=1;
      	
      	$pdf->Write(0, "Equation :", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(); //new row
        $pdf->Write(0, $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]." = ".round($ans[$k],4)."  * ", '', 0, 'L', false, 0, false, false, 0);
      	
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
             	$pdf->Write(0, "exp(".round($ans[$k],4).")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") *", '', 0, 'L', false, 0, false, false, 0);
                
             }
             elseif($i <= $p-3)
             {
             	$pdf->Write(0, "exp(".round($ans[$k],4).")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") *", '', 0, 'L', false, 0, false, false, 0);
                
             }
             else
             {
             	$pdf->Write(0, "exp(".round($ans[$k],4).")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")", '', 0, 'L', false, 0, false, false, 0);
             }
             $k++;
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
     
      	$pdf->Cell(200,10,'Estimated output values ',1,0,'C');
      	$pdf->Ln(); //new row
      	$pdf->Cell(50,10,'Output variables ',1,0,'C');
      	$pdf->Cell(50,10,'Yi',1,0,'C');
      	$pdf->Cell(50,10,'Residuals',1,0,'C');
      	$pdf->Cell(50,10,'Standard Deviation',1,0,'C');
      	$pdf->Ln(); //new row
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{       
      		$pdf->Cell(50,10,'Y'.$i,1,0,'C'); 
      		$pdf->Cell(50,10,round($output[$i],4),1,0,'C'); 
      		$pdf->Cell(50,10,round($Res[$i],4),1,0,'C');
      		$pdf->Cell(50,10,round($stdres[$i],4),1,0,'C');       
        	$pdf->Ln(); //new row
      	}
    	$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
	
    }	
	if($m_RegrType=="Logarithmic")
	{
		echo $m_RegrType." Regression";
		$m_finalrow=$m_finalrow-1;
	    for ($i = 1; $i <= $m_finalrow; $i++)
        {                
        		$X[$i][1] =  1;    
        		     
       	}
        $k=1;
        $m=0;
	    for ($j = 0; $j < $SelectCol; $j++)
        {
            	$k++;
            	$m=0;
            	for ($i = 2; $i <= $m_finalrow+1; $i++)
            	{
                	$m++;       
                	$X[$m][$k] =  log($m_TripMtx[$i][$m_RegrInpdVar[$j]]);
                }
        }
        $p = $SelectCol + 1;

        
	    for ($j = 1; $j <= $p; $j++)
        {
            for ($i = 1; $i <= $m_finalrow; $i++)
            {                
                $X_t[$j][$i]=$X[$i][$j] ;
            }
        }
        
         for($i=1;$i<=$p;$i++)
        {
            for($j=1;$j<=$m_finalrow;$j++)
            {
                for($k=1;$k<=$p;$k++)
                {
                    $s=0;
                    $s=$X_t[$i][$j]*$X[$j][$k];
                   	$multi[$i][$k]=$multi[$i][$k]+$s;
                   	
				     
                }
            }
        }
        


 //multiplication  of XT and Y
                  
        for($i=1;$i<=$p;$i++)
        {
             for($j=1;$j<=$m_finalrow;$j++)
             {
             	$r=0;
               	$r=$X_t[$i][$j]*$Y[$j+1][$m_RegrDepdVar];
                $multiXTY[$i]=$multiXTY[$i]+$r;
                
             }
       	}
//INVERSE OF MATRIX
        
    	 for($i = 1; $i <= $p; $i++)
     	{
     		for($j = 1; $j <= $p; $j++)
        	{
        		if($i == $j)
            	{
            		$b[$i][$j]=1;
            	}
            	else
            	{
                	$b[$i][$j]=0;
            	}
        	}
     	}
        for($i = 1; $i <= $p; $i++)
        {
            for($k=1; $k<=$p; $k++)
            {
                 $b[$i][$k];
            }
        }
 //IMP
         
        for($k = 1; $k <= $p; $k++)
        {
            for($i = $k+1; $i <= $p; $i++)
            {
                $q = $multi[$i][$k];
                for($j = 1; $j <= $p; $j++)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                   
                }
            }
        }
        
//checking for determinant to be 0
        
        for($i = 1; $i <= $p; $i++)
        {        
	        if($b[$i][$i] == 0)
            {
                ?>
                <script>
                    alert("Non Singular Matrix");
                    //document.location = "RegrMod.php";
                </script>
                <?php
            }
            //echo "<BR>";
       	}   
        
        for($k = $p; $k >0; $k--)
        {
            for($i = $k-1; $i > 0; $i--)
            {
                $q = $multi[$i][$k];
                for($j = $p; $j >= 1; $j--)
                {
                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                   
                }
              
            }
        }
       	
        
        for($i = 1; $i <= $p; $i++)
        {
            $q = $multi[$i][$i];
            for($k=1; $k<=$p; $k++)
            {
                $b[$i][$k] = ($b[$i][$k] / $q);
                $multi[$i][$k] = ($multi[$i][$k] / $q);
            }
        }
        
        
        
        	   //matrix b is xtx-1
        
	   	for($i=1;$i<=$p;$i++)
       	{
    	   for($j=1;$j<=$p;$j++)
           {
	           $t=0;
               $t=$b[$i][$j]*$multiXTY[$j];
               $ans[$i]=$ans[$i]+$t;
               
              
           }
            
    	}
/*		
      for($j=1;$j<=$p;$j++){
      $ans[$j]=round($ans[$j],4);
      
      }
       
 */ 
      
		
//ESTIMATED VALUE OF OUTPUTS

      for($i=1;$i<=$m_finalrow;$i++)
       {
        	for($j=1;$j<=$p;$j++)
            {

                $t=0;
                $t=$X[$i][$j]*$ans[$j];
                $output[$i] = $output[$i]+$t;
                 
             }
       }
       

// standard variables

       
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	$Res[$i]=$Y[$i+1][$m_RegrDepdVar]-$output[$i];
        	 
      	}
      
      	// standard variables
      	$deltaSum = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
            $deltaSum += $Res[$j]*$Res[$j] ;
        }
            
      	$deltaSum1=$deltaSum/($m_finalrow-$p);
       	$deltaRoot = sqrt($deltaSum1);   
                 
        //
        
        for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$stdres[$j]=$Res[$j]/$deltaRoot;
        }

 // for r square value
          
       for ($i = 2; $i <= $m_finalrow+1; $i++)
       {
           $SumC += $Y[$i][$m_RegrDepdVar];          
       }
       $avg = $SumC / $m_finalrow;
       
       $deltaSum2 = 0;
      	for ($j = 1; $j <= $m_finalrow; $j++)
        {     
        	$deltaPro1 =  ($avg-$Y[$j+1][$m_RegrDepdVar]) * ($avg-$Y[$j+1][$m_RegrDepdVar]);
            $deltaSum2 += $deltaPro1;
        }

	    $v=$deltaSum/$deltaSum2;
    	$r_sqr=1-$v;
      
// fot t value
      
      	for($i = 1; $i <= $p; $i++)
        {
            $msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
        }

        for($i = 1; $i <= $p; $i++)
        {
            $t_value[$i]=$ans[$i]/$msemse[$i];
        }
 
        $pdf->Cell(200,10,' Coefficients ',1,0,'C');
        $pdf->Ln(); //new row
    	$pdf->Cell(50,10,' ',1,0,'C');
    	$pdf->Cell(50,10,'Estimate',1,0,'C');
    	$pdf->Cell(50,10,'Standard Error of Estimate',1,0,'C');
    	$pdf->Cell(50,10,'T-Stat',1,0,'C');
     	$pdf->Ln(); //new row
     	
      	
      	$k=0;
      	for ($i = 1; $i <= $p-3; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
            		$pdf->Cell(50,10,"Intercept",1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],6),1,0,'C');
    				$pdf->Cell(50,10,$t_value[$i],1,0,'C');
     				$pdf->Ln(); //new row
            }
            else
            {
            		$pdf->Cell(50,10,$m_TripMtx[1][$m_RegrInpdVar[$k]],1,0,'C');
    				$pdf->Cell(50,10,round($ans[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($msemse[$i],6),1,0,'C');
    				$pdf->Cell(50,10,round($t_value[$i],6),1,0,'C');
     				$pdf->Ln(); //new row
                  	$k++;
            }
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
      
      	$k=1;
      	
      	$pdf->Write(0, "Equation :", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(); //new row
        $pdf->Write(0, $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]." = ".round($ans[$k],4)."  + ", '', 0, 'L', false, 0, false, false, 0);
      	
      	$k++;
      	for ($i = 0; $i <= $p-3; $i++)
      	{
            if($i==0)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")ln(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") +", '', 0, 'L', false, 0, false, false, 0);
                
             }
             elseif($i <= $p-4)
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")ln(".$m_TripMtx[1][$m_RegrInpdVar[$i]].") +", '', 0, 'L', false, 0, false, false, 0);
                
             }
             else
             {
             	$pdf->Write(0, "(".round($ans[$k],4).")ln(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")", '', 0, 'L', false, 0, false, false, 0);
             }
             $k++;
      	}
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	$pdf->Ln(); //new row
      	
     
      	$pdf->Cell(200,10,'Estimated output values ',1,0,'C');
      	$pdf->Ln(); //new row
      	$pdf->Cell(50,10,'Output variables ',1,0,'C');
      	$pdf->Cell(50,10,'Yi',1,0,'C');
      	$pdf->Cell(50,10,'Residuals',1,0,'C');
      	$pdf->Cell(50,10,'Standard Deviation',1,0,'C');
      	$pdf->Ln(); //new row
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{       
      		$pdf->Cell(50,10,'Y'.$i,1,0,'C'); 
      		$pdf->Cell(50,10,round($output[$i],4),1,0,'C'); 
      		$pdf->Cell(50,10,round($Res[$i],4),1,0,'C');
      		$pdf->Cell(50,10,round($stdres[$i],4),1,0,'C');       
        	$pdf->Ln(); //new row
      	}
    	$pdf->Ln(); //new row
    	$pdf->Ln(); //new row
	
	}	
}
		//------------------------------------------------------------------------------------------
if($m_AnalysisVar == "DataAna")
{

	$pdf->Output("user/".$UploadFile.'/Experiment2/'.$m_DataChoiceVar.date("Ymdhms").'.pdf',"F");
}
elseif($m_AnalysisVar == "RegrAna")
{
	$pdf->Output("user/".$UploadFile.'/Experiment2/'.RegrAna.date("Ymdhms").'.pdf',"F");
}
//============================================================+
// END OF FILE
//============================================================+

?>


