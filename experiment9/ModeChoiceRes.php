<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Mode Split");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment9/";


$m_nmode = $_POST['nmode'];

 $m_txtcoTV = $_POST['txtcoTV'];
 $m_txtcoTW = $_POST['txtcoTW'];
 $m_txtcoTT = $_POST['txtcoTT'];
 $m_txtcoFC = $_POST['txtcoFC'];
 $m_txtcoPC = $_POST['txtcoPC'];
 $m_txtcoOP = $_POST['txtcoOP'];
 $m_trip = $_POST['trip'];

 	for ($i=0; $i < $m_nmode ;$i++)
	{	
    	$m_ModeName[$i] = $_POST['ModeName'][$i];
	
    	$m_txtTV[$i] = $_POST['txtTV'][$i];
	
    	$m_txtTW[$i] = $_POST['txtTW'][$i];
	
    	$m_txtTT[$i] = $_POST['txtTT'][$i];
	
    	$m_txtFC[$i] = $_POST['txtFC'][$i];
	
    	$m_txtPC[$i] = $_POST['txtPC'][$i];

    	$m_txtOP[$i] = $_POST['txtOP'][$i];
	}

	
?>
<head>
<style type="text/css">
	#scroller 
	{
    width:800px;
    height:150px;
    overflow:auto;  
 	}
 	.title1 
		{
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: x-normal;
			color: #00529C;			
			font-weight : bold;				
		}
		.lable1
		{ 
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: xx-small;
			color: #00529C;
			background-color: #ECECEC;
			font-weight : bold;
		}
</style>
	
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("#p1").hide();
	$("#p2").hide();
	$("#submit").hide();
	
	$(".btn1").click(function(){
		$("#submit").hide();
	    $("#p").slideUp("slow");
	    $("#p1").slideDown("slow");
	    
  });

	$(".btn2").click(function(){
		$("#submit").hide();
	    $("#p").slideDown("slow");
	    $("#p1").slideUp("slow");
	    
  });
	


	$(".btn3").click(function(){
		$("#submit").show();
		$("#p1").slideUp("slow");
		$("#p2").slideDown("slow");
 
	    
  });

	$(".btn4").click(function(){
		
		$("#p1").slideDown("slow");
		$("#p2").slideUp("slow");
		$("#submit").hide("submit");
 
	    
  });

	  
});
</script>


<script language="javascript">
function chk1()
{ 
	document.Frm.action="ModSplitModRpt.php";	
}
function chk2()
{ 
	document.Frm.action="ModSplitModRptPdf.php";	
}

function chk3()
{
	document.Frm.action="intermediateModSplitMod.php";
}
</script>
</script>

</head>

<div id="body">
<center>

<div id="p">
<caption><B>Trip Characteristics</B></caption>
<table class="table table-bordered table-hover">

