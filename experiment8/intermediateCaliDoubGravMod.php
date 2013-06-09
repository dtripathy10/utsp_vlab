<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment8/";


$m_FunctionsVal = $_POST['FunctionsVal'];
$m_AccuracyVal = $_POST['AccuracyVal'];			
$m_txtAccuracy = $_POST['txtAccuracy'];  

$m_CostFile = $_POST['CostFile']; 
$m_TripFile = $_POST['TripFile']; 

include("AddCaliDoubGravModRpt.php");
include("CaliDoubModrptPdf.php");

//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));


if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="CaliDoubMod.php?Exp=6";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------	 
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

</head>

<div id="body">

<form enctype="multipart/form-data" method="post" name="Frm" >
<h1><font color="Black">Data Successfully added to the Report.</h1>
<br>
<a href='<?php echo $folder?>CaliDoubGravModReport.xls' target="new"><h3>Click to Download Overall Report (.xls)</h2></a>
<br>
<a href='abcd.php?Exp=8'  target="new"><h3>Click to Download Overall Report(.pdf)</h2></a>
<br>	
<a href = "CaliDoubMod.php?Exp=6"><h3>Go back to experiment</h2></a>
</form>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 