<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4);
?> 

<?php
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment5/";

$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_POST['CostFile'];
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];

$m_CostFile = $_GET['CostFile'];
$m_OriginFile = $_GET['OriginFile'];
$m_DestFile = $_GET['DestFile'];
if(empty($_POST['submit']))
{
	$m_CostFile = $_POST['CostFile'];
	$m_OriginFile = $_POST['OriginFile'];
	$m_DestFile = $_POST['DestFile'];
}

?>

<style type="text/css">

#scroller {
    width:800px;
    height:300px;
    overflow:auto;   
 }
 
 .title1 
		{
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: x-normal;
			color: #00529C;			
			font-weight : bold;
			text-align: center;			
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
		alert ("Select Impedance Functions !!");
		document.Frm.FunctionsVal.focus();
		return false ;
	}
	else if(document.Frm.FunctionsVal.value == "PowerFun" || document.Frm.FunctionsVal.value == "ExponentialFun")
	{
		if(document.Frm.txtBeta.value == "")
		{
			alert ("Enter Beta Value !!");
			document.Frm.txtBeta.focus();
			return false ;
		}
		if(isNaN(document.Frm.txtBeta.value))
		{
			alert ("Enter Numeric Value For Beta !!");
			document.Frm.txtBeta.focus();
			return false ;
		}
	}	
	else if(document.Frm.FunctionsVal.value == "GammaFun" || document.Frm.FunctionsVal.value == "LinearFun")
	{
		if(document.Frm.txtBeta1.value == "")
		{
			alert ("Enter Beta1 Value !!");
			document.Frm.txtBeta1.focus();
			return false ;
		}
		if(isNaN(document.Frm.txtBeta1.value))
		{
			alert ("Enter Numeric Value For Beta1 !!");
			document.Frm.txtBeta1.focus();
			return false ;
		}
		if(document.Frm.txtBeta2.value == "")
		{
			alert ("Enter Beta2 Value !!");
			document.Frm.txtBeta2.focus();
			return false ;
		}
		if(isNaN(document.Frm.txtBeta2.value))
		{
			alert ("Enter Numeric Value For Beta2!!");
			document.Frm.txtBeta2.focus();
			return false ;
		}
	}
	document.Frm.action="SigGravModRes.php?Exp=3";	
}
</script>

</head>
<div id="body">
<center>    

<form enctype="multipart/form-data" method="post" name="Frm" action="SigGravModDefaultInput.php?Exp=3">
<div id ="submit">
<table class="table table-bordered table-hover">
<tr>
	<th align="left" width="40%"> Origin / Destination Constrained Model : </th>
	<td align="left" width="60%">
	<select name="MethodVal" onChange="form.submit();">
		<option value="" <?if ($m_MethodVal == "") {?>selected <?}?>>Select</option>
		<option value="SinglyOrigin" <?if ($m_MethodVal == "SinglyOrigin") {?>selected <?}?>> Origin Constrained </option>
		<option value="SinglyDest" <?if ($m_MethodVal == "SinglyDest") {?>selected <?}?>> Destination Constrained </option>					
	</select>	
	</td>
</tr>

<tr>
	<th align="left"> Impedence Functions : </th>
	<td align="left">
	<select name="FunctionsVal" onChange="form.submit();">
		<option value="" <?if ($m_FunctionsVal == "") {?>selected <?}?>>Select</option>
		<option value="PowerFun" <?if ($m_FunctionsVal == "PowerFun") {?>selected <?}?>> Power Function </option>
		<option value="ExponentialFun" <?if ($m_FunctionsVal == "ExponentialFun") {?>selected <?}?>>Exponential Function </option>
		<option value="GammaFun" <?if ($m_FunctionsVal == "GammaFun") {?>selected <?}?>>Gamma Function</option>		
		<option value="LinearFun" <?if ($m_FunctionsVal == "LinearFun") {?>selected <?}?>>Linear Function</option>			
	</select>						
	</td>
</tr>

<?php 
if($_POST['FunctionsVal']=="PowerFun" || $_POST['FunctionsVal']=="ExponentialFun")
{
	?>
	<tr>
		<th align="left"> Enter &#946; Value : </th>
		<td align="left">
			<input type="Text" name="txtBeta" size="20" value="<?php $m_txtBeta ?>">	&nbsp;&nbsp;
			
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
	<?php 
}

elseif($_POST['FunctionsVal']=="GammaFun" || $_POST['FunctionsVal']=="LinearFun")
{
	?>
	<tr>
		<th align="left"> Enter &#946;<sub>1</sub> Value : </th>
		<td align="left">
			<input type="Text" name="txtBeta1" size="20" value="<?php $m_txtBeta1 ?>">	&nbsp;&nbsp;
			
			<?php 
			if($_POST['FunctionsVal']=="GammaFun")
			{
			?>
				<font size=3 color="#990000"><B>F<sub>ij</sub> =  e<sup>-&#946;<sub>1</sub>C<sub>ij</sub></sup> C<sub>ij</sub><sup>&#946;<sub>2</sub></sup><B></font>
			<?php 
			}	
			elseif($_POST['FunctionsVal']=="LinearFun") 
			{
			?>
				<font size=3 color="#990000"><B>F<sub>ij</sub> =  &#946;<sub>1</sub> + &#946;<sub>2</sub>C<sub>ij</sub><B></font>
			<?php 
			}
			?>
								
		</td>			
	</tr>
	
	<tr>
		<th align="left"> Enter &#946;<sub>2</sub> Value : </th>
		<td align="left" >
			<input type="Text" name="txtBeta2" size="20" value="<?php $m_txtBeta2 ?>">	
		</td>
	</tr>	
	</table>

	<?php 
}
?>
<br>
</form>
<table cellspacing=5>
                	        
      	
        
    <input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
    <input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
    <input type="hidden" name="DestFile" value="<?=$m_DestFile?>"> 
 	
</table>
<table cellspacing=5 align="center">
<tr>

<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
<!--<td align="left"><input type="submit" class=button value="Reset"></td>-->
</tr>
</table>
<table cellspacing=5 width = "40%" align="center" border=0>

<tr>

<!--  <td align="center">&nbsp;&nbsp;<a href="SigGravMod.php?Exp=3"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td> -->

<td align="center">&nbsp;&nbsp;<a href="SigGravModDel.php?Exp=3&CostFile=<?=$m_CostFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type ="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>     


</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
