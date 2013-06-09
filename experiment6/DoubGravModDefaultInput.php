<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Doubly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment6/";

$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_POST['CostFile'];
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];

//$m_CostFile = $_GET['CostFile'];
//$m_OriginFile = $_GET['OriginFile'];
//$m_DestFile = $_GET['DestFile'];
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
	document.Frm.action="DoubGravModRes.php?Exp=4";	
}
</script>
</head>
<div id="body">
<br>
<center> 
<form enctype="multipart/form-data" method="post" name="Frm" action="DoubGravModDefaultInput.php?Exp=4">


<table class="table table-bordered table-hover">

<tr>
    <th align="left"> Impedance Functions : </th>
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
            <input type="Text" name="txtBeta" size="20" value="<?php $m_txtBeta ?>">    &nbsp;&nbsp;
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
            <input type="Text" name="txtBeta1" size="20" value="<?php $m_txtBeta1 ?>">    &nbsp;&nbsp;
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
    <?php
}
?>
 
    <tr>
            <th align="left"  width="40%"> Select Accuracy : </th>
            <td align="left"  width="60%">
            <select name="AccuracyVal">        
                <option value="" <?if ($m_AccuracyVal == "") {?>selected <?}?>>Select</option>
                <option value="Individual" <?if ($m_AccuracyVal == "Individual") {?>selected <?}?>>Individual Cell</option>
                <option value="All" <?if ($m_AccuracyVal == "All") {?>selected <?}?>>All Cell</option>                        
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;
			<!-- To open new page -->
            <a href="javascript:Popup('AccuracyHelp.php?Exp=4')"><b><u>Click Here To Know</u></b></a>
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
<table cellspacing=5 align="center">
<tr>

<td align="left"><input type="submit" class="button" value="Submit" name="Submit" OnClick="return chk1()"></td>
<!--<td align="left"><input type="submit" class=button value="Reset"></td>-->
</tr>
</table>

<table cellspacing=5>
                	        
      	
        
    <input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
    <input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
    <input type="hidden" name="DestFile" value="<?=$m_DestFile?>"> 
 	
</table>
</form>

<table cellspacing=5 width = "40%" align="center" border=0>

<tr>

<!--  <td align="center">&nbsp;&nbsp;<a href="SigGravMod.php?Exp=4"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td> -->

<td align="center">&nbsp;&nbsp;<a href="DoubGravModDel.php?Exp=4&CostFile=<?=$m_CostFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type ="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>     
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
