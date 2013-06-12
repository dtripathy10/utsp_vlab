<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4,"Regression Analysis","Trip Generation");

  ?>
<div id="body">
<?
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment2/";
$m_TripFile =$_SESSION['TripFile'];
if(empty($m_TripFile))
{
	$m_TripFile =$_POST['TripFile'];
}
$m_AnalysisVar = $_POST['AnalysisVar'];
	


$file_ext1= substr($m_TripFile, strripos($m_TripFile, '.'));	
if($file_ext1 == '.xls' )
{

	// Trip File		

     	require_once EXCELREADER.'/Excel/reader.php';
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $nRow = $dataTripF->sheets[0]['numRows'];
        $nCol = $dataTripF->sheets[0]['numCols'];
 
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {  
                for ($j = 1; $j <= $dataTripF->sheets[0]['numRows']; $j++)
        		{       
        			$m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
        		} 
        } 
}      
elseif($file_ext1 == '.csv' )
{

 	$nCol=0; 
	$nRow = 0;
	$name = $folder.$m_TripFile;
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
        
        
}      
  
      
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
            			           	
            		}
            		else 
            		{	
                 		$reg[$i][$j] =  $sump[$j][$i]/($deltaRoot[$j]*$deltaRoot[$i]);
            		}
        		}
        	}

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

	}
	}
	elseif($m_AnalysisVar == "RegrAna")
	{
		$ans =  $_SESSION['ANS'];
		
for($i=1;$i<=count($ans);$i++)
{
	$coefficients[$i-1] =  $_SESSION['ANS'][$i];
}

$m_RegrType = $_SESSION['RegrType'];
$m_Dep =  $_SESSION['RegrDepdVar'];
$m_InDep =  $_SESSION['RegrInpdVar'];
$m_type=$_SESSION['Type'] ;

for($i=0;$i<=count($m_InDep);$i++)
{
	$m_Independent[$i]=  $_SESSION['RegrInpdVar'][$i];
	
}
if($m_type == "Linear")
{

	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <=count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]+$m_TripMtx[$i][$m_Independent[$j]]*$coefficients[$k];
			$k++;
		}
		
	}
}
if($m_RegrType == "Quadratic")
{

	
		$counted = count($m_InDep);
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <$counted; $j++)
		{
			
			$m_trip[$i]=$m_trip[$i]+$m_TripMtx[$i][$m_Independent[$j]]*$coefficients[$k];
			$k++;
		}
		for ($j = 0; $j <$counted; $j++)
		{
			
			$m_trip[$i]=$m_trip[$i]+pow($m_TripMtx[$i][$m_Independent[$j]],2)*$coefficients[$k];
			$k++;
			
		}
	}

}
if($m_RegrType == "Power")
{

	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]*(pow($m_TripMtx[$i][$m_Independent[$j]],$coefficients[$k]));
			$k++;
		}
	}
	
	
}
if($m_RegrType == "Exponential")
{

	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]*exp($coefficients[$k]*$m_TripMtx[$i][$m_Independent[$j]]);
			$k++;
		}

	}
	
	
}
if($m_RegrType == "Logarithmic")
{

	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]+log($m_TripMtx[$i][$m_Independent[$j]])*$coefficients[$k];
			$k++;
		}
	}

	
}
		
	
	}



include("DataRegrModRptpdf.php");
include("AddDataRegrRpt.php");
	
	
?> 

<form enctype="multipart/form-data" method="post" name="Frm">
<h1><font color="Black" size="4"><b>Data Successfully added to the Report.</b></font></br>
<br>
<a href='../user/<?php echo $UploadFile?>/Experiment2/DataRegr.xls' target="new"><font color="#800000" size="2"><b>Click to Download Overall Report(.xls)</b></font></a>
 </br><br>
<a href='abcd.php?Exp=2'  target="new"><font color="#800000" size="2"><b>Click to Download Overall Report(.pdf)</b></font></a>
</br><br>
<a href = DataRegrMod2.php?TripFile=<?php echo $m_TripFile ?>><font color="#800000" size="2"><b>Go back to experiment</b></font></a>
</form>


</div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 	