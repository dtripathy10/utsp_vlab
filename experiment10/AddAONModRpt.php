<?php 
$UploadFile = $_SESSION['user'];
$folder = "../user/".$UploadFile."/Experiment10/";



if(file_exists($folder."AONModReport.xls"))
{
		$fh = fopen($folder."AONModReport.xls", "a+") or die("can't open file");

}

 
   fwrite($fh, "All or Nothing Assignment  \n \n") ;
   fwrite($fh, "Final Assignment \n") ;
   fwrite($fh, "From \t To \t Flow \n") ;
   for ($i = 2; $i <= $m_nlinks+1; $i++)
   {           	          
        for ($j = 1; $j < $m_nlinks-2; $j++)
        {
        		
                fwrite($fh, $m_TripMtx[$i][$j]." \t") ;
        		
            }
            
            fwrite($fh, $y[$i]." \n") ;
   }
   fwrite($fh, "\n \n") ;
?>     
