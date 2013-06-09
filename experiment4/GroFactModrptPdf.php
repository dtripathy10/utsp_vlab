<?php
$m_MethodVal = $_POST['MethodVal'];			//To retrieve values of the selected method
$m_BaseFile = $_POST['BaseFile']; 	 

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Bombay');
$pdf->SetTitle('Experiment: Growth Factor Distribution Model');
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


$file_ext1 = substr($m_BaseFile, strripos($m_BaseFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}

//----------------------------------------------------------------------------------------------
date_default_timezone_set('Asia/Calcutta');
$datetoday = date("F j, Y, g:i a");




 //styling for normal non header cells
$pdf->SetTextColor(255,127,0);
$pdf->SetFont("dejavusans",'B');
$pdf->Write(0, 'Experiment No. 4 ', '', 0, 'L',false, 0, false, false, 0);
$pdf->Write(0, $datetoday, '', 0, 'R', true, 0, false, false, 0);

$pdf->Write(0, 'Trip Distribution : Growth Factor Distribution Model', '', 0, 'C', true, 0, false, false, 0);

    if($m_MethodVal == "UniformGFM")
    {
    	$pdf->Write(0, 'Uniform Growth Factor Method', '', 0, 'C', true, 0, false, false, 0);

    }
    elseif($m_MethodVal == "SinglyGFM")
    {
    	$pdf->Write(0, 'Singly Constrained Growth Factor Method', '', 0, 'C', true, 0, false, false, 0);
    }
    elseif($m_MethodVal == "FratarGFM")
    {
    	$pdf->Write(0, 'Fratar Growth Factor Method', '', 0, 'C', true, 0, false, false, 0);
    }

$pdf->Ln(); //new row
$pdf->Ln(); //new row
$pdf->SetTextColor(0); //black
$pdf->SetFont("times");
$pdf->SetTextColor(0,0,130);
//$pdf->FillColor(0,0,130);
$pdf->Write(0, 'Input Values : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(); //new row

//-------------------------------Reading Xls file-------------------------------------------------
if($file_ext1 == '.xls')
{
	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_BaseFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zones
	$nRow=$dataBaseF->sheets[0]['numRows'];
	$nCol=$dataBaseF->sheets[0]['numCols'];

	$pdf->Cell(((($nCol+1)*25)+35),10,' Origin-Destination Matrix For Base Year ',1,0,'C');
	$pdf->Ln(); //new row
	$pdf->Cell(35,10,' Zone ',1,0,'C');
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
       $pdf->Cell(25,10,$i,1,0,'C');
	}
	$pdf->Cell(25,10,' Origin Totals',1,0,'C');
	$pdf->Ln(); //new row
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
   		$sumR[$i]=0;
    	$pdf->Cell(35,10,$i,1,0,'C');
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{       
       		      
        	$sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];    
        	$pdf->Cell(25,10,$m_BaseMtx[$i][$j],1,0,'C');          
    	}
    	$pdf->Cell(25,10,$sumR[$i],1,0,'C'); 
		$pdf->Ln(); //new row
	}
	
	
	

	$pdf->Cell(35,10,' Destination Totals',1,0,'C');
	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    {
        $sumC[$j]=0;
        for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        {
            $sumC[$j] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];                     
        }
        $pdf->Cell(25,10,$sumC[$j],1,0,'C');   
        $m_TotalBaseSum += $sumC[$j];
    }  
    $pdf->Ln(); //new row
	$pdf->Ln(); //new row   
}
//-------------------------------------------------------------------------------
//-----------------------------Raeding csv file--------------------------------------------

elseif($file_ext1 == '.csv')
{
    $nCol = 0; 
	$nRow = 0;
	$name = $folder.$m_BaseFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Base[$nRow][$c] = $data[$c];
        	
     	}
     	$nRow++;
    
    }
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_BaseMtx[$i+1][$j+1] = $m_Base[$i][$j] ;      	
         }
    	
    }
    

	$pdf->Cell(((($nCol+1)*25)+35),10,' Origin-Destination Matrix For Base Year ',1,0,'C');
	$pdf->Ln(); //new row
	$pdf->Cell(35,10,' Zone ',1,0,'C');
	for ($i = 1; $i <= $nRow; $i++)
	{
    	   $pdf->Cell(25,10,$i,1,0,'C');
	}
	$pdf->Cell(25,10,' Origin Totals',1,0,'C');
	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	$pdf->Cell(35,10,$i,1,0,'C');
    	for ($j = 1; $j <= $nCol; $j++)
    	{          
        	$sumR[$i] += (double)$m_BaseMtx[$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$m_BaseMtx[$i][$j];
        	$pdf->Cell(25,10,$m_BaseMtx[$i][$j],1,0,'C');           
    	}
    	$pdf->Cell(25,10,$sumR[$i],1,0,'C');
    	$pdf->Ln(); //new row  
	}
	
	
	$pdf->Cell((($nCol+1)*25),10,' Destination Totals',1,0,'C');
	for ($j = 1; $j <=$nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$m_BaseMtx[$i][$j];                     
        	}
        	$pdf->Cell(25,10,$sumC[$j],1,0,'C');
    		$m_TotalBaseSum += $sumC[$j];
	} 
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row
	
