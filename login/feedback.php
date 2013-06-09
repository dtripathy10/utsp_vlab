
<!--
        Author:		Debabrata Tripathy, IIT Bombay, Mumbai
        Mail ID:	dtriapthy10@gmail.com
        Website:	http://home.iitb.ac.in/~debabratatripathy/
        Phone No:	9004499484
-->
<?php
include_once("header.php");
include_once("../util/system.php");
selectDatabase();
getHeader(8, "Feedback | UTSP VLab");
?>
<div id="body">
    <script language="javascript">
        function multiselect_validate(select) {
            var valid = false;
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].selected) {
                    valid = true;
                    break;
                }
            }

            return valid;
        }
        function chk1()
        {
          
            if (!multiselect_validate(document.getElementById("experiment")))
            {
                alert("Please Select Experiment!!!");
                document.FB.experiment.focus();
                return false;
            }

            for (var x = 0; x < FB['Rate1'].length; x++)
            {
                valid = FB['Rate1'][x].checked
                if (valid)
                {
                    break
                }
            }

            if (!valid)
            {
                alert("Please rate the 1st question.")
                return false;
            }


            for (var x = 0; x < FB['Rate2'].length; x++)
            {
                valid = FB['Rate2'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please rate the 2ndt question.")
                return false;
            }

            for (var x = 0; x < FB['Rate3'].length; x++)
            {
                valid = FB['Rate3'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please rate the 3rd question")
                return false;
            }

            for (var x = 0; x < FB['Quest1'].length; x++)
            {
                valid = FB['Quest1'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please answer the 1st Question")
                return false;
            }

            for (var x = 0; x < FB['Quest2'].length; x++)
            {
                valid = FB['Quest2'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please answer the 2nd Question")
                return false;
            }
            for (var x = 0; x < FB['Quest3'].length; x++)
            {
                valid = FB['Quest3'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please answer the 3rd Question")
                return false;
            }
            for (var x = 0; x < FB['Quest4'].length; x++)
            {
                valid = FB['Quest4'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please answer the 4th Question")
                return false;
            }
            for (var x = 0; x < FB['Quest5'].length; x++)
            {
                valid = FB['Quest5'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please answer the 5th Question")
                return false;
            }
            for (var x = 0; x < FB['Quest6'].length; x++)
            {
                valid = FB['Quest6'][x].checked
                if (valid)
                {
                    break
                }
            }
            if (!valid)
            {
                alert("Please answer the 6th Question")
                return false;
            }

            document.FB.action = "feedbacksave.php";
        }
    </script>
    <h1 class="designation">Feedback</h1>
    <div class="awesome">
        Please take 2 minutes and give us your thoughts on the previous experiment. We will go over every response to try and make the experiment even more of what you want!
    </div>
    <div class="feed"> <span class="left-bar tab" style="color:#FF0000;"><span>*</span>required fields</span>
    </div>
    <form method="post" name="FB" action="feedback.php">
        <?php
        session_start();
        $UsrName = $_SESSION['fname'] . "&nbsp;&nbsp;" . $_SESSION['lname'];
        ?>
        <div class="feed">
            <span class="left-bar tab"><span class="text-error">*</span>Name of the Student/Faculty</span>
            <input name="uname" value="<?php echo $UsrName ?>" type="text" readonly class="input-xlarge" style="height: 30px;">
        </div>
        <?php
        $sql = "select * from usermaster where UserName='" . $_SESSION['user'] . "'";
        $result = mysql_query($sql, $conn);
        while ($row = mysql_fetch_array($result)) {
            $m_ColUniName = $row['college'];
        }
        ?>
        <div class="feed">
            <span class="left-bar tab"><span class="text-error">*</span>Name of the Institute</span>
            <input class="input-xlarge" style="height: 30px;" name="institute" value="<?php echo $m_ColUniName ?>" type="text">
        </div>
        <div class="feed">

            <span class="left-bar tab"><span class="text-error">*</span>   Which experiment did you performed ?</span>
            <select id ="experiment" name="experiment[]" multiple size="1">
                <option value="0">General</option>
                <option value="1">Volume, Speed and Delay Study at Intersection</option>
                <option value="2">Regression Analysis</option>
                <option value="3">Category Analysis</option>
                <option value="4">Growth Factor Distribution Model</option>
                <option value="5">Singly constrained Gravity Model</option>
                <option value="6">Doubly constrained Gravity Model</option>
                <option value="7">Calibration of Singly Constrained Gravity Model</option>
                <option value="8">Calibration of Doubly Constrained Gravity Model</option>
                <option value="9">Mode Split</option>
                <option value="10">All or Nothing (AON) Assignment</option>
                <option value="11">User Equilibrium Assignment</option>
                <option value="12">System Optimal assignment</option>
            </select>
        </div>
        <div class="feed">
            <span class="left-bar tab"><span class="text-error">*</span>Please tell your agreement with the following statements</span>
            <table class="table table-bordered table-hover" style="margin-top: 10px;">
                <tr>
                    <th></td>
                    <th>Excellent</th>
                    <th>Very Good</th>
                    <th>Good</th>
                    <th> Average</th>
                    <th>Poor</th
                </tr>
                <tr>
                    <td >To what degree was the actual lab environment simulated.</td>
                    <td ><input name="Rate1" type="radio" value="Excellent" <?php if ($_POST['Rate1'] == "Excellent") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate1" type="radio" value="VeryGood" <?php if ($_POST['Rate1'] == "VeryGood") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate1" type="radio" value="Good" <?php if ($_POST['Rate1'] == "Good") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate1" type="radio" value="Average" <?php if ($_POST['Rate1'] == "Average") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate1" type="radio" value="Poor" <?php if ($_POST['Rate1'] == "Poor") { ?> checked <?php } ?> ></td>
                </tr>
                <tr>
                    <td >The manuals (Theory and Procedure) were found to be helpful.</td>
                    <td ><input name="Rate2" value="Excellent" type="radio" <?php if ($_POST['Rate2'] == "Excellent") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate2" type="radio" value="VeryGood" <?php if ($_POST['Rate2'] == "VeryGood") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate2" value="Good" type="radio" <?php if ($_POST['Rate2'] == "Good") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate2" value="Average" type="radio" <?php if ($_POST['Rate2'] == "Average") { ?> checked <?php } ?> ></td>
                    <td ><input name="Rate2" value="Poor" type="radio" <?php if ($_POST['Rate2'] == "Poor") { ?> checked <?php } ?> ></td>
                </tr>
                <tr>
                    <td>The results of experiment were easily interpretable.</td>
                    <td><input name="Rate3" value="Excellent" type="radio" <?php if ($_POST['Rate3'] == "Excellent") { ?> checked <?php } ?> ></td>
                    <td><input name="Rate3" value="VeryGood" type="radio" <?php if ($_POST['Rate3'] == "VeryGood") { ?> checked <?php } ?> ></td>
                    <td><input name="Rate3" value="Good" type="radio" <?php if ($_POST['Rate3'] == "Good") { ?> checked <?php } ?> ></td>
                    <td><input name="Rate3" value="Average" type="radio" <?php if ($_POST['Rate3'] == "Average") { ?> checked <?php } ?> ></td>
                    <td><input name="Rate3" value="Poor" type="radio" <?php if ($_POST['Rate3'] == "Poor") { ?> checked <?php } ?> ></td>
                </tr>
            </table>
        </div>
        <div class="feed">
            <span class="left-bar tab">How helpful do you feel the system is?</span>
            <textarea id="solution" name="helpful"><?php echo $helpful ?></textarea>
        </div>
        <div class="feed">
            <span class="left-bar tab"><span class="text-error">*</span>Please tell your agreement with the following statements?</span>
            <table class="table table-bordered table-hover"  style="margin-top: 10px;">
                <tr>
                    <th></th>
                    <th>Yes</th>
                    <th>No</th>
                </tr>

                <tr>
                    <td>Did you get the feel of actual lab while performing the experiments?</td>
                    <td ><input name="Quest1" type="radio" value="Yes" <?php if ($_POST['Quest1'] == "Yes") { ?> checked <?php } ?> ></td>
                    <td > <input name="Quest1" type="radio" value="No" <?php if ($_POST['Quest1'] == "No") { ?> checked <?php } ?> ></td>
                </tr>

                <tr>
                    <td>Did you go through the manual/step by step method before performing the experiments live ?</td>
                    <td><input name="Quest2" type="radio" value="Yes" <?php if ($_POST['Quest2'] == "Yes") { ?> checked <?php } ?> ></td>
                    <td><input name="Quest2" type="radio" value="No" <?php if ($_POST['Quest2'] == "No") { ?> checked <?php } ?> ></td>
                </tr>

                <tr>
                    <td>Could you measure and analyze the data successfully?</td>
                    <td><input name="Quest3" type="radio" value="Yes" <?php if ($_POST['Quest3'] == "Yes") { ?> checked <?php } ?> ></td>
                    <td><input name="Quest3" type="radio" value="No" <?php if ($_POST['Quest3'] == "No") { ?> checked <?php } ?> ></td>
                </tr>

                <tr>
                    <td>Could you compare your results with the given typical results?</td>

                    <td >
                        <input name="Quest4" type="radio" value="Yes" <?php if ($_POST['Quest4'] == "Yes") { ?> checked <?php } ?>></td>
                    <td >
                        <input name="Quest4" type="radio" value="No" <?php if ($_POST['Quest4'] == "No") { ?> checked <?php } ?> ></td>
                </tr>

                <tr>
                    <td>Do you think performing experiments through virtual labs are more challenging than the real lab experiments?</td>

                    <td >
                        <input name="Quest5" type="radio" value="Yes" <?php if ($_POST['Quest5'] == "Yes") { ?> checked <?php } ?> ></td>
                    <td >
                        <input name="Quest5" type="radio" value="No" <?php if ($_POST['Quest5'] == "No") { ?> checked <?php } ?> ></td>
                </tr>

                <tr>
                    <td>Do you think doing experiments through virtual lab gives scope for more innovative and creative research work?</td>

                    <td>
                        <input name="Quest6" type="radio" value="Yes" <?php if ($_POST['Quest6'] == "Yes") { ?> checked <?php } ?> ></td>
                    <td >
                        <input name="Quest6" type="radio" value="No" <?php if ($_POST['Quest6'] == "No") { ?> checked <?php } ?> ></td>
                </tr>
            </table>
        </div>

        <div class="feed">
            <span class="left-bar tab"><span class="text-error">*</span> Specify problems/difficulties you faced while performing the experiments.</span>
            <textarea id="solution" name="problems"><?php echo $problems ?></textarea>
        </div>
        <div class="feed">
            <span class="left-bar tab"> Give most interesting thing about the experiments.</span>
            <textarea id="solution" name="interesting"><?php echo $interesting ?></textarea>
        </div>
        <div class="feed center">
            <input name="Submit" type="Submit" class="button" value="Submit" OnClick="return chk1();"/>
            <span class="tab"></sapn>
                <input name="reset" type="reset" class="button" value="Reset" />
        </div>
    </form>



</div>
<?php
include_once("footer.php");
getFooter(8);
?>

