<?php
session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
include "userchk.php";	//To check user's session

// To Create Report into Excel File 

header("Content-type: application/vnd.ms-excel");
$filename = "CalibrationSinglyConstrainedGravityModel_" . date('YMd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   	  

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

$m_FunctionsVal = $_POST['FunctionsVal'];
$m_MethodVal = $_POST['MethodVal'];			
$m_CostFile = $_POST['CostFile']; 
$m_TripFile = $_POST['TripFile']; 
	 

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
?>

<!DOCTYPE HTML>
<html>
<head>
</head>

<body bgcolor="#FFFFFF">
        <?php
    if($m_MethodVal == "SinglyOrigin")
    {
          ?>
          <h2>Calibration Of Singly Constrained Gravity Model (Origin)</h2>
          <?php
    }
    elseif($m_MethodVal == "SinglyDest")
    {
        ?>
        <h2>Calibration Of Singly Constrained Gravity Model (Destination)</h2>
        <?php
    }   
  ?>
<BR><BR>   

<?php

//---------------------- Reading Xls file -----------------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{
	// Cost File

	require_once 'phpExcelReader/Excel/reader.php';
	$dataCostF = new Spreadsheet_Excel_Reader();
	$dataCostF->setOutputEncoding('CP1251');
	$dataCostF->read($UploadFile."/Experiment7/".$m_CostFile);
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
        $dataTripF->read($UploadFile."/Experiment7/".$m_TripFile);
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
            echo '<tr align="center" bgcolor="#EBF5FF">';
            echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {
                echo '<td >';               
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
//---------------------------------------------------------------------------------

//------------------------- Reading csv file --------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' )
{
	// Cost File

    $nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment7/".$m_CostFile;
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
	$name = $UploadFile."/Experiment7/".$m_TripFile;
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
            echo '<tr align="center" bgcolor="#EBF5FF">';
            echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
                echo '<td >';               
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

	if($m_FunctionsVal == "PowerFun")
    {
      	echo "<h3><b> Selected Frictional Functions : Power Function [<font size=3 color='#990000'><B>F<sub>ij</sub> =  C<sub>ij</sub><sup>&#946;</sup><B></font>] <b></h3><br>";
    }
    elseif ($m_FunctionsVal == "ExponentialFun")   
    {
     	echo "<h3><b> Selected Frictional Functions : Exponential Function [<font size=3 color='#990000'><B>F<sub>ij</sub> =  e<sup>-&#946;C<sub>ij</sub></sup><B></font>] <b></h3><br>";
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
         
                  for ($j = 1; $j <= $n; $j++)
                   {
                          $sumTC[$j]=0;   
                        for ($i = 1; $i <= $n; $i++)
                        {
                            $sumTC[$j] += $tijk[$j][$i];                  
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
               echo "<td bgcolor='#EBF5FF'>".$sumTR[$i]."</td>";
               echo "<td bgcolor='#EBF5FF'>".$Destsum[$i]."</td>";
               echo "<td bgcolor='#EBF5FF'>".$sumTC[$i]."</td>";   
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