<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Growth Factor Distribution Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment4/";

$m_MethodVal = $_POST['MethodVal'];
$m_BaseFile = $_FILES['BaseFile']['name'];  //To Read file name uploaded in the folder present in the server
$m_OriginFile = $_FILES['OriginFile']['name'];
$m_DestFile = $_FILES['DestFile']['name'];
$m_txtGrowth = $_POST['txtGrowth'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];
if(empty($m_BaseFile))
{
	$m_BaseFile = $_POST['BaseFile'];
}
if(empty($m_OriginFile))
{
	$m_OriginFile = $_POST['OriginFile'];
}
if(empty($m_DestFile))
{
	$m_DestFile = $_POST['DestFile'];
}
if(empty($m_txtGrowth))
{	
	
	$m_txtGrowth = $_POST['txtGrowth'];
}
if(empty($m_txtAccuracy))
{	
	
	$m_txtAccuracy = $_POST['txtAccuracy'];
}

//----------------------------------verifying the format of the file---------------------------


$file_ext1= substr($m_BaseFile, strripos($m_BaseFile, '.'));
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


move_uploaded_file($_FILES["BaseFile"]["tmp_name"],$folder . $_FILES["BaseFile"]["name"]);  //to upload file in the folder name present in the server

if(empty($m_MethodVal))
{
	$m_MethodVal = $_POST['MethodVal'];
}
$stop = $_POST['stop'];

?>


<script type="text/javascript">


		$(document).ready(function(){

		$("#Total").show();
		$("#SingOriCalc").show();
		$("#SingOriFinal").hide();
		$("#SingDestCalc").show();
		$("#SingDestFinal").hide();






	/*	$(".btn2").click(function(){
	//	    $("#GF").slideUp("slow");
	//	    $("#base").slideDown("slow");
		    
//	  	});

//		$(".btn3").click(function(){
//		    $("#GF").slideUp("slow");
//		    $("#UGF").slideDown("slow");
		    
//	  	});
	  	
//		$(".btn4").click(function(){
//		    $("#UGF").slideUp("slow");
//		    $("#GF").slideDown("slow");
		    
//	  });



//	$(".btn5").click(function(){
//	    $("#Total").slideUp("slow");
//	    $("#base").slideDown("slow");
	    
//  });
	$(".btn6").click(function(){
	    $("#Total").slideUp("slow");
	    $("#SingOriCalc").slideDown("slow");
	    
  });
	$(".btn7").click(function(){
	    $("#SingOriCalc").slideUp("slow");
	    $("#Total").slideDown("slow");
	    
  });
	  */
	$(".btn8").click(function(){
	    $("#SingOriCalc").slideUp("slow");
	    $("#SingOriFinal").slideDown("slow");
	    
  });
	$(".btn9").click(function(){
	    $("#SingOriFinal").slideUp("slow");
	    $("#SingOriCalc").slideDown("slow");
	    
  });


	$(".btn13").click(function(){
	    $("#SingDestCalc").slideUp("slow");
	    $("#SingDestFinal").slideDown("slow");
	    
  });
	$(".btn14").click(function(){
	    $("#SingDestFinal").slideUp("slow");
	    $("#SingDestCalc").slideDown("slow");
	    
  });
	$(".btn15").click(function(){
	    $("#OriTot").slideUp("slow");
	    $("#base").slideDown("slow");
	    
  });
	$(".btn16").click(function(){
	    $("#OriTot").slideUp("slow");
	    $("#DestTot").slideDown("slow");
	    
  });
	$(".btn17").click(function(){
	    $("#DestTot").slideUp("slow");
	    $("#OriTot").slideDown("slow");
	    
  });
	$(".btn18").click(function(){
	    $("#DestTot").slideUp("slow");
	    $("#iteration").slideDown("slow");
	    
  });
	$(".btn19").click(function(){
	    $("#iteration").slideUp("slow");
	    $("#DestTot").slideDown("slow");
	    
  });


	  
	  
});
</script>	

<script language="javascript">
function chk1()
{ 
	document.Frm.action="intermediateGroFactMod.php";	
}


