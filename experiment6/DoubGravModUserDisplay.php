<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Doubly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment6/";

if(!is_dir($folder))
{
	mkdir($folder, 0777);
}


$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_FILES['CostFile']['name'];
$m_OriginFile = $_FILES['OriginFile']['name'];
$m_DestFile = $_FILES['DestFile']['name'];


//---------------------------------- verifying the format of the file ---------------------------

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


//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$folder. $_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder. $_FILES["OriginFile"]["name"]);
move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder. $_FILES["DestFile"]["name"]);

?>



<style type="text/css">

#scroller {
    width:800px;
    height:300px;
    overflow:auto;   
 }
 
 .title1 
		{
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: x-normal;
			color: #00529C;			
			font-weight : bold;
			text-align: center;			
		}
		.lable1
		{ 
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: xx-small;
			color: #00529C;
			background-color: #ECECEC;
			font-weight : bold;
		}
</style>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("#OriTot").hide();
	$("#DestTot").hide();
	//$("#submit").hide();
	$(".btn1").click(function(){
	    $("#cost").slideUp("slow");
	    $("#OriTot").slideDown("slow");
	    
  	});

	    
  	

	$(".btn2").click(function(){
	    $("#OriTot").slideUp("slow");
	    $("#cost").slideDown("slow");
	    
  	});
	


	$(".btn3").click(function(){
		
		$("#OriTot").slideUp("slow");
		$("#DestTot").slideDown("slow");
		
	    
  	});
	
	$(".btn4").click(function(){
		
		$("#DestTot").slideUp("slow");
		$("#OriTot").slideDown("slow");
 
	    
  	});
	$(".btn5").click(function(){
		
		$("#DestTot").slideUp("slow");
		$("#Submit").slideDown("slow");
 
	    
  	});

});
</script>


<script language="javascript">
function chk1()
{ 
	document.Frm.action="DoubGravModDefaultInput.php";	
}

</script>


</head>
<div id="body">
<center>  
<?php


