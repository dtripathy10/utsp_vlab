<?php
session_start();	//To check whether the session has started or not

include"conn.php";	// Database Connection file
include "userchk.php";	//To check user's session

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];


$m_CostFile = $_FILES['CostFile']['name'];
$m_TripFile = $_FILES['TripFile']['name'];



//------------------------------ verifying the format of the file -------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="CaliDoubMod.php";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------


//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$UploadFile."/Experiment8/" . $_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["TripFile"]["tmp_name"],$UploadFile."/Experiment8/" . $_FILES["TripFile"]["name"]);
?>


<!DOCTYPE HTML>
<html>

<head>
<title>Virtual Labs - IIT Bombay</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<style type="text/css">
<!--
-->
</style>
<style type="text/css">@import "css/flexnav.css";</style>
<script type="text/javascript" src="js/beethoven.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
<link href="css/custom.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="ddtabmenufiles/ddtabmenu.js">
</script>
<link rel="stylesheet" type="text/css" href="ddtabmenufiles/glowtabs.css" />

<style type="text/css">
#scroller {
    width:800px;
    height:300px;
    overflow:auto;
 }
</style>

<script language="javascript">
function chk1()
{ 

	document.Frm.action="CaliDoubInput.php";	
}

</script>

</head>



<body bgcolor="#FFFFFF">
<div id="header_main"></div>
 <div id="no_print">
<!-- start header -->
<div id="header">
        <ul id= "menuTop">
			<li><a href="home.php" >Home</a></li>
        	<li><a href="experiment.php" class="active" >Experiments</a></li>
        	<li><a href="Feedback.php" >Feedback</a></li>
        	<li><a href="UserReport.php" >Reports</a></li>
        	<li><a href="" >Contributors</a></li>
        	<li><a href="contactus.php" >Contact Us</a></li>
			<li><a href="logout.php">Log Out</a></li>
		</ul>
</div>
<div style="position: relative; margin:auto; width: 1024px; background-color:#e3f2fc">
  <p style="padding-left:25px;" ><font size="+3" style='font-weight: normal;font-family:Georgia, "Times New Roman", Times, serif;'>Calibration Of Doubly Constrained Gravity Model</font></p>
</div>
<div style="background-image:url(images/content_bg.jpg);position: relative; margin:auto; width: 1024px; min-height:400px;">
        <div id="contentBox" style=" padding:0px; padding-left:50px; padding-right:50px;">
<ul>
<center>
<BR><BR>         

<?php


//------------------------------- Reading Xls file ------------------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{
	// Cost File

	require_once 'phpExcelReader/Excel/reader.php';
	$dataCostF = new Spreadsheet_Excel_Reader();
	$dataCostF->setOutputEncoding('CP1251');
	$dataCostF->read($UploadFile."/Experiment8/".$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	
	$n=$dataCostF->sheets[0]['numRows'];
	$CostRow = $dataCostF->sheets[0]['numRows'];
	$CostCol = $dataCostF->sheets[0]['numCols'];
	
	// check for square matrix
	
	if($CostRow != $CostCol)
	{
		?>
			 <script lanuguage = javascript>		
				alert("The Base Year Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
				location = "CaliDoubMod.php";			
			</script>
		<?php 		
	}
?>

	<div id="scroller">
	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b>Cost Matrix </b></caption>
	<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
       echo "<td ><b>".$i."</b></td>";
	}
	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
 
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $dataCostF->sheets[0]['numCols']; $j++)
    	{     
        	echo "<td bgcolor='#EBF5FF'>";             
        	$m_CostMtx[$i][$j]=$dataCostF->sheets[0]['cells'][$i][$j];
        	
        	// check for number
        	
    	    if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliDoubMod.php";			
					</script>
				<?php 
			}
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    	echo "</tr>";
	}
?>
	</table>
	</div>

	<br><br>

<?php

     // Trip File
     
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        $dataTripF->read($UploadFile."/Experiment8/".$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
         
		$TripRow = $dataTripF->sheets[0]['numRows'];
		$TripCol = $dataTripF->sheets[0]['numCols'];
		
		// check for square matrix
		
		if($TripRow != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
						alert("The Trip Matrix must be a square matrix i.e., the number of rows must be equal to the number of columns")
						location = "CaliDoubMod.php";			
			</script>
		<?php 		
		}
		
		// Check for dimension of both the files
		
		if($TripRow != $CostRow  && $CostCol != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
						alert("The dimension of both the file must be same.")
						location = "CaliDoubMod.php";			
			</script>
		<?php 		
		}
		
        echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Given Base Year Trip Matrix </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>&nbsp;Zone&nbsp;</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[O<sub>i</sub>]&nbsp;</b></td>";
        echo '</tr>';      
       
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            echo '<tr align="center" bgcolor="#EBF5FF">';
            echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {
                echo '<td >';               
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                
                // check for number
                
            	if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliDoubMod.php";			
					</script>
				<?php 
				}
                echo $m_TripMtx[$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j];               
                echo "</td>";
               }  
               echo '<td bgcolor="#B8DBFF"><b>'.$OriginSum[$i].'</b></td>';
               echo "</tr>";                                  
        }
       
        echo "<tr align='center'>";
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[D<sub>j</sub>]&nbsp; </b></td>";
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
            echo "<td bgcolor='#B8DBFF'><b>".$Destsum[$j]."</b></td>";    
         }   
         echo "</tr>";      
         echo "</table></div><br><br>";

}
//---------------------------------------------------------------------------------


