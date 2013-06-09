<?php


session_start();			//To check whether the session has started or not
include"conn.php";			//for Database connection
//include "userchk.php";	//To check user's session
include"functlib.php";		//All functions are present inside the file functionlib.php


//To output the results in excel sheet
header("Content-type: application/vnd.ms-excel");
$filename = "GrowthFactorModel_" . date('YMd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Disposition: attachment;Filename=document_name.xls");

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   	  

$UploadFile = $_SESSION['user'];			//To retrieve values of session variable

$m_MethodVal = $_POST['MethodVal'];			//To retrieve values of the selected method
$m_BaseFile = $_POST['BaseFile']; 	 



//----------------------------------verifying the format of the file---------------------------

/*
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
*/
//----------------------------------------------------------------------------------------------

?>

<!DOCTYPE HTML>
<html>
<head>
</head>

<body bgcolor="#FFFFFF">

  <?php
    if($m_MethodVal == "UniformGFM")
    {
          ?>
          <h2>Uniform Growth Factor Method</h2>
          <?php
    }
    elseif($m_MethodVal == "SinglyGFM")
    {
        ?>
        <h2>Singly Constrained Growth Factor Method</h2>
        <?php
    }
    elseif($m_MethodVal == "FratarGFM")
    {
        ?>
        <h2>Fratar Growth Factor Method</h2>
        <?php
    }
    ?>
 
<?php


//-------------------------------Reading Xls file-------------------------------------------------
if($file_ext1 == '.xls')
{
	require_once 'phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($UploadFile."/Experiment4/".$m_BaseFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zones
	$nRow=$dataBaseF->sheets[0]['numRows'];
	$nCol=$dataBaseF->sheets[0]['numCols'];

	?>

	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><B>O-D Matrix For Base Year</B></caption>
	<?php
	echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
       echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
	}
	echo "<td bgcolor='#B8DBFF'><B>Origin Total</B></td>";
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
   		$sumR[$i]=0;
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><B>'.$i.'</B></td>';
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{       
       		echo '<td bgcolor="#EBF5FF">';        
        	$sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	echo $m_BaseMtx[$i][$j];     
        	echo "</td>";            
    	}
    	echo '<td bgcolor="#B8DBFF"><B>';
    	echo $sumR[$i];
    	echo "</B></td></tr>";   
	}
	?>

	<tr align="center" bgcolor='#B8DBFF'>
	<td><B>Destination Total</B></td>
	<?php

	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    {
        $sumC[$j]=0;
        for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        {
            $sumC[$j] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];                     
        }
        ?>
        <td><B>
        <?php
        echo $sumC[$j];
        ?>
        </B></td>             
        <?php     
        $m_TotalBaseSum += $sumC[$j];
    }     
}
//-------------------------------------------------------------------------------
//-----------------------------Raeding csv file--------------------------------------------

elseif($file_ext1 == '.csv')
{
    $nCol = 0; 
	$nRow = 0;
	$name = $UploadFile."/Experiment4/".$m_BaseFile;
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
    
    ?>

	<div id="scroller">
	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><B>O-D Matrix For Base Year</B></caption>
	<?php

    echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
	for ($i = 1; $i <= $nRow; $i++)
	{
    	   echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
	}
	echo "<td bgcolor='#B8DBFF'><B>Origin Total</B></td>";
	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><B>'.$i.'</B></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	echo '<td bgcolor="#EBF5FF">';        
        	$sumR[$i] += (double)$m_BaseMtx[$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$m_BaseMtx[$i][$j];
        	echo $m_BaseMtx[$i][$j];     
        	echo "</td>";            
    	}
    	echo '<td bgcolor="#B8DBFF"><B>';
    	echo $sumR[$i];
    	echo "</B></td></tr>";   
	}
	?>

	<tr align="center" bgcolor='#B8DBFF'>
	<td><B>Destination Total</B></td>
	<?php

	for ($j = 1; $j <=$nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$m_BaseMtx[$i][$j];                     
        	}
    ?>
    <td><B>
    <?php
	        echo $sumC[$j];
    ?>
    </B></td>             
    <?php     
    		$m_TotalBaseSum += $sumC[$j];
	}     
     
     
     
     
     
fclose($file);

} 
//-----------------------------------------------------------------------------------
?>
   
</tr>

</table>

<br><br>

