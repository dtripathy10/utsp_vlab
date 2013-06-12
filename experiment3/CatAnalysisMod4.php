 <?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Catagory Analysis","Trip Generatrion");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3/";


$m_CatAnalysis = $_FILES['CatFile']['name'];




if(empty($m_CatAnalysis) )
{
	$m_CatAnalysis = $_POST['CatFile'];
}
$m_no_of_criteria = $_POST['no_of_criteria'];


for ($i = 0; $i < $m_no_of_criteria; $i++)
{

  			  $m_Category[$i] = $_POST['Category'][$i];
}

for ($i = 0; $i < $m_no_of_criteria; $i++)
{

  			  $m_no_of_groups[$i] = $_POST['no_of_groups'][$i];
}

//---------------------------------- verifying the format of the file ---------------------------

$file_ext1= substr($m_CatAnalysis, strripos($m_CatAnalysis, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="CatAnalysisMod.php?Exp=17";
    
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
 #vert
 {
    /* for firefox, safari, chrome, etc. */
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    /* for ie */
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
 }

</style>



<!-- Validation for Form Controls -->

<script language="javascript">
function chk1()
{	

	
	document.Frm.action="CatAnalysisModRes.php?Exp=17";
	//document.Frm.target="_blank"; 
}
</script>

</head>
<div id="body">
<center>   
<form enctype="multipart/form-data" method="post" name="Frm" action="CatAnalysisMod4.php?Exp=17">
<?php 

//  move uploaded files to user specific folder 

		 move_uploaded_file($_FILES["CatFile"]["tmp_name"],$folder . $_FILES["CatFile"]["name"]);		
//------------------------------- reading Xls file-------------------------------------------------

if($file_ext1 == '.xls' )
{

	// Trip File

		require_once EXCELREADER.'/Excel/reader.php';
        $dataCatF = new Spreadsheet_Excel_Reader();
        $dataCatF->setOutputEncoding('CP1251');       
        $dataCatF->read($folder.$m_CatAnalysis);
        error_reporting(E_ALL ^ E_NOTICE);
       	$nRow = $dataCatF->sheets[0]['numRows'];
        $nCol = $dataCatF->sheets[0]['numCols'];
        
        echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
		for ($i = 1; $i <= $nRow; $i++)
        {               
            echo '<tr align="center" bgcolor="#EBF5FF">';           
            for ($j = 1; $j <= $nCol; $j++)
            {
                // saving excel file data in to $m_TripMtx 2-Dimension array variable
                            
                $m_CatMtx[$i][$j]=$dataCatF->sheets[0]['cells'][$i][$j];
                
                if($i>=2)
                {
               		if(!is_numeric($m_CatMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "CatAnalysisMod.php?Exp=17";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td bgcolor='#B8DBFF'><b>".$m_CatMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_CatMtx[$i][$j];    
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
	$name = $folder.$m_CatAnalysis;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Cat[$nRow][$c] = $data[$c];
        	
     	}
     	$nRow++;
    
    }
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		 $m_CatMtx[$i+1][$j+1] = $m_Cat[$i][$j];      	
         }
    	
    }
     
     echo "<caption><b> Observed Socio-Economic Data </b></caption>";
     echo '<div id="scroller"><table class="table table-bordered table-hover">';
     for ($i = 1; $i <= $nRow; $i++)
     {               
            echo '<tr align="center" bgcolor="#EBF5FF">';           
            for ($j = 1; $j <= $nCol; $j++)
            {
                         
                if($i>=2)
                {
               		if(!is_numeric($m_CatMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "CatAnalysisMod.php?Exp=17";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td bgcolor='#B8DBFF'><b>".$m_CatMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_CatMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br>";  
        
        
}
for ($j = 1; $j < $nCol; $j++) 
{
	for ($i = 1; $i <= $nRow; $i++)
	{
		$m_dummy[$i] = $m_CatMtx[$i+1][$j];
//		echo "    ";
		

	}
//	echo "<br>";
	sort($m_dummy);
	for ($i = 1; $i <= $nRow; $i++)
	{
//		echo $m_dummy[$i];
//		echo "    ";
		
		$k=$i;
	}
//	echo "<br>";
	if($j==1)
	{
		 $max[$j]=$m_dummy[$k-1];
	}
	else 
	{
		 $max[$j]=$m_dummy[$k];
	}
//	echo "<br>";
	 $min[$j]=$m_dummy[2];
//	echo "<br>";
//	echo "<br>";
} 


echo '<br><br><br><br>';
echo "<caption><b> Criterion for analysis </b></caption>";
echo '<table class="table table-bordered table-hover">';
echo '<tr align = "center"><td bgcolor="#B8DBFF"><b>Criteria :</b>&nbsp;&nbsp;&nbsp;(range)</td><td bgcolor="#B8DBFF"><b>Enter the Range</b></td></tr>';
for ($i = 1; $i <= $m_no_of_criteria; $i++)
{
	
	echo '<tr align = "center"><td bgcolor="#B8DBFF"><b>'.$m_CatMtx[1][$m_Category[$i-1]].':</b>&nbsp;&nbsp;&nbsp;('.$min[$m_Category[$i-1]]."  to ".$max[$m_Category[$i-1]].')'.'</td><td bgcolor="#EBF5FF">';
//	echo '<tr align = "center"><td bgcolor="#B8DBFF"><tr><td><b>'.$m_CatMtx[1][$m_Category[$i-1]].'</b></td></tr><tr><td>('.$min[$m_Category[$i-1]]."  to ".$max[$m_Category[$i-1]].')'.'</td></tr></td><td bgcolor="#EBF5FF">';
	
	echo '<table border=0 cellspacing=4 align="center" >';
	for ($j = 1; $j <= $m_no_of_groups[$i-1]; $j++) 
	{
					echo '<tr>';
					echo '<td>Group :'.$j.'&nbsp;&nbsp;&nbsp;&nbsp;</td>';
					echo '<td><input type="Text" name="lower_criGrp[]" size="30">&nbsp; To &nbsp;<input type="Text" name="upper_criGrp[]" size="30"></td></td>';
					echo '</tr>'; 	
	}
	echo '</table></td>';

}
echo '</table>';
?>
<br><br><br>

<input type="hidden" name="CatFile"  value="<?=$m_CatAnalysis?>"> 
<input type="hidden" name="no_of_criteria" size="50" value="<?=$m_no_of_criteria?>">
<?php 
for ($i = 0; $i < $m_no_of_criteria; $i++)
{	
?>
    	<input type="hidden" name="Category[]" size="50" value="<?=$m_Category[$i]?>">
<?php
} 
for ($i = 0; $i < $m_no_of_criteria; $i++)
{
   	
   	
?>
    	<input type="hidden" name="no_of_groups[]" size="50" value="<?=$m_no_of_groups[$i]?>">

<?php 
}

?>


<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"><span class="tab"></span>
<input type="Reset" class=button value="Reset">
<br><br>
<a href="CatAnalysisMod.php?Exp=17"><H2><input type ="button" value="Back"></H2></a>
<br>
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  



