 <?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3/";


$m_CatAnalysis = $_FILES['CatFile']['name'];
$m_no_of_criteria = $_POST['no_of_criteria'];

//$m_CatAnalysis = $_POST['CatFile'];
if(empty($m_CatAnalysis) )
{
	$m_CatAnalysis = $_POST['CatFile'];
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

	document.Frm.action="CatAnalysisMod4.php?Exp=17";
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
            echo '<tr align="center" >';           
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
                     echo "<td ><b>".$m_CatMtx[$i][$j]."</b></td>" ;
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
            echo '<tr align="center" >';           
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
                     echo "<td ><b>".$m_CatMtx[$i][$j]."</b></td>" ;
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
echo '<table>';
for ($m = 1; $m <= $m_no_of_criteria; $m++)
{

		echo "<tr><td><b>Criteria Basis ".$m." : </b>";
		echo '<select name="Category[]">';
		?>
		<option value="" >Select</option>
		<?php 
		for ($j = 2; $j < $nCol; $j++)
        {
        	?>
  			<option value="<?php echo ($j);?>"><?php echo $m_CatMtx[1][$j]?></option>  			
  			<?php     			
        }
        echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        
		echo "<b>No. of groups to be categorized in criteria basis: </b>";
		echo '<select name="no_of_groups[]" ';
		?>
		<option value="">Select</option>
		<?php 
		for ($k = 1; $k <= 5; $k++)
        {
        	?>
  			<option value="<?php echo $k?>"><?php echo $k?></option>  			
  			<?php     			
        }
       echo '</select></td></tr>';
  		

  		
}
?>
<br><br><br>

<input type="hidden" name="CatFile" size="50" value="<?=$m_CatAnalysis?>"> 
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
<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>
<td align="left"><input type="Reset" class=button value="Reset"></td>
</tr>
</table> 
<br><br>
<a href="CatAnalysisMod2.php?Exp=17&CatFile=<?php echo $m_CatAnalysis?>"><H2><input type ="button" value="Back"></H2></a>
<br>
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  