<?php
if($m_MethodVal == "UniformGFM")
{
    $m_txtGrowth = $_POST['txtGrowth'];
   
    echo "<h2>Growth Factor = ".$m_txtGrowth."</h2><Br><Br>";
   
    echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Uniform Growth Rate Matrix For Future Year</B></caption>';
    echo '<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
    for ($i = 1; $i <= $nRow; $i++)
    {
        echo '<td bgcolor="#CCE6FF"><B>'.$i.'</B></td>';
    }
    echo "<td bgcolor='#B8DBFF'><B>Origin Total</B></td>";
    echo "</tr>";
    for ($i = 1; $i <= $nRow; $i++)
    {   
        echo '<tr align="center">';
        echo'<td bgcolor="#CCE6FF"><B>'.$i.'</B></td>';
        $SumUR[$i] = 0;
        for ($j = 1; $j <= $nRow; $j++)
        {     
                            
            //echo $m_BaseMtx[$i][$j]."</td><td>";
            //echo $GFOrigin[$i]."</td><td>";
            $UG[$i][$j] = $m_BaseMtx[$i][$j] * $m_txtGrowth;
            $SumUR[$i] += round($UG[$i][$j]);
            //echo "<td>".$m_BaseMtx[$i][$j]."*".$GFOrigin[$i]."=".$UGOrigin[$i][$j]."</td>";  
              
            echo "<td bgcolor='#EBF5FF'>".round($UG[$i][$j])."</td>";
        }
        echo "<td bgcolor='#B8DBFF'><B>".round($SumUR[$i])."</B></td>";    
        echo "</tr>";       
    }
    echo '<tr align=Center bgcolor="#B8DBFF">';
     echo "<td><B>Destination Total</B></td>";   
    for ($j = 1; $j <= $nRow; $j++)
    {
        $sumUC[$j]=0;
        for ($i = 1; $i <= $nRow; $i++)
        {
            $sumUC[$j] += round($UG[$i][$j]);                    
        }
        echo "<td><B>". round($sumUC[$j])."</B></td>";    
    }     
    echo "</tr>";       
    echo "</table><br><br>";
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
        	$dataOriginF->read($UploadFile."/Experiment4/".$m_OriginFile);
        	error_reporting(E_ALL ^ E_NOTICE);
   
        	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Origins Total For Future Year</B></caption>';
        	echo'<tr align="center"  bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numCols']; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        	{          
            	for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            	{
                	echo '<td>';
                  	//echo $dataOriginF->sheets[0]['cells'][$i][$j];
                	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                	echo $m_OriginMtx[$i][$j];
                	$m_TotalSum += $m_OriginMtx[$i][$j];
                	echo "</td>";
               }

               echo "</tr>";  
        }
        echo "</table><br><br><br><br> ";
	 }
//-------------------------------------------------csv-----------------------------------
	 elseif($file_ext2 == '.csv')
     {

        
    		$nCol = 0; 
			$OriRow = 0;
			$name = $UploadFile."/Experiment4/".$m_OriginFile;
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
            echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Origins Total For Future Year</B></caption>';
        	echo'<tr align="center"  bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        	    echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	echo '<td>';
        	        	  //echo $dataOriginF->sheets[0]['cells'][$i][$j];
        	        	//$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
        	        	echo $m_OriginMtx[$i][$j];
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
        	        	echo "</td>";
               		}               
            }
        	echo "</tr></table></div><br><br><br><br> ";
        }