fclose($file);

} 

//-----------------------------------------------------------------------------------

if($m_MethodVal == "UniformGFM")
{
    $m_txtGrowth = $_POST['txtGrowth'];
   
    $pdf->Write(0, "Growth Factor = ".$m_txtGrowth, '', 0, 'L', true, 0, false, false, 0);
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row
	$pdf->Ln(); //new row
	$pdf->Cell(((($nCol+1)*25)+35),10,' Uniform Growth Rate Matrix For Future Year ',1,0,'C');
	$pdf->Ln(); //new row
	
	$pdf->Cell(35,10,' Zone ',1,0,'C');
    for ($i = 1; $i <= $nRow; $i++)
    {
        $pdf->Cell(25,10,$i,1,0,'C');
    }
    $pdf->Cell(25,10,'Origin Totals',1,0,'C');
    $pdf->Ln(); //new row
    for ($i = 1; $i <= $nRow; $i++)
    {   
        $pdf->Cell(35,10,$i,1,0,'C');
        $SumUR[$i] = 0;
        for ($j = 1; $j <= $nRow; $j++)
        {     
            $UG[$i][$j] = $m_BaseMtx[$i][$j] * $m_txtGrowth;
            $SumUR[$i] += round($UG[$i][$j]);
            $pdf->Cell(25,10,(round($UG[$i][$j])),1,0,'C');
        }
        $pdf->Cell(25,10,$SumUR[$i],1,0,'C');    
        $pdf->Ln(); //new row      
    }
    $pdf->Cell(35,10,'Destination Totals',1,0,'C');  
    for ($j = 1; $j <= $nRow; $j++)
    {
        $sumUC[$j]=0;
        for ($i = 1; $i <= $nRow; $i++)
        {
            $sumUC[$j] += round($UG[$i][$j]);                    
        }
        $pdf->Cell(25,10,round($sumUC[$j]),1,0,'C');  
    }     
    $pdf->Ln(); //new row
    $pdf->Ln(); //new row      
    
}

elseif($m_MethodVal == "SinglyGFM")
{
    $m_ConstraintsVal = $_POST['ConstraintsVal'];

    if($m_ConstraintsVal=="SinglyOrigin")
    {
        $m_OriginFile = $_POST['OriginFile'];
        
        
        
        
//----------------------------------verifying the format of the file---------------------------



$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));


if(!($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------

 //------------------------------------------------xls file-------------------------------------       
        if($file_ext2 == '.xls')
		{ 
        	$dataOriginF = new Spreadsheet_Excel_Reader();
        	$dataOriginF->setOutputEncoding('CP1251');
        	//$dataOriginF->read('base_matrix.xls');
        	$dataOriginF->read($folder.$m_OriginFile);
        	error_reporting(E_ALL ^ E_NOTICE);
        	
        	$pdf->Cell((($nCol+1)*25),10,' Origin Totals For Future Year ',1,0,'C');
			$pdf->Ln(); //new row
			$pdf->Cell(25,10,' Zone ',1,0,'C');
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numCols']; $i++)
        	{
            	$pdf->Cell(25,10,$i,1,0,'C');
        	}
        	$pdf->Ln(); //new row
        	$pdf->Cell(25,10," ",1,0,'C');
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        	{          
            	for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            	{
                	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                	$pdf->Cell(25,10,$m_OriginMtx[$i][$j],1,0,'C');
                	$m_TotalSum += $m_OriginMtx[$i][$j];
               }
               $pdf->Ln(); //new row  
        }
        $pdf->Ln(); //new row  
        $pdf->Ln(); //new row  
	 }
//-------------------------------------------------csv-----------------------------------
	 elseif($file_ext2 == '.csv')
     {

        
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
        	$pdf->Cell((($nCol+1)*25),10,' Origin Totals For Future Year ',1,0,'C');
			$pdf->Ln(); //new row
			$pdf->Cell(25,10,' Zone ',1,0,'C');
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        	    $pdf->Cell(25,10,$i,1,0,'C');
        	}
        	$pdf->Ln(); //new row
        	$pdf->Cell(25,10," ",1,0,'C');
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	$pdf->Cell(25,10,$m_OriginMtx[$i][$j],1,0,'C');
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}               
            }
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row
        }
