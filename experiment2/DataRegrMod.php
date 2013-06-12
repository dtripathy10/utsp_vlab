<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4,"Regression Analysis","Trip Generation");
?> 
<div id="body">
<br>
<?php
session_start();
$UploadFile = $_SESSION['user'];
if(!is_dir(USER_ROOT.$UploadFile."/Experiment2"))
{
	mkdir(USER_ROOT.$UploadFile."/Experiment2", 0777);
}
$file = fopen(USER_ROOT.$UploadFile."/Experiment2/DataRegr.xls", "w");   
fclose($file);

?>

<?php


// Retrieving the values of variables (Here file name)

if(empty($_POST['Submit']))
{
$m_TripFile = $_FILES['TripFile']['tmp_name'];
$m_CatAnalysis = $_FILES['CatFile']['tmp_name'];
$m_Model = $_POST['Model'];
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
	if(document.Frm.TripFile.value == "")
	{
		alert ("Select File !!");
		document.Frm.TripFile.focus();
		return false ;
	}
	document.Frm.action="DataRegrMod2.php?Exp=1";
}

function chk2()
{	
	document.Frm.action="DataRegrModDefault.php?Exp=1";
}


</script>

  <div class="container-fluid1">   
<form enctype="multipart/form-data" method="post" name="Frm" action="DataRegrMod.php?Exp=1">
<center>
<table border="0"  style="border: 1px solid #808080" bgcolor="#e3f2fc" width=100% height="50px">
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


<div id="user" >
<table border="0" cellspacing="10" cellpadding="3" style="border: 1px solid #808080" bgcolor="#e3f2fc" width=100%>

<tr align="center">
	<th align="left"  width="30%"> File (xls/csv) : </th>
	<td align="left"><input type="File" name="TripFile" size="50" value="<?php echo $m_TripFile;?>"></td>
	
</tr>
<tr >
<td colspan="2"><span style="font-size: small; color: #ff0000;"><strong><br><br>See the default Excel / CSV input files for file format:</strong></span></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="<?echo DOC_FOLDER?>/pune.xls">- (Click Here) for Input File (xls)</a></strong></td>
</tr>
<tr>
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="<?echo DOC_FOLDER?>/punecsv.csv">- (Click Here) for Input File (csv)</a></strong></td>
</tr>
</table>


<input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1();">
<span class="tab"></span>
<input type="Reset" class=button value="Reset">

</div>

<div id="default" >
<input type="submit" class=button value="Submit" name="Submit" OnClick="return chk2();">
<span class="tab"></span>
<input type="Reset" class=button value="Reset">
</div>


<br>

</center>

</form>
</div>    
  </div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 	