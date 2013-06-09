<?php
session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
include "userchk.php";	//To check user's session

// To Create Report into Excel File 

header("Content-type: application/vnd.ms-excel");
$filename = "SinglyConstrainedGravityModel_" . date('YMd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   	  

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_POST['CostFile']; 
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];  




//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="SigGravMod.php";
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
          <h2>Singly Constrained Gravity Model (Origin)</h2>
          <?php
    }
    elseif($m_MethodVal == "SinglyDest")
    {
        ?>
        <h2>Singly Constrained Gravity Model(Destination)</h2>
        <?php
    }    
  ?>
<BR><BR>   

<?php

//------------------------------ Reading Xls file ----------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{

	// Cost File

	require_once 'phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($UploadFile."/Experiment5/".$m_CostFile);
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
       		// $sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	echo $m_BaseMtx[$i][$j];     
        	echo "</td>";            
    	}
    	//echo '<td>';
    	//echo $sumR[$i];
    	//echo "</td></tr>";   
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
        $dataOriginF->read($UploadFile."/Experiment5/".$m_OriginFile);
        error_reporting(E_ALL ^ E_NOTICE);
   
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Origins Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo '</tr>';
        
        //$m_TotalSum=0;
        for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        {        
            echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            {
                echo '<td>';
                  //echo $dataOriginF->sheets[0]['cells'][$i][$j];
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                echo $m_OriginMtx[$i][$j];
                //$m_TotalSum += $m_OriginMtx[$i][$j];
                echo "</td>";
               }    
               echo "</tr>";             
        }
        echo "</table><br><br>";
        
        // Destination File 
       
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        //$dataDestF->read('base_matrix.xls');
        $dataDestF->read($UploadFile."/Experiment5/".$m_DestFile);
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
                $m_TotalSum += $m_DestMtx[$i][$j];
                  echo "</td>";   
            }
            echo "</tr>";  
        }
        echo "</table><br><br>";
        
        }
//---------------------------------------------------------------------------------

//---------------------------- Reading csv file -----------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
{
	// Cost File
    $nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment5/".$m_CostFile;
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

	
	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b> Base Year O-D Cost Matrix </b></caption>
	<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $nCol; $i++)
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
	<br>

	<?php

	// Origin File
	
			$nCol = 0; 
			$OriRow = 0;
			$name = $UploadFile."/Experiment5/".$m_OriginFile;
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

        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Origins Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $nCol; $i++)
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
               }    
               echo "</tr>";             
        }
        echo "</table><br>";
        
        // Destination File 
               
			$nCol = 0; 
			$DestRow = 0;
			$name = $UploadFile."/Experiment5/".$m_DestFile;
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
        

        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Future Year Destinations Total </b></caption>';
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
                	$m_TotalSum += $m_DestMtx[$i][$j];
                 	 echo "</td>";   
            }
            echo "</tr>";  
        }
        echo "</table><br>";
        
//-----------------------------------------------------------------------------
}     
?>

<?php 

		if($m_FunctionsVal == "PowerFun")
         {
         	echo "<h3><b> Selected Impedence Functions : Power Function [<font size=3 color='#990000'><B>F<sub>ij</sub> = C<sub>ij</sub><sup>".$_POST['txtBeta']."</sup><B></font>] <b></h3><br>";
         	//echo "<h3><b>Entered &#946; value : ".$_POST['txtBeta']." <b></h3><br><br>";
         }
         elseif ($m_FunctionsVal == "ExponentialFun")   
         {
         	echo "<h3><b> Selected Impedence Functions : Exponential Function [<font size=3 color='#990000'><B>F<sub>ij</sub> = e<sup>-(".$_POST['txtBeta'].")C<sub>ij</sub></sup><B></font>] <b></h3><br>";
         	//echo "<h3><b>Entered &#946; value : ".$_POST['txtBeta']." <b></h3><br><br>";
         }
         elseif ($m_FunctionsVal == "GammaFun")   
         {
         	echo "<h3><b> Selected Impedence Functions : Gamma Function [<font size=3 color='#990000'><B>F<sub>ij</sub> = e<sup>-(".$_POST['txtBeta1'].")C<sub>ij</sub></sup> C<sub>ij</sub><sup>".$_POST['txtBeta2']."</sup><B></font>] <b></h3><br>";
         	//echo "<h3><b>Entered &#946;<sub>1</sub> value : ".$_POST['txtBeta1']." <b></h3><br><br>";
         	//echo "<h3><b>Entered &#946;<sub>2</sub> value : ".$_POST['txtBeta2']." <b></h3><br><br>";
         }
         elseif ($m_FunctionsVal == "LinearFun")   
         {
         	echo "<h3><b> Selected Impedence Functions : Linear Function [<font size=3 color='#990000'><B>F<sub>ij</sub> = ".$_POST['txtBeta1']." + ".$_POST['txtBeta2']."C<sub>ij</sub><B></font>] <b></h3><br>";
         	//echo "<h3><b>Entered &#946;<sub>1</sub> value : ".$_POST['txtBeta1']." <b></h3><br><br>";
         	//echo "<h3><b>Entered &#946;<sub>2</sub> value : ".$_POST['txtBeta2']." <b></h3><br><br>";
         }                   