//---------------------------------------------------------------------------------------  

 		$pdf->Write(0, 'Growth Factor Calculations', '', 0, 'L', true, 0, false, false, 0);
 		
		$pdf->Ln(); //new row
		$pdf->Cell(25,10,' Zone ',1,0,'C');
		$pdf->Cell(50,10,' Future year Origin total ',1,0,'C');
		$pdf->Cell(50,10,' Base year Origin total ',1,0,'C');
		$pdf->Cell(75,10,' Growth Factor For Each Originating Zone ',1,0,'C');
		$pdf->Ln(); //new row
        
        for ($j = 1; $j <= $nRow; $j++)
        {
        	$pdf->Cell(25,10,$j,1,0,'C');
			$pdf->Cell(50,10,$m_OriginMtx[1][$j],1,0,'C');
			$pdf->Cell(50,10,$sumR[$j],1,0,'C');
			$GFOrigin[$j] = $m_OriginMtx[1][$j] / $sumR[$j];
			$pdf->Cell(75,10,round($GFOrigin[$j], 3),1,0,'C');
			$pdf->Ln(); //new row
        }            
        $pdf->Ln(); //new row
        $pdf->Ln(); //new row   
        $pdf->Ln(); //new row     

        $pdf->Cell((($nRow)*25+140),10,' Singly Constrained Growth Factor Matrix For Future Year ',1,0,'C');
		$pdf->Ln(); //new row
		$pdf->Cell(50,10,' Zone ',1,0,'C');
        for ($i = 1; $i <= $nRow; $i++)
        {
             $pdf->Cell(25,10,$i,1,0,'C');
        }
        $pdf->Cell(45,10,"Origins Total Base year ",1,0,'C');
        $pdf->Cell(45,10,"Origins Total Future year",1,0,'C');
        
        $pdf->Ln(); //new row
        for ($i = 1; $i <= $nRow; $i++)
        {  
            $SumOR[$i]=0;           
            $pdf->Cell(50,10,$i,1,0,'C');    
            for ($j = 1; $j <= $nRow; $j++)
            {        
                $UGOrigin[$i][$j] = $m_BaseMtx[$i][$j] * $GFOrigin[$i];
                $pdf->Cell(25,10,round($UGOrigin[$i][$j]),1,0,'C');
                $SumOR[$i]+=round($UGOrigin[$i][$j]);                
              }
              $pdf->Cell(45,10,$SumOR[$i],1,0,'C');
              $pdf->Cell(45,10,$m_OriginMtx[1][$i],1,0,'C');
               $pdf->Ln(); //new row
        }
         $pdf->Cell(50,10,"Destination Totals Base year",1,0,'C');
        for($i=1; $i <= $nRow; $i++)
        {        
            $SumOC[$i]=0;
              for($j=1; $j <= $nRow; $j++)
              {  
                   $SumOC[$i]+=round($UGOrigin[$j][$i]);
                   
              }
              $pdf->Cell(25,10,round($SumOC[$i]),1,0,'C');              
        }
        $pdf->Ln(); //new row;
        $pdf->Ln(); //new row     
    }
    elseif ($m_ConstraintsVal=="SinglyDest")
    {
    
    	$m_DestFile = $_POST['DestFile'];
       
    	
//----------------------------------verifying the format of the file---------------------------


$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------
//------------------------------------------------xls file-------------------------------------       
        if($file_ext3 == '.xls')
		{     	
        		$dataDestF = new Spreadsheet_Excel_Reader();
        		$dataDestF->setOutputEncoding('CP1251');
        		//$dataDestF->read('base_matrix.xls');
        		$dataDestF->read($folder.$m_DestFile);
       			error_reporting(E_ALL ^ E_NOTICE);
				
       			        	
        		$pdf->Cell((($nCol+1)*25),10,'Destination Totals For Future Year ',1,0,'C');
				$pdf->Ln(); //new row
				$pdf->Cell(25,10,' Zone ',1,0,'C');
        		for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        		{
        		    $pdf->Cell(25,10,$i,1,0,'C');
        		}
        		$pdf->Ln(); //new row
        
        		$m_TotalSum=0;
        		for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        		{
            		$pdf->Ln(); //new row
        			$pdf->Cell(25,10," ",1,0,'C');
            		for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               		{
                		$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                		$pdf->Cell(25,10,$m_DestMtx[$i][$j],1,0,'C');
                		$m_TotalSum += $m_DestMtx[$i][$j];
               		}
            		$pdf->Ln(); //new row  
        		}
        		$pdf->Ln(); //new row
        		$pdf->Ln(); //new row
		}
		//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext3 == '.csv')
		{ 
		
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
		
		
		
			$pdf->Cell((($nCol+1)*25),10,'Destination Totals For Future Year ',1,0,'C');
			$pdf->Ln(); //new row
			$pdf->Cell(25,10,' Zone ',1,0,'C');
        	for ($i = 1; $i <= $nCol; $i++)
        	{
            	$pdf->Cell(25,10,$i,1,0,'C');
        	}
        	$pdf->Ln(); //new row
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	$pdf->Cell(25,10," ",1,0,'C');
            	for ($j = 1; $j <= $nCol; $j++)
               	{
                	$pdf->Cell(25,10,$m_DestMtx[$i][$j],1,0,'C');
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	
            	}
           		$pdf->Ln(); //new row  
        	}
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row
		
		}
