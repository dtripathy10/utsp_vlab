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

$file = fopen($folder."DoubGravModReport.xls", "a+");   
fclose($file);

$file1 = fopen($folder."CostFile.xls", "w");
$url = "../Docs/costmatrix.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."CostFile.xls");

$m_CostFile = "CostFile.xls";

$file2 = fopen($folder."OriginFile.xls", "w");
$url = "../Docs/Origin_gravity.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."OriginFile.xls");

$m_OriginFile = "OriginFile.xls";

$file3 = fopen($folder."DestFile.xls", "w");
$url = "../Docs/destination_gravity.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."DestFile.xls");

$m_DestFile = "DestFile.xls";

//$m_CostFile = $_FILES['CostFile']['name'];
//$m_OriginFile = $_FILES['OriginFile']['name'];
//$m_DestFile = $_FILES['DestFile']['name'];



//---------------------------------- verifying the format of the file ---------------------------

//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$folder.$_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder.$_FILES["OriginFile"]["name"]);
move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder.$_FILES["DestFile"]["name"]);

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

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("#OriTot").hide();
	$("#DestTot").hide();
	$("#calculation").hide();
	$("#Final").hide();
	$("#submit").hide();
	$(".btn1").click(function(){
	    $("#cost").slideUp("slow");
	    $("#OriTot").slideDown("slow");
	    
  	});

	    
  	

	$(".btn2").click(function(){
		$("#submit").hide();
	    $("#OriTot").slideUp("slow");
	    $("#cost").slideDown("slow");
	    
  	});
	


	$(".btn3").click(function(){
		
		$("#OriTot").slideUp("slow");
		$("#DestTot").slideDown("slow");
		$("#submit").slideDown();
	    
  	});

	$(".btn4").click(function(){
		$("#submit").hide();
		$("#DestTot").slideUp("slow");
		$("#OriTot").slideDown("slow");
 
	    
  	});
	$(".btn5").click(function(){
		
		$("#DestTot").slideUp("slow");
		$("#submit").slideDown("slow");
 
	    
  	});


	  
});
</script>

<script language="javascript">

function chk1()
{
	
		document.Frm.action="DoubGravModDefaultInput.php?Exp=4";	
}


</script>

</head>
<div id="body">
<br>
<center> 
<?php


//------------------------------- Reading Xls file ----------------------------------------


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
			location = "SigGravMod.php?Exp=4";			
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
						location = "SigGravMod.php?Exp=4";
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
	<button class="btn1">
	Next
	</button>
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
	    		    location="SigGravMod.php?Exp=4";
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
						location = "SigGravMod.php?Exp=4";			
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
	    		    location="SigGravMod.php?Exp=4";
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
						location = "SigGravMod.php?Exp=4";			
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
		echo "</div>";    
        

//---------------------------------------------------------------------------------



        
fclose($file1);
fclose($file2);
fclose($file3);
?>

</table>
<form enctype="multipart/form-data" method="post" name="Frm" action="DoubGravModDefaultInput.php?Exp=4">
    <input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
    <input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
    <input type="hidden" name="DestFile" value="<?=$m_DestFile?>"> 
<div id ="submit">
<button class="btn4">Back</button>
<input type="submit" class=button value="Next" name="Submit">

</div>

   
		
</form>

<br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>

<!--  <td align="center">&nbsp;&nbsp;<a href="SigGravMod.php?Exp=4"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td> -->

<td align="center">&nbsp;&nbsp;<a href="DoubGravModDel.php?Exp=4&CostFile=<?=$m_CostFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type ="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>     
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