?>

<?php                
    if($m_FunctionsVal == "PowerFun")
    {
    	// Calculation for Power Function	
    	
        $m_txtBeta = $_POST['txtBeta'];
       
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
            
            echo "</table><br><br>";
       
    }
    elseif($m_FunctionsVal == "ExponentialFun")
    {
       // Calculation for Exponential Function	
       
    		$m_txtBeta = $_POST['txtBeta'];
 
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
            
        echo "</table><br><br>";       
         
    }    
    elseif($m_FunctionsVal == "GammaFun")
    {
        // Calculation for Gamma Function	
        
    	$m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
     
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
            
        echo "</table><br><br>";    
      
    }
    elseif($m_FunctionsVal == "LinearFun")
    {
    	// Calculation for Linear Function	
    	
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        
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
            
            echo "</table><br><br>";
    }
?>

<?php        
        if($m_MethodVal == "SinglyOrigin")
        {         
        	// Calculation for Singly Constrained Gravity Model (Origin) 
        
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> [D<sub>j</sub>][F<sub>ij</sub>] </b></caption>';
            echo "<tr align='center'>";
            echo'<td  bgcolor="#CCE6FF"><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            }           
            echo '<td bgcolor="#B8DBFF"><b>&#8721;[D<sub>j</sub>][F<sub>ij</sub>]</b></td></tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><b>".$i."</b></td>";
                $sumR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $DF[$i][$j] = $m_DestMtx[1][$j] * $ImpCost[$i][$j];         
                    $sumR[$i] += $DF[$i][$j];  
                    echo "<td bgcolor='#EBF5FF'>".round($DF[$i][$j],4)."</td>";
                }     
                echo "<td bgcolor='#B8DBFF'><b>".round($sumR[$i],4)."</b></td>";  
                echo "</tr>";
            }
            
            echo "</table><br><br>";   
              
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Interaction Probabilities [Pr<sub>ij</sub>] </b></caption>';
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo'<td><B>Zone</B></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><B>'.$i.'</B></td>';
            }           
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $PR[$i][$j] = $DF[$i][$j] / $sumR[$i];               
                    echo "<td bgcolor='#EBF5FF'>".round($PR[$i][$j],4)."</td>";
                }             
                echo "</tr>";
            }
            
            echo "</table><br><br>";   
            
            ?>
                      
            <?php 
            
        	echo '<h2>Final Result</h2><br>';
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> O-D Matrix [T<sub>ij</sub>] </b></caption>';
            echo "<tr align='center'>";
            echo'<td  bgcolor="#CCE6FF"><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td  bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
            }           
            echo '<td bgcolor="#B8DBFF"><b>&#8721;[D<sub>j</sub>][F<sub>ij</sub>]</b></td><td bgcolor="#B8DBFF"><b>Future year Origins Total</b></td></tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  bgcolor='#CCE6FF'><B>".$i."</B></td>";
                $sumTR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $T[$i][$j] = $m_OriginMtx[1][$i] * $PR[$i][$j];      
                    $sumTR[$i] += $T[$i][$j];                 
                    echo "<td bgcolor='#EBF5FF'>".round($T[$i][$j],4)."</td>";
                }    
                echo "<td bgcolor='#B8DBFF'><b>".$sumTR[$i]."</b></td>";           
                echo "<td bgcolor='#B8DBFF'><b>".$m_OriginMtx[1][$i]."</b></td>";  
                echo "</tr>";
            }
        
           /* echo "<tr align='center'>";
            echo "<td bgcolor='#B8DBFF'><b>&#8721;[O<sub>i</sub>][F<sub>ij</sub>]</b></td>";   
            for ($j = 1; $j <= $n; $j++)
            {
                $sumTC[$j]=0;   
                for ($i = 1; $i <= $n; $i++)
                {
                    $sumTC[$j] += $T[$i][$j];                  
                   }
                   echo "<td bgcolor='#B8DBFF'><b>".round($sumTC[$j],4)."</b></td>";      
            }     
             echo "</tr>";      */    
            echo "</table><br><br>";
            
        }
        
        elseif($m_MethodVal == "SinglyDest")
        {
        	// Calculation for Singly Constrained Gravity Model (Destination) 	
        
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B> [O<sub>i</sub>][F<sub>ij</sub>] </B></caption>';
            echo "<tr align='center'>";
            echo'<td  bgcolor="#CCE6FF"><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            }

            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><b>".$i."</b></td>";
                for ($j = 1; $j <= $n; $j++)
                {             
                    $OF[$i][$j] = $m_OriginMtx[1][$i] * $ImpCost[$i][$j];   
                    echo "<td bgcolor='#EBF5FF'>".round($OF[$i][$j],4)."</td>";
                }                     
                echo "</tr>";
            }
            echo '<tr align="center" bgcolor="#B8DBFF">';
            echo '<td><b>&#8721;[O<sub>i</sub>][F<sub>ij</sub>]</b></td>';
            for ($j = 1; $j <= $n; $j++)
            {                 
                $sumC[$j]=0;
                for ($i = 1; $i <= $n; $i++)
                {   
                    $sumC[$j] += $OF[$i][$j];                      
                }     
                echo "<td><B>".round($sumC[$j],4)."</B></td>";                  
            }
            echo "</tr>";
            
            echo "</table><br><br>";       
   
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B> Interaction Probabilities [Pr<sub>ij</sub>] </B></caption>';
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo'<td><B>Zone</B></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><B>'.$i.'</B></td>';
            }           
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $PR[$i][$j] = $OF[$j][$i] / $sumC[$i];               
                    echo "<td bgcolor='#EBF5FF'>".round($PR[$i][$j],4)."</td>";     
                }                     
                echo "</tr>";
            }
            
            echo "</table><br><br>";   
            
            ?>
          
            <?php 
        
            echo '<h2>Final Result</h2><br>';
            echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B> O-D Matrix  [T<sub>ij</sub>] </B></caption>';
            echo "<tr align='center'>";
            echo'<td  bgcolor="#CCE6FF"><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td  bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
            }           
           echo "</tr>";
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  bgcolor='#CCE6FF'><B>".$i."</B></td>";                
                for ($j = 1; $j <= $n; $j++)
                {     
                    $T[$i][$j] = $m_DestMtx[1][$i] * $PR[$i][$j];                                      
                    echo "<td bgcolor='#EBF5FF'>".round($T[$i][$j],4)."</td>";
                }                      
                echo "</tr>";
            }
        
            echo "<tr align='center'><td bgcolor='#B8DBFF'><b>&#8721;[O<sub>i</sub>][F<sub>ij</sub>]</b></td>";    
            for ($j = 1; $j <= $n; $j++)
            {
                    $sumTC[$j]=0;   
                for ($i = 1; $i <= $n; $i++)
                {
                    $sumTC[$j] += $T[$j][$i];                  
                   }
                   echo "<td bgcolor='#B8DBFF'><B>".round($sumTC[$j],4)."</B></td>";      
            }     
             echo "</tr>";    
            
            echo "<tr align='center'><td bgcolor='#B8DBFF'><b>Future year Destinations Total</b></td>";    
           	for ($i = 1; $i <= $n; $i++)
           	{
           		echo "<td bgcolor='#B8DBFF'><B>".$m_DestMtx[1][$i]."</B></td>";      
            }     
            echo "</tr>"; 
                  
            echo "</table><br><br>";            
        } 
?>
<br>
</body>
</html>