//---------------------------------------------------------------------------------
				$pdf->Write(0, 'Growth Factor Calculations', '', 0, 'L', true, 0, false, false, 0);
 				$pdf->Ln(); //new row
 				$pdf->Cell(25,10,' Zone ',1,0,'C');
				$pdf->Cell(50,10,' Future year Destination total ',1,0,'C');
				$pdf->Cell(50,10,' Base year Destination total ',1,0,'C');
				$pdf->Cell(75,10,' Growth Factor For Each Originating Zone ',1,0,'C');
				$pdf->Ln(); //new row
        		for ($j = 1; $j <= $nRow; $j++)
        		{
        			$pdf->Cell(25,10,$j,1,0,'C');
					$pdf->Cell(50,10,$m_DestMtx[1][$j],1,0,'C');
					$pdf->Cell(50,10,$sumC[$j],1,0,'C');
					$GFDest[$j] = $m_DestMtx[1][$j] / $sumC[$j];
					$pdf->Cell(75,10,round($GFDest[$j], 3),1,0,'C');
					$pdf->Ln(); 
        		}            
        		$pdf->Ln(); //new row
        		$pdf->Ln(); //new row  

        	$pdf->Cell((($nRow)*25+100),10,' Singly Constrained Growth Factor Matrix For Future Year ',1,0,'C');
			$pdf->Ln(); //new row
			$pdf->Cell(55,10,' Zone ',1,0,'C');
        	for ($i = 1; $i <= $nRow; $i++)
        	{
        			$pdf->Cell(25,10,$i,1,0,'C');
        	}
        	$pdf->Cell(45,10,"Origins Total Base year ",1,0,'C');
			$pdf->Ln(); //new row
        
        	for ($i = 1; $i <= $nRow; $i++)
        	{   
           		$SumDR[$i]=0;   
            	$pdf->Cell(55,10,$i,1,0,'C');
            	for ($j = 1; $j <= $nRow; $j++)
            	{    
                	$UGDest[$i][$j] = $m_BaseMtx[$i][$j] * $GFDest[$j];
                	$SumDR[$i] += round($UGDest[$i][$j]); 
                	$pdf->Cell(25,10,round($UGDest[$i][$j]),1,0,'C');
              	} 
              	$pdf->Cell(45,10,$SumDR[$i],1,0,'C');    
            	$pdf->Ln(); //new row;
        	}
        
        	$pdf->Cell(55,10,"Destinations Total Base year ",1,0,'C');
			
        	for($i=1; $i <= $nRow; $i++)
        	{
            	$SumDC[$i]=0;
              	for($j=1; $j <= $nRow; $j++)
              	{  
                   	$SumDC[$i] += round($UGDest[$j][$i]);
                   
              	}
              	$pdf->Cell(25,10,round($SumDC[$i]),1,0,'C');              
        	}
         	$pdf->Ln(); //new row
         	$pdf->Cell(55,10,"Destinations Total Future year ",1,0,'C');
			   
        	for($i=1; $i <= $nRow; $i++)
        	{	
        		$pdf->Cell(25,10,$m_DestMtx[1][$i],1,0,'C');
        	}
    	}
    	
}
elseif($m_MethodVal == "FratarGFM")
{
    
			$m_AccuracyVal = $_POST['AccuracyVal'];
		
			$m_txtAccuracy = $_POST['txtAccuracy'];
		
			$m_OriginFile = $_POST['OriginFile'];
		
			$m_DestFile = $_POST['DestFile'];
		
			$m_numItr = $_POST['numItr'];
       
	
		$itrbrk=$_POST['Itrbrk'];
		
		if(empty($itrbrk))
		{
		    $itrbrk=$_POST['Itrbrk'];
		    echo $itrbrk;
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
		
		
		
//----------------------------------verifying the format of the file---------------------------



$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------
//------------------------------------------------xls file-------------------------------------       
        if($file_ext2 == '.xls' && $file_ext3 == '.xls')
		{  
				$dataOriginF = new Spreadsheet_Excel_Reader();
        		$dataOriginF->setOutputEncoding('CP1251');
        		$dataOriginF->read($folder.$m_OriginFile);
        		error_reporting(E_ALL ^ E_NOTICE);
        		
        		        	
        	
        		$OriginCol = $dataOriginF->sheets[0]['numCols'];
        		$OriginRow = $dataOriginF->sheets[0]['numRows'];
        		
        		$pdf->Cell((($nCol+1)*25),10,' Origin Totals For Future Year ',1,0,'C');
				$pdf->Ln(); //new row
				$pdf->Cell(25,10,' Zone ',1,0,'C');
        		for ($i = 1; $i <= $nRow; $i++)
        		{
        			$pdf->Cell(25,10,$i,1,0,'C');
        		}
        		$pdf->Ln(); //new row
        		$pdf->Cell(25,10," ",1,0,'C');   
        		$m_TotalSum=0;
        		for ($i = 1; $i <= $OriginRow; $i++)
        		{
            
            		for ($j = 1; $j <= $OriginCol; $j++)
            		{
                		
                		$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                		$pdf->Cell(25,10,$m_OriginMtx[$i][$j],1,0,'C');
                		$m_TotalSum += $m_OriginMtx[$i][$j];
               		}
					$pdf->Ln(); //new row  
                 
        		}
        		$pdf->Ln(); //new row  
        		$pdf->Ln(); //new row  
       
        		$dataDestF = new Spreadsheet_Excel_Reader();
        		$dataDestF->setOutputEncoding('CP1251');
        		$dataDestF->read($folder.$m_DestFile);
        		error_reporting(E_ALL ^ E_NOTICE);
        		
        		$DestinationCol = $dataDestF->sheets[0]['numCols'];
				$DestinationRow = $dataDestF->sheets[0]['numRows'];

        		$pdf->Cell((($nCol+1)*25),10,'Destination Totals For Future Year ',1,0,'C');
				$pdf->Ln(); //new row
				$pdf->Cell(25,10,' Zone ',1,0,'C');
        		for ($i = 1; $i <= $nRow; $i++)
        		{
        		    $pdf->Cell(25,10,$i,1,0,'C');
        		}
        		$pdf->Ln(); //new row
        		$pdf->Cell(25,10," ",1,0,'C');
        		$m_TotalSum=0;
       			 for ($i = 1; $i <= $DestinationRow; $i++)
       			 {
            
            			for ($j = 1; $j <= $DestinationCol; $j++)
               			{
                			$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                			$pdf->Cell(25,10,$m_DestMtx[$i][$j],1,0,'C');
                			$m_TotalSum += $m_DestMtx[$i][$j];  
            			}
            	$pdf->Ln(); //new row  
        		}
       			$pdf->Ln(); //new row; 

		}

//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext2 == '.csv' && $file_ext3 == '.csv')
		{

		           
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

        	$pdf->Cell((($nCol+1)*25),10,' Origin Totals For Future Year ',1,0,'C');
			$pdf->Ln(); //new row
			$pdf->Cell(25,10,' Zone ',1,0,'C');
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        	    $pdf->Cell(25,10,$i,1,0,'C');
        	}
        	$pdf->Ln(); //new row
        	$pdf->Cell(25,10," ",1,0,'C');
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	$pdf->Cell(25,10,$m_OriginMtx[$i][$j],1,0,'C');
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}               
            }
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row

        	
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
		
		
			$pdf->Cell((($nCol+1)*25),10,'Destination Totals For Future Year ',1,0,'C');
			$pdf->Ln(); //new row
			$pdf->Cell(25,10,' Zone ',1,0,'C');
        	for ($i = 1; $i <= $nCol; $i++)
        	{
            	$pdf->Cell(25,10,$i,1,0,'C');
        	}
        	$pdf->Ln(); //new row
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	$pdf->Cell(25,10," ",1,0,'C');
            	for ($j = 1; $j <= $nCol; $j++)
               	{
                	$pdf->Cell(25,10,$m_DestMtx[$i][$j],1,0,'C');
                	$m_TotalSum += $m_DestMtx[$i][$j];  
            	}
           		$pdf->Ln(); //new row  
        	}
        	$pdf->Ln(); //new row
        	$pdf->Ln(); //new row		
		}	      			
   
		$pdf->Write(0, "Selected Accuracy : ".$m_AccuracyVal." Cell ", '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0, "Entered Accuracy Level (i.e., percentage of error): ".$m_txtAccuracy." % ", '', 0, 'L', true, 0, false, false, 0);   
        $TotalBaseSumR=0;
        for ($i = 1; $i <= $nRow; $i++)
        {
            $sumRD[$i]=$sumR[$i];
            $sumCD[$i]=$sumC[$i];
            $TotalFutureR +=$m_OriginMtx[1][$i];
            $TotalBaseSumR+=$sumR[$i];          
        }
       
        $itr=0;
     
	
           
        do
        {  
           if($m_AccuracyVal=="Individual")
            {
            	for ($j = 1; $j <= $nRow; $j++)
            	{
                 	$m_a=(((($m_OriginMtx[1][$j]-$sumRD[$j])*100)/$sumRD[$j])> $m_txtAccuracy || ((($m_DestMtx[1][$j]-$sumCD[$j])*100)/$sumCD[$j])> $m_txtAccuracy);
            	}
            }
            else
            {                        
                 $m_a= ((($TotalFutureR-$TotalBaseSumR)*100)/$TotalBaseSumR)>$m_txtAccuracy;               
            }       
            if($m_a)
            {            	           	
                $itr++;
                $pdf->Write(0, "Iteration # ".$itr, '', 0, 'C', true, 0, false, false, 0);
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $sumRD[$k]=0;                
                     for ($l = 1; $l <= $nRow; $l++)
                     {                         
                        $sumRD[$k] += $m_BaseMtx[$k][$l];            
                     }          
                   }
          
                for ($l = 1; $l <= $nRow; $l++)
                {
                       $a[$l]=($m_OriginMtx[1][$l] / $sumRD[$l]);                     
                }   
      
                
        		$pdf->Cell((($nRow)*25+140),10,' Fratar Growth Factor Matrix For Future Year ',1,0,'C');
				$pdf->Ln(); //new row
				$pdf->Cell(50,10,' Zone ',1,0,'C');	
                for ($i = 1; $i <= $nRow; $i++)
                {
                    $pdf->Cell(25,10,$i,1,0,'C');
                }      
        		$pdf->Cell(45,10,"Origins Total Base year ",1,0,'C');
       			$pdf->Cell(45,10,"Origins Total Future year",1,0,'C');     
				$pdf->Ln(); //new row
                for ($k = 1; $k <= $nRow; $k++)
                {          
                    $pdf->Cell(50,10,$k,1,0,'C');    

                    $SumDobR1[$k]=0;  
                    
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           $s[$k][$l] = $m_BaseMtx[$k][$l] * $a[$k];
                           $SumDobR1[$k] += $s[$k][$l];  
                           $pdf->Cell(25,10,round($s[$k][$l],3),1,0,'C'); 
                    }   
                    $pdf->Cell(45,10,round($SumDobR1[$k],3),1,0,'C');
                    $pdf->Cell(45,10,$m_OriginMtx[1][$k],1,0,'C');
                    $pdf->Ln(); //new row        
                }
             
                $pdf->Cell(50,10,"Destinations Total Base year",1,0,'C');
               
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC1[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC1[$k] += $s[$l][$k];;                   
                      }
                      $pdf->Cell(25,10,(round($SumDobC1[$k],3)),1,0,'C');     
                }
				$pdf->Ln(); //new row  
				  
              	$pdf->Cell(50,10,"Destination Total Future year",1,0,'C');
                 for ($l = 1; $l<= $nRow; $l++)
                 {
                 		$pdf->Cell(25,10,$m_DestMtx[1][$l],1,0,'C');  
                 }
                $pdf->Ln(); //new row  
                $pdf->Ln(); //new row 
            
                for ($l = 1; $l<= $nRow; $l++)
                {
                    $sumCD[$l]=0;
                    for ($k = 1; $k <= $nRow; $k++)
                    {
                        $sumCD[$l] += $s[$k][$l];                    
                    } 
                }
 
                for ($l = 1; $l <= $nRow; $l++)
                {
                      $b[$l]=$m_DestMtx[1][$l] / $sumCD[$l];                     
                }              
        		$pdf->Cell((($nRow)*25+140),10,' Fratar Growth Factor Matrix For Future Year ',1,0,'C');
				$pdf->Ln(); //new row
				$pdf->Cell(50,10,' Zone ',1,0,'C');
                for ($i = 1; $i <= $nRow; $i++)
                {
                    $pdf->Cell(25,10,$i,1,0,'C');
                }  
                $pdf->Cell(45,10,"Origin Totals Base Year",1,0,'C');
                $pdf->Cell(45,10,"Origins Total Future year",1,0,'C'); 
               	$pdf->Ln(); //new row
                 
                for ($l = 1; $l <= $nRow; $l++)
                {
                    $pdf->Cell(50,10,$l,1,0,'C'); 
                    $SumDobR2[$l]=0; 
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        $t[$k][$l] = $s[$l][$k] * $b[$k];  
                        $SumDobR2[$l] += $t[$k][$l]; 
                        $pdf->Cell(25,10,round($t[$k][$l],3),1,0,'C');  
                    }  
                    $pdf->Cell(45,10,round($SumDobR2[$l],3),1,0,'C');  
                    $pdf->Cell(45,10,$m_OriginMtx[1][$l],1,0,'C');
                    $pdf->Ln(); //new row;  
                            
                }
               
                $pdf->Cell(50,10," Destination Total Base year",1,0,'C');
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC2[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC2[$k] += $t[$k][$l];;                   
                      }
                       $pdf->Cell(25,10,round($SumDobC2[$k],3),1,0,'C');     
                }
                 $pdf->Ln(); //new row;
                 $pdf->Cell(50,10,"Destination Total Future year",1,0,'C');  
                 for ($l = 1; $l<= $nRow; $l++)
                 {
                  		$pdf->Cell(25,10,$m_DestMtx[1][$l],1,0,'C');
                 }
                  $pdf->Ln(); //new row
                  $pdf->Ln(); //new row
                
                
                     $TotalBaseSumC=0;
                     $TotalBaseSumR=0;
                     $TotalFutureC=0;
                     $TotalFutureR=0;
                for ($k = 1; $k <= $nRow; $k++)
                {
                     $TotalBaseSumC +=$SumDobC2[$k];
                     $TotalBaseSumR +=$SumDobR2[$k];
                     $TotalFutureC  +=$m_DestMtx[1][$k];
                     $TotalFutureR  +=$m_OriginMtx[1][$k];
                }
           
                for ($k = 1; $k <= $nRow; $k++)
                {                       
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                        $m_BaseMtx[$k][$l] = round($t[$l][$k]);  
                                           
                    }                       
                }                  
               $pdf->Ln(); //new row
               $pdf->Ln(); //new row
               $pdf->Ln(); //new row
               $pdf->Ln(); //new row
              
            }          
        }while($m_a==1 && $itr < $itrbrk && $itr < $m_numItr);  
