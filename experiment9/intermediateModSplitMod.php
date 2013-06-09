<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Mode Split");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment9/";

$m_nmode = $_POST['nmode'];

 $m_txtcoTV = $_POST['txtcoTV'];
 $m_txtcoTW = $_POST['txtcoTW'];
 $m_txtcoTT = $_POST['txtcoTT'];
 $m_txtcoFC = $_POST['txtcoFC'];
 $m_txtcoPC = $_POST['txtcoPC'];
 $m_txtcoOP = $_POST['txtcoOP'];
 $m_trip = $_POST['trip'];

	for ($i=0; $i < $m_nmode ;$i++)
	{	
    	$m_ModeName[$i] = $_POST['ModeName'][$i];
	
    	$m_txtTV[$i] = $_POST['txtTV'][$i];
	
    	$m_txtTW[$i] = $_POST['txtTW'][$i];
	
    	$m_txtTT[$i] = $_POST['txtTT'][$i];
	
    	$m_txtFC[$i] = $_POST['txtFC'][$i];
	
    	$m_txtPC[$i] = $_POST['txtPC'][$i];

    	$m_txtOP[$i] = $_POST['txtOP'][$i];
	}
		
	
	
include("AddModSplitRpt.php");
include("ModSplitModRptPdf.php");
?>
<div id="body">
<form enctype="multipart/form-data" method="post" name="Frm" action =" AddModSplitRpt.php">
<h1><font color="Black">Data Successfully added to the Report.</h1><br>
<a href='../user/<?php echo $UploadFile?>/Experiment9/ModSplitReport.xls' target="new"><h3>Click to Download Overall Report (.xls)</h2></a><br>
<a href='abcd.php?Exp=9' target="new"><h3>Click to Download Overall Report (.pdf)</h2></a><br>
<a href = "ModeChoiceInput1.php"><h3>Go back to experiment</h2></a>
</form>
</div>
<?php
  include_once("footer.php");
  getFooter(3);
?> 