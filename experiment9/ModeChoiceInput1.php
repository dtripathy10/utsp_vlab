<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Mode Split");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment9/";

if(!is_dir($folder))
{
	mkdir($folder, 0777);
}

// Retrieving the values of variables

$m_nmode = $_POST['nmode'];
?>
<head>
<link rel="stylesheet" type="text/css" href="ddtabmenufiles/glowtabs.css" />

<!-- Validation for Form Controls -->

<script language="javascript">
function chk1()
{  
	if(document.Frm.nmode.value == "")
    {
        alert ("Enter the no. of modes !!");
        document.Frm.nmode.focus();
        return false ;
    }
    if(isNaN(document.Frm.nmode.value))
	{
		alert ("Enter only numeric value !!");
		document.Frm.nmode.focus();
		return false ;
	}
    if(isNaN(document.Frm.nmode.value))
	{
		alert ("Enter only numeric value !!");
		document.Frm.nmode.focus();
		return false ;
	}
    if((document.Frm.nmode.value)>5)
	{
		alert ("Maximum 5 modes are allowed !!");
		document.Frm.nmode.focus();
		return false ;
	}
    document.Frm.action="ModeChoiceInput2.php";
}
</script>


</head>

<div id="body">
<center>
<form enctype="multipart/form-data" method="post" name="Frm">
<table class="table table-bordered table-hover">
<tr>
    <th align="left"  width="30%"><b> Enter the no. of modes : <b></th>
    <td align="left">
    <input type="Text" name="nmode" size="20" value="<?php $m_nmode ?>"> 
    </td>
</tr>
</table>
<br><br>
<table align="center">
<tr>
	<td align="left">
	<input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()">
	</td>
</tr>
</table>
</form>
<input type="hidden" name="nmode" value="<?=$m_nmode?>">
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(3);
?>          