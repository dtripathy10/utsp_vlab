<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4,"Regression Analysis","Trip Generation");
?> 
<div id="body">
<?php
include "../functlib.php";
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment2/";

// Retrieving the values of variables

$m_TripFile = $_FILES['TripFile']['name'];
$m_AnalysisVar = $_POST['AnalysisVar'];
$m_DataChoiceVar = $_POST['DataChoiceVar'];
$m_RegrType = $_POST['RegrType'];
$m_Type = $_POST['Type'];

for ($i=0; $i < count($_POST['CorrDescVar']);$i++)
{	
    $m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];    
}

$m_PlotXVar = $_POST['PlotXVar'];
$m_PlotYVar = $_POST['PlotYVar'];


$m_RegrDepdVar = $_POST['RegrDepdVar'];

for ($i=0; $i < count($_POST['RegrInpdVar']);$i++)
{	
    $m_RegrInpdVar[$i] = $_POST['RegrInpdVar'][$i];    
}

if(empty($m_TripFile))
{
	$m_TripFile = $_POST['TripFile'];
}

if(empty($m_TripFile) && empty($_POST['TripFile']))
{
	$m_TripFile = $_GET['TripFile'];
}


//---------------------------------- verifying the format of the file ---------------------------

$file_ext1= substr($m_TripFile, strripos($m_TripFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="DataRegrMod.php?Exp=1";
    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------


?>


<style type="text/css">
#scroller 
{
    width:900px;
    height:300px;
    overflow:auto;
    border-bottom:2px solid #999;
 }
</style>


<!-- Validation for Form Controls -->

<script language="javascript">
function chk1()
{	
	if(document.Frm.AnalysisVar.value == "")
	{
		alert ("Select Analysis !!");
		document.Frm.AnalysisVar.focus();
		return false ;
	}	
	else if(document.Frm.AnalysisVar.value == "DataAna")
	{
		if(document.Frm.DataChoiceVar.value == "")
		{
			alert ("Select Choice !!");
			document.Frm.DataChoiceVar.focus();
			return false ;
		}	
		else if(document.Frm.DataChoiceVar.value == "Correlation" || document.Frm.DataChoiceVar.value == "Descriptives")
		{			
			if(document.Frm.elements["CorrDescVar[]"].value == "")
			{
				alert ("Select Variables !!");
				document.Frm.CorrDescVar.focus();
				return false ;
			}			
		}	
		else if(document.Frm.DataChoiceVar.value == "Plot")
		{
			if(document.Frm.PlotXVar.value == "")
			{
				alert ("Select X variable !!");
				document.Frm.PlotXVar.focus();
				return false ;
			}	
			if(document.Frm.PlotYVar.value == "")
			{
				alert ("Select Y variable !!");
				document.Frm.PlotYVar.focus();
				return false ;
			}	
		}
	}
	else if(document.Frm.AnalysisVar.value == "RegrAna")
	{
		if(document.Frm.Type.value == "")
		{
			alert ("Select the type of regression !!");
			document.Frm.Type.focus();
			return false ;
		}
		else if(document.Frm.Type.value == "NonLinear")
		{
			if(document.Frm.RegrType.value == "")
			{
				alert ("Select the method for non linear regression!!");
				document.Frm.RegrType.focus();
				return false ;
			}
			if(document.Frm.RegrDepdVar.value == "")
			{
				alert ("Select Dependent variable !!");
				document.Frm.RegrDepdVar.focus();
				return false ;
			}	
			if(document.Frm.elements["RegrInpdVar[]"].value == "")
			{
				alert ("Select Independent Variables !!");
				document.Frm.RegrInpdVar.focus();
				return false ;
			}	
		}
		else
		{
			if(document.Frm.RegrDepdVar.value == "")
			{
				alert ("Select Dependent variable !!");
				document.Frm.RegrDepdVar.focus();
				return false ;
			}	
			if(document.Frm.elements["RegrInpdVar[]"].value == "")
			{
				alert ("Select Independent Variables !!");
				document.Frm.RegrInpdVar.focus();
				return false ;
			}	
		}


		

	}	

	document.Frm.action="DataRegrModRes.php?Exp=1";
	//document.Frm.target="_blank"; 
}
</script>

</head>

<center>     
<?php 

//  move uploaded files to user specific folder 

		 move_uploaded_file($_FILES["TripFile"]["tmp_name"],$folder . $_FILES["TripFile"]["name"]);		
		 	

//------------------------------- reading Xls file-------------------------------------------------

if($file_ext1 == '.xls' )
{

	// Trip File

		require_once EXCELREADER.'/Excel/reader.php';
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $nRow = $dataTripF->sheets[0]['numRows'];
        $nCol = $dataTripF->sheets[0]['numCols'];
        
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
        for ($i = 1; $i <= $nRow; $i++)
        {               
            echo '<tr align="center" >';  
            if($i == 1)
            {
            	echo "<td ><b>Zone</b></td>";
            }
            else 
            {
            	echo "<td ><b>".($i-1)."</b></td>"; 
            }           
            for ($j = 1; $j <= $nCol; $j++)
            {
                // saving excel file data in to $m_TripMtx 2-Dimension array varible
                            
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                
                if($i>=2)
                {
               		if(!is_numeric($m_TripMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "DataRegrMod.php?Exp=1";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td ><b>".$m_TripMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_TripMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br><br>";  

        

}
//----------------------------------------------------------------------------------

//----------------------------- reading csv file---------------------------------------------

elseif($file_ext1 == '.csv' )
{

 	$nCol=0; 
	$nRow = 0;
	$name = $folder.$m_TripFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Trip[$nRow][$c] = $data[$c];
        	
     	}
     	$nRow++;
    
    }
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		 $m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j];      	
         }
    	
    }
    
     echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
     for ($i = 1; $i <= $nRow; $i++)
     {               
     		
            echo '<tr align="center" >'; 
            if($i == 1)
            {
            	echo "<td ><b>Zone</b></td>";
            }
            else 
            {
            	echo "<td ><b>".($i-1)."</b></td>"; 
            }         
            for ($j = 1; $j <= $nCol; $j++)
            {
                         
                if($i>=2)
                {
               		if(!is_numeric($m_TripMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "DataRegrMod.php?Exp=1";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td ><b>".$m_TripMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_TripMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br><br>";  
        
        
}
//------------------------------------------------------------------------------------------------       
        
?>

<form enctype="multipart/form-data" method="post" name="Frm" action="DataRegrMod2.php?Exp=1">

<table class="table table-bordered table-hover">

<tr>
	<th align="left"  width="30%"> Analysis : </th>
	<td align="left" >
	<select name="AnalysisVar" onChange="form.submit();">
		<option value="" <?php if ($m_AnalysisVar == "") {?>selected <?php }?>>Select</option>
		<option value="DataAna" <?php if ($m_AnalysisVar == "DataAna") {?>selected <?php }?>>Data Analysis</option>
		<option value="RegrAna" <?php if ($m_AnalysisVar == "RegrAna") {?>selected <?php }?>>Regression Analysis</option>		
	</select>	
	</td>
</tr>

<?php  
if($_POST['AnalysisVar']=="DataAna")
{
	?>
	<tr>
	<th align="left"  width="30%"> Choice : </th>
	<td align="left" >
	<select name="DataChoiceVar" onChange="form.submit();">
		<option value="" <?php if ($m_DataChoiceVar == "") {?>selected <?php }?>>Select</option>
		<option value="Correlation" <?php if ($m_DataChoiceVar == "Correlation") {?>selected <?php }?>> Correlation Matrix </option>
		<option value="Descriptives" <?php if ($m_DataChoiceVar == "Descriptives") {?>selected <?php }?>> Descriptive Statistics</option>		
		<option value="Plot" <?php if ($m_DataChoiceVar == "Plot") {?>selected <?php }?>> Plot </option>		
	</select>	
	</td>
	</tr>
	
	<?php 
	if ($_POST['DataChoiceVar']=="Correlation" || $_POST['DataChoiceVar']=="Descriptives")
	{		
		echo "<tr>";
		echo "<th align='left'  width='30%'> Variables : </th>";
		echo "<td align='left'>";
		
		
		echo '<select name="CorrDescVar[]" multiple size=5>';
		
		for ($j = 1; $j <= $nCol; $j++)
        {
        	?>
  			<option value="<?php echo $j;?>" <?php if ($m_CorrDescVar[$j] == $j) {?>selected<?php }?>><?php echo $m_TripMtx[1][$j];?></option>  			
  			<?php     			
        }
        
  		echo '</select>';		
  		
  		echo "</td>";
		echo "</tr>";
	}	
	elseif ($_POST['DataChoiceVar']=="Plot")
	{
		echo "<tr>";
		echo "<th align='left'  width='30%'> Plot (X,Y) : </th>";
		echo "<td align='left'> <b>X - Axis :</b> &nbsp;&nbsp;";
		
		echo '<select name="PlotXVar" onChange="form.submit();">';
		?>
		<option value="" <?php if ($m_PlotXVar == "") {?>selected <?php }?>>Select</option>
		<?php 
		
		for ($j = 1; $j <= $nCol; $j++)
        {
        	?>
  			<option value="<?php echo $j;?>" <?php if ($m_PlotXVar == $j) {?>selected<?php }?>><?php echo $m_TripMtx[1][$j];?></option>
  			<?php  			
        }
                        
  		echo '</select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Y - Axis :</b> &nbsp;&nbsp;';	
  		
  		echo '<select name="PlotYVar" onChange="form.submit();">';
  		?>
		<option value="" <?php if($m_PlotYVar == "") {?>selected <?php }?>>Select</option>
		<?php 
		for ($j = 1; $j <= $nCol; $j++)
        {
        	if($_POST['PlotXVar']!=$j)
        	{
        	?>        	
  			<option value="<?php echo $j;?>" <?php if($m_PlotYVar == $j) {?>selected<?php }?>><?php echo $m_TripMtx[1][$j];?></option>
  			<?php  			  			
        	}  			
        }
        
  		echo '</select>';	
		echo "</td>";
		echo "</tr>";
		
	}
	
}
elseif($_POST['AnalysisVar']=="RegrAna")
{		
	
	?>
	<tr>
	<th align="left"  width="30%">Regression Type : </th>
	<td align="left" >
	<select name="Type" onChange="form.submit();">
		<option value="" <?php if ($m_Type == "") {?>selected <?php }?>>Select</option>
		<option value="Linear" <?php if ($m_Type == "Linear") {?>selected <?php }?>>Linear </option>
		<option value="NonLinear" <?php if ($m_Type == "NonLinear") {?>selected <?php }?>>Non Linear </option>
	</select>	
	</td>
	</tr>
	<?php 	
		if($_POST['Type']=="NonLinear")	
		{
			?>
			<th align="left"  width="30%">Method : </th>
			<td align="left" >
			<select name="RegrType" onChange="form.submit();">
			<option value="" <?php if ($m_RegrType == "") {?>selected <?php }?>>Select</option>
			<option value="Quadratic" <?php if ($m_RegrType == "Quadratic") {?>selected <?php }?>>Quadratic </option>	
			<option value="Power" <?php if ($m_RegrType == "Power") {?>selected <?php }?>>Power </option>		
			<option value="Exponential" <?php if ($m_RegrType == "Exponential") {?>selected <?php }?>>Exponential </option>	
			<option value="Logarithmic" <?php if ($m_RegrType == "Logarithmic") {?>selected <?php }?>> Logarithmic </option>	
			<?php 
		}
		else if($_POST['Type']=="Linear")	
		{
			$m_RegrType = "Linear";
			
		}
		if(isset($_POST['Type']))
		{
			$m_RegrType=$_POST['RegrType'];
			if($_POST['Type']=="Linear")	
			{
			
				?>
                <font size=3 color="#990000"><B>y =  ax + b<B></font>
            	<?php
			}
			else if($m_RegrType=="Quadratic")
            {
            	?>
                <font size=3 color="#990000"><B>y =  ax<sup>2</sup>+bx+c<B></font>
            	<?php
            }
			else if($m_RegrType=="Power")
            {
            	?>
                <font size=3 color="#990000"><B>y =  ab<sup>x</sup><B></font>
            	<?php
            }
			else if($m_RegrType=="Exponential")
            {
            	?>
                <font size=3 color="#990000"><B>y =  ae<sup>x</sup><B></font>
            	<?php
            }
			else if($m_RegrType=="Logarithmic")
            {
            	?>
                <font size=3 color="#990000"><B>y =  a + blog[x]<B></font>
            	<?php
            }
         echo"</tr>";
		echo "<tr>";
		echo "<th align='left'  width='30%'> Variables : </th>";
		echo "<td align='left'>"; 
		echo '<table class="table table-bordered table-hover"><tr><td align="left"><b>Dependent</b></td>';
		
		echo '<td align="left"><select name="RegrDepdVar" onChange="form.submit();">';
		?>
		<option value="" <?php if($m_RegrDepdVar == "") {?>selected <?php }?>>Select</option>
		<?php 		
		for ($j = 1; $j <= $nCol; $j++)
        {
        	?>
  			<option value="<?php echo $j;?>" <?php if($m_RegrDepdVar == $j) {?>selected<?php }?>><?php echo $m_TripMtx[1][$j];?></option>
  			<?php  					
        }        
  		echo '</td></select>';
  		echo '<td align="left"><b>Independent</b></td>';	
  		
  		echo '<td align="left"><select name="RegrInpdVar[]" multiple size=5>';  		
		for ($j = 1; $j <= $nCol; $j++)
        {
        	if($_POST['RegrDepdVar']!=$j)
        	{
        	?>        	
  			<option value="<?php echo $j;?>" <?php if($m_RegrInpdVar[$j] == $j) {?>selected<?php }?>><?php echo $m_TripMtx[1][$j];?></option>
  			<?php  			  			
        	}  			
        }        
  		echo '</select></td>';
		echo "</tr></table></td>";
		echo "</tr>";
					
		}
}


?>

</table>

<input type="hidden" name="TripFile" size="50" value="<?php echo $m_TripFile;?>"> 
	
	<?php 	if ($_POST['DataChoiceVar']=="Plot")
			{
				?>
				<input type="hidden" name="file_ext1" size="50" value="<?php echo $file_ext1;?>">
				<a href="plotexample.php?TripFile=<?php echo $m_TripFile;?>&AnalysisVar=<?php echo $m_AnalysisVar;?>&DataChoiceVar=<?php echo $m_DataChoiceVar;?>&PlotXVar=<?php echo $m_PlotXVar;?>&PlotYVar=<?php echo $m_PlotYVar;?>&file_ext1=<?php echo $file_ext1;?>" target="_blank"><H2><input type ="button" value="Submit"></H2></a>
				<?php
			}
			else 
			{	?>
				<input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()">
				<?php 
			}
	?>	

<?php 
if($m_TripFile = "DataRegr.xls")
{
echo '<a class="pull-right" href="DataRegrMod.php?Exp=1"><input type ="button" value="Back">';
}
else
{
?>
<br>
<a class="pull-right" href="DataRegrMod.php?Exp=1"><H2><input type ="button" value="Back"></H2></a>
<br>
<?php }?> 
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 	