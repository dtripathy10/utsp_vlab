<?php 
session_start();			//To check whether the session has started or not
include"conn.php";			//for Database connection
//include "userchk.php";	//To check user's session
include"functlib.php";		//All functions are present inside the file functionlib.php

	$UploadFile = $_SESSION['user'];		//To retrieve values of session variable
	   
    $m_CatAnalysis = $_GET['CatFile'];
    $m_CatAnalysis2 = $_GET['CatFile2'];
		
	$myFile1 = $UploadFile."/Experiment3/".$m_CatAnalysis;
	$fh1 = fopen($myFile1, 'w') or die("can't open file");
	fclose($fh1);
	unlink($UploadFile."/Experiment3/".$m_CatAnalysis);						//To delete observed Socio-economic data file
			
	$myFile2 = $UploadFile."/Experiment3/".$m_CatAnalysis2;
	$fh2 = fopen($myFile2, 'w') or die("can't open file");
	fclose($fh2);
	unlink($UploadFile."/Experiment3/".$m_CatAnalysis2);						//To delete Forecasted Socio-economic data file
	
	unlink($UploadFile."/Experiment3/TestReport.pdf");
	unlink($UploadFile."/Experiment3/CategoryAnalysis.pdf");
	unlink($UploadFile."/Experiment3/CategoryAnalysisFinal.pdf");

?>

<script>
     document.location = "view2.php?link=T009&Exp=17";
</script>