<?php
include_once("../util/system.php");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment7/";
	
$m_CostFile = $_GET['CostFile'];
$m_TripFile = $_GET['TripFile'];
    		
$myFile1 = $folder.$m_CostFile;
$fh1 = fopen($myFile1, 'w') or die("can't open file");
fclose($fh1);
unlink($folder.$m_CostFile);	// To delete Cost file  	
			
$myFile2 = $folder.$m_TripFile;
$fh2 = fopen($myFile2, 'w') or die("can't open file");
fclose($fh2);
unlink($folder.$m_TripFile);	// To delete Trip file  	    		
    
?>

<script>
     document.location = "CaliSingMod.php?Exp=5";
</script>