//----------------------------- Reading csv file ----------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' )
{
	// Cost File

    $nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment8/".$m_CostFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{    	   
        	$m_Cost[$n][$c] = $data[$c];        	
     	}
     	$n++;    
    }
    for ($i = 0; $i < $n; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_CostMtx[$i+1][$j+1] = $m_Cost[$i][$j] ;      	
         }
    	
    }
   	$CostRow = $n;
	$CostCol = $nCol;
	
	// check for square matrix
	
	if($CostRow != $CostCol)
	{
		?>
			 <script lanuguage = javascript> 			 
						alert("The Base Year O-D Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
						location = "CaliDoubMod.php";			
			</script>
		<?php 		
	}
	

?>

	<div id="scroller">
	<table border=1 cellspacing=1 width="100%" height="25%">
	<caption><b>Cost Matrix </b></caption>
	<?php
	echo'<tr align="center" bgcolor="#CCE6FF"><td><b>Zone</b></td>';
	for ($i = 1; $i <= $n; $i++)
	{
       echo "<td ><b>".$i."</b></td>";
	}
	for ($i = 1; $i <= $n; $i++)
	{
 
    	echo '<tr align="center"><td bgcolor="#CCE6FF"><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{     
        	echo "<td bgcolor='#EBF5FF'>";
    		
        	// check for number
        	
        	if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript>			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliDoubMod.php";			
					</script>
				<?php 
			}
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    	echo "</tr>";
	}
?>
	</table>
	</div>

	<br><br>

<?php

    // Trip File
    
    $nCol=0; 
	$n = 0;
	$name = $UploadFile."/Experiment8/".$m_TripFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Trip[$n][$c] = $data[$c];
        	
     	}
     	$n++;
    
    }
    for ($i = 0; $i < $n; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j] ;      	
         }
    	
    }
		$TripRow = $n;
		$TripCol = $nCol;
	
		// check for square matrix
		
		if($TripRow != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
						alert("The Trip Matrix must be a square matrix i.e., the number of rows must be equal to the number of columns")
						location = "CaliDoubMod.php";			
			</script>
		<?php 		
		}
		
		// Check for dimension of both the files
		
		if($TripRow != $CostRow  && $CostCol != $TripCol)
		{
		?>
			 <script lanuguage = javascript>			 
						alert("The dimension of both the file must be same.")
						location = "CaliDoubMod.php";			
			</script>
		<?php 		
		}
    
        echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> Given Base Year Trip Matrix </b></caption>';
        echo'<tr align="center" bgcolor="#CCE6FF"><td><b>&nbsp;Zone&nbsp;</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[O<sub>i</sub>]&nbsp;</b></td>";
        echo '</tr>';      
       
        for ($i = 1; $i <= $n; $i++)
        {    
            echo '<tr align="center" bgcolor="#EBF5FF">';
            echo "<td bgcolor='#CCE6FF'><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
                echo '<td >';
                
                // check for number
                
    			if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliDoubMod.php";			
					</script>
				<?php 
				}
                
                echo $m_TripMtx[$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j];               
                echo "</td>";
               }  
               echo '<td bgcolor="#B8DBFF"><b>'.$OriginSum[$i].'</b></td>';
               echo "</tr>";                                  
        }
       
        echo "<tr align='center'>";
        echo "<td bgcolor='#B8DBFF'><b> &#8721;&nbsp;[D<sub>j</sub>]&nbsp; </b></td>";
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
            echo "<td bgcolor='#B8DBFF'><b>".$Destsum[$j]."</b></td>";    
         }   
         echo "</tr>";      
         echo "</table></div><br><br>";
}
else
{
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'CaliDoubMod.php';
			</script>
			<?php  
}
   
 ?>
<br>
<form enctype="multipart/form-data" method="post" name="Frm" >
<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
</tr>
</table>
       	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
       	<input type="hidden" name="TripFile" value="<?=$m_TripFile?>">
</form>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
	<!--  <td align="center">&nbsp;&nbsp;<a href="CaliDoubMod.php"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td>	-->
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;<a href="CaliDoubModDel.php?CostFile=<?=$m_CostFile?>&TripFile=<?=$m_TripFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>


<br><br>
</ul>
</center>

</div>

<br><br>
    </p>
 
  </div>
</div>
<div style="position: relative; margin:auto; width: 1024px; background-color:#0e8de0">
<img src="images/footer-curve.jpg" width="1024" height="31" alt=""><div class="copyright">Copyright &copy; 2010-2011</div><br>
</div>

</body>
</html>