//-------------------------------------------------------------------------------------------------------------------

    
        
        do
        {  
           if($m_AccuracyVal=="Individual")
            {
            	for ($j = 1; $j <= $nRow; $j++)
            	{
                 	$m_a=(((($m_OriginMtx[1][$j]-$sumRD[$j])*100)/$sumRD[$j])> $m_txtAccuracy || ((($m_DestMtx[1][$j]-$sumCD[$j])*100)/$sumCD[$j])> $m_txtAccuracy);
            	}
            }
            else
            {                        
                 $m_a= ((($TotalFutureR-$TotalBaseSumR)*100)/$TotalBaseSumR)>$m_txtAccuracy;               
            }       
            if($m_a)
            {            	           	
                $itr++;
                								                            

                for ($k = 1; $k <= $nRow; $k++)
                {
                    $sumRD[$k]=0;                
                     for ($l = 1; $l <= $nRow; $l++)
                     {                         
                        $sumRD[$k] += $m_BaseMtx[$k][$l];            
                     }          
                   }
          
                for ($l = 1; $l <= $nRow; $l++)
                {
                       $a[$l]=($m_OriginMtx[1][$l] / $sumRD[$l]);                     
                }   

                for ($k = 1; $k <= $nRow; $k++)
                {          
               

                    $SumDobR1[$k]=0;  
                    
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           $s[$k][$l] = $m_BaseMtx[$k][$l] * $a[$k];
                           $SumDobR1[$k] += $s[$k][$l];  
                           
                    }   

                }
               	
                
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC1[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC1[$k] += $s[$l][$k];;                   
                      }
                           
                }
				
              
                
               
                for ($l = 1; $l<= $nRow; $l++)
                {
                    $sumCD[$l]=0;
                    for ($k = 1; $k <= $nRow; $k++)
                    {
                        $sumCD[$l] += $s[$k][$l];                    
                    } 
                }

                for ($l = 1; $l <= $n; $l++)
                {
                      $b[$l]=$m_DestMtx[1][$l] / $sumCD[$l];                     
                }              

                
                for ($l = 1; $l <= $nRow; $l++)
                {
                   
                    $SumDobR2[$l]=0; 
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        $t[$k][$l] = $s[$l][$k] * $b[$k];  
                        $SumDobR2[$l] += $t[$k][$l];                       
                            
                    }  
                
                            
                }
                
                 
               
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC2[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC2[$k] += $t[$k][$l];;                   
                      }
                        
                }
                
               
                
                     $TotalBaseSumC=0;
                     $TotalBaseSumR=0;
                     $TotalFutureC=0;
                     $TotalFutureR=0;
                for ($k = 1; $k <= $nRow; $k++)
                {
                     $TotalBaseSumC +=$SumDobC2[$k];
                     $TotalBaseSumR +=$SumDobR2[$k];
                     $TotalFutureC  +=$m_DestMtx[1][$k];
                     $TotalFutureR  +=$m_OriginMtx[1][$k];
                }
           
                for ($k = 1; $k <= $nRow; $k++)
                {                       
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                        $m_BaseMtx[$k][$l] = round($t[$l][$k]);  
                                           
                    }                       
                }                  
               
            }          
        }while($m_a==1 && $itr < $itrbrk );  
        
        
        
