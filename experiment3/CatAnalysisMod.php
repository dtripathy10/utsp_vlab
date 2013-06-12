 <?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Catagory Analysis","Trip Generatrion");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3";

if(!is_dir($folder))
{
	mkdir($folder, 0777);
}

// Retrieving the values of variables (Here file name)

if(empty($_POST['Submit']))
{
$m_CatAnalysis = $_FILES['CatFile']['name'];

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
<style type="text/css">

#scroller {
    width:800px;
    height:300px;
    overflow:auto;
    border-bottom:2px solid #999;
 }
</style>

<!-- Validation for Form Controls -->

<script language="javascript">

function chk1()
{	
	if(document.Frm.CatFile.value == "")
	{
		alert ("Select File !!");
		document.Frm.CatFile.focus();
		return false ;
	}
	document.Frm.action="CatAnalysisMod2.php?Exp=17";
}
function chk2()
{	
	document.Frm.action="CatAnalysisModDefault.php?Exp=17";
}
</script>

</head>
<div id="body">
<center>   
<form enctype="multipart/form-data" method="post" name="Frm" action="CatAnalysisMod.php?Exp=17">
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


<div id="user" >
<table class="table table-bordered table-hover">

<tr align="center">
	<th align="left"  width="30%"> File (xls/csv) : </th>
	<td align="left"><input type="File" name="CatFile" size="50" value="<?=$m_CatAnalysis?>"></td>
</tr>
<tr >
<td colspan="2"><span style="font-size: small; color: #ff0000;"><strong><br><br>See the default Excel / CSV input files for file format:</strong></span></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="<?php echo DOC_FOLDER;?>/pune.xls">- (Click Here) for Input File (xls)</a></strong></td>
</tr>
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="<?php echo DOC_FOLDER;?>/pune.csv">- (Click Here) for Input File (csv)</a></strong></td>
</tr>

</table>




<input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"><span class="tab"></span>
<input type="Reset" class=button value="Reset">

</div>
<div id="default" >

<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk2()"><span class="tab"></span>
<input type="Reset" class=button value="Reset">

</div>
<br>

</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
