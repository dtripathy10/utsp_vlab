<?php
session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
//include "userchk.php";	//To check user's session

// To Create Report into Excel File 

header("Content-type: application/vnd.ms-excel");
$filename = "DoublyConstrainedGravityModel_" . date('YMd') . ".xls"; 
header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Disposition: attachment;Filename=document_name.xls");

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   	

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

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
?>


<!DOCTYPE HTML>
<html>
<body>

<h2> Doubly Constrained Gravity Model </h2>

<?php

//----------------------- Reading Xls file -------------------------------------
if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{

	// Cost File

	require_once 'phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($UploadFile."/Experiment6/".$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$n=$dataBaseF->sheets[0]['numRows'];

?>

	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b> Base Year O-D Cost Matrix </b></caption>
<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
       	echo "<td ><b>".$i."</b></td>";
	}
	//echo "<td>Origin Total</td>";
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
   		// $sumR[$i]=0;
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{      
        	echo "<td bgcolor='#EBF5FF'>";       

        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	echo $m_BaseMtx[$i][$j];    
        	echo "</td>";           
    	}
    	echo "</tr>"; 
	}
?>
	</table>

	<br><br>

<?php
       
      // Origin File
      
        $dataOriginF = new Spreadsheet_Excel_Reader();
        $dataOriginF->setOutputEncoding('CP1251');
        //$dataOriginF->read('base_matrix.xls');
        $dataOriginF->read($UploadFile."/Experiment6/".$m_OriginFile);
        error_reporting(E_ALL ^ E_NOTICE);
  
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Origins Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo '</tr>';
       
        $sumorigin=0;
        for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        {       
            echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            {
                echo '<td>';
                  //echo $dataOriginF->sheets[0]['cells'][$i][$j];
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                echo $m_OriginMtx[$i][$j];
                 $sumorigin += $m_OriginMtx[$i][$j];
                echo "</td>";
             }   
             echo "</tr>";  
             $err[$i] = 99;          
        }
       
      
        echo "</table></div><br><br>";
       
		 // Destination File
      
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        //$dataDestF->read('base_matrix.xls');
        $dataDestF->read($UploadFile."/Experiment6/".$m_DestFile);
        error_reporting(E_ALL ^ E_NOTICE);

        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Destinations Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo '</tr>';
       
        $m_TotalSum=0;
        for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        {
            echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               {
                   echo "<td>";  
                   //echo $dataDestF->sheets[0]['cells'][$i][$j];
                   $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                   echo $m_DestMtx[$i][$j];
                   $djk[$j] = $m_DestMtx[$i][$j];               
                   $m_TotalSum += $m_DestMtx[$i][$j];
                   echo "</td>";  
            }
            echo "</tr>"; 
           
        }
        echo "</table></div><br><br>";
        
        
}
//---------------------------------------------------------------------------------

