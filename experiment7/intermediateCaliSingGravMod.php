<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment7/";

$m_FunctionsVal = $_POST['FunctionsVal'];
$m_MethodVal = $_POST['MethodVal'];			
$m_CostFile = $_POST['CostFile']; 
$m_TripFile = $_POST['TripFile']; 
	 
include("AddCaliSingGravModRpt.php");
include("CaliSingModrptPdf.php");

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
<a href='<?php echo $folder;?>CaliSingGravModReport.xls' target="new"><h3>Click to Download Overall Report (.xls)</h2></a>
<br>
<a href='abcd.php?Exp=7'  target="new"><h3>Click to Download Overall Report(.pdf)</h2></a>
<br>
<a href = "CaliSingMod.php?Exp=5"><h3>Go back to experiment</h2></a>
</form>

</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
	