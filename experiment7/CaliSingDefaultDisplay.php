<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment7/";
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}


$file = fopen($folder."CaliSingGravModReport.xls", "a+");   
fclose($file);

$file1 = fopen($folder."CostFile.xls", "w");
$url = "../Docs/cost_calb.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."CostFile.xls");

$m_CostFile = "CostFile.xls";

$file2 = fopen($folder."TripFile.xls", "w");
$url = "../Docs/trip_calib.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."TripFile.xls");

$m_TripFile = "TripFile.xls";

//  move uploaded files to user specific folder 


?>


<style type="text/css">
#scroller {
    width:800px;
    height:300px;
    overflow:auto;
 }
</style>

<script language="javascript">
function chk1()
{ 

	document.Frm.action="CaliSingInput.php?Exp=5";	
}

</script>

</head>
<div id="body">
<center> 

<?php


//------------------------------- Reading Xls file ------------------------------------------


	require_once '../phpExcelReader/Excel/reader.php';
	$dataCostF = new Spreadsheet_Excel_Reader();
	$dataCostF->setOutputEncoding('CP1251');
	$dataCostF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	
	$n=$dataCostF->sheets[0]['numRows'];
	$CostRow = $dataCostF->sheets[0]['numRows'];
	$CostCol = $dataCostF->sheets[0]['numCols'];

	echo '<caption><b>Cost Matrix </b></caption><div id="scroller"><table class="table table-bordered table-hover">';

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
        	
        	// check for number
        	
    	    if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliSingMod.php?Exp=5";			
					</script>
				<?php 
			}
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    	echo "</tr>";
	}
?>
	</table>
	</div>

	<br><br>

<?php

     // Trip File
     
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
         
		$TripRow = $dataTripF->sheets[0]['numRows'];
		$TripCol = $dataTripF->sheets[0]['numCols'];
		
		// check for square matrix

		
        echo '<caption><b> Given Base Year Trip Matrix </b></caption><div id="scroller"><table class="table table-bordered table-hover">';
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
                
                // check for number
                
            	if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliSingMod.php?Exp=5";			
					</script>
				<?php 
				}
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
         echo "</table></div><br><br>";


	// Cost File

   
 ?>
<br>
<form enctype="multipart/form-data" method="post" name="Frm" action="CaliSingInput.php?Exp=5">
<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
</tr>
</table>
         	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="TripFile" value="<?=$m_TripFile?>"> 
</form>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
	<!--  <td align="center">&nbsp;&nbsp;<a href="CaliSingMod.php?Exp=5"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td>	-->
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;<a href="CaliSingModDel.php?Exp=5&CostFile=<?=$m_CostFile?>&TripFile=<?=$m_TripFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
