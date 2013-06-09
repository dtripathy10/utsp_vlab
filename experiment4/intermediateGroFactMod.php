<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Growth Factor Distribution Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment4/";

$m_MethodVal = $_POST['MethodVal'];			//To retrieve values of the selected method
$m_BaseFile = $_POST['BaseFile']; 	 
$m_txtGrowth = $_POST['txtGrowth'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];

include("AddGroFactRpt.php");
include("GroFactModrptPdf.php");
	
?> 

<div id="body">  

<form enctype="multipart/form-data" method="post" name="Frm" action="GroFactModRes.php">
<h1><font color="Black">Data Successfully added to the Report.</h1>
<br>
<a href='<?php echo $folder?>GroFactReport.xls' target="new"><h3>Click to Download Overall Report(.xls)</h2></a>
<br>
<a href='abcd.php?Exp=4'  target="new"><h3>Click to Download Overall Report(.pdf)</h2></a>
<br>
<a href ="GroFactMod.php"><h3>Go back to experiment</h2></a>
</form>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  