</script>

<div id="body">  
<center>
<div id="base">

<?php
//-------------------------------Reading Xls file-------------------------------------------------

if($file_ext1 == '.xls')
{
	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_BaseFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$nRow=$dataBaseF->sheets[0]['numRows'];
	$nCol=$dataBaseF->sheets[0]['numCols'];
	$BaseRow = $nRow;
	$BaseCol = $nCol;
	
	if( !($BaseRow==$BaseCol))
	{
	    ?>
	    <script lanuguage = javascript>
	    alert("The base year marix must be a square matrix i.e.,the number of rows must be equal to number of column");
	    location="GroFactMod.php";
	    </script>
	    <?php
	}

	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	$sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	
        	//To check whether the entries are numeric in the base file 
        	if(!is_numeric($m_BaseMtx[$i][$j]))
			{
			?>
			 <script lanuguage = javascript> 
			 
					alert("Enter Only Numeric Values in Base year OD file!! \n Error at [<?=$i?>,<?=$j?>]")
					location = "GroFactMod.php";
			
			</script>
			<?php 
			}
    	}
	}

	for ($j = 1; $j <= $nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];                     
        	}

    		$m_TotalBaseSum += $sumC[$j];
	}     
}


//---------------------------------------------------------------------------------
//-----------------------------Reading csv file--------------------------------------------

elseif($file_ext1 == '.csv')
{
    $nCol=0; 
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
    
    $BaseRow = $nRow;
	$BaseCol = $nCol;
    
    
	if( !($BaseRow==$BaseCol))
	{
	    ?>
	    <script lanuguage = javascript>
	    alert("The base year marix must be a square matrix  i.e..,the number of rows must be equal to number of column");
	    location="GroFactMod.php";
	    </script>
	    <?php
	}
    ?>
	<?php

	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	$sumR[$i] += (double)$m_BaseMtx[$i][$j]; 
        	$m_BaseMtx[$i][$j]=$m_BaseMtx[$i][$j];
    	    if(!is_numeric($m_BaseMtx[$i][$j]))
			{
			?>
			 <script lanuguage = javascript> 
			 
					alert("Enter Only Numeric Values in Base year OD matrix!! \n Error at [<?=$i?>,<?=$j?>]")
					location = "GroFactMod.php";
			
			</script>
			<?php 
			}
    	}
	}
	?>

	<?php

	for ($j = 1; $j <=$nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$m_BaseMtx[$i][$j];                     
        	}
    ?>
    <?php     
    		$m_TotalBaseSum += $sumC[$j];
	} 
	fclose($file);
	 

} 
//-----------------------------------------------------------------------------------
?>	
<br><br>

