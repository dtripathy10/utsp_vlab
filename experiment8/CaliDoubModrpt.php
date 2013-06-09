<?php
session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
include "userchk.php";	//To check user's session

// To Create Report into Excel File 

header("Content-type: application/vnd.ms-excel");
$filename = "CalibrationDoublyConstrainedGravityModel_" . date('YMd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   	  

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

$m_FunctionsVal = $_POST['FunctionsVal'];
$m_AccuracyVal = $_POST['AccuracyVal'];			
$m_txtAccuracy = $_POST['txtAccuracy'];  

$m_CostFile = $_POST['CostFile']; 
$m_TripFile = $_POST['TripFile']; 


//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));


if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="CaliDoubMod.php";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------	 
?>


<!DOCTYPE HTML>
<html>
<head>
</head>

<body bgcolor="#FFFFFF">
        <h2>Calibration Of Doubly Constrained Gravity Model</h2> 
<BR><BR>   

<?php


//--------------------- Reading Xls file -------------------------------------------------
if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{

	// Cost File

	require_once 'phpExcelReader/Excel/reader.php';
	$dataCostF = new Spreadsheet_Excel_Reader();
	$dataCostF->setOutputEncoding('CP1251');
	$dataCostF->read($UploadFile."/Experiment8/".$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$n=$dataCostF->sheets[0]['numRows'];

?>


	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b>Cost Matrix </b></caption>
<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
       echo "<td ><b>".$i."</b></td>";
	}
	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
 
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $dataCostF->sheets[0]['numCols']; $j++)
    	{     
        	echo "<td bgcolor='#EBF5FF'>";             
        	$m_CostMtx[$i][$j]=$dataCostF->sheets[0]['cells'][$i][$j];
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    echo "</tr>";
}
?>
</table>


<br><br>

<?php
      
	// Trip File
     
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        //$dataTripF->read('base_matrix.xls');
        $dataTripF->read($UploadFile."/Experiment8/".$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
 
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Given Base Year Trip Matrix </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>&nbsp;Zone&nbsp;</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[O<sub>i</sub>]&nbsp;</b></td>";
        echo '</tr>';      
       
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            echo '<tr align="center">';
            echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {
                echo '<td bgcolor="#EBF5FF">';               
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                echo $m_TripMtx[$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j];               
                echo "</td>";
               }  
               echo '<td bgcolor="#B8DBFF"><b>'.$OriginSum[$i].'</b></td>';
               echo "</tr>";                                  
        }
       
        echo "<tr align='center'>";
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[D<sub>j</sub>]&nbsp; </b></td>";
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
            echo "<td bgcolor='#B8DBFF'><b>".$Destsum[$j]."</b></td>";    
         }   
         echo "</tr>";      
         echo "</table><br><br>";
         
}
//----------------------------------------------------------------------------------


//-------------------------- Reading csv file ---------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' )
{
	// Cost File
	
 	$nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment8/".$m_CostFile;
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

?>

	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b>Cost Matrix </b></caption>
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
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    	echo "</tr>";
	}
?>
</table>


<br><br>

<?php

    // Trip File
    
    $nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment8/".$m_TripFile;
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

        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Given Base Year Trip Matrix </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>&nbsp;Zone&nbsp;</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[O<sub>i</sub>]&nbsp;</b></td>";
        echo '</tr>';      
       
        for ($i = 1; $i <= $n; $i++)
        {    
            echo '<tr align="center">';
            echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
                echo '<td bgcolor="#EBF5FF">';
                echo $m_TripMtx[$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j];               
                echo "</td>";
               }  
               echo '<td bgcolor="#B8DBFF"><b>'.$OriginSum[$i].'</b></td>';
               echo "</tr>";                                  
        }
       
        echo "<tr align='center'>";
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[D<sub>j</sub>]&nbsp; </b></td>";
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
            echo "<td bgcolor='#B8DBFF'><b>".$Destsum[$j]."</b></td>";    
         }   
         echo "</tr>";      
         echo "</table><br><br>";
    
    
}
            
