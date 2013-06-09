<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment7/";


// Retrieving the values of variables

if(empty($_POST['Submit']))
{
 	$m_CostFile = $_FILES['CostFile']['tmp_name'];
	$m_TripFile = $_FILES['TripFile']['tmp_name'];
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

	if(document.Frm.CostFile.value == "")
	{
		alert ("Select Cost Matrix File !!");
		document.Frm.CostFile.focus();
		return false ;
	}

	if(document.Frm.TripFile.value == "")
	{
		alert ("Select Trip Matrix File !!");
		document.Frm.TripFile.focus();
		return false ;
	}

		
	document.Frm.action="CaliSingModDefaultDisplay.php?Exp=5";
}
function chk2()
{	
	document.Frm.action="CaliSingDefaultDisplay.php?Exp=5";
}
</script>

</head>
<div id="body">
<center>  
<form enctype="multipart/form-data" method="post" name="Frm" action="CaliSingMod.php?Exp=5">
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



<tr>
	<th align="left"> Select Cost Matrix File (xls/csv) : </th>
	<td align="left" >
	<input type="File" name="CostFile" size="30">	
	</td>
</tr>

<tr>
	<th align="left"> Select Base Year Trip Matrix File (xls/csv) : </th>
	<td align="left" >
		<input type="File" name="TripFile" size="30">	
	</td>
</tr>
<tr >
<td colspan="2"><span style="font-size: small; color: #ff0000;"><strong><br><br>See the default Excel / CSV input files for file format:</strong></span></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="../Docs/cost_calb.xls">- (Click Here) For Cost Matrix File (xls)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="../Docs/trip_calib.xls">- (Click Here) For Base Year Trip Matrix File (xls)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="../Docs/cost_calbcsv.csv">- (Click Here) For Cost Matrix File (csv)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="../Docs/trip_calib.csv">- (Click Here) For Base Year Trip Matrix File (csv)</a></strong></td>
</tr>	
	
</table>
<br>
<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
<td align="left"><input type="Reset" class=button value="Reset"></td>
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