<?php
if($m_MethodVal == "UniformGFM"  )
{
    //$m_txtGrowth = $_POST['txtGrowth'];
   
    echo "<h2>Growth Factor = ".$m_txtGrowth."</h2><Br><Br>";
    echo"<br><br><br>";
    
    
    echo '<caption><B>Uniform Growth Rate Matrix For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
    echo '<tr align="center"><td ><B>Zone</B></td>';
    for ($i = 1; $i <= $nRow; $i++)
    {
        echo '<td><B>'.$i.'</B></td>';
    }
    echo "<td><B>Origin Total</B></td>";
    echo "</tr>";
    for ($i = 1; $i <= $nRow; $i++)
    {   
        echo '<tr align="center">';
        echo'<td><B>'.$i.'</B></td>';
        $SumUR[$i] = 0;
        for ($j = 1; $j <= $nRow; $j++)
        {     
            $UG[$i][$j] = $m_BaseMtx[$i][$j] * $m_txtGrowth;
            $SumUR[$i] += round($UG[$i][$j]);  
            echo "<td>".round($UG[$i][$j])."</td>";
        }
        echo "<td><B>".round($SumUR[$i])."</B></td>";    
        echo "</tr>";       
    }
    echo '<tr align="center" >';
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
    echo "</table></div><br><br>";
	 echo '<br><br><br><br>';
}
elseif($m_MethodVal == "SinglyGFM")
{
   	$m_ConstraintsVal = $_POST['ConstraintsVal'];
    if($m_ConstraintsVal=="SinglyOrigin")
    {
    	
    	move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder . $_FILES["OriginFile"]["name"]);
    	
    
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
        
//------------------------------------------------Reading xls file-------------------------------------    
if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{ 
       		$dataOriginF = new Spreadsheet_Excel_Reader();
        	$dataOriginF->setOutputEncoding('CP1251');
        	$dataOriginF->read($folder.$m_OriginFile);		//Reading file from server
        	error_reporting(E_ALL ^ E_NOTICE);

        	$OriginCol = $dataOriginF->sheets[0]['numCols'];  //no. of columns 
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        	{      
        		    for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
        	    	{
        	        	echo '<td>';
        	        	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];  //reading values into an array
        	    	    if(!is_numeric($m_OriginMtx[$i][$j]))
						{
						?>
			 			<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
						</script>
						<?php 
						}
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}               
            }

       
}
//------------------------------------------------Reading csv file-----------------------------------
elseif($file_ext1 == '.csv' && $file_ext2 == '.csv')
{

        
    		$nCol = 0; 
			$OriRow = 0;
			$name = $folder.$m_OriginFile;		//assigning name of the file uploaded in the server
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
   			
   			$OriginCol = $nCol;
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	    	    if(!is_numeric($m_OriginMtx[$i][$j]))
						{
						?>
			 			<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
						</script>
						<?php 
						}
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}               
            }

//---------------------------------------------------------------------------------------              
}

else 
{
    
	?>
	
	<script language= 'javascript'>
		alert("All input files must be in the same format i.e..either .xls or .csv ");
		location = 'GroFactMod.php';
	</script>
	<?php  
}

    ?>
        	
      		<div id ="SingOriCalc">
 			<?php
 			 
 			//	calculating growth factor
 			
 			echo '<caption><B>Growth Factor Calculations </B></caption>';
        	echo '<div id="scroller"><table class="table table-bordered table-hover">';
       		echo'<tr align="center"><td><B>Zone</B></td><td><B>Future year Origin total</B></td><td><B>Base year Origin total</B></td><td><B>Growth Factor For Each Originating Zone</B></td></tr>';
       
        	for ($j = 1; $j <= $nRow; $j++)
        	{
            	echo '<tr align="center"><td bgcolor="#CCE6FF"><B>'.$j.'</B></td><td bgcolor="#EBF5FF">';     
            	echo $m_OriginMtx[1][$j]."</td><td bgcolor='#EBF5FF'>";
            	echo $sumR[$j]."</td><td bgcolor='#CCE6FF'>";
            	$GFOrigin[$j] = $m_OriginMtx[1][$j] / $sumR[$j];
            	echo round($GFOrigin[$j], 3)."</td>";     
            	echo "</tr>";
        	}            
        	echo "</table></div>";        
        	?>

			<br><br>


			<button class = 'btn8'>Next</button>
    		</div> 
    		<?php
            //	 singly constrained growth factor model
            echo '<div id="SingOriFinal">';
        	echo '<caption><B>Singly Constrained Growth Factor Matrix For Future Year </B></caption>';
        	echo '<div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center"><td ><B>Zone</B></td>';
        	for ($i = 1; $i <= $nRow; $i++)
        	{
            	echo "<td><B>".$i."</B></td>";
        	}
        		echo "<td ><B>Origins Total Base year</B></td><td ><B>Origins Total Future year</B></td>";
 			    echo '</tr>';
        		for ($i = 1; $i <= $nRow; $i++)
        		{  
            		$SumOR[$i]=0;           
            		echo '<tr align="center">';
            		echo'<td bgcolor="#CCE6FF"><B>'.$i.'</B></td>';    
            		for ($j = 1; $j <= $nRow; $j++)
           			{                     
                		$UGOrigin[$i][$j] = $m_BaseMtx[$i][$j] * $GFOrigin[$i];
                		echo "<td>".round($UGOrigin[$i][$j])."</td>";
                		$SumOR[$i]+=round($UGOrigin[$i][$j]);                
              		}
              	echo "<td><B>".$SumOR[$i]."</B></td>";   
              	echo "<td><B>".$m_OriginMtx[1][$i]."</B></td>";
              	echo "</tr>";
        	}
        	echo "<tr>";
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
        	echo "</table></div><br><br>";  
        	echo "<button class = 'btn9'>Previous</button>";
    		echo "</div>";
        	   
    }
    elseif ($m_ConstraintsVal=="SinglyDest")
    {
    	move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder . $_FILES["DestFile"]["name"]);   //uploading or moving file to server
        
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
//------------------------------------------------Reading xls file-------------------------------------       
if($file_ext1 == '.xls' && $file_ext3 == '.xls')
{ 
       
        	$dataDestF = new Spreadsheet_Excel_Reader();
        	$dataDestF->setOutputEncoding('CP1251');
        	//$dataDestF->read('base_matrix.xls');
        	$dataDestF->read($folder.$m_DestFile);
        	error_reporting(E_ALL ^ E_NOTICE);

        	$DestinationCol = $dataDestF->sheets[0]['numCols'];
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    			location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        	{
            	echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            	for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               	{
                	$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	$m_TotalSum += $m_DestMtx[$i][$j];
            	}
        	}
		}
