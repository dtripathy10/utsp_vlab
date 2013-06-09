<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment7/";


$m_CostFile = $_POST['CostFile'];
$m_TripFile = $_POST['TripFile'];



$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];
if(empty($_POST['submit']))
{
//$m_CostFile = $_FILES['CostFile']['tmp_name'];
//$m_TripFile = $_FILES['TripFile']['tmp_name'];
$m_CostFile = $_POST['CostFile'];
$m_TripFile = $_POST['TripFile'];
}



?>


<!-- Validation for Form Controls -->

<script language="javascript">

function chk1()
{	
	if(document.Frm.MethodVal.value == "")
	{
		alert ("Select Origin / Destination Constrained Model !!");
		document.Frm.MethodVal.focus();
		return false ;
	}	
	
	if(document.Frm.FunctionsVal.value == "")
	{
		alert ("Select Frictional Functions !!");
		document.Frm.FunctionsVal.focus();
		return false ;
	}


		
	document.Frm.action="CaliSingModRes.php?Exp=5";
}
</script>
</head>
<div id="body">
<center> 

<form enctype="multipart/form-data" method="post" name="Frm" action="CaliSingInput.php?Exp=5">
<table class="table table-bordered table-hover">
<tr>
	<th align="left" width="30%"> Origin / Destination Constrained Model : </th>
	<td align="left" width="70%">
	<select name="MethodVal" onChange="form.submit();">
		<option value="" <?if ($m_MethodVal == "") {?>selected <?}?>>Select</option>
		<option value="SinglyOrigin" <?if ($m_MethodVal == "SinglyOrigin") {?>selected <?}?>> Origin Constrained </option>
		<option value="SinglyDest" <?if ($m_MethodVal == "SinglyDest") {?>selected <?}?>> Destination Constrained </option>					
	</select>	
	</td>
</tr>

<tr>
	<th align="left"> Frictional Functions : </th>
	<td align="left">
	<select name="FunctionsVal" onChange="form.submit();">
		<option value="" <?if ($m_FunctionsVal == "") {?>selected <?}?>>Select</option>
		<option value="PowerFun" <?if ($m_FunctionsVal == "PowerFun") {?>selected <?}?>> Power Function </option>
		<option value="ExponentialFun" <?if ($m_FunctionsVal == "ExponentialFun") {?>selected <?}?>>Exponential Function </option>				
	</select>		
	&nbsp;&nbsp;
		<?php 
			if($_POST['FunctionsVal']=="PowerFun")
			{
			?>
				<font size=3 color="#990000"><B>F<sub>ij</sub> =  C<sub>ij</sub><sup>&#946;</sup><B></font>
			<?php 
			}
			elseif($_POST['FunctionsVal']=="ExponentialFun") 
			{
			?>
				<font size=3 color="#990000"><B>F<sub>ij</sub> =  e<sup>-&#946;C<sub>ij</sub></sup><B></font>
			<?php 
			}
		?>	
					
	</td>
</tr>
		
	
</table>
<br>
         	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="TripFile" value="<?=$m_TripFile?>"> 

<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
</tr>
</table>

</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
		
