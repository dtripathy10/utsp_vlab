<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Mode Split");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment9/";

$m_nmode = $_POST['nmode'];

for ($i=0; $i < $m_nmode ;$i++)
{	
    	$m_ModeName[$i] = $_POST['ModeName'][$i];
	
    	$m_txtTV[$i] = $_POST['txtTV'][$i];
	
    	$m_txtTW[$i] = $_POST['txtTW'][$i];
	
    	$m_txtTT[$i] = $_POST['txtTT'][$i];
	
    	$m_txtFC[$i] = $_POST['txtFC'][$i];
	
    	$m_txtPC[$i] = $_POST['txtPC'][$i];

    	$m_txtOP[$i] = $_POST['txtOP'][$i];
}	
	
$file = fopen($folder."ModSplitReport.xls", "a+");   
fclose($file);
?>
<head>
<script language="javascript">

function chk1()
{
    dml=document.forms['Frm'];
	// get the number of elements from the document
	 len = dml.elements.length;
	 for( i=0 ; i<len ; i++)
	 {

		//check the Selectbox with the elements name
		if (dml.elements[i].name=='ModeName[]')
		{
		  // if exists do the validation and set the focus to the textbox
		    if (dml.elements[i].value=="")
			{
				alert("Select Mode Value !");
				dml.elements[i].focus();
				return false;			
			}
		    
		}
		
		//check the textbox with the elements name
		
		if (dml.elements[i].name=='txtTV[]')
		{
		  	// if exists do the validation and set the focus to the textbox
		    if (dml.elements[i].value=="")
			{
				alert("Enter the In-vehicle travel time !!");
				dml.elements[i].focus();
				return false;			
			}
		
		    if (isNaN(dml.elements[i].value))
			{
				alert("Enter numeric value only !!");
				dml.elements[i].focus();
				return false;			
			}
		    
		}

		if (dml.elements[i].name=='txtTW[]')
		{			  	
		    if (dml.elements[i].value=="")
			{
				alert("Enter the walking travel time !!");
				dml.elements[i].focus();
				return false;			
			}
		
		    if (isNaN(dml.elements[i].value))
			{
				alert("Enter numeric value only !!");
				dml.elements[i].focus();
				return false;			
			}
		   
		}

		if (dml.elements[i].name=='txtTT[]')
		{			  	
		    if (dml.elements[i].value=="")
			{
				alert("Enter the waiting time !!");
				dml.elements[i].focus();
				return false;			
			}
		
		    if (isNaN(dml.elements[i].value))
			{
				alert("Enter numeric value only !!");
				dml.elements[i].focus();
				return false;			
			}
		    
		}

		if (dml.elements[i].name=='txtFC[]')
		{			  	
		    if (dml.elements[i].value=="")
			{
				alert("Enter the fare charged !!");
				dml.elements[i].focus();
				return false;			
			}
		
		    if (isNaN(dml.elements[i].value))
			{
				alert("Enter numeric value only !!");
				dml.elements[i].focus();
				return false;			
			}
		}

		if (dml.elements[i].name=='txtPC[]')
		{			  	
		    if (dml.elements[i].value=="")
			{
				alert("Enter the parking cost !!");
				dml.elements[i].focus();
				return false;			
			}
		
		    if (isNaN(dml.elements[i].value))
			{
				alert("Enter numeric value only !!");
				dml.elements[i].focus();
				return false;			
			}
		}

		if (dml.elements[i].name=='txtOP[]')
		{			  	
		    if (dml.elements[i].value=="")
			{
				alert("Enter the Other parameters !!");
				dml.elements[i].focus();
				return false;			
			}
		
		    if (isNaN(dml.elements[i].value))
			{
				alert("Enter numeric value only !!");
				dml.elements[i].focus();
				return false;			
			}
		}	
		
	 }
		if(document.Frm.txtcoTV.value == "")
	    {
	        alert ("Enter the Coefficient of In-Vehicle Travel time !!");
	        document.Frm.txtcoTV.focus();
	        return false ;
	    }
	    if(isNaN(document.Frm.txtcoTV.value))
		{
			alert ("Enter only numeric value !!");
			document.Frm.txtcoTV.focus();
			return false ;
		}

	    if(document.Frm.txtcoTW.value == "")
	    {
	        alert ("Enter the Coefficient of Walking time !!");
	        document.Frm.txtcoTW.focus();
	        return false ;
	    }
	    if(isNaN(document.Frm.txtcoTW.value))
		{
			alert ("Enter only numeric value !!");
			document.Frm.txtcoTW.focus();
			return false ;
		}

	    if(document.Frm.txtcoTT.value == "")
	    {
	        alert ("Enter the Coefficient of Waiting time !!");
	        document.Frm.txtcoTT.focus();
	        return false ;
	    }
	    if(isNaN(document.Frm.txtcoTT.value))
		{
			alert ("Enter only numeric value !!");
			document.Frm.txtcoTT.focus();
			return false ;
		}

	    if(document.Frm.txtcoFC.value == "")
	    {
	        alert ("Enter the Coefficient of Fare Charged !!");
	        document.Frm.txtcoFC.focus();
	        return false ;
	    }
	    if(isNaN(document.Frm.txtcoFC.value))
		{
			alert ("Enter only numeric value !!");
			document.Frm.txtcoFC.focus();
			return false ;
		}

	    if(document.Frm.txtcoPC.value == "")
	    {
	        alert ("Enter the Coefficient of Parking Cost !!");
	        document.Frm.txtcoPC.focus();
	        return false ;
	    }
	    if(isNaN(document.Frm.txtcoPC.value))
		{
			alert ("Enter only numeric value !!");
			document.Frm.txtcoPC.focus();
			return false ;
		}

	    if(document.Frm.txtcoOP.value == "")
	    {
	        alert ("Enter the Coefficient of Other parameters !!");
	        document.Frm.txtcoOP.focus();
	        return false ;
	    }
	    if(isNaN(document.Frm.txtcoOP.value))
		{
			alert ("Enter only numeric value !!");
			document.Frm.txtcoOP.focus();
			return false ;
		}
	    
	    if(document.Frm.trip.value == "")
	    {
	        alert ("Enter the No. Of Trips !!");
	        document.Frm.trip.focus();
	        return false ;
	    }

	 document.Frm.action="ModeChoiceRes.php";
	return true;	
}
function chk2(i)
{
	var a = new Array();
	a = document.getElementsByName('ModeName['+i+']')[0];

	

	if(a['value']==0)
	{
		document.getElementsByName('txtTV[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtTW[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtTT[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtFC[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtPC[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtOP[]')[i].removeAttribute("readonly");
		
	}
	if(a['value']==1 || a['value']==2)
	{
		
		document.getElementsByName('txtTW[]')[i].setAttribute("readonly", "true");
		document.getElementsByName('txtTT[]')[i].setAttribute("readonly", "true");
		document.getElementsByName('txtFC[]')[i].setAttribute("readonly", "true");
		document.getElementsByName('txtPC[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtTW[]')[i].value = 0;
		document.getElementsByName('txtTT[]')[i].value = 0;
		document.getElementsByName('txtFC[]')[i].value = 0;
		
	}
	if(a['value']==3 || a['value']==4 || a['value']==5)
	{
		document.getElementsByName('txtTW[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtTT[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtFC[]')[i].removeAttribute("readonly");
		document.getElementsByName('txtPC[]')[i].setAttribute("readonly", "true");
		document.getElementsByName('txtPC[]')[i].value=0;
	}
}