//---------------------------------------------------------------------------------------  
        ?>
      
      
 		<?php 
 		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Growth Factor Calculations </B></caption>';
        
        echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td><td><B>Future year Origin total</B></td><td><B>Base year Origin total</B></td><td><B>Growth Factor For Each Originating Zone</B></td></tr>';
       
        for ($j = 1; $j <= $nRow; $j++)
        {
            echo '<tr align="center"><td bgcolor="#CCE6FF"><B>'.$j.'</B></td><td bgcolor="#EBF5FF">';     
            echo $m_OriginMtx[1][$j]."</td><td bgcolor='#EBF5FF'>";
            echo $sumR[$j]."</td><td bgcolor='#CCE6FF'>";
            $GFOrigin[$j] = $m_OriginMtx[1][$j] / $sumR[$j];
            echo round($GFOrigin[$j], 3)."</td>";     
            echo "</tr>";
        }            
        echo "</table><br><br>";        
        ?>
        
       
        
        <?php 
        
        echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Singly Constrained Growth Factor Matrix For Future Year </B></caption>';
        echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
        for ($i = 1; $i <= $nRow; $i++)
        {
             echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
        }
        echo "<td bgcolor='#B8DBFF'><B>Origins Total Base year</B></td><td bgcolor='#B8DBFF'><B>Origins Total Future year</B></td>";
        echo '</tr>';
        for ($i = 1; $i <= $nRow; $i++)
        {  
            $SumOR[$i]=0;           
            echo '<tr align="center">';
            echo'<td bgcolor="#CCE6FF"><B>'.$i.'</B></td>';    
            for ($j = 1; $j <= $nRow; $j++)
            {                     
                //echo $m_BaseMtx[$i][$j]."</td><td>";
                //echo $GFOrigin[$i]."</td><td>";
                $UGOrigin[$i][$j] = $m_BaseMtx[$i][$j] * $GFOrigin[$i];
                //echo "<td>".$m_BaseMtx[$i][$j]."*".$GFOrigin[$i]."=".$UGOrigin[$i][$j]."</td>";
                 
                echo "<td bgcolor='#EBF5FF'>".round($UGOrigin[$i][$j])."</td>";
                $SumOR[$i]+=round($UGOrigin[$i][$j]);                
              }
              echo "<td bgcolor='#B8DBFF'><B>".$SumOR[$i]."</B></td>";   
              echo "<td bgcolor='#B8DBFF'><B>".$m_OriginMtx[1][$i]."</B></td>";
              echo "</tr>";
        }
        echo "<tr bgcolor='#B8DBFF'>";
        echo '<td  align="center"><B>Destinations Total Base year</B></td>';
        for($i=1; $i <= $nRow; $i++)
        {        
            $SumOC[$i]=0;
              for($j=1; $j <= $nRow; $j++)
              {  
                   $SumOC[$i]+=round($UGOrigin[$j][$i]);
                   
              }
              echo "<td><B>".round($SumOC[$i])."</B></td>";
              
        }
         echo "</tr>";
        echo "</table><br><br>";      
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
        		$dataDestF->read($UploadFile."/Experiment4/".$m_DestFile);
       			error_reporting(E_ALL ^ E_NOTICE);

        		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Destinations Total For Future Year </B></caption>';
        		echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        		for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        		{
        		    echo '<td><B>'.$i.'</B></td>';
        		}
        		echo "</tr>";
        
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
        		echo "</table><br><br><br><br> ";
		}
		//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext3 == '.csv')
		{ 
		
			$nCol = 0; 
			$DestRow = 0;
			$name = $UploadFile."/Experiment4/".$m_DestFile;
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
		
		
		
			echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Destinations Total For Future Year </B></caption>';
        	echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            	for ($j = 1; $j <= $nCol; $j++)
               	{
                	echo "<td>";   
                   //echo $dataDestF->sheets[0]['cells'][$i][$j];
                   //$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	echo "</td>";   
            	}
           		echo "</tr>";  
        	}
        	echo "</table></div><br><br><br><br> ";
		
		}