//------------------------------------------------Reading CSV file-------------------------------------       
         elseif($file_ext1=='.csv' && $file_ext3 == '.csv')
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
   			
		    $DestinationCol = $nCol;
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    			location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	for ($j = 1; $j <= $nCol; $j++)
               	{
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	$m_TotalSum += $m_DestMtx[$i][$j];
            	}
        	}
		}
		else 
		{ 
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'GroFactMod.php';
			</script>
			<?php  
		
		}
    	echo "</div>";
//---------------------------------------------------------------------------------
        	?>
      		<div id ="SingDestCalc">
			<?php 
			//Calculation for growth factor
			
        	echo '<caption><B>Growth Factor Calculations </B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        
        	echo'<tr align="center"><td><B>Zone</B></td><td><B>Future year Destination total</B></td><td><B>Base year Destination total</B></td><td><B>Growth Factor For Destination Zone</B></td></tr>';
       
        	for ($j = 1; $j <= $nRow; $j++)
        	{
            	echo '<tr align="center"><td ><B>'.$j.'</B></td><td>';      
            	echo $m_DestMtx[1][$j]."</td><td>";
            	echo $sumC[$j]."</td><td>";
            	$GFDest[$j] = $m_DestMtx[1][$j] / $sumC[$j];
            	echo round($GFDest[$j], 3)."</td>";
            	echo "</tr>";
        	}     
       
        	echo "</table></div>";         
        	?>

        
        	<?php 
			echo "<button class = 'btn13'>Next</button>";
    		echo "</div>";
    		
            //	 singly constrained growth factor model
            echo '<div id="SingDestFinal">';
        	echo '<caption><B>Singly Constrained Growth Factor Matrix For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center"><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nRow; $i++)
        	{
        	     echo "<td ><B>".$i."</B></td>";
        	}
        	echo "<td><B>Origins Total Base year</B></td>";
        	echo '</tr>';
        
        	for ($i = 1; $i <= $nRow; $i++)
        	{   
           		$SumDR[$i]=0;   
            	echo '<tr align="center">';       
           	 	echo '<td align="center" ><B>'.$i.'</B></td>';
            	for ($j = 1; $j <= $nRow; $j++)
            	{    
                	$UGDest[$i][$j] = $m_BaseMtx[$i][$j] * $GFDest[$j];
                	$SumDR[$i] += round($UGDest[$i][$j]);                     
                	echo '<td align="center">'.round($UGDest[$i][$j]).'</td>';
              	}    
              	echo "<td ><B>".$SumDR[$i]."</B></td>";    
            	echo "</tr>";
        	}
        
        	echo "<tr align=center>";
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
        	echo "<tr align='center'><td><B>Destination Total Future year</B></td>";        
        	for($i=1; $i <= $nRow; $i++)
        	{
            echo "<td><B>".$m_DestMtx[1][$i]."</B></td>";
        	}
          	echo "</tr>";
        	echo "</table></div><br><br>"; 
        	echo "<button class = 'btn14'>Previous</button>";
    		echo "</div>"; 
 
    }
 
}
elseif($m_MethodVal == "FratarGFM")
    {
    	$m_AccuracyVal = $_POST['AccuracyVal'];
        $m_txtAccuracy = $_POST['txtAccuracy'];      

        move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder . $_FILES["OriginFile"]["name"]);
        move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder . $_FILES["DestFile"]["name"]);
      
        $m_OriginFile = $_FILES['OriginFile']['name'];
        $m_DestFile = $_FILES['DestFile']['name'];
        
    	if(empty($m_AccuracyVal))
		{
			$m_AccuracyVal = $_POST['AccuracyVal'];
		}
    	if(empty($m_txtAccuracy))
		{
			$m_txtAccuracy = $_POST['txtAccuracy'];
		}
    	if(empty($m_OriginFile))
		{
			$m_OriginFile = $_POST['OriginFile'];
		}
    	if(empty($m_DestFile))
		{
			$m_DestFile = $_POST['DestFile'];
		}
       
	
		$itrbrk=$_POST['Itrbrk'];
		
   		if($_POST['first'])
		{
			$itrbrk=1;
		}
		if(empty($itrbrk))
		{
		    $itrbrk=$_POST['Itrbrk'];
		    $itrbrk = 1;
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
        if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
		{    
 
		
			$dataOriginF = new Spreadsheet_Excel_Reader();
        	$dataOriginF->setOutputEncoding('CP1251');
        	$dataOriginF->read($folder.$m_OriginFile); 			//Reading origin file	
        	error_reporting(E_ALL ^ E_NOTICE);
        	
        	
        	
        	$OriginCol = $dataOriginF->sheets[0]['numCols'];
        	$OriginRow = $dataOriginF->sheets[0]['numRows'];
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	  
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriginRow; $i++)
        	{
            
         		for ($j = 1; $j <= $nCol; $j++)
            	{
                	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                	if(!is_numeric($m_OriginMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	$m_TotalSum += $m_OriginMtx[$i][$j];
               	}

                 
        	}
       
        	$dataDestF = new Spreadsheet_Excel_Reader();
        	$dataDestF->setOutputEncoding('CP1251');
        	$dataDestF->read($folder.$m_DestFile);			//	Reading Destination file
        	error_reporting(E_ALL ^ E_NOTICE);
        	
        	
        	
			$DestinationCol = $dataDestF->sheets[0]['numCols'];
			$DestinationRow = $dataDestF->sheets[0]['numRows'];
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    			location="GroFactMod.php";
	    		</script>
	    	<?php
			}
			
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestinationRow; $i++)
        	{
            
           		for($j = 1; $j <= $DestinationCol; $j++)
               	{
                	$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	$m_TotalSum += $m_DestMtx[$i][$j];
            	}
        	}

        	
		}

