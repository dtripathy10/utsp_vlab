 <?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3/";

if(!is_dir($folder))
{
	mkdir($folder, 0777);
}


$m_CatAnalysis = fopen($folder."CategoryAnalysisReport.xls", "a+");   
fclose($m_CatAnalysis);

$file1 = fopen($folder."observedSurvey.xls", "w");
$url = DOC_FOLDER."/survey_old.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."observedSurvey.xls");

$m_CatAnalysis = "observedSurvey.xls";


//  move uploaded files to user specific folder 


?>

<style type="text/css">
#scroller 
{
    width:900px;
    height:300px;
    overflow:auto;
    border-bottom:2px solid #999;
 }

 #vert
 {
    /* for firefox, safari, chrome, etc. */
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    /* for ie */
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
 }

</style>
<!-- Validation for Form Controls -->

<script language="javascript">
function chk1()
{	

	document.Frm.action="CatAnalysisMod3.php?Exp=17";
	//document.Frm.target="_blank"; 
}
</script>

</head>
<div id="body">
<center>   
<form enctype="multipart/form-data" method="post" name="Frm" action="CatAnalysisModDefault.php?Exp=17">
<?php 

//------------------------------- reading Xls file-------------------------------------------------

	// Trip File

		require_once EXCELREADER.'/Excel/reader.php';
        $dataCatF = new Spreadsheet_Excel_Reader();
        $dataCatF->setOutputEncoding('CP1251');       
        $dataCatF->read($folder.$m_CatAnalysis);
        error_reporting(E_ALL ^ E_NOTICE);
       	$nRow = $dataCatF->sheets[0]['numRows'];
        $nCol = $dataCatF->sheets[0]['numCols'];
        
        echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
        for ($i = 1; $i <= $nRow; $i++)
        {               
            echo '<tr align="center" >';           
            for ($j = 1; $j <= $nCol; $j++)
            {
                // saving excel file data in to $m_TripMtx 2-Dimension array variable
                            
                $m_CatMtx[$i][$j]=$dataCatF->sheets[0]['cells'][$i][$j];
                
                if($i>=2)
                {
               		if(!is_numeric($m_CatMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "CatAnalysisMod.php?Exp=17";	
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td ><b>".$m_CatMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_CatMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br><br>";  

        


//----------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------       
		echo "<b>Select no. of  Criteria: </b>";
		echo '<select name="no_of_criteria" ';
		?>
		<option value="">Select</option>
		<?php 
		for ($k = 1; $k <($nCol-1); $k++)
        {
        	?>
  			<option value="<?php echo $k?>"><?php echo $k?></option>  			
  			<?php     			
        }
       echo '</select><br><br><br>';
       
            

?>
<br><br><br>

<input type="hidden" name="CatFile"  value="<?=$m_CatAnalysis?>"> 


<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
<td align="left"><input type="Reset" class=button value="Reset"></td>
</tr>
</table> 
<br><br>
<a href="CatAnalysisMod.php?Exp=17"><H2><input type ="button" value="Back"></H2></a>
<br>
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	

