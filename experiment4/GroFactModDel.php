<?php
include_once("../util/system.php");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment4/";
	
	$m_MethodVal = $_GET['MethodVal'];		//To retrieve values of the selected method
	
	if($m_MethodVal == "UniformGFM")
    {
    	
    	$m_BaseFile = $_GET['BaseFile'];
    	
		$myFile = $folder.$m_BaseFile;
		$fh = fopen($myFile, 'w') or die("can't open file");
		fclose($fh);
		unlink($folder.$m_BaseFile);				//To delete Basefile

    }
    elseif($m_MethodVal == "SinglyGFM")
    {
    	$m_ConstraintsVal = $_GET['ConstraintsVal'];
    	
    	if($m_ConstraintsVal=="SinglyOrigin")    	
    	{
    	
        	$m_BaseFile = $_GET['BaseFile'];
        	$m_OriginFile = $_GET['OriginFile'];
        	
        	$myFile1 = $folder.$m_BaseFile;
			$fh1 = fopen($myFile1, 'w') or die("can't open file");
			fclose($fh1);
			unlink($folder.$m_BaseFile);			//To delete Basefile
			
			$myFile2 = $folder.$m_OriginFile;
			$fh2 = fopen($myFile2, 'w') or die("can't open file");
			fclose($fh2);
			unlink($folder.$m_OriginFile);			//To delete Originfile
		
    	}
    	elseif ($m_ConstraintsVal=="SinglyDest")
    	{
    	
    		$m_BaseFile = $_GET['BaseFile'];
    		$m_DestFile = $_GET['DestFile'];
    		
    		$myFile1 = $folder.$m_BaseFile;			
			$fh1 = fopen($myFile1, 'w') or die("can't open file");
			fclose($fh1);
			unlink($folder.$m_BaseFile);			//To delete Basefile
			
			$myFile2 = $folder.$m_DestFile;
			$fh2 = fopen($myFile2, 'w') or die("can't open file");
			fclose($fh2);
			unlink($folder.$m_DestFile);  			//To delete Destinationfile  		
    	}
    }
    elseif($m_MethodVal == "FratarGFM")
    {
    
        $m_BaseFile = $_GET['BaseFile'];
        $m_OriginFile = $_GET['OriginFile'];
		$m_DestFile = $_GET['DestFile'];
		
		
		$myFile1 = $folder.$m_BaseFile;
		$fh1 = fopen($myFile1, 'w') or die("can't open file");
		fclose($fh1);
		unlink($folder.$m_BaseFile);						//To delete Basefile
			
		$myFile2 = $folder.$m_OriginFile;
		$fh2 = fopen($myFile2, 'w') or die("can't open file");
		fclose($fh2);
		unlink($folder.$m_OriginFile);						//To delete Originfile
		
		$myFile3 = $folder.$m_DestFile;
		$fh3 = fopen($myFile3, 'w') or die("can't open file");
		fclose($fh3);
		unlink($folder.$m_DestFile);  						//To delete Destinationfile
    }
?>

<script>
     document.location = "GroFactMod.php";
</script>