<tr align="center" bgcolor="#B8DBFF"><td >&nbsp;</td><td><b>t<sup>u</sup><sub>ij</sub></b></td><td><b>t<sup>w</sup><sub>ij</sub></b></td><td><b>t<sup>t</sup><sub>ij</sub></b><td><b>f<sub>ij</sub></b></td><td><b>P<sup>c</sup></b></td><td><b>&Phi;<sub>ij</sub></b></td></tr>
<?php 
for ($i = 0; $i < $m_nmode;$i++) 
{
	echo "<tr align ='center'><td bgcolor='#B8DBFF' width='25%'><b>";
	if($m_ModeName[$i]== 1)
	{
		echo "Car";
	}
	else if($m_ModeName[$i] == 2)
	{
		echo "Two Wheeler";
	}
	else if($m_ModeName[$i] == 3)
	{
		echo "Bus";
	}
	else if($m_ModeName[$i] == 4)
	{
		echo "Train";
	}
	else if($m_ModeName[$i] == 5)
	{
		echo "Walk";
	}	
	else if($m_ModeName[$i] == 6)
	{
		echo "Public Transport (Auto Rickshaw,cab,etc)";
	}
	echo "</b></td>";
	echo '<td bgcolor="#EBF5FF">'.$m_txtTV[$i].'</td>';
	echo '<td bgcolor="#EBF5FF">'.$m_txtTW[$i].'</td>';
	echo '<td bgcolor="#EBF5FF">'.$m_txtTT[$i].'</td>';
	echo '<td bgcolor="#EBF5FF">'.$m_txtFC[$i].'</td>';
	echo '<td bgcolor="#EBF5FF">'.$m_txtPC[$i].'</td>';
	echo '<td bgcolor="#EBF5FF">'.$m_txtOP[$i].'</td>';
	echo '</tr>';
	
}
echo '<tr align="center"><td bgcolor="#B8DBFF"><b>a<sub>i</sub></b></td><td bgcolor="#EBF5FF"><b>'.$m_txtcoTV.'</b></td><td bgcolor="#EBF5FF"><b>'.$m_txtcoTW.'</b></td><td bgcolor="#EBF5FF"><b>'.$m_txtcoTT.'</b></td><td bgcolor="#EBF5FF"><b>'.$m_txtcoFC.'</b></td><td bgcolor="#EBF5FF"><b>'.$m_txtcoPC.'</b></td><td bgcolor="#EBF5FF"><b>'.$m_txtcoOP.'</b></td></tr>';
echo '</table><br><br>';

echo '<button class="btn1">Next</button>';
echo"</div>";
?>
</center>
<div id="p1">
<h2>Calculations</h2><br><br>

<?php 

$m_sumexp=0;
for ($i = 0; $i < $m_nmode;$i++) 
{
	echo '<b> Cost of travel by ';
	if($m_ModeName[$i]== 1)
	{
		echo "Car =";
	}
	else if($m_ModeName[$i] == 2)
	{
		echo "Two Wheeler =";
	}
	else if($m_ModeName[$i] == 3)
	{
		echo "Bus =";
	}
	else if($m_ModeName[$i] == 4)
	{
		echo "Train =";
	}
	else if($m_ModeName[$i] == 5)
	{
		echo "Walk =";
	}	
	else if($m_ModeName[$i] == 6)
	{
		echo "Public Transport (Auto Rickshaw,cab,etc) = ";
	}
	echo "&nbsp".$m_txtcoTV." * ". $m_txtTV[$i]." + ".$m_txtcoTW." * ".$m_txtTW[$i]." + ".$m_txtcoTT." * ".$m_txtTT[$i]." + ".$m_txtcoFC." * ".$m_txtFC[$i]." + ".$m_txtcoPC." * ".$m_txtPC[$i]." + ".$m_txtOP[$i]." * ".$m_txtcoOP;
	$m_cost[$i] = $m_txtcoTV * $m_txtTV[$i] + $m_txtcoTW * $m_txtTW[$i] + $m_txtcoTT * $m_txtTT[$i] + $m_txtcoFC * $m_txtFC[$i] + $m_txtcoPC * $m_txtPC[$i] + $m_txtOP[$i] * $m_txtcoOP;
	echo " = ".$m_cost[$i]."</b><br><br>";
	
	$m_exp[$i] = exp(-$m_cost[$i]);
	$m_sumexp = $m_sumexp + $m_exp[$i];
	
}


for ($i = 0; $i < $m_nmode;$i++) 
{
	echo "<b>Probability of choosing mode ";
	if($m_ModeName[$i]== 1)
	{
		echo "Car = p<sup>car</sup><sub>ij</sub> = ";
	}
	else if($m_ModeName[$i] == 2)
	{
		echo "Two Wheeler = p<sup>two wheeler</sup><sub>ij</sub> = ";
	}
	else if($m_ModeName[$i] == 3)
	{
		echo "Bus = p<sup>bus</sup><sub>ij</sub> =";
	}
	else if($m_ModeName[$i] == 4)
	{
		echo "Train = p<sup>train</sup><sub>ij</sub> = ";
	}
	else if($m_ModeName[$i] == 5)
	{
		echo "Walk = p<sup>walk</sup><sub>ij</sub> = ";
	}	
	else if($m_ModeName[$i] == 6)
	{
		echo "Public Transport (Auto Rickshaw,cab,etc) = p<sup>public transport</sup><sub>ij</sub> = ";
	}
	$m_pij[$i]= $m_exp[$i]/$m_sumexp;
	echo $m_pij[$i]."</b><br><br>";
}


