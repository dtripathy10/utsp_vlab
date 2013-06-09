<?php

session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
include "userchk.php";	//To check user's session

// To Create Report into Excel File 

header("Content-type: application/vnd.ms-excel");
$filename = "TripGenerationRegressionAnalysis_" . date('YMd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");


header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   	  

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

$m_AnalysisVar = $_POST['AnalysisVar'];
$m_TripFile = $_POST['TripFile'];


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


?>


<!DOCTYPE HTML>
<html>
<head>
</head>

<body bgcolor="#FFFFFF">

        <h2>Trip Generation: Regression analysis</h2>
 
<BR><BR>   


<?php

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
        
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {               
            echo '<tr align="center" bgcolor="#EBF5FF">'; 
            if($i == 1)
            {
            	echo "<td bgcolor='#B8DBFF'><b>Zone</b></td>";
            }
            else 
            {
            	echo "<td bgcolor='#B8DBFF'><b>".($i-1)."</b></td>"; 
            }           
            for ($j = 1; $j <= $nCol; $j++)
            {
                            
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                
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
                     echo "<td bgcolor='#B8DBFF'><b>".$m_TripMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_TripMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table><br><br><br>";     

        
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
    
     echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
     for ($i = 1; $i <= $nRow; $i++)
     {               
            echo '<tr align="center" bgcolor="#EBF5FF">'; 
            if($i == 1)
            {
            	echo "<td bgcolor='#B8DBFF'><b>Zone</b></td>";
            }
            else 
            {
            	echo "<td bgcolor='#B8DBFF'><b>".($i-1)."</b></td>"; 
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
                     echo "<td bgcolor='#B8DBFF'><b>".$m_TripMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_TripMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br><br>";     
}
//------------------------------------------------------------------------------------------------ 
        

?>

<?php 

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
        
         	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Correlation Matrix</B></caption>';
         	echo '<tr align="center"><td bgcolor="#CCE6FF">&nbsp;</td>';
         
         	for ($i = 0; $i < $SelectCol; $i++)
         	{
            	echo "<td bgcolor='#CCE6FF'><B>".$m_TripMtx[1][$m_CorrDescVar[$i]]."</B></td>";
         	}
         	echo "</tr>";
         	for ($j = 0; $j < $SelectCol; $j++)
         	{     
            	echo '<tr align="center">';
            	echo '<td bgcolor="#CCE6FF"><B>'.$m_TripMtx[1][$m_CorrDescVar[$j]].'</B></td>';
            	for ($i = 0; $i < $SelectCol; $i++)
            	{
                	echo "<td bgcolor='#EBF5FF'>".round($reg[$j][$i],4)."</td>";
            	}
            	echo "</tr>";
        	}
        	echo "</table>";  
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

        	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Descriptive Statistics</b></caption>';
        	echo '<tr align="center" bgcolor="#B8DBFF"><td>&nbsp;</td><td><b>N</b></td><td><b>Minimum</b></td><td><b>Maximum</b></td><td><b>Mean</b></td><td><b>Standard Deviation</b></td></tr>';
                           
            for ($i = 0; $i < $SelectCol; $i++)
            {
                  echo '<tr align="center" bgcolor="#EBF5FF">'; 
                  echo'<td  bgcolor="#B8DBFF"><b>'.$m_TripMtx[1][$m_CorrDescVar[$i]].'</b></td>';   
                  echo'<td>'.($m_finalrow-1).'</td>'; 
                  echo'<td>'.$min[$i].'</td>'; 
                  echo'<td>'.$max[$i].'</td>'; 
                  echo'<td>'.round($avg[$i],4).'</td>'; 
                  echo'<td>'.round($deltaRoot[$i],4).'</td>';        
                  echo "</tr>";       
          	}  
        	echo "</table><br><br><br>";
		}		
		elseif ($m_DataChoiceVar == "Plot")
		{
			/*
			$m_PlotXVar = $_POST['PlotXVar'];
			$m_PlotYVar = $_POST['PlotYVar'];  		
			

			for ($i =2; $i < $nRow; $i++)
       		{
            	$x[$i] = (int)$m_TripMtx[$i][$m_PlotXVar];
          
            	$y[$i] = (int)$m_TripMtx[$i][$m_PlotYVar];
                    
       		}
       		
       		$rangeX= max($x);
       		$rangeY=max($y);
       		
       		echo "<table><tr align='center'><td id='vert'><b>".$m_TripMtx[1][$m_PlotYVar]."</b></td><td>";
       		echo "<b>".$m_TripMtx[1][$m_PlotXVar]."&nbsp;&nbsp;VS&nbsp;&nbsp;".$m_TripMtx[1][$m_PlotYVar]."</b><br><br>";
       		
			require ('phpGraph/gChart.php');
			$scatter = new gScatterChart();
			//$scatter -> addDataSet(array(12,87,75,41,23,96,68,71,34,9,202));
			//$scatter -> addDataSet(array(98,60,27,34,56,79,58,74,18,76,210));
			$scatter -> addDataSet($x);
			$scatter -> addDataSet($y);			
			$scatter -> addValueMarkers('d','FF0000',0,-1,5);
			$scatter -> setVisibleAxes(array('x','y'));
			$scatter -> addAxisRange(0, 0, $rangeX);
			$scatter -> addAxisRange(1, 0, $rangeY);
			?>
			<img src="<?php print $scatter->getUrl();  ?>" /></center>
			<?php 
			
			
			echo "</td></tr><tr align='center'><td>&nbsp;&nbsp;&nbsp;<td><b>".$m_TripMtx[1][$m_PlotXVar]."</b><td></tr></table>";
       		*/
		}
	}
	elseif($m_AnalysisVar == "RegrAna")
	{
		$m_RegrType=$_POST['RegrType'];
		$m_RegrDepdVar = $_POST['RegrDepdVar'];
		
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
        
        	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Output Varaible </b></caption>';
        	for ($i = 1; $i <= $m_finalrow; $i++)
        	{         
        		if($i==1)
            	{
            		echo "<tr bgcolor='#B8DBFF' align='center'><td><b>Zone</b></td>" ;
                	echo "<td><b>".$dataTripF->sheets[0]['cells'][$i][$m_RegrDepdVar]."</b></td></tr>" ;
           		}
            	else
            	{
            		$Y[$i][$m_RegrDepdVar]=$dataTripF->sheets[0]['cells'][$i][$m_RegrDepdVar];
                	echo"<tr bgcolor='#EBF5FF'><td align='center'>".($i-1)."</td>";
                	echo "<td align='center'>".$Y[$i][$m_RegrDepdVar]."</td></tr>";
           		}
       		}
        	echo "</table><br><br>";

        
         }
		//----------------------------------------------------------------------------------
		
		//----------------------------- Reading csv file -----------------------------------

		elseif($file_ext1 == '.csv' )
		{

    		echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Output Varaible </b></caption>';
        	for ($i = 1; $i <= $m_finalrow; $i++)
        	{         
        		if($i==1)
            	{
            		echo "<tr bgcolor='#B8DBFF' align='center'><td><b>Zone</b></td>" ;
                	echo "<td><b>".$m_TripMtx[$i][$m_RegrDepdVar]."</b></td></tr>" ;
           		}
            	else
            	{
            		$Y[$i][$m_RegrDepdVar]=$m_TripMtx[$i][$m_RegrDepdVar];
                	echo"<tr bgcolor='#EBF5FF'><td align='center'>".($i-1)."</td>";
                	echo "<td align='center'>".$Y[$i][$m_RegrDepdVar]."</td></tr>";
           		}
       		}
        	echo "</table></div><br><br>";
    		
		}
		
		//------------------------------------------------------------------------------------------
        	
        	
	if($m_RegrType=="Linear")
	{	
		
		
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

        /*
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> X[i][j] </b></caption>';
        for ($i = 1; $i <= $m_finalrow; $i++)
        {   
            echo"<tr bgcolor='#EBF5FF'>";
            for ($j = 1; $j <= $p; $j++)
            {    
            	echo"<td align='center'>".$X[$i][$j]."</td>";
            }
            echo "</tr>";      
        }
        echo "</table><br><br>";
      	*/
        
        for ($j = 1; $j <= $p; $j++)
        {
            for ($i = 1; $i <= $m_finalrow; $i++)
            {                
               $X_t[$j][$i]=$X[$i][$j] ;               
            }
        }

       /* 
       echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> X<sup>T</sup>[i][j] </b></caption>';  
       for ($i = 1; $i <= $p; $i++)
       {
       		echo"<tr bgcolor='#EBF5FF'>";
            for ($j = 1; $j <= $m_finalrow; $j++)
            {       
                echo"<td align='center'>". $X_t[$i][$j]."</td>";          
            }
            echo "</tr>";      
        }
        
        echo "</table><br><br>";
        */
      
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

        /*
        //echo $p;
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> X[i][j] * X<sup>T</sup>[i][j] </b></caption>';
        for ($j = 1; $j <= $p; $j++)
        {
            echo"<tr bgcolor='#EBF5FF'>";
            for ($i = 1; $i <= $p; $i++)
            {   
               echo"<td align='center'>". $multi[$i][$j]."</td>";
            }
            echo "</tr>";    
        }
        
        echo "</table><br><br>";
        */  
        
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

       	/*
      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> X<sup>T</sup>[i][j] * Y[i][j] </b></caption>';  
      	for ($i = 1; $i <= $p; $i++)
      	{      
         	echo"<tr bgcolor='#EBF5FF'><td align='center'>".$multiXTY[$i]."</td></tr>";
      	}
      
      	echo "</table><br><br>";    
      	*/
      
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
            echo "<BR>";
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
        
    	/*
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> ( X<sup>T</sup>[i][j] * X[i][j])<sup>-1</sup> </b></caption>';  
        for($i = 1; $i <= $p; $i++)
        {
            echo"<tr bgcolor='#EBF5FF'>";
            for($k=1; $k<=$p; $k++)
            {
                echo"<td align='center'>".$b[$i][$k]."</td>";
                
            }
            echo "</tr>";
        }
        echo "</table><br><br>";
        */
        
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
      
      	echo '<table border=1 cellspacing=1 align="center" width="80%" height="8%">';
      	echo '<tr align="center" bgcolor="#B8DBFF"><td><b>R-Square<b></td>';
      	echo '<td><b>Standard Error<b></td>';
      	echo '<tr bgcolor="#EBF5FF" align="center"align="center"><td>'.$r_sqr.'</td><td>'.$deltaRoot.'</td></tr>';
      	echo "</table><br><br>";

      	// fot t value
      
      	for($i = 1; $i <= $p; $i++)
        {
            $msemse[$i]=sqrt($deltaSum1*$b[$i][$i]);
        }

        for($i = 1; $i <= $p; $i++)
        {
            $t_value[$i]=$ans[$i]/$msemse[$i];
        }

      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Coefficients</b></caption>';
      	echo "<tr align='center' bgcolor='#B8DBFF'><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
        	       	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>Intercept</b></td>";
            	   	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
            }
            else
            {
                  	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>".$m_TripMtx[1][$m_RegrInpdVar[$k]]."</b></td>";
                	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
                  	$k++;
            }
      	}
      	echo "</table><br>";
      
      	$k=1;
      	echo '<table border=1 cellspacing=1 align="center" width="85%" height="10%"><caption><b> Equation </b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>";
      	echo $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]."&nbsp;=&nbsp;".$ans[$k]."&nbsp;+&nbsp;";
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
                echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;+&nbsp;";
             }
             elseif($i <= $p-3)
             {
                 echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;+&nbsp;";
             }
             else
             {
                 echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")";
             }
             $k++;
      	}
      	echo "</b></td></tr></table><br><br>";
     
      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Estimated output values</b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	echo "<tr align='center' bgcolor='#EBF5FF'><td>Y<sub>".$i."</sub></td>";    
           	echo "<td>".$output[$i]."</td><td>$Res[$i]</td><td>".$stdres[$i]."</td></tr>";
      	}
    	echo "</table><br><br><br>";
	}

	if($m_RegrType=="Quadratic")
	{	
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

      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Coefficients</b></caption>';
      	echo "<tr align='center' bgcolor='#B8DBFF'><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
        	       	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>Intercept</b></td>";
            	   	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
            }
            else
            {
                  	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>".$m_TripMtx[1][$m_RegrInpdVar[$k]]."</b></td>";
                	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
                  	$k++;
            }
      	}
      	echo "</table><br>";
      
      	$k=1;
      	echo '<table border=1 cellspacing=1 align="center" width="85%" height="10%"><caption><b> Equation </b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>";
      	echo $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]."&nbsp;=&nbsp;".$ans[$k]."&nbsp;*&nbsp;";
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
                echo "(".$ans[$k].")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;*&nbsp;";
             }
             elseif($i <= $p-3)
             {
                 echo "(".$ans[$k].")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;*&nbsp;";
             }
             else
             {
                 echo "(".$ans[$k].")^(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")";
             }
             $k++;
      	}
      	echo "</b></td></tr></table><br><br>";
     
      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Estimated output values</b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	echo "<tr align='center' bgcolor='#EBF5FF'><td>Y<sub>".$i."</sub></td>";    
           	echo "<td>".$output[$i]."</td><td>$Res[$i]</td><td>".$stdres[$i]."</td></tr>";
      	}
    	echo "</table><br><br><br>";
		
	
	}
	if($m_RegrType=="Exponential")
	{	
				
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
		
		
		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Coefficients</b></caption>';
      	echo "<tr align='center' bgcolor='#B8DBFF'><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
        	       	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>Intercept</b></td>";
            	   	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
            }
            else
            {
                  	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>".$m_TripMtx[1][$m_RegrInpdVar[$k]]."</b></td>";
                	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
                  	$k++;
            }
      	}
      	echo "</table><br>";
      
      	$k=1;
      	echo '<table border=1 cellspacing=1 align="center" width="85%" height="10%"><caption><b> Equation </b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>";
      	echo $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]."&nbsp;=&nbsp;".$ans[$k]."&nbsp;*&nbsp;";
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
                echo "exp(".$ans[$k].")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;*&nbsp;";
             }
             elseif($i <= $p-3)
             {
                 echo "exp(".$ans[$k].")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;*&nbsp;";
             }
             else
             {
                 echo "exp(".$ans[$k].")*(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")";
             }
             $k++;
      	}
      	echo "</b></td></tr></table><br><br>";
     
      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Estimated output values</b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	echo "<tr align='center' bgcolor='#EBF5FF'><td>Y<sub>".$i."</sub></td>";    
           	echo "<td>".$output[$i]."</td><td>$Res[$i]</td><td>".$stdres[$i]."</td></tr>";
      	}
    	echo "</table><br><br><br>";
	}
	if($m_RegrType=="Logarithmic")
	{			$m_finalrow=$m_finalrow-1;
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
		
		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Coefficients</b></caption>';
      	echo "<tr align='center' bgcolor='#B8DBFF'><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
      	$k=0;
      	for ($i = 1; $i <= $p; $i++)
      	{      
            //echo "<tr align='center' bgcolor='#EBF5FF'><td>&#946<sub>".($i-1)."</sub></td>";
            if($i==1)
            {    
        	       	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>Intercept</b></td>";
            	   	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                   	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
            }
            else
            {
                  	echo "<tr align='center'><td bgcolor='#B8DBFF'><b>".$m_TripMtx[1][$m_RegrInpdVar[$k]]."</b></td>";
                	echo "<td bgcolor='#EBF5FF'>".$ans[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$msemse[$i]."</td>";
                  	echo "<td bgcolor='#EBF5FF'>".$t_value[$i]."</td></tr>";
                  	$k++;
            }
      	}
      	echo "</table><br>";
      
      	$k=1;
      	echo '<table border=1 cellspacing=1 align="center" width="85%" height="10%"><caption><b> Equation </b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>";
      	echo $dataTripF->sheets[0]['cells'][1][$m_RegrDepdVar]."&nbsp;=&nbsp;".$ans[$k]."&nbsp;+&nbsp;";
      	$k++;
      	for ($i = 0; $i < $p-1; $i++)
      	{
            if($i==0)
             {
                echo "(".$ans[$k].")ln(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;+&nbsp;";
             }
             elseif($i <= $p-3)
             {
                 echo "(".$ans[$k].")ln(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")&nbsp;+&nbsp;";
             }
             else
             {
                 echo "(".$ans[$k].")ln(".$m_TripMtx[1][$m_RegrInpdVar[$i]].")";
             }
             $k++;
      	}
      	echo "</b></td></tr></table><br><br>";
     
      	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Estimated output values</b></caption>';
      	echo "<tr bgcolor='#B8DBFF'><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
      	for ($i = 1; $i <= $m_finalrow; $i++)
      	{                
        	echo "<tr align='center' bgcolor='#EBF5FF'><td>Y<sub>".$i."</sub></td>";    
           	echo "<td>".$output[$i]."</td><td>$Res[$i]</td><td>".$stdres[$i]."</td></tr>";
      	}
    	echo "</table><br><br><br>";
	}
}
?>

<br><br><br>
</body>
</html>


