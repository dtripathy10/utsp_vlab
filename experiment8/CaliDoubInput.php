<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment8/";

// Retrieving the values of variables
$m_CostFile = $_FILES['CostFile']['name'];
$m_TripFile = $_FILES['TripFile']['name'];
//$m_CostFile = $_POST['CostFile'];
//$m_TripFile = $_POST['TripFile'];


$m_FunctionsVal = $_POST['FunctionsVal'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy']; 
if(empty($_POST['submit']))
{
	$m_CostFile = $_FILES['CostFile']['tmp_name'];
	$m_TripFile = $_FILES['TripFile']['tmp_name'];
	$m_CostFile = $_POST['CostFile'];
	$m_TripFile = $_POST['TripFile'];
}
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];  

//------------------------------ verifying the format of the file -------------------------


$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));


if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="CaliDoubMod.php?Exp=6";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------


//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$folder. $_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["TripFile"]["tmp_name"],$folder. $_FILES["TripFile"]["name"]);


?>
<!-- Validation for Form Controls -->

<script language="javascript">

function chk1()
{	
	if(document.Frm.FunctionsVal.value == "")
	{
		alert ("Select Frictional Functions !!");
		document.Frm.FunctionsVal.focus();
		return false ;
	}

	if(document.Frm.AccuracyVal.value == "")
	{
		alert ("Select Accuracy !!");
		document.Frm.AccuracyVal.focus();
		return false ;
	}

	if(document.Frm.txtAccuracy.value == "")
	{
		alert ("Enter Accuracy Level Value !!");
		document.Frm.txtAccuracy.focus();
		return false ;
	}

	if(isNaN(document.Frm.txtAccuracy.value))
	{
		alert ("Enter Numeric Value For Accuracy Level !!");
		document.Frm.txtAccuracy.focus();
		return false ;
	}
		

		
	document.Frm.action="CaliDoubModRes.php?Exp=6";
}
</script>
</head>
<div id="body">
<center> 
<form enctype="multipart/form-data" method="post" name="Frm" action="CaliDoubInput.php?Exp=6">
<table class="table table-bordered table-hover">

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

<tr>
	<th align="left"  width="30%"> Select Accuracy : </th>
	<td align="left"  width="75%">
		<select name="AccuracyVal">		
			<option value="" <?if ($m_AccuracyVal == "") {?>selected <?}?>>Select</option>
			<option value="Individual" <?if ($m_AccuracyVal == "Individual") {?>selected <?}?>>Individual Cell</option>
			<option value="All" <?if ($m_AccuracyVal == "All") {?>selected <?}?>>All Cell</option>						
		</select>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript:Popup('../AccuracyHelp.php?Exp=6')"><b><u>Click Here To Know</u></b></a>
		<script type="text/javascript"> 			
  			var stile = "top=350, left=800, width=400, height=200 status=no, menubar=no, toolbar=no scrollbar=no";
     		function Popup(apri) 
     		{
        		window.open(apri, "", stile);
     		}			
		</script>					
	</td>
</tr>
	
<tr>
	<th align="left"  width="30%"> Enter Accuracy Level : </th>
	<td align="left">
		<input type="Text" name="txtAccuracy" size="20" value="3"> <b>(&#37;)</b>
	</td>
</tr>
	
</table>
<br>

         	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="TripFile" value="<?=$m_TripFile?>"> 

<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
<!--<td align="left"><input type="Reset" class=button value="Reset"></td>-->
</tr>
</table>

</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
 