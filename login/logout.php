<?php
session_start();
// Retrieving the values of variables
if(isset($_SESSION['user'])) {
	$rc = $_SESSION['user'];
	session_unset();
//Destroy the session																 |	
session_destroy();
rrmdir("../user/".$rc);
}



function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				 if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
				 }
			}
			reset($objects);
			rmdir($dir);
		}
}
// This function is used to delete the user folder with subfolder and files


header('Location: ../index.php');
?> 


