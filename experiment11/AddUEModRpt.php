<?php


if(file_exists($folder."UEModReport.xls"))
		$fh = fopen($folder."UEModReport.xls", "a+") or die("can't open file");

fwrite($fh, "User Equilibrium Assignment  \n \n") ;
fwrite($fh, "Alpha value consdered :".$_SESSION['alphaValue']."\n Beta value consdered :".$_SESSION['betaValue']." \n \n") ;
fwrite($fh, "Result \n") ;
fwrite($fh, "From \t To \t Link Flow(Xi) \t Link Traveltime Tij \n") ;
for ($i = 1; $i <= $m_nlinks; $i++)
{           	
	fwrite($fh, $frm[$i]."\t ") ;
	fwrite($fh, $to[$i]."\t ") ;
	fwrite($fh, $x[$i]."\t ") ;
	fwrite($fh, $t[$i]."\n ") ;
$sum +=($x[$i]*$t[$i]);
}
fwrite($fh, "\n \n") ;
            
fwrite($fh, "Total System Travel Time \t ".$sum." \n") ;
fwrite($fh, "\n \n \n") ;
fclose($fh);
?>        
