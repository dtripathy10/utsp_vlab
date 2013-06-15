 <?php
include_once("../util/system.php");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3/";
	   
    $m_CatAnalysis = $_GET['CatFile'];
    $m_CatAnalysis2 = $_GET['CatFile2'];
		
	$myFile1 =$folder.$m_CatAnalysis;
	$fh1 = fopen($myFile1, 'w') or die("can't open file");
	fclose($fh1);
	unlink($UploadFile."/Experiment3/".$m_CatAnalysis);						//To delete observed Socio-economic data file
			
	$myFile2 =$folder.$m_CatAnalysis2;
	$fh2 = fopen($myFile2, 'w') or die("can't open file");
	fclose($fh2);
	unlink($folder.$m_CatAnalysis2);						//To delete Forecasted Socio-economic data file
	
	unlink($folder."TestReport.pdf");
	unlink($folder."CategoryAnalysis.pdf");
	unlink($folder."CategoryAnalysisFinal.pdf");

?>

<script>
     document.location = "CatAnalysisMod.php";
</script>