//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
		{


			//	Reading Destination file
			
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
   			
   			        	
        	$OriginCol = $nCol;
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	if(!is_numeric($m_OriginMtx[$i][$j]))
						{
						?>
			 			<script lanuguage = javascript> 
			 
							alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?=$i?>,<?=$j?>]")
							location = "GroFactMod.php";
			
						</script>
						<?php 
						}
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}               
            }
     
        	
        	//	Reading Destination file
        	
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
   			
   			
   			$DestinationCol = $nCol;
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix.");
	    			location="GroFactMod.php";
	    		</script>
	    		<?php
			}

        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	for ($j = 1; $j <= $nCol; $j++)
               	{
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
            	}
        	}
		
		}
		else 
		{
		
		    
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'GroFactMod.php';
			</script>
			<?php  
		
		}
//---------------------------------------------------------------------------------

		
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
            		// Checking whether each individual cells of base year value is within the limit of accuracy given by the user for the future year
            		
                 	$m_a=(((($m_OriginMtx[1][$j]-$sumRD[$j])*100)/$sumRD[$j])> $m_txtAccuracy || ((($m_DestMtx[1][$j]-$sumCD[$j])*100)/$sumCD[$j])> $m_txtAccuracy); 
            	}
            }
            else
            {   
            	// Checking whether total destination or origin total value of base year is within the limit of accuracy given by the user for the future year
            	                     
                 $m_a = ((($TotalFutureR-$TotalBaseSumR)*100)/$TotalBaseSumR)>$m_txtAccuracy;               
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

                for ($l = 1; $l <= $nRow; $l++)
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
        }while($m_a==1 && $itr < $itrbrk);  

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
        		echo '<caption><B>Fratar Growth Factor Matrix For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
                echo'<tr align="center"><td><B>Zone</B></td>';
                for ($i = 1; $i <= $nRow; $i++)
                {
                    echo "<td><B>".$i."</B></td>";
                }      
                 echo "<td><B>Current Origins Total</B></td><td><B>Origins Total Future year</B></td>";                 
                 echo '<tr align="center">';       

                for ($k = 1; $k <= $nRow; $k++)
                {          
                    echo '<td align="center"><B>'.$k.'</B></td>';

                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           
                           echo '<td align="center" >'.round($s[$k][$l],3).'</td>';      
                    }   
                    echo '<td align="center"><B>'.round($SumDobR1[$k],3).'</B></td>';     // S  
                    echo "<td align='center'><B>".$m_OriginMtx[1][$k]."</B></td>";  //S
                    echo"</tr>";          
                }
               
                // S
                echo "<tr>";
                echo '<td  align="center"><B>Current Destinations Total</B></td>';
                   for ($k = 1; $k <= $nRow; $k++)
                {
                      echo "<td align='center'><B>".round($SumDobC1[$k],3)."</B></td>";              
                }
                 echo "</tr>";
                 echo "<tr><td align='center'><B>Destinations Total Future year</B></td>";
                   for ($l = 1; $l<= $nRow; $l++)
                  {
                         echo "<td align='center'><B>".$m_DestMtx[1][$l]."</B></td>";
                  }
                   echo"  </tr>";
                // S
                echo "</table></div><BR>";


 				echo '<caption><B>Fratar Growth Factor Matrix For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
                echo'<tr align="center"><td><B>Zone</B></td>';
                for ($i = 1; $i <= $nRow; $i++)
                {
                    echo "<td><B>".$i."</B></td>";
                }      
                echo "<td><B>Current Origins Total</B></td><td><B>Origins Total Future year</B></td>";
                echo "</tr>";
                echo '<tr align="center">';
                
                for ($l = 1; $l <= $nRow; $l++)
                {
                    echo '<td align="center" ><B>'.$l.'</B></td>';
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        echo '<td align="center">'.round($t[$k][$l],3).'</td>';      
                    }  
                    echo '<td align="center" ><B>'.round($SumDobR2[$l],3).'</B></td>';  
                    echo "<td align='center'><B>".$m_OriginMtx[1][$l]."</B></td>";  //S
                    echo "</tr>";           
                }
                
                echo "<tr>";
                echo '<td align="center"><B>Current Destinations Total</B></td>';
                   for ($k = 1; $k <= $nRow; $k++)
                {
                      echo "<td align='center'><B>".round($SumDobC2[$k],3)."</B></td>";              
                }
                 echo "</tr>";
                 echo "<tr><td align='center'><B>Destinations Total Future year</B></td>";
                   for ($l = 1; $l<= $nRow; $l++)
                  {
                         echo "<td align='center'><B>".$m_DestMtx[1][$l]."</B></td>";
                  }
                   echo"  </tr>";
              
                
                echo "</table></div>";
                echo "<br><br>";
	            
     if($itr < $itrbrk)
        {
                echo "<h2>No. of Iteration taken to reach final result : ".$itr."</h2>";
                echo "<br><br>";
        }
        else
        {
        		echo "<h2>Current Iteration &nbsp;# ".$itr."</h2>";
                echo "<br><br>";
        }
    }
    