//-------------------------------------------------------------------------------------------------------------------
        
        
	     
        if($itr < $itrbrk)
        {
        		$pdf->Write(0, "Final Result", '', 0, 'L', true, 0, false, false, 0);
        		$pdf->Ln(); //new row
            	$pdf->Ln(); //new row
               
        }
        else
        {
        		$pdf->Write(0, "Iteration # ".$itr, '', 0, 'C', true, 0, false, false, 0);
                $pdf->Ln(); //new row
        		
        }
        $pdf->Cell((($nRow)*25+140),10,' Fratar Growth Factor Matrix For Future Year ',1,0,'C');
		$pdf->Ln(); //new row
		$pdf->Cell(50,10,' Zone ',1,0,'C');
		for ($i = 1; $i <= $nRow; $i++)
        {
                $pdf->Cell(25,10,$i,1,0,'C');
        }      
        $pdf->Cell(45,10,"Origin Totals Base Year",1,0,'C');
        $pdf->Cell(45,10,"Origins Total Future year",1,0,'C'); 
        $pdf->Ln(); //new row
        for ($k = 1; $k <= $nRow; $k++)
        {          
        		$pdf->Cell(50,10,$k,1,0,'C');
				for ($l = 1; $l <= $nRow; $l++)
                {
                           $pdf->Cell(25,10,round($s[$k][$l],3),1,0,'C');    
                    }   
                    $pdf->Cell(45,10,round($SumDobR1[$k],3),1,0,'C'); 
                    $pdf->Cell(45,10,$m_OriginMtx[1][$k],1,0,'C'); 
                    $pdf->Ln(); //new row  
                }
               
                // S
                $pdf->Cell(50,10," Destination Total Base year",1,0,'C');
                for ($k = 1; $k <= $nRow; $k++)
                {
                	  $pdf->Cell(25,10,round($SumDobC1[$k],3),1,0,'C');              
                }
                $pdf->Ln(); //new row 
                $pdf->Cell(50,10," Destination Total Future year",1,0,'C');
                for ($l = 1; $l<= $nRow; $l++)
                {
                	  $pdf->Cell(25,10,$m_DestMtx[1][$l],1,0,'C'); 
                }
                $pdf->Ln(); //new row 
                $pdf->Ln(); //new row 


 				$pdf->Cell((($nRow)*25+140),10,' Fratar Growth Factor Matrix For Future Year ',1,0,'C');
				$pdf->Ln(); //new row
				$pdf->Cell(50,10,' Zone ',1,0,'C');
                for ($i = 1; $i <= $nRow; $i++)
                {
                    $pdf->Cell(25,10,$i,1,0,'C');
                }      
                $pdf->Cell(45,10,"Origin Totals Base Year",1,0,'C');
                $pdf->Cell(45,10,"Origins Total Future year",1,0,'C'); 
               	$pdf->Ln(); //new row
                
                
                for ($l = 1; $l <= $nRow; $l++)
                {
                    $pdf->Cell(50,10,$l,1,0,'C'); 
                    for ($k = 1; $k <= $nRow; $k++)
                    {  
                    	$pdf->Cell(25,10,round($t[$k][$l],3),1,0,'C');     
                    }  
                    $pdf->Cell(45,10,round($SumDobR2[$l],3),1,0,'C');  
                    $pdf->Cell(45,10,$m_OriginMtx[1][$l],1,0,'C');
                    $pdf->Ln(); //new row;        
                }
                $pdf->Cell(50,10," Destination Total Base year",1,0,'C');
                for ($k = 1; $k <= $nRow; $k++)
                {
                	  $pdf->Cell(25,10,round($SumDobC2[$k],3),1,0,'C');            
                }
                $pdf->Ln(); //new row;
                $pdf->Cell(50,10,"Destination Total Future year",1,0,'C');
                for ($l = 1; $l<= $nRow; $l++)
                {
                	  $pdf->Cell(25,10,$m_DestMtx[1][$l],1,0,'C');
                }
                $pdf->Ln(); //new row
                $pdf->Ln(); //new row
                
                $pdf->Write(0, "No. of Iteration taken to reach final result : ".$itr, '', 0, 'L', true, 0, false, false, 0);
                $pdf->Ln(); //new row
                $pdf->Ln(); //new row
               
    }   
if($m_MethodVal == "SinglyGFM")
{
	$pdf->Output($folder.$m_ConstraintsVal.date("Ymdhms").'.pdf',"F");
}
else 
{
	$pdf->Output($folder.$m_MethodVal.date("Ymdhms").'.pdf',"F");
}
//============================================================+
// END OF FILE
//============================================================+
?>
