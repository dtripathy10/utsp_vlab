
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

        function traverse($dir) {
            $results_array = array(".", "..");
            if (!is_dir($dir)) {
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
                    echo $dir."/".basename($value) . "<br/>";
                    traverse($dir."/".basename($value));
                } else {
                    echo $dir."/".basename($value) . "<br/>";
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