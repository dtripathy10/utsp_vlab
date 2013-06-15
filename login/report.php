
<!--
        Author:		Debabrata Tripathy, IIT Bombay, Mumbai
        Mail ID:	dtriapthy10@gmail.com
        Website:	http://home.iitb.ac.in/~debabratatripathy/
        Phone No:	9004499484
-->	

<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(9, "Repoort | UTSP VLab");
?>
<div id="body">
    <table class="table table-striped table-bordered">
        <tr><th align="center">#</th>
            <th align="center">Experiment Name</th>
            <th align="center">Input/Report File</th>
        </tr>
        <?php
        session_start();
        $root_dir = USER_ROOT . '/' . $_SESSION['user'];

        function sub_string($mystring,$findname) {
			$pos = strpos($mystring, $findname);
			return $pos;
        }
        function exp_name($a) {	
        if(sub_string($a,"Experiment1")) {
        	return "Volume, Speed and Delay Study at Intersection";
        }else if(sub_string($a,"Experiment2")) {
        	return "Trip Generation:Regression Analysis";
        }else if(sub_string($a,"Experiment3")) {
        	return "Trip Generation:Category Analysis";
        }else if(sub_string($a,"Experiment4")) {
        	return "Trip Distribution:Growth Factor Distribution Model";
        }else if(sub_string($a,"Experiment5")) {
        	return "Trip Distribution:Singly constrained Gravity Model";
        }else if(sub_string($a,"Experiment6")) {
        	return "Trip Distribution:Doubly constrained Gravity Model";
        }else if(sub_string($a,"Experiment7")) {
        	return "Trip Distribution:Calibration of Singly Constrained Gravity Model";
        }else if(sub_string($a,"Experiment8")) {
        	return "Trip Distribution:Calibration of Doubly Constrained Gravity Model";
        }else if(sub_string($a,"Experiment9")) {
        	return "Mode Split";
        }else if(sub_string($a,"Experiment10")) {
        	return "Trip Assignment:All or Nothing (AON) Assignment";
        }else if(sub_string($a,"Experiment11")) {
        	return "Trip Assignment:User Equilibrium Assignment";
        }else if(sub_string($a,"Experiment12")) {
        	return "Trip Assignment:System Optimal Assignment";
        }else {
        	return "error";
        }
        	
        }
        $__counter = 0;
        function traverse($dir) {
        global $__counter;
            $results_array = array(".", "..");
            if (!is_dir($dir)) {
            	
            	$data = $dir."/".basename($dir);
            	$exp_name = exp_name($dir);
            	$file_name = basename($dir);
            	
            	echo "<tr><td>".++$__counter."</td><td>".$exp_name."</td><td><a href=".$dir." target='_blank'>".$file_name."</a></td></tr>";
                return;
            } else {
                $results_array = scandir($dir);
            }
            foreach ($results_array as $value) {
                //check value is directory or file or . or ..
                if ($value === '.' || $value === '..') {
                    continue;
                }
                if (!is_dir($value)) {
                    //echo $dir."/".basename($value) . "<br/>";
                    traverse($dir."/".basename($value));
                } else {
                    //echo $dir."/".basename($value) . "<br/>";
                }
            }
        }

        traverse($root_dir);
        ?>
    </table>
</div>
<?php
include_once("footer.php");
getFooter(9);
?>