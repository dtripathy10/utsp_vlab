<?php
/*
  1   Regression Analysis
  2   Growth Factor Distribution Model
  3   Singly constrained Gravity Model
  4   Doubly constrained Gravity Model
  5   Calibration of Singly Constrained Gravity Model
  6   Calibration of Doubly Constrained Gravity Model
  7   Mode Split
  8   All or Nothing (AON) Assignment
  9   User Equilibrium Assignment
  10  System Optimal assignment
  11  Stochastic User Equilibrium
  12  Volume, Speed and Delay Study at Intersection
  17  Category Analysis
 */


require_once("../util/system.php");

function printSelfEvaluationQuestion($Exp, $ans) {
    //select the database
    selectDatabase();
    $query = "SELECT * FROM selfeval where ExpNo=" . $Exp . " order by Srno";
    $query = mysql_query($query) or die("MySQL Login Error: " . mysql_error());
    ?>
    <script>
    <?php
    if ($ans == 1) {
        ?>
            // other onload attached earlier
            window.onload = function() {
                element = document.getElementsByClassName("result");
                for (var i = 0;
                        i < element.length;
                        i++) {
                    element[i].style.display = "block";
                }
            };
    <?php }
    ?>

        function chk() {
            var elements = document.getElementsByClassName("answers");
            var counter = 0;
            for (var i = 1; i <= elements.length; i++) {
                temp = document.getElementsByName('rd_opt' + i);
                for (var j = 0; j < temp.length; j++) {
                    if (temp[j].checked) {
                        counter++;
                        break;
                    }
                }
                console.log(elements.length);
            }

            if (counter === elements.length) {
                var retVal = confirm("Do you want to continue ?");
                if (retVal === true) {
                    return true;
                } else {
                    return false;
                }
            } else {
                var retVal = confirm("Do you want to continue ?\t" + counter);
                if (retVal === true) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    </script>
    <form name ="form1" Method ="get" action ="selfevaluation.php"><ul class="question_form">
            <?php
            $counter = 1;
            if (mysql_num_rows($query) > 0) {
                $row = mysql_num_rows($query);
                while ($row = mysql_fetch_array($query)) {
                    $QtsType = $row['QType'];
                    $Question = $row['Question'];
                    $Option1 = $row['Option1'];
                    $Option2 = $row['Option2'];
                    $Option3 = $row['Option3'];
                    $Option4 = $row['Option4'];
                    $answer = $row['Answer'];
                    echo ('<li><div class="question">' . $Question . '</span>');
                    if ($QtsType == 'MO') {
                        switch ($answer) {
                            case $Option1:
                                $res = 'a)&nbsp;&nbsp;&nbsp;&nbsp;' . $answer;
                                break;
                            case $Option2:
                                $res = 'b)&nbsp;&nbsp;&nbsp;&nbsp;' . $answer;
                                break;
                            case $Option3:
                                $res = 'c)&nbsp;&nbsp;&nbsp;&nbsp;' . $answer;
                                break;
                            case $Option4:
                                $res = 'd)&nbsp;&nbsp;&nbsp;&nbsp;' . $answer;
                                break;
                        }
                        ?>
                        <br>

                        <ul class="answers">
                            <li>   <input type = "radio" NAME="rd_opt<?= $counter; ?>" Value = "<?= $Option1 ?>" /> <?= $Option1 ?></li>  
                            <li>    <input type = "radio" NAME="rd_opt<?= $counter; ?>" Value = "<?= $Option2 ?>" /> <?= $Option2 ?></li>  
                            <li>    <input type = "radio" NAME="rd_opt<?= $counter; ?>" Value = "<?= $Option3 ?>" /> <?= $Option3 ?></li>  
                            <li>    <input type = "radio" NAME="rd_opt<?= $counter; ?>" Value = "<?= $Option4 ?>" /> <?= $Option4 ?></li>  
                        </ul>
                        <?php
                    }//if loop
                    elseif ($QtsType == 'TF') {
                        switch ($answer) {
                            case $Option1:
                                $res = 'a)&nbsp;&nbsp;&nbsp;&nbsp;' . $answer;
                                break;
                            case $Option2:
                                $res = 'b)&nbsp;&nbsp;&nbsp;&nbsp;' . $answer;
                                break;
                        }
                        ?>
                        <br>
                        <ul class="answers">
                            <li>   <input type = "radio" NAME="rd_opt<?= $counter; ?>" Value = "True" /> True </li>  
                            <li>     <input type = "radio" NAME="rd_opt<?= $counter; ?>" Value = "False" /> False </li>  
                        </ul>

                        <?php
                    }//eseif loop
                    echo ' <div class="result">';
                    if ($ans == 1) {
                        echo $res;
                    }
                    echo '</div>';
                    echo('</li>');
                    $counter++;
                }//whie
                ?>
                <hr/>
            </ul>
            <div class="text-center">
                <input type = "submit" class="button" value = "submit" name="submit" onclick="return chk();">
            </div>
        </form>
        <?php
    }
}
?>