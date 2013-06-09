 <?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3/";

$m_no_of_criteria = $_POST['no_of_criteria'];


$m_CatAnalysis = $_FILES['CatFile']['name'];
if(empty($m_CatAnalysis) )
{
	$m_CatAnalysis = $_POST['CatFile'];
}
$m_CatAnalysis2 = $_FILES['CatFile2']['name'];
if(empty($m_CatAnalysis2) )
{
	$m_CatAnalysis2 = $_POST['CatFile2'];
}

for ($i = 0; $i < $m_no_of_criteria; $i++)
{
			
  		$m_Category[$i] = $_POST['Category'][$i];
}

$tot=0;
for ($i = 0; $i < $m_no_of_criteria; $i++)
{

  			 $m_no_of_groups[$i] = $_POST['no_of_groups'][$i];
  			 $tot = $tot+ $m_no_of_groups[$i];
}


for ($j = 0; $j <= $tot; $j++) 
{ 
		 $m_lower_criGrp[$j] = $_POST['lower_criGrp'][$j];
}
for ($j = 0; $j <= $tot; $j++) 
{
		 $m_upper_criGrp[$j] = $_POST['upper_criGrp'][$j];	
}


$counter = $_POST['counter'];

for ($i = 0; $i < $counter; $i++)
{
	$m_TripRateValues[$i] = $_POST['TripRateValues'][$i];

}



include "CatAnalysisModRpt2.php";
include 'CatAnalysisModRptPdf2.php';
	
?> 

<div id="body">
<form enctype="multipart/form-data" method="post" name="Frm">
<h1><font color="Black" size="4"><b>Data Successfully added to the Report.</b></font><br><br>
<a href="<?php echo $folder;?>CategoryAnalysisReport.xls" target="new"><font color="#800000" size="2"><b>Click to Download Overall Report(.xls)</b></font></a><br><br>
<a href='CatAnalysismerge.php?Exp=17'  target="new"><font color="#800000" size="2"><b>Click to Download Overall Report(.pdf)</b></font></a><br><br>	
<a href = "CatAnalysisMod2.php?Exp=17&CatFile=<?php echo $m_CatAnalysis?>"><font color="#800000" size="2"><b>Go back to experiment</b></font></a>
</form>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	



