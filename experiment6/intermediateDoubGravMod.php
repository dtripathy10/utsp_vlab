<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Doubly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment6/";


// Retrieving the values of variables
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];   

$m_CostFile = $_POST['CostFile'];
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];
$m_FunctionsVal = $_POST['FunctionsVal'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];

$m_numItr = $_POST['numItr'];

include("AddDoubGravModRpt.php");
include("DoubGravModrptPdf.php");

?>
</head>
<div id="body">

<form enctype="multipart/form-data" method="post" name="Frm" >
<h1><font color="Black">Data Successfully added to the Report.</h1>
<br>
<a href='../user/<?php echo $UploadFile?>/Experiment6/DoubGravModReport.xls' target="new"><h3>Click to Download Overall Report (.xls)</h2></a>
<br>
<a href='abcd.php?Exp=6'  target="new"><h3>Click to Download Overall Report(.pdf)</h2></a>
<br>	
<a href = "DoubGravMod.php?Exp=4"><h3>Go back to experiment</h2></a>
</form>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	