//------------------------------- Reading Xls file ----------------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{
	// Cost File

	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	//$n=$dataBaseF->sheets[0]['numRows'];
	$n = $dataBaseF->sheets[0]['numRows'];
	$nCol = $dataBaseF->sheets[0]['numCols'];
	
	$CostRow = $dataBaseF->sheets[0]['numRows'];
	$CostCol = $dataBaseF->sheets[0]['numCols'];
	if($CostRow != $CostCol)
	{
		?>
		<script lanuguage = javascript> 
 			// check for square matrix
			alert("The Base Year O-D Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
			location = "DoubGravMod.php";			
		</script>
		<?php 		
	}
	?>
	
	<div id="cost">
	<div id="scroller">
	<table class="table table-bordered table-hover">
	<caption><b> Base Year O-D Cost Matrix </b></caption>
	<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $n; $i++)
	{
	       echo "<td ><b>".$i."</b></td>";
	}
	//echo "<td>Origin Total</td>";
	for ($i = 1; $i <= $n; $i++)
	{
   	// $sumR[$i]=0;
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	echo "<td bgcolor='#EBF5FF'>";        
       	// $sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];         
        //echo $dataBaseF->sheets[0]['cells'][$i][$j];
       		$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
    		
       		// check for number
       		if(!is_numeric($m_BaseMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 
			 			alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php";
					</script>
				<?php 
			}
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
	</div>
	<button class="btn1">Next</button>
	</div>
	<br>

	<?php
	
		// Origin File
               
        $dataOriginF = new Spreadsheet_Excel_Reader();
        $dataOriginF->setOutputEncoding('CP1251');
        //$dataOriginF->read('base_matrix.xls');
        $dataOriginF->read($folder.$m_OriginFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $OriginRow = $dataOriginF->sheets[0]['numRows'];
        $OriginCol = $dataOriginF->sheets[0]['numCols'];
        
		if( !($OriginCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
	   				// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="DoubGravMod.php";
	    		</script>
	    	<?php
		}        	        
   		echo '<div id="OriTot">';
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Origins Total </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
        for ($i = 1; $i <= $nCol; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo '</tr>';
        
        //$m_TotalSum=0;
        for ($i = 1; $i <= $OriginRow; $i++)
        {        
            echo '<tr align="center" bgcolor="#EBF5FF"><td>&nbsp</td>';
            for ($j = 1; $j <= $nCol; $j++)
            {
                echo '<td>';
                  //echo $dataOriginF->sheets[0]['cells'][$i][$j];
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                
                // check for number
                if(!is_numeric($m_OriginMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 			
						alert("Enter Only Numeric Values in Future Year Origin Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php";			
					</script>
					<?php 
				}
                echo $m_OriginMtx[$i][$j];
                //$m_TotalSum += $m_OriginMtx[$i][$j];
                echo "</td>";
               }    
               echo "</tr>";             
        }
        
       
        echo "</table></div><br>";
        
		echo '<button class="btn2">Back</button>';
		echo'<button class="btn3">Next</button>';
		echo '</div>';
        
        // Destination File 
       
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        //$dataDestF->read('base_matrix.xls');
        $dataDestF->read($folder.$m_DestFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        
        $DestRow = $dataDestF->sheets[0]['numRows'];
        $DestCol = $dataDestF->sheets[0]['numCols'];
        
		if( !($DestCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
	   				// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    		    location="DoubGravMod.php";
	    		</script>
	    	<?php
		}
		
		echo '<div id="DestTot">';
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Destinations Total </b></caption>';
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
                //echo $dataDestF->sheets[0]['cells'][$i][$j];
                $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                
                // check for number
                if(!is_numeric($m_DestMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 			
						alert("Enter Only Numeric Values in Future Year Destination Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php";			
					</script>
					<?php 
				}
                echo $m_DestMtx[$i][$j];
                $m_TotalSum += $m_DestMtx[$i][$j];
                echo "</td>";   
            }
            echo "</tr>";  
        }
        echo "</table></div><br>";
      //  echo '<button class="btn4">Back</button>';
	//	echo'<button class="btn5">Next</button>';
	//	echo '</div>';
        
}
//---------------------------------------------------------------------------------


//----------------------------- Reading csv file --------------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
{
	// Cost File
	
    $nCol=0; 
	$n = 0;
	$name = $folder.$m_CostFile;
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
    
	$CostRow = $n;
	$CostCol = $nCol;

	if($CostRow != $CostCol)
	{
		?>
		<script lanuguage = javascript> 
			// check for square matrix
			alert("The Base Year O-D Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
			location = "DoubGravMod.php";
		</script>
		<?php 		
	}	
	?>
	<div id="cost">
	<div id="scroller">
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
        	
        	// check for number
    		if(!is_numeric($m_BaseMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php";			
					</script>
				<?php 
			}        
           	echo $m_BaseMtx[$i][$j];     
        	echo "</td>";            
    	}
  
    	echo "</tr>";  
	}
	?>
	</table>
	</div>
	<button class="btn1">Next</button>
	</div>
	<br>

	<?php
	
		// Origin File
		
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
		$OriginRow = $OriRow;
		$OriginCol = $nCol;
		if( !($OriginCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
			   		// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    			location="DoubGravMod.php";
	    		</script>
	   		<?php
		}
		echo '<div id="OriTot">';
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Origins Total </b></caption>';
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
                
                // check for number
                if(!is_numeric($m_OriginMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Future Year Origin Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php";			
					</script>
					<?php 
				}
                echo $m_OriginMtx[$i][$j];
                echo "</td>";
               }    
               echo "</tr>";             
        }
        echo "</table></div><br>";
        echo '<button class="btn2">Back</button>';
		echo'<button class="btn3">Next</button>';
		echo '</div>';
        
        // Destination File 
       
        
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
       
        $DestCol = $nCol;
		if( !($DestCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
	   				// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="DoubGravMod.php";
	    		</script>
	    	<?php
		}
        
		echo '<div id="DestTot">';
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Destinations Total </b></caption>';
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
                   	
                   	// check for number
              		if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 			<script lanuguage = javascript> 
			 				alert("Enter Only Numeric Values in Future Year Destination Total File !! \n Error at [<?=$i?>,<?=$j?>]")
							location = "DoubGravMod.php";
						</script>
					<?php 
					}   
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                 	echo "</td>";   
            }
            echo "</tr>";  
        }
        echo "</table></div><br>";
        
		
//-----------------------------------------------------------------------------

}
else
{
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'DoubGravMod.php';
			</script>
			<?php  
}
        
?>



<form enctype="multipart/form-data" method="post" name="Frm" action="DoubGravModUserDisplay.php">


<br>       
<div id="submit">       
        <table cellspacing=5>
                	        
        	<input type="hidden" name="AccuracyVal" size="50" value="<?=$m_AccuracyVal?>"> 
        	<input type="hidden" name="txtAccuracy" size="50" value="<?=$m_txtAccuracy?>"> 
        	<input type="hidden" name="txtBeta" value="<?=$m_txtBeta?>">
        	<input type="hidden" name="txtBeta1" value="<?=$m_txtBeta1?>">
        	<input type="hidden" name="txtBeta2" value="<?=$m_txtBeta2?>">        	
        
        	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
        	<input type="hidden" name="DestFile" value="<?=$m_DestFile?>"> 
        	
<button class="btn4">Back</button> 
<input type="submit" class="btn4" value="Next" name="Submit" OnClick="return chk1()">
</div> 
<?php 

?>
<!--<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>-->
<!--<td align="left"><input type="Reset" class=button value="Reset"></td>-->
</tr>
</table>		
</form>

<br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>

<!--  <td align="center">&nbsp;&nbsp;<a href="DoubGravMod.php"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td> -->

<td align="center">&nbsp;&nbsp;<a href="DoubGravModDel.php?CostFile=<?=$m_CostFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type="button" value ="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>     
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