//---------------------------- Reading csv file ---------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
{

	// Cost File
	
    $nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment6/".$m_CostFile;
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

	?>

	<div id="scroller">
	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b>Base Year O-D Cost Matrix </b></caption>
	<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $n; $i++)
	{
       echo "<td ><b>".$i."</b></td>";
	}
	for ($i = 1; $i <= $n; $i++)
	{
   		echo '<tr align="center"><td bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{      
        	echo "<td bgcolor='#EBF5FF'>";       
        	echo $m_BaseMtx[$i][$j];    
        	echo "</td>";           
    	}
    	echo "</tr>"; 
	}
	?>
	</table>
	</div>

	<br><br>

	<?php
       
	// Origin File
		
	
		$nCol = 0; 
		$OriRow = 0;
		$name = $UploadFile."/Experiment6/".$m_OriginFile;
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
		$sumorigin=0;
        echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Origins Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo '</tr>';
        for ($i = 1; $i <= $OriRow; $i++)
        {       
            echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            for ($j = 1; $j <= $nCol; $j++)
            {
                echo '<td>';
                echo $m_OriginMtx[$i][$j];
                echo "</td>";
                 $sumorigin += $m_OriginMtx[$i][$j];
               }   
               echo "</tr>";  
               $err[$i] = 99;          
        }
       
      
        echo "</table></div><br><br>";
        
        // Destination File 
            
			$nCol = 0; 
			$DestRow = 0;
			$name = $UploadFile."/Experiment6/".$m_DestFile;
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


        echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Destinations Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo '</tr>';
       
        $m_TotalSum=0;
        for ($i = 1; $i <= $DestRow; $i++)
        {
            echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            for ($j = 1; $j <= $nCol; $j++)
               {
                   echo "<td>";
                   echo $m_DestMtx[$i][$j];
                   $djk[$j] = $m_DestMtx[$i][$j];               
                   $m_TotalSum += $m_DestMtx[$i][$j];
                   echo "</td>";  
            }
            echo "</tr>"; 
           
        }
        echo "</table></div><br><br>";
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
         echo '<h4> Impedance Function used : Power function </h4>[<font size=3 color="#990000"><b>F<sub>ij</sub> =  C<sub>ij</sub><sup>'.$m_txtBeta.'</sup><B></font>]<br><br>';
         echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
         echo '<tr align="center" bgcolor="#CCE6FF">';
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {               
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = pow($m_BaseMtx[$i][$j],$m_txtBeta);
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
            echo "</table></div><br><br>";
        
    }
    elseif($m_FunctionsVal == "ExponentialFun")
    {
    	// Calculation for Exponential Function	
    	
       $m_txtBeta = $_POST['txtBeta'];
       
        if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}
       echo '<h4> Impedance Function used : Exponential function </h4>[<font size=3 color="#990000"><B>F<sub>ij</sub> =  e<sup>-('.$m_txtBeta.')C<sub>ij</sub></sup><B></font>]<br><br>';
       echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
            echo "<tr align='center' bgcolor='#CCE6FF'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {               
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = exp(-(($m_txtBeta)*($m_BaseMtx[$i][$j])));
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
        echo "</table></div><br><br>";      
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
		echo '<h4> Impedance Function used : Gamma function </h4>[<font size=3 color="#990000"><B>F<sub>ij</sub> =  e<sup>-('.$m_txtBeta1.')C<sub>ij</sub></sup> C<sub>ij</sub><sup>'.$m_txtBeta2.'</sup><B></font>]<br><br>';
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
        echo "<tr align='center' bgcolor='#CCE6FF'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = ((exp(-($m_txtBeta1)*($m_BaseMtx[$i][$j]))) * (pow($m_BaseMtx[$i][$j],-($m_txtBeta2))));
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
        echo "</table></div><br><br>";   
       
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
        echo '<h4> Impedance Function used : Linear function </h4>[<font size=3 color="#990000"><B>F<sub>ij</sub> =  '.$m_txtBeta1.'+'. $m_txtBeta1.'C<sub>ij</sub><B></font>]<br><br>';
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Impedance Matrix Calculations </b></caption>';
        echo "<tr align='center'bgcolor='#CCE6FF'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><b>".$i."</b></td>";
                for ($j = 1; $j <= $n; $j++)
                {               
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = ($m_txtBeta1 + ($m_txtBeta2 * $m_BaseMtx[$i][$j]));
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
            echo "</table></div><br><br>";
            
                     
    }
     echo "<h3><b>Selected Accuracy : ".$m_AccuracyVal." Cell <b></h3><br>";
     echo "<h3><b>Entered Accuracy Level (i.e., percentage of error): ".$m_txtAccuracy." %<b></h3><br><br>";
 
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
                 if($errOri[$j] > $m_txtAccuracy || $errDest[$j] > $m_txtAccuracy)
               {
                      $m_a=1;                      
               }                                          
           }           
      }
      else if($m_AccuracyVal == "All")
      {
      	// Accuracy Level All
      	
           if($erra > $m_txtAccuracy)
           {
                $m_a=1;
           }     
      }      
      if($m_a)
      {
            $itr++;

            echo "<h3>Iteration &nbsp;# ".$itr."</h3>";
           
 
        //  echo "iteration no. ".$itr++."<br>";
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
            
        
            echo"<table border=1 cellspacing=1 align='center' width='100%' height='25%'>";
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo"<td>i</td>
           		<td>j</td>
           		<td >Bj</td>
           		<td>Dj</td>
           		<td>fcij</td>
           		<td>BjDjfcij</td>
           		<td>sumBjDjFcij</td>
           		<td>Ai</td>";
            echo "</tr>";
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		echo "<tr>";
            		echo "<td>".$i."</td><td>".$j."<td>".$Bj[$i]."</td><td>".$m_DestMtx[1][$j]."</td><td>".$ImpCost[$i][$j]."</td><td>".$BjDjFcij[$i][$j] ."</td><td>".$sumBjDjFcij[$i]."<td>".$Ai[$i]."</td>";
            		echo "</tr>";
            	}
            	
            }
            echo "</table>";
           echo "<br><br><br><br>";
     
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
           
      
            echo"<table border=1 cellspacing=1 align='center' width='100%' height='25%'>";
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo"<td>i</td>
           		<td>j</td>
           		<td >Ai</td>
           		<td>Oi</td>
           		<td>fcij</td>
           		<td>AiOifcij</td>
           		<td>sumAiOiFcij</td>
           		<td>Bj</td>";
            echo "</tr>";
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		echo "<tr>";
            		echo "<td>".$i."</td><td>".$j."<td>".$Ai[$j]."</td><td>".$m_OriginMtx[1][$j]."</td><td>".$ImpCost[$i][$j]."</td><td>".$AiOiFcij[$i][$j]."</td><td>".$sumAiOiFcij[$i]."<td>".$Bj[$i]."</td>";
            		echo "</tr>";
            	}
            	
            }
            echo "</table>";
           echo "<br><br><br><br>";
        
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
            

           
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b>O-D Matrix [T<sub>ij</sub>] </b></caption>';
            echo "<tr align='center'>";
            echo'<td  bgcolor="#CCE6FF"><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td  bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
            }          
            echo '<td bgcolor="#B8DBFF"><b>Oi</b></td><td bgcolor="#B8DBFF"><b>New Oi</b></td></tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {   
                    echo "<td bgcolor='#EBF5FF'>".round($T[$i][$j],4)."</td>";
                }   
                echo "<td bgcolor='#B8DBFF'><b>".$m_OriginMtx[1][$i]."</b></td>";  
                echo "<td bgcolor='#B8DBFF'><b>".$sumOi[$i]."</b></td>";         
                echo "</tr>";
            }
            echo '<tr><td bgcolor="#B8DBFF"><b>Dj</b></td>';
            for ($i = 1; $i <= $n; $i++)
            {
            	 echo "<td bgcolor='#B8DBFF'><b>".$m_DestMtx[1][$i]."</b></td>"; 
            }
            echo '</tr><tr><td bgcolor="#B8DBFF"><b>New Dj</b></td>';
      		for ($i = 1; $i <= $n; $i++)
            {
            	 echo "<td bgcolor='#B8DBFF'><b>".$sumDj[$i]."</b></td>"; 
            }
            echo "</tr></table>";

       
            
                     
            $erra=0;
            for ($i = 1; $i <= $n; $i++)
            {
             	 	$errOri[$i] = abs((($m_OriginMtx[1][$i] - $sumOi[$i]) * 100) / $m_OriginMtx[1][$i]);
              		$errDest[$i] = abs((($m_DestMtx[1][$i] - $sumDj[$i]) * 100) / $m_DestMtx[1][$i]);
              		$sum = $sumorigin + $m_TotalSum;
              		$erra = abs((($m_OriginMtx[1][$i] - $sumOi[$i])+($m_DestMtx[1][$i] - $sumDj[$i])*100)/$sum);              
            }  
                       
        }       
  }while($m_a==1  && $itr<$itrbrk);

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
                echo "<h3>Final Result</h3>";
                echo "<br>";
        }
        else
        {
        		echo "<h3>Iteration &nbsp;# ".$itr."</h3>";
                echo "<br><br>";
        }
          
                    
            echo"<table border=1 cellspacing=1 align='center' width='100%' height='25%'>";
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo"<th>i</th>
           		<th>j</th>
           		<th>B<sub>j</sub></th>
           		<th>D<sub>j</sub></th>
           		<th>f(C<sub>ij</sub>)</th>
           		<th>B<sub>j</sub>D<sub>j</sub>f(C<sub>ij</sub>)</th>
           		<th>&sum;B<sub>j</sub>D<sub>j</sub>f(C<sub>ij</sub>)</th>
           		<th>A<sub>i</sub> = 1/&sum;B<sub>j</sub>D<sub>j</sub>f(C<sub>ij</sub>)</th>";
            echo "</tr>";
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		echo "<tr>";
            		echo "<td>".$i."</td><td>".$j."<td>".$Bj[$i]."</td><td>".$m_DestMtx[1][$j]."</td><td>".$ImpCost[$i][$j]."</td><td>".$BjDjFcij[$i][$j] ."</td><td>".$sumBjDjFcij[$i]."<td>".$Ai[$i]."</td>";
            		echo "</tr>";
            	}
            	
            }
            echo "</table>";
           echo "<br><br><br><br>";

            echo"<table border=1 cellspacing=1 align='center' width='100%' height='25%'>";
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo"<th>i</th>
           		<th>j</th>
           		<th>A<sub>i</sub></th>
           		<th>O<sub>i</sub></th>
           		<th>f(C<sub>ij</sub>)</th>
           		<th>A<sub>i</sub>O<sub>i</sub>f(C<sub>ij</sub>)</th>
           		<th>&sum;A<sub>i</sub>O<sub>i</sub>f(C<sub>ij</sub>)</th>
           		<th>B<sub>j</sub> = 1/&sum;A<sub>i</sub>O<sub>i</sub>f(C<sub>ij</sub>)</th>";
            echo "</tr>";
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		echo "<tr>";
            		echo "<td>".$i."</td><td>".$j."<td>".$Ai[$j]."</td><td>".$m_OriginMtx[1][$j]."</td><td>".$ImpCost[$i][$j]."</td><td>".$AiOiFcij[$i][$j]."</td><td>".$sumAiOiFcij[$i]."<td>".$Bj[$i]."</td>";
            		echo "</tr>";
            	}
            	
            }
            echo "</table>";
           echo "<br><br><br><br>";
            

                       
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b>O-D Matrix [T<sub>ij</sub>] </b></caption>';
            echo "<tr align='center'>";
            echo'<th  bgcolor="#CCE6FF"><b>Zone</b></th>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<th  bgcolor="#CCE6FF"><b>'.$i.'</b></th>';
            }          
            echo '<th bgcolor="#B8DBFF"><b>Oi</b></th><th bgcolor="#B8DBFF"><b>New Oi</b></th></tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><th  bgcolor='#CCE6FF'><B>".$i."</B></th>";
                for ($j = 1; $j <= $n; $j++)
                {   
                    echo "<td bgcolor='#EBF5FF'>".round($T[$i][$j],4)."</td>";
                }   
                echo "<td bgcolor='#B8DBFF'><b>".$m_OriginMtx[1][$i]."</b></td>";  
                echo "<td bgcolor='#B8DBFF'><b>".$sumOi[$i]."</b></td>";         
                echo "</tr>";
            }
            echo '<tr><th bgcolor="#B8DBFF"><b>Dj</b></th>';
            for ($i = 1; $i <= $n; $i++)
            {
            	 echo "<td bgcolor='#B8DBFF'><b>".$m_DestMtx[1][$i]."</b></td>"; 
            }
            echo '</tr><tr><th bgcolor="#B8DBFF"><b>New Dj</b></th>';
      		for ($i = 1; $i <= $n; $i++)
            {
            	 echo "<td bgcolor='#B8DBFF'><b>".$sumDj[$i]."</b></td>"; 
            }
            echo "</tr></table>";
    
  		if($itr < $itrbrk)
        {
                echo "<h3>No. of Iteration taken to reach final result : ".$itr."</h3>";
                echo "<br><br>";
        }
        else
        {
        		echo "<h3>Current Iteration &nbsp;# ".$itr."</h3>";
                echo "<br><br>";
        }
 
?>							
												

</body>
</html>