//---------------------------------------------------------------------------------

        	?>
      
     
			<?php 
        		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Growth Factor Calculations </B></caption>';
        
        		echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td><td><B>Future year Destination total</B></td><td><B>Base year Destination total</B></td><td><B>Growth Factor For Destination Zone</B></td></tr>';
       
        		for ($j = 1; $j <= $nRow; $j++)
        		{
            		echo '<tr align="center"><td bgcolor="#CCE6FF"><B>'.$j.'</B></td><td bgcolor="#EBF5FF">';      
            		echo $m_DestMtx[1][$j]."</td><td bgcolor='#EBF5FF'>";
            		echo $sumC[$j]."</td><td bgcolor='#CCE6FF'>";
            		//echo $sumC[$j]."</td><td>";
            		$GFDest[$j] = $m_DestMtx[1][$j] / $sumC[$j];
            		echo round($GFDest[$j], 3)."</td>";
            		echo "</tr>";
        		}            
        		echo "</table><br><br>";        
        	?>
        
        
        	<?php 

        	echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Singly Constrained Growth Factor Matrix For Future Year</B></caption>';
        	echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
        	for ($i = 1; $i <= $nRow; $i++)
        	{
             		echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
        	}
        	echo "<td bgcolor='#B8DBFF'><B>Origins Total Base year</B></td>";
        	echo '</tr>';
        
        	for ($i = 1; $i <= $nRow; $i++)
        	{   
           		$SumDR[$i]=0;   
            	echo '<tr align="center">';       
            	echo '<td align="center" bgcolor="#CCE6FF"><B>'.$i.'</B></td>';
            	for ($j = 1; $j <= $nRow; $j++)
            	{    
                                
                	//echo $m_BaseMtx[$i][$j]."</td><td>";
                	//echo $GFDest[$i]."</td><td>";
                	$UGDest[$i][$j] = $m_BaseMtx[$i][$j] * $GFDest[$j];
                	$SumDR[$i] += round($UGDest[$i][$j]);                
                	//echo "<td>".$m_BaseMtx[$i][$j]."*".$GFDest[$j]."=".$UGDest[$j]."</td>";     
                	echo '<td align="center" bgcolor="#EBF5FF">'.round($UGDest[$i][$j]).'</td>';
              	}    
              	echo "<td bgcolor='#B8DBFF'><B>".$SumDR[$i]."</B></td>";    
            	echo "</tr>";
        	}
        
        	echo "<tr align=center bgcolor='#B8DBFF'>";
        	echo '<td  align="center"><B>Destinations Total Base year</B></td>';
        	for($i=1; $i <= $nRow; $i++)
        	{
            	$SumDC[$i]=0;
              	for($j=1; $j <= $nRow; $j++)
              	{  
                   	$SumDC[$i] += round($UGDest[$j][$i]);
                   
              	}
              	echo "<td><B>".round($SumDC[$i])."</B></td>";              
        	}
         	echo "</tr>";
        	echo "<tr align=center bgcolor='#B8DBFF'><td><B>Destination Total Future year</B></td>";        
        	for($i=1; $i <= $nRow; $i++)
        	{
            	echo "<td><B>".$m_DestMtx[1][$i]."</B></td>";
        	}
          	echo "</tr>";
        	echo "</table><br><br>";   
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
        		//$dataOriginF->read('base_matrix.xls');
        		$dataOriginF->read($UploadFile."/Experiment4/".$m_OriginFile);
        		error_reporting(E_ALL ^ E_NOTICE);
        		
        		        	
        	
        		$OriginCol = $dataOriginF->sheets[0]['numCols'];
        		$OriginRow = $dataOriginF->sheets[0]['numRows'];
   
       			echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Origins Total For Future Year</B></caption>';

        		echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        		for ($i = 1; $i <= $nRow; $i++)
        		{
        		    echo '<td><B>'.$i.'</B></td>';
        		}
        		echo "</tr>";
        		echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';    
        		$m_TotalSum=0;
        		for ($i = 1; $i <= $OriginRow; $i++)
        		{
            
            		for ($j = 1; $j <= $OriginCol; $j++)
            		{
                		echo "<td>";
                  		//echo $dataOriginF->sheets[0]['cells'][$i][$j];
                		$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                		echo $m_OriginMtx[$i][$j];
                		$m_TotalSum += $m_OriginMtx[$i][$j];
                		echo "</td>";
               		}

                 
        		}
        		echo "</tr>";
        		echo "</table><br><br>";
       
        		$dataDestF = new Spreadsheet_Excel_Reader();
        		$dataDestF->setOutputEncoding('CP1251');
        		//$dataDestF->read('base_matrix.xls');
        		$dataDestF->read($UploadFile."/Experiment4/".$m_DestFile);
        		error_reporting(E_ALL ^ E_NOTICE);
        		
        		$DestinationCol = $dataDestF->sheets[0]['numCols'];
				$DestinationRow = $dataDestF->sheets[0]['numRows'];

        		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Destinations Total For Future Year</B></caption>';

        		echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        		for ($i = 1; $i <= $nRow; $i++)
        		{
        		    echo '<td><B>'.$i.'</B></td>';
        		}
        		echo "</tr>";
        		echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
        		$m_TotalSum=0;
       			 for ($i = 1; $i <= $DestinationRow; $i++)
       			 {
            
            			for ($j = 1; $j <= $DestinationCol; $j++)
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

//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext2 == '.csv' && $file_ext3 == '.csv')
		{

		           
    		$nCol = 0; 
			$OriRow = 0;
			$name = $UploadFile."/Experiment4/".$m_OriginFile;
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
            echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Origins Total For Future Year</B></caption>';
        	echo'<tr align="center"  bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        	    echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	echo '<td>';
        	        	  //echo $dataOriginF->sheets[0]['cells'][$i][$j];
        	        	//$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
        	        	echo $m_OriginMtx[$i][$j];
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
        	        	echo "</td>";
               		}               
            }
        	echo "</tr></table></div><br><br><br><br> ";

        	
        	$nCol = 0; 
			$DestRow = 0;
			$name = $UploadFile."/Experiment4/".$m_DestFile;
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
		
		
		
			echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Destinations Total For Future Year </B></caption>';
        	echo'<tr align="center" bgcolor="#CCE6FF"><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            	for ($j = 1; $j <= $nCol; $j++)
               	{
                	echo "<td>";   
                   //echo $dataDestF->sheets[0]['cells'][$i][$j];
                   //$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	echo "</td>";   
            	}
           		echo "</tr>";  
        	}
        	echo "</table></div><br><br><br><br> ";

		
		
		}	      			
 
        echo "<h3><b>Selected Accuracy : ".$m_AccuracyVal." Cell <b></h3><br>";
        echo "<h3><b>Entered Accuracy Level (i.e., percentage of error): ".$m_txtAccuracy." %<b></h3><br><br>";
       
   
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
                echo "<h2>Iteration &nbsp;# ".$itr."</h2>"; 	
                echo "<br><br>";								                            

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
        
                
                echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Fratar Growth Factor Matrix For Future Year</B></caption>';
                echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';	
                for ($i = 1; $i <= $nRow; $i++)
                {
                    echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                }      
                 echo "<td bgcolor='#B8DBFF'><B>Current Origins Total</B></td><td bgcolor='#B8DBFF'><B>Origins Total Future year</B></td>";                 
                 echo '<tr align="center">';       
				
                for ($k = 1; $k <= $nRow; $k++)
                {          
                    echo '<td align="center" bgcolor="#CCE6FF"><B>'.$k.'</B></td>';

                    $SumDobR1[$k]=0;  
                    
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           $s[$k][$l] = $m_BaseMtx[$k][$l] * $a[$k];
                           $SumDobR1[$k] += $s[$k][$l];  
                           
                           echo '<td align="center" bgcolor="#EBF5FF">'.round($s[$k][$l],3).'</td>';  
                    }   
                    echo '<td align="center" bgcolor="#B8DBFF"><B>'.round($SumDobR1[$k],3).'</B></td>'; 
                    echo "<td align='center' bgcolor='#B8DBFF'><B>".$m_OriginMtx[1][$k]."</B></td>";  
                    echo"</tr>";        
                }
               
                
                echo "<tr bgcolor='#B8DBFF'>";	
                echo '<td  align="center"><B>Current Destinations Total</B></td>';	
                
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC1[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC1[$k] += $s[$l][$k];;                   
                      }
                     echo "<td align='center'><B>".round($SumDobC1[$k],3)."</B></td>";         
                }
				
              
                echo "</tr>";
                echo "<tr bgcolor='#B8DBFF'><td align='center'><B>Destinations Total Future year</B></td>";
                  for ($l = 1; $l<= $nRow; $l++)
                  {
                         echo "<td align='center'><B>".$m_DestMtx[1][$l]."</B></td>";
                  }
                  echo"  </tr>";
                echo "</table><BR>";
               
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

                echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Fratar Growth Factor Matrix For Future Year</B></caption>';
                echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
                for ($i = 1; $i <= $nRow; $i++)
                {
                    echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                }      
                echo "<td bgcolor='#B8DBFF'><B>Current Origins Total</B></td><td bgcolor='#B8DBFF'><B>Origins Total Future year</B></td>";
                echo "</tr>";
                echo '<tr align="center">';
                
                for ($l = 1; $l <= $nRow; $l++)
                {
                    echo '<td align="center" bgcolor="#CCE6FF"><B>'.$l.'</B></td>';
                    $SumDobR2[$l]=0; 
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        $t[$k][$l] = $s[$l][$k] * $b[$k];  
                        $SumDobR2[$l] += $t[$k][$l];                       
                        echo '<td align="center" bgcolor="#EBF5FF">'.round($t[$k][$l],3).'</td>';      
                    }  
                    
                    echo '<td align="center" bgcolor="#B8DBFF"><B>'.round($SumDobR2[$l],3).'</B></td>';  
                    echo "<td align='center' bgcolor='#B8DBFF'><B>".$m_OriginMtx[1][$l]."</B></td>";  
                    echo "</tr>";  
                            
                }
                
                 
                echo "<tr bgcolor='#B8DBFF'>";	
                echo '<td align="center"><B>Current Destinations Total</B></td>';	
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC2[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC2[$k] += $t[$k][$l];;                   
                      }
                      echo "<td align='center'><B>".round($SumDobC2[$k],3)."</B></td>";     
                }
                
                 
                 echo "</tr>";
                 echo "<tr bgcolor='#B8DBFF'><td align='center'><B>Destinations Total Future year</B></td>";
                   for ($l = 1; $l<= $nRow; $l++)
                  {
                         echo "<td align='center'><B>".$m_DestMtx[1][$l]."</B></td>";
                  }
                   echo"  </tr>";           
                echo "</table>";
                echo "<br><br>";
                
                
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
               echo "<br><br><br>";	
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
                echo "<h2>Final Result</h2>";
                echo "<br><br>";
        }
        else
        {
        		echo "<h2>Iteration &nbsp;# ".$itr."</h2>";
                echo "<br><br>";
        }
        		echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Fratar Growth Factor Matrix For Future Year</B></caption>';
                echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
                for ($i = 1; $i <= $nRow; $i++)
                {
                    echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                }      
                 echo "<td bgcolor='#B8DBFF'><B>Current Origins Total</B></td><td bgcolor='#B8DBFF'><B>Origins Total Future year</B></td>";                 
                 echo '<tr align="center">';       

                for ($k = 1; $k <= $nRow; $k++)
                {          
                    echo '<td align="center" bgcolor="#CCE6FF"><B>'.$k.'</B></td>';

                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           
                           echo '<td align="center" bgcolor="#EBF5FF">'.round($s[$k][$l],3).'</td>';      
                    }   
                    echo '<td align="center" bgcolor="#B8DBFF"><B>'.round($SumDobR1[$k],3).'</B></td>';     // S  
                    echo "<td align='center' bgcolor='#B8DBFF'><B>".$m_OriginMtx[1][$k]."</B></td>";  //S
                    echo"</tr>";          
                }
               
                // S
                echo "<tr bgcolor='#B8DBFF'>";
                echo '<td  align="center"><B>Current Destinations Total</B></td>';
                   for ($k = 1; $k <= $nRow; $k++)
                {
                      echo "<td align='center'><B>".round($SumDobC1[$k],3)."</B></td>";              
                }
                 echo "</tr>";
                 echo "<tr bgcolor='#B8DBFF'><td align='center'><B>Destinations Total Future year</B></td>";
                   for ($l = 1; $l<= $nRow; $l++)
                  {
                         echo "<td align='center'><B>".$m_DestMtx[1][$l]."</B></td>";
                  }
                   echo"  </tr>";
                // S
                echo "</table><BR>";


 				echo '<table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><B>Fratar Growth Factor Matrix For Future Year</B></caption>';
                echo'<tr align="center"><td bgcolor="#CCE6FF"><B>Zone</B></td>';
                for ($i = 1; $i <= $nRow; $i++)
                {
                    echo "<td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                }      
                echo "<td bgcolor='#B8DBFF'><B>Current Origins Total</B></td><td bgcolor='#B8DBFF'><B>Origins Total Future year</B></td>";
                echo "</tr>";
                echo '<tr align="center">';
                
                for ($l = 1; $l <= $nRow; $l++)
                {
                    echo '<td align="center" bgcolor="#CCE6FF"><B>'.$l.'</B></td>';
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        echo '<td align="center" bgcolor="#EBF5FF">'.round($t[$k][$l],3).'</td>';      
                    }  
                    echo '<td align="center" bgcolor="#B8DBFF"><B>'.round($SumDobR2[$l],3).'</B></td>';  
                    echo "<td align='center' bgcolor='#B8DBFF'><B>".$m_OriginMtx[1][$l]."</B></td>";  //S
                    echo "</tr>";           
                }
                
                 // S
                echo "<tr bgcolor='#B8DBFF'>";
                echo '<td align="center"><B>Current Destinations Total</B></td>';
                   for ($k = 1; $k <= $nRow; $k++)
                {
                      echo "<td align='center'><B>".round($SumDobC2[$k],3)."</B></td>";              
                }
                 echo "</tr>";
                 echo "<tr bgcolor='#B8DBFF'><td align='center'><B>Destinations Total Future year</B></td>";
                   for ($l = 1; $l<= $nRow; $l++)
                  {
                         echo "<td align='center'><B>".$m_DestMtx[1][$l]."</B></td>";
                  }
                   echo"  </tr>";
                // S
                
                echo "</table>";
                echo "<br><br>";
                
                echo "<h2>No. of Iteration taken to reach final result : ".$itr."</h2>";
                echo "<br><br>";
    }   

?>

</body>
</html>