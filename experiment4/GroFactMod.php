<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Growth Factor Distribution Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment4/";
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}



//Retrieving values of variables 
if(empty($_POST['Submit']))
{
$m_MethodVal = $_POST['MethodVal'];
$m_txtGrowth = $_POST['txtGrowth'];
$m_ConstraintsVal = $_POST['ConstraintsVal'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];   
$m_BaseFile = $_FILES['BaseFile']['tmp_name'];
$m_OriginFile = $_FILES['OriginFile']['tmp_name'];
$m_DestFile = $_FILES['DestFile']['tmp_name'];
}

?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
      $(document).ready(function () {
    	  $('#default').hide();
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

<script language="javascript">

// To check validation of all inputs
function chk1()
{   
    if(document.Frm.MethodVal.value == "")
    {
        alert ("Select Method Value !!");
        document.Frm.MethodVal.focus();
        return false ;
    }   
    
    else if(document.Frm.MethodVal.value == "SinglyGFM")
    {
        if(document.Frm.ConstraintsVal.value == "")
        {
            alert ("Select Constraints Value !!");
            document.Frm.ConstraintsVal.focus();
            return false ;
        }   
        else if(document.Frm.ConstraintsVal.value == "SinglyOrigin")
        {
            if(document.Frm.OriginFile.value == "")
            {
                alert ("Select Future Year Origins Total File !!");
                document.Frm.OriginFile.focus();
                return false ;
            }
        }
        else if(document.Frm.ConstraintsVal.value == "SinglyDest")
        {
            if(document.Frm.DestFile.value == "")
            {
                alert ("Select Future Year Destinations Total File !!");
                document.Frm.DestFile.focus();
                return false ;
            }   
        }       
    }   
    else if(document.Frm.MethodVal.value == "FratarGFM")
    {
        
        if(document.Frm.OriginFile.value == "")
        {
            alert ("Select Future Year Origins Total File !!");
            document.Frm.OriginFile.focus();
            return false ;
        }
        if(document.Frm.DestFile.value == "")
        {
            alert ("Select Future Year Destinations Total File !!");
            document.Frm.DestFile.focus(); 
            return false ;
        }       
    }

    if(document.Frm.BaseFile.value == "")
    {
        alert ("Select Base Year O-D Matrix File !!");
        document.Frm.BaseFile.focus();
        return false ;
    }   
    document.Frm.action="GroFactModInputDisplay.php?Exp=2";  
}
//To check validation of all inputs
function chk2()
{  
    document.Frm.action="GroFactDefaultInput.php?Exp=2";  
}
</script>
<div id="body">  
<form enctype="multipart/form-data" method="post" name="Frm" action="GroFactMod.php">
<center>
<table class="table table-bordered table-hover">
<tr>
<td>
<b>&nbsp;Choose the appropriate option</b>
</td>

<td>
	         <div>
                   <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1"/> <b>Default File</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2"   checked="true"/> <b>Your File</b>
              </div>
</td>
</tr>
</table>


<div id="default"> 

<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk2()"></td>
</tr>
</table>
 
</div>
<div id="user">
<table class="table table-bordered table-hover">
<tr>
    <th align="left"  width="30%"> Methods : </th>
    <td align="left"  width="75%">
    <select name="MethodVal" onChange="form.submit();">
        <option value="" <?php if ($m_MethodVal == "") {?>selected <?php }?>>Select</option>
        <option value="UniformGFM" <?php if ($m_MethodVal == "UniformGFM") {?>selected <?php }?>>Uniform Growth Factor Method</option>
        <option value="SinglyGFM" <?php if ($m_MethodVal == "SinglyGFM") {?>selected <?php }?>>Singly Constrained Growth Factor Method</option>
        <option value="FratarGFM" <?php if ($m_MethodVal == "FratarGFM") {?>selected <?php }?>>Doubly Constrained Growth Factor Method</option>       
    </select>   
    </td>
</tr>

<?php 

if($_POST['MethodVal']=="SinglyGFM")
{
?>
    <tr>
        <th align="left"  width="30%"> Constraints : </th>
        <td align="left"  width="75%">
        <select name="ConstraintsVal" onChange="form.submit();">       
            <option value="" <?php if ($m_ConstraintsVal == "") {?>selected <?php }?>>Select</option>
            <option value="SinglyOrigin" <?php if ($m_ConstraintsVal == "SinglyOrigin") {?>selected <?php }?>>Singly Constrained Growth Factor Method (Origin)</option>
            <option value="SinglyDest" <?php if ($m_ConstraintsVal == "SinglyDest") {?>selected <?php }?>>Singly Constrained Growth Factor Method (Destination)</option>                       
        </select>   
        </td>
    </tr>

    <?php 
}
    if($_POST['ConstraintsVal']=="SinglyOrigin")
    {
    ?>
        <tr>
            <th align="left"  width="30%"> Select Future Year Origins Total File (xls / csv) : </th>
            <td align="left">
                <input type="File" name="OriginFile" size="30">   
            </td>
        </tr>
        <?php
    }
    elseif($_POST['ConstraintsVal']=="SinglyDest")
    {
        ?>
        <tr>
            <th align="left"  width="30%"> Select Future Year Destinations Total File (xls / csv) : </th>
            <td align="left">
                <input type="File" name="DestFile" size="30">   
            </td>
        </tr>
        <?php
    }   


elseif($_POST['MethodVal']=="FratarGFM")
{
        ?>

        <tr>
            <th align="left"  width="30%"> Select Future Year Origins Total File (xls / csv) : </th>
            <td align="left">
                <input type="File" name="OriginFile" size="30">   
            </td>
        </tr>

        <tr>
            <th align="left"  width="30%"> Select Future Year Destinations Total File (xls / csv) : </th>
            <td align="left">
                <input type="File" name="DestFile" size="30">   
            </td>
        </tr>
        <?php
}
?>

<tr>
    <th align="left"  width="30%"> Select Base Year O-D Matrix File (xls / csv) : </th>
    <td align="left">
    <input type="File" name="BaseFile" size="30">   
    </td>
</tr>

<tr >
<td colspan="2"><span style="font-size: small; color: #ff0000;"><strong><br><br>See the default Excel / CSV input files for file format:</strong></span></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="Docs/origin_future.xls">- (Click Here) For Future Year Origins Total File (xls)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="Docs/destination_future.xls">- (Click Here) For Future Year Destinations Total File (xls)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="Docs/base_matrix.xls">- (Click Here) For Base Year O-D Matrix File (xls)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="Docs/origin_futurecsv.csv">- (Click Here) For Future Year Origins Total File (csv)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="Docs/destination_futurecsv.csv">- (Click Here) For Future Year Destinations Total File (csv)</a></strong></td>
</tr>
<tr >
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="Docs/base_matrixcsv.csv">- (Click Here) For Base Year O-D Matrix File (csv)</a></strong></td>
</tr>

</table>
<br>

<table cellspacing=5>
<tr>
<td align="left"><input class="btn btn-primary"type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
</div>
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