?>
<form enctype="multipart/form-data" method="post" name="Frm" action="GroFactModRes.php">

        	<input type="hidden" name="MethodVal" value="<?=$m_MethodVal?>">
        	<input type="hidden" name="txtGrowth" value="<?=$m_txtGrowth?>">
        	<input type="hidden" name="ConstraintsVal" value="<?=$m_ConstraintsVal?>"> 
        	   
        	<input type="hidden" name="AccuracyVal" value="<?=$m_AccuracyVal?>"> 
        	<input type="hidden" name="txtAccuracy" value="<?=$m_txtAccuracy?>"> 
        	<input type="hidden" name="BaseFile" value="<?=$m_BaseFile?>"> 
        	<input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
        	<input type="hidden" name="DestFile" value="<?=$m_DestFile?>">
        	<input type="hidden" name="Itrbrk" value="<?=$itrbrk?>"> 
        	<input type="hidden" name="Itr" value="<?=$itr?>">
        	<input type="hidden" name="stop" value="<?=$stop?>">
			
			    <?php 
			    
			    if($m_MethodVal == "FratarGFM")
			    {
			        echo'<tr>';
			        if($itrbrk != 1 && !($itr < $itrbrk))
    			    {
    			       echo'<td align="left"><input type="submit" class=button value="First " name="first"><span class="tab"></span>';
    			        
    			    }
			    	if($itrbrk>1 && $m_a == 1 )
			    	{
			        	 echo'<input type="submit" class=button value="Previous" name="Previous"><span class="tab"></span>';
    				}
    				if(!($itr < $itrbrk))
    				{
    				     echo'<input type="submit" class=button value="Next" name="Next"><span class="tab"></span>';
    				     echo'<input type="submit" class=button value="Last" name="FinalRes"><span class="tab"></span>';
    				}
    				if($m_a != 1)
    				{
			        echo'<td align="left"> Select number of iteration to be printed in the report :';
			        echo'<td align="left">';
			        ?>
			        <select name="numItr">
        			<?php 
        			for ($i = 1; $i <= $itr; $i++) 
        			{
        				?>
        					<option><?php echo $i; ?></option>        					
        				<?php 
        			}
        			?>
					</select>
					<br>
					<b>(Note: Final iteration will always be printed in the report)</b>					
        			<?php    
					}
			    }
   			
    			?>							
				
		</div>
