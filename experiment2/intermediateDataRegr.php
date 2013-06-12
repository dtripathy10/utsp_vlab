<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4,"Regression Analysis","Trip Generation");

  ?>
<div id="body">
<?
session_start();
$UploadFile = $_SESSION['user'];
$m_TripFile =$_SESSION['TripFile'];
if(empty($m_TripFile))
{
	$m_TripFile =$_POST['TripFile'];
}
$m_AnalysisVar = $_POST['AnalysisVar'];
	
//include("DataRegrModRptpdf.php");
include("AddDataRegrRpt.php");
	
	
?> 

<form enctype="multipart/form-data" method="post" name="Frm">
<h1><font color="Black" size="4"><b>Data Successfully added to the Report.</b></font></br>
<br>
<a href='../user/<?php echo $UploadFile?>/Experiment2/DataRegr.xls' target="new"><font color="#800000" size="2"><b>Click to Download Overall Report(.xls)</b></font></a>
 </br><br>
 <!--
<a href='abcd.php?Exp=2'  target="new"><font color="#800000" size="2"><b>Click to Download Overall Report(.pdf)</b></font></a>
</br><br>	
 -->
<a href = DataRegrMod2.php?TripFile=<?php echo $m_TripFile ?>><font color="#800000" size="2"><b>Go back to experiment</b></font></a>
</form>


</div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 	