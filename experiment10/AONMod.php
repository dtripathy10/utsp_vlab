<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"All or Nothing (AON) Assignment","Trip Assignment");

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment10/";

// Retrieving the values of variables
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}


// Retrieving the values of variables

if(empty($_POST['Submit']))
{
	$m_NodeFile = $_FILES['NodeFile']['name'];
	$m_OdFile = $_FILES['OdFile']['name'];
}

?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
      $(document).ready(function () {
    	  $('#user').hide();
          $('#id_radio1').click(function () {
               $('#user').hide('fast');
               $('#default').show('fast');
           });
          $('#id_radio2').click(function () {
               $('#default').hide('fast');
               $('#user').show('fast');
           });
       });
</script>
<!-- Validation for Form Controls -->

<script language="javascript">
function chk1()
{	
		
		if(document.Frm.NodeFile.value == "")
		{
			alert ("Select File !!");
			document.Frm.NodeFile.focus();
			return false ;
		}
		if(document.Frm.OdFile.value == "")
		{
			alert ("Select File !!");
			document.Frm.OdFile.focus();
			return false ;
		}
		document.Frm.action="AONUserDisplay.php?Exp=8";
}
function chk2()
{	
	document.Frm.action="AONDefault.php?Exp=8";
}
</script>
</head>
<div id="body">
<center> 
<form enctype="multipart/form-data" method="post" name="Frm" action="AONMod.php?Exp=8">
<table class="table table-bordered table-hover">
<tr>
<td>
<b>&nbsp;Choose the appropriate option</b>
</td>

<td>
	         <div>
                   <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" checked="true"/> <b>Default File</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" /> <b>Your File</b>
              </div>
</td>
</tr>
</table>

<div id ="default">
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk2()"></td>
<td align="left"><input type="Reset" class=button value="Reset"></td>
</div>

<div id="user">
<table class="table table-bordered table-hover">
<tr align="center" >
	<th align="left"  width="30%"> Link Characteristics File (xls/csv) : </th>
	<td align="left"><input type="File" name="NodeFile" size="50" value="<?=$m_NodeFile?>"></td>
</tr>
<tr align="center">
	<th align="left"  width="30%"> Origin Destination File (xls/csv) : </th>
	<td align="left"><input type="File" name="OdFile" size="50" value="<?=$m_OdFile?>"></td>
</tr>
<tr >
<td colspan="2"><span style="font-size: small; color: #ff0000;"><strong><br><br>See the default Excel / CSV input files for file format:</strong></span></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="../Docs/link.xls">- (Click Here) For Link Characteristics Matrix File (xls)</a></strong></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="../Docs/OD.xls">- (Click Here) For Origin Destination File (xls)</a></strong></td>
</tr>
<tr>
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="../Docs/linkcsv.csv">- (Click Here)For Link Characteristics Matrix File (csv)</a></strong></td>
</tr>
<tr>
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="../Docs/OD.csv">- (Click Here) For Origin Destination File (csv)</a></strong></td>
</tr>
</table>
<br>


<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
<!--<td align="left"><input type="Reset" class=button value="Reset"></td>-->
</tr>
</table>
 </div>
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  