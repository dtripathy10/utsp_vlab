<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Growth Factor Distribution Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment4/";

//Retrieving values of variables 
if(empty($_POST['Submit']))
{
$m_MethodVal = $_POST['MethodVal'];
$m_ConstraintsVal = $_POST['ConstraintsVal'];
}

?>

<!DOCTYPE HTML>


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
              
    }   
    
    document.Frm.action="GroFactModDefaultDisplay.php";  
    //document.Frm.action="GroFactModRes.php";
}
</script>

<div id="body">  

<form enctype="multipart/form-data" method="post" name="Frm" action="GroFactDefaultInput.php">
<center>
<table class="table table-bordered table-hover">
<tr>
    <th align="left"  width="30%"> Methods : </th>
    <td align="left"  width="75%">
    <select name="MethodVal" onChange="form.submit();">
        <option value="" <?if ($m_MethodVal == "") {?>selected <?}?>>Select</option>
        <option value="UniformGFM" <?if ($m_MethodVal == "UniformGFM") {?>selected <?}?>>Uniform Growth Factor Method</option>
        <option value="SinglyGFM" <?if ($m_MethodVal == "SinglyGFM") {?>selected <?}?>>Singly Constrained Growth Factor Method</option>
        <option value="FratarGFM" <?if ($m_MethodVal == "FratarGFM") {?>selected <?}?>>Doubly Constrained Growth Factor Method</option>       
    </select>   
    </td>
</tr>

<?

if($_POST['MethodVal']=="SinglyGFM")
{
?>
    <tr>
        <th align="left"  width="30%"> Constraints : </th>
        <td align="left"  width="75%">
        <select name="ConstraintsVal" onChange="form.submit();" >       
            <option value="" <?if ($m_ConstraintsVal == "") {?>selected <?}?>>Select</option>
            <option value="SinglyOrigin" <?if ($m_ConstraintsVal == "SinglyOrigin") {?>selected <?}?>>Singly Constrained Growth Factor Method (Origin)</option>
            <option value="SinglyDest" <?if ($m_ConstraintsVal == "SinglyDest") {?>selected <?}?>>Singly Constrained Growth Factor Method (Destination)</option>                       
        </select>   
        </td>
    </tr>
<?php 
}
?>

</table>
<br>


<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
</tr>
</table>
 </center>
</form>
</div>

<?php
  include_once("footer.php");
  getFooter(4);
?>  

