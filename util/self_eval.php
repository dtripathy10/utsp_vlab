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
function printSelfEvaluationQuestion($Exp) {
	//select the database
	selectDatabase();
	$query = "SELECT * FROM SelfEval where ExpNo=".$Exp." order by Srno";
  $query = mysql_query($query) or die("MySQL Login Error: ".mysql_error()); 
  ?>
<form name ="form1" Method ="post" action ="SelfEvalResult.php"><ul class="question_form">
<ul>
  <?php
	if (mysql_num_rows($query) > 0) { 
		$row=mysql_num_rows($query);
 		$i=1;
 		while($row = mysql_fetch_array($query)) { 
  			$Srno=$row['Srno'];
  			$QtsType=$row['QType'];
  			$Question=$row['Question'];	
  			$Option1=$row['Option1'];
  			$Option2=$row['Option2'];
  			$Option3=$row['Option3'];
  			$Option4=$row['Option4'];
  			echo ('<li><span class="question">'.$Question.'</span>');
  			if($QtsType=='MO')	{
 	 ?>
  	<br>
    <span class="text-error pull-right">AAAAAAAAAAAAAAAAAAAAAAAA</span>
  	<input type = "radio" NAME="rd_opt<?=$row["Srno"];?>" Value = "<?=$Option1?>" /> <?=$Option1?><br>
  	<input type = "radio" NAME="rd_opt<?=$row["Srno"];?>" Value = "<?=$Option2?>" /> <?=$Option2?><br>
  	<input type = "radio" NAME="rd_opt<?=$row["Srno"];?>" Value = "<?=$Option3?>" /> <?=$Option3?><br>
  	<input type = "radio" NAME="rd_opt<?=$row["Srno"];?>" Value = "<?=$Option4?>" /> <?=$Option4?><br>  
 	<br>  
 	 <?php 
  }//if loop
  elseif($QtsType='TF') {
  	?>
  	<br>
	<span class="text-error pull-right">AAAAAAAAAAAAAAAAAAAAAAAA</span>
  	<input type = "radio" NAME="rd_opt<?=$row["Srno"];?>" Value = "True" /> True <br>
  	<input type = "radio" NAME="rd_opt<?=$row["Srno"];?>" Value = "False" /> False <br>
  	<br>  
 	 <?php   	
  }//eseif loop
  echo('</li>');  
 }//whie
 ?>
 <hr/>
</ul>
  <div class="text-center">
    <input type = "submit" class="btn btn-info" value = "Submit">
  </div>
</form>
<?php
}
}

?>