<table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk1()">
</td></tr>
</table>
		
        
</form>


<br>

</table>

<table cellspacing=5 width = "100%" align="center" border=0>
<tr>


</tr>
<tr>
<?php 
	if($m_MethodVal == "UniformGFM")
    {
          ?>
          <td align="center">&nbsp;&nbsp;<a href="GroFactModDel.php?MethodVal=<?=$m_MethodVal?>&BaseFile=<?=$m_BaseFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
          <?php
    }
    elseif($m_MethodVal == "SinglyGFM")
    {
    	if($m_ConstraintsVal=="SinglyOrigin")    	
    	{
        ?>
        <td align="center">&nbsp;&nbsp;<a href="GroFactModDel.php?MethodVal=<?=$m_MethodVal?>&ConstraintsVal=<?=$m_ConstraintsVal?>&BaseFile=<?=$m_BaseFile?>&OriginFile=<?=$m_OriginFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
        <?php
    	}
    	elseif ($m_ConstraintsVal=="SinglyDest")
    	{
    		?>
        	<td align="center">&nbsp;&nbsp;<a href="GroFactModDel.php?MethodVal=<?=$m_MethodVal?>&ConstraintsVal=<?=$m_ConstraintsVal?>&BaseFile=<?=$m_BaseFile?>&DestFile=<?=$m_DestFile?>"><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
        	<?php
    	}
    }
    elseif($m_MethodVal == "FratarGFM")
    {
        ?>
       	<td align="center">&nbsp;&nbsp;<a href="GroFactModDel.php?MethodVal=<?=$m_MethodVal?>&BaseFile=<?=$m_BaseFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
        <?php
    }
?>
</tr>

</table>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 