for ($i = 0; $i < $m_nmode;$i++) 
{	
	echo "<b>Proportion of Trips by  ";
	if($m_ModeName[$i]== 1)
	{
		echo "Car = T<sup>car</sup><sub>ij</sub> ";
	}
	else if($m_ModeName[$i] == 2)
	{
		echo "Two Wheeler = T<sup>two wheeler</sup><sub>ij</sub> ";
	}
	else if($m_ModeName[$i] == 3)
	{
		echo "Bus = T<sup>bus</sup><sub>ij</sub> =";
	}
	else if($m_ModeName[$i] == 4)
	{
		echo "Train = T<sup>train</sup><sub>ij</sub> ";
	}
	else if($m_ModeName[$i] == 5)
	{
		echo "Walk = T<sup>walk</sup><sub>ij</sub> ";
	}	
	else if($m_ModeName[$i] == 6)
	{
		echo "Public Transport (Auto Rickshaw,cab,etc) = T<sup>public transport</sup><sub>ij</sub> ";
	}
	$m_proportion[$i] = $m_pij[$i]* $m_trip;
	echo "=".$m_pij[$i]." * ".$m_trip." = ".$m_proportion[$i]."</b><br><br>";
}	


for ($i = 0; $i < $m_nmode;$i++) 
{	
	echo "<b>Fare Collected from ";
	if($m_ModeName[$i]== 1)
	{
		echo "Car = F<sup>car</sup><sub>ij</sub> ";
	}
	else if($m_ModeName[$i] == 2)
	{
		echo "Two Wheeler = F<sup>two wheeler</sup><sub>ij</sub> ";
	}
	else if($m_ModeName[$i] == 3)
	{
		echo "Bus = F<sup>bus</sup><sub>ij</sub>";
	}
	else if($m_ModeName[$i] == 4)
	{
		echo "Train = F<sup>train</sup><sub>ij</sub> ";
	}
	else if($m_ModeName[$i] == 5)
	{
		echo "Walk = F<sup>walk</sup><sub>ij</sub> ";
	}	
	else if($m_ModeName[$i] == 6)
	{
		echo "Public Transport (Auto Rickshaw,cab,etc) = F<sup>public transport</sup><sub>ij</sub> ";
	}
	$m_fare[$i] = $m_proportion[$i]* $m_cost[$i];
	echo "=".$m_proportion[$i]." * ".$m_cost[$i]." = ".$m_fare[$i]."</b><br><br>";
	
}

?>


<button class="btn2">Previous</button>
<button class="btn3">Next</button>