</script>

</head>
<div id ="body">
<center>
<form enctype="multipart/form-data" method="post" name="Frm" action="ModeChoiceInput2.php">
<center>
	<div>
	<table class="table table-bordered table-hover" >
	<th>Sr No.</th><th>Mode Choice</th><th>In-Vehicle Travel time</th><th>Walking time</th><th>Waiting time</th><th>Fare Charged</th><th>Parking Cost</th><th>Other parameters</th>
	<tr>
	
<?php 
for ($i = 0; $i < $m_nmode; $i++) 
{
	?>

	<th><?=$i+1?></th>
	<td>
	<select name="ModeName[<?php echo $i;?>]" onChange="chk2(<?php echo $i;?>);">          
    	<option value="" >Select</option>
        <option value="1">Car</option>
        <option value="2">Two Wheeler</option>
        <option value="3">Bus</option>
        <option value="4">Train</option>
        <option value="5">Para Transit</option>   
    </select>   
    </td>
        <td>
            <input type="Text" name="txtTV[]" class="modechoice"  >
        </td>
 
        <td>
            <input type="Text" name="txtTW[]" class="modechoice">   
        </td>

        <td>
            <input type="Text" name="txtTT[]"  class="modechoice">   
        </td>

        <td >
            <input type="Text" name="txtFC[]" class="modechoice" >   
        </td>

        <td align="left">
            <input type="Text" name="txtPC[]"  class="modechoice">   
        </td>
        <td>
            <input type="Text" name="txtOP[]" class="modechoice">   
        </td>
    </tr>
    

	
	<?php 
}
?>
	<tr>
		<th colspan ="2">Coefficients</th>
       	<td>
             <input type="Text" name="txtcoTV" class="modechoice">  
        </td>
        <td>
            <input type="Text" name="txtcoTW" class="modechoice" >   
        </td>
        <td>
            <input type="Text" name="txtcoTT" class="modechoice" >   
        </td>
        <td>
            <input type="Text" name="txtcoFC" class="modechoice" >   
        </td>
        <td>
            <input type="Text" name="txtcoPC" class="modechoice" >   
        </td>
        <td>
            <input type="Text" name="txtcoOP" class="modechoice">   
        </td>
 	</table>
 	</div>
 	<br><br>
 	<table class="table table-bordered table-hover">
 	    <tr>
        <th align="Center"  width="60%" height="30px"> No. Of Trips generated between Source and Destination : </th>
        <td align="left">
            <input type="Text" name="trip" size="20">   
        </td>
    </tr>
    
	</table>
</center>	
<input type="hidden" name="nmode" value="<?=$m_nmode?>">
<br><br>

<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Next" name="Next" OnClick="return chk1()"></td>
<td align="left"><input type="Reset" class=button value="Reset"></td>
</tr>
</table> 

</form>

<br><br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
      <td align="center">&nbsp;&nbsp;<a href="ModeChoiceInput1.php"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(3);
?>     