//-------------------------------------------------------------------------------------------              
         
         if($m_FunctionsVal == "PowerFun")
         {
         	echo "<h3><b> Selected Frictional Functions : Power Function [<font size=3 color='#990000'><B>F<sub>ij</sub> =  C<sub>ij</sub><sup>&#946;</sup><B></font>] <b></h3><br>";
         }
         elseif ($m_FunctionsVal == "ExponentialFun")   
         {
         	echo "<h3><b> Selected Frictional Functions : Exponential Function [<font size=3 color='#990000'><B>F<sub>ij</sub> =  e<sup>-&#946;C<sub>ij</sub></sup><B></font>] <b></h3><br>";
         }
         
         echo "<h3><b>Selected Accuracy : ".$m_AccuracyVal." Cell <b></h3><br>";
         echo "<h3><b>Entered Accuracy Level (i.e., percentage of error): ".$m_txtAccuracy." %<b></h3><br><br>";

         
           $l = 1;
          
           //Beta
        for ($bt = 0.001; $bt < 1; $bt = $bt + 0.001)
        {
               $res[$l] = 0 ;
           
            if($m_FunctionsVal == "ExponentialFun")
            {
            	// Calculation for Exponential Function	 
            	
                for ($i = 1; $i <= $n; $i++)
                {               
                    for ($j = 1; $j <= $n; $j++)
                    {        
                          $fijk[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));                   
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
                          $fijk[$i][$j] = pow($m_CostMtx[$i][$j],$bt);                
                    }              
                }
            }
           
            for ($i = 1; $i <= $n; $i++)
            {
                $djk[$i] = $Destsum[$i];
                $err[$i] = 99;
            }
           $erra=99;  
            for ($m = 1; $m <= 10; $m++)
            {
              //  for ($k = 1; $k <= $n; $k++)
               // {
              //      if($err[$k] > $m_txtAccuracy)
             //          {
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
              	
                       if($erra > $m_txtAccuracy)
                     {
                            $m_a=1;
                      }     
             }      
             if($m_a)
              {
                    for ($i = 1; $i <= $n; $i++)
                    {            
                       for ($j = 1; $j <= $n; $j++)
                       {               
                             $d_fijk[$i][$j] = $djk[$j] * $fijk[$i][$j];                  
                       }   
                    }              

                    for ($i = 1; $i <= $n; $i++)
                    {
                         $djkfij[$i]=0;
                         for ($j = 1; $j <= $n; $j++)
                         {
                               $djkfij[$i] = $djkfij[$i] + $d_fijk[$i][$j];
                         }
                    }
                       
                    for ($i = 1; $i <= $n; $i++)
                    {                   
                         for ($j = 1; $j <= $n; $j++)
                         {
                                $tijk[$i][$j] = $OriginSum[$i] * $djk[$j] * $fijk[$i][$j] / $djkfij[$i];  //Tij TAKING ORIGIN CONSTRAINT
                         }
                   }
                       
                   for ($i = 1; $i <= $n; $i++)
                   {
                            $mdjk[$i]=0;
                            for ($j = 1; $j <= $n; $j++)
                            {
                                $mdjk[$i] = $mdjk[$i] + $tijk[$j][$i];   //MODELED Dj's
                            }
                    }
                       
                    for ($i = 1; $i <= $n; $i++)
                    {
                            $djk[$i] = $Destsum[$i] * $djk[$i] / $mdjk[$i];    //Dj's FOR NEXT ITERATION
                    }
                    for ($i = 1; $i <= $n; $i++)
                    {
                           $err[$i] = abs(($Destsum[$i] - $djk[$i]) / $Destsum[$i] * 100);   //DIFFERENCE IN TARGET ANS OBTAINED Dj's
                           $erra +=$err[$i];                          
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
                       $fijk[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));                   
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
                       $fijk[$i][$j] = pow($m_CostMtx[$i][$j],$bt);                
                   }              
               }
        }
       
        for ($i = 1; $i <= $n; $i++)
        {
            $djk[$i] = $Destsum[$i];
            $err[$i] = 99;       
        }
         $erra=99;       
        for ($m = 1; $m <= 10; $m++)
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
	              	
                       if($erra > $m_txtAccuracy)
                     {
                            $m_a=1;
                      }     
             }      
             if($m_a)
             {
                    for ($k = 1; $k <= $n; $k++)
                    {
                   if($err[$k] > $m_txtAccuracy)
                   {
                      for ($i = 1; $i <= $n; $i++)
                     {            
                           for ($j = 1; $j <= $n; $j++)
                           {               
                               $d_fijk[$i][$j] = $djk[$j] * $fijk[$i][$j];                  
                        }   
                       }              

                      for ($i = 1; $i <= $n; $i++)
                    {
                        $djkfij[$i]=0;
                        for ($j = 1; $j <= $n; $j++)
                        {
                            $djkfij[$i] = $djkfij[$i] + $d_fijk[$i][$j];
                        }
                    }
                       
                       for ($i = 1; $i <= $n; $i++)
                    {                   
                        for ($j = 1; $j <= $n; $j++)
                        {
                            $tijk[$i][$j] = $OriginSum[$i] * $djk[$j] * $fijk[$i][$j] / $djkfij[$i];  //Tij TAKING ORIGIN CONSTRAINT
                        }
                    }
                       
                       for ($i = 1; $i <= $n; $i++)
                    {
                        $mdjk[$i]=0;
                        for ($j = 1; $j <= $n; $j++)
                        {
                            $mdjk[$i] = $mdjk[$i] + $tijk[$j][$i];   //MODELED Dj's
                        }
                    }
                       
                           for ($i = 1; $i <= $n; $i++)
                        {
                            $djk[$i] = $Destsum[$i] * $djk[$i] / $mdjk[$i];    //Dj's FOR NEXT ITERATION
                        }

                        for ($i = 1; $i <= $n; $i++)
                        {
                            $err[$i] = abs(($Destsum[$i] - $djk[$i]) / $Destsum[$i] * 100);   //DIFFERENCE IN TARGET ANS OBTAINED Dj's
                            $erra +=$err[$i];
                        }               
                       }  
                }
            }
        }
          // Finding Origin & Destination Total
         
           for ($i = 1; $i <= $n; $i++)
        {
            $oik[$i] = 0;
            $djk[$i] = 0;
            for ($j = 1; $j <= $n; $j++)
            {
                $oik[$i] = $oik[$i] + $tijk[$i][$j];
                $djk[$i] = $djk[$i] + $tijk[$j][$i];
            }
        }
       
           //Output
          
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Trip Matrix with respect to Optimal Beta Value (Minimum SSE) </b></caption>';
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
                   echo "<td bgcolor='#EBF5FF'>".(int)$tijk[$i][$j]."</td>";          
            }
            echo "</tr>";
          }   
        echo "</table><br><br>";
       
        echo '<table border=1 cellspacing=1 align="center" width="80%" height="10%">';
        echo "<tr align='center'>";
        echo "<td bgcolor='#EBF5FF' width='50%'><b> Minimum Residual = ".$res_min." </b></td>";    
        echo "<td bgcolor='#EBF5FF' width='50%'><b> Optimal Beta = ".$b_opt." </b></td>";      
        echo "</tr>";      
          echo "</table><br><br>";
                  
          echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%">';
        echo "<tr align='center' bgcolor='#CCE6FF'>";
        echo "<TH> Target Oi</TH> <TH> Modelled Oi</TH> <TH> Target Dj</TH> <TH> Modelled Dj</TH>";    
           echo '</tr>';
          
           for ($i = 1; $i <= $n; $i++)
           {
               echo "<tr align='center'>";
                   echo "<td bgcolor='#EBF5FF'>".$OriginSum[$i]."</td>";
                   echo "<td bgcolor='#EBF5FF'>".$oik[$i]."</td>";
                   echo "<td bgcolor='#EBF5FF'>".$Destsum[$i]."</td>";
                   echo "<td bgcolor='#EBF5FF'>".$djk[$i]."</td>";   
            echo "</tr>";
          }   
        echo "</table><br><br>";
       
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%">';
        echo "<tr align='center' bgcolor='#CCE6FF'>";
        echo "<TH> Beta </TH> <TH> Residual SSE</TH>";    
           echo '</tr>';
          for ($i = 1; $i <= $nbt; $i++)
           {
               echo "<tr align='center'>";
               echo "<td bgcolor='#EBF5FF'>".$b[$i]."</td>";
               echo "<td bgcolor='#EBF5FF'>".$res[$i]."</td>";
               echo "</tr>";
          }   
        echo "</table><br><br>";
       
?>

<br>
</body>
</html>