<br>
</div>
<center>
<div id="p2">
<caption><B>Solutions</B></caption>
<table class="table table-bordered table-hover">
<tr align="center" bgcolor='#B8DBFF'><td >&nbsp;</td><td><b>t<sup>u</sup><sub>ij</sub></b></td><td><b>t<sup>w</sup><sub>ij</sub></b></td><td><b>t<sup>t</sup><sub>ij</sub></b><td><b>f<sub>ij</sub></b></td><td><b>P<sup>c</sup></b></td><td><b>&Phi;<sub>ij</sub></b></td><td><b>C</b></td><td><b>e<sup>C</sup></b></td><td><b>p<sub>ij</sub></b></td><td><b>T<sub>ij</sub></b></td></tr>
<?php 
for ($i = 0; $i < $m_nmode;$i++) 
{
	echo "<tr align ='center'><td bgcolor='#B8DBFF' width='15%'><b>";
	if($m_ModeName[$i]== 1)
	{
		echo "Car";
	}
	else if($m_ModeName[$i] == 2)
	{
		echo "Two Wheeler";
	}
	else if($m_ModeName[$i] == 3)
	{
		echo "Bus";
	}
	else if($m_ModeName[$i] == 4)
	{
		echo "Train";
	}
	else if($m_ModeName[$i] == 5)
	{
		echo "Walk";
	}	
	else if($m_ModeName[$i] == 6)
	{
		echo "Public Transport (Auto Rickshaw,cab,etc)";
	}
	echo "</b></td>";
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_txtTV[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_txtTW[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_txtTT[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_txtFC[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_txtPC[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_txtOP[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_cost[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_exp[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_pij[$i].'</td>';
	echo '<td bgcolor="#EBF5FF" width="5%">'.$m_proportion[$i].'</td>';
	echo '</tr>';
	
}
echo '<tr align="center"><td bgcolor="#B8DBFF"><b>a<sub>i</sub></b></td>
<td bgcolor="#EBF5FF"><b>'.$m_txtcoTV.'</b></td>
<td bgcolor="#EBF5FF"><b>'.$m_txtcoTW.'</b></td>
<td bgcolor="#EBF5FF"><b>'.$m_txtcoTT.'</b></td>
<td bgcolor="#EBF5FF"><b>'.$m_txtcoFC.'</b></td>
<td bgcolor="#EBF5FF"><b>'.$m_txtcoPC.'</b></td>
<td bgcolor="#EBF5FF"><b>'.$m_txtcoOP.'</b></td>
<td bgcolor="#EBF5FF"> - </td>
<td bgcolor="#EBF5FF"> - </td>
<td bgcolor="#EBF5FF"> - </td>
<td bgcolor="#EBF5FF"> - </td></tr>';
echo '</table>';

?>
</table>
<br><br>
<button class="btn4">Previous</button>
<br><br><br>
<form enctype="multipart/form-data" method="post" name="Frm" action="ModeChoiceRes.php">  
      
      <input type="hidden" name="nmode" value="<?=$m_nmode?>">
      
      <input type="hidden" name="txtcoTV" value="<?=$m_txtcoTV?>">
      <input type="hidden" name="txtcoTW" value="<?=$m_txtcoTW?>">
      <input type="hidden" name="txtcoTT" value="<?=$m_txtcoTT?>">
      <input type="hidden" name="txtcoFC" value="<?=$m_txtcoFC?>">
      <input type="hidden" name="txtcoPC" value="<?=$m_txtcoPC?>">
      <input type="hidden" name="txtcoOP" value="<?=$m_txtcoOP?>">
      <input type="hidden" name="trip" value="<?=$m_trip?>">
             
      <?php 
      	for ($i=0; $i < $m_nmode ;$i++)
		{	
    	?>
    	<input type="hidden" name="ModeName[]" size="50" value="<?=$m_ModeName[$i]?>">
    	<input type="hidden" name="txtTV[]" size="50" value="<?=$m_txtTV[$i]?>">
    	<input type="hidden" name="txtTW[]" size="50" value="<?=$m_txtTW[$i]?>">
    	<input type="hidden" name="txtTT[]" size="50" value="<?= $m_txtTT[$i]?>">
    	<input type="hidden" name="txtFC[]" size="50" value="<?= $m_txtFC[$i]?>">
    	<input type="hidden" name="txtPC[]" size="50" value="<?= $m_txtPC[$i]?>">
    	<input type="hidden" name="txtOP[]" size="50" value="<?= $m_txtOP[$i]?>">
    	<?php 
		}	
      ?>
<table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk3()">
</td></tr>
</table>
</div>
<br><br><br><br>
<div id="submit">
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
      <td align="center"><a href="ModeChoiceInput1.php"><H3><input type="button" value="Restart Experiment"></H3></a></td>
</tr>
</table>
</div>
</form>
</div>
<?php
  include_once("footer.php");
  getFooter(3);
?> 