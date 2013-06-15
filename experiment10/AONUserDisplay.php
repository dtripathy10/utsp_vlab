<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"All or Nothing (AON) Assignment","Trip Assignment");

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment10/";

if(!is_dir($folder))
{
	mkdir($folder, 0777);
}
$file = fopen($folder."AONModReport.xls", "a+");   
fclose($file);

$m_NodeFile = $_FILES['NodeFile']['name'];
$m_OdFile = $_FILES['OdFile']['name'];

$_SESSION['ODFile']=$m_OdFile;
$_SESSION['NodeFile']=$m_NodeFile;

if(empty($m_NodeFile))
{
	$m_NodeFile = $_POST['NodeFile'];
}
if(empty($m_OdFile))
{
	$m_OdFile = $_POST['OdFile'];
}

//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_NodeFile, strripos($m_NodeFile, '.'));
$file_ext2= substr($m_OdFile, strripos($m_OdFile, '.'));

if(!($file_ext1 == '.csv'&& $file_ext2 == '.csv'  || $file_ext1 == '.xls' && $file_ext2 == '.xls'))
{
	?>
	<script language="javascript">
	    alert("invalid file format");
    	location="AONMod.php?Exp=8";
    </script>
	<?php 
}
else 
{
//  move uploaded files to user specific folder
 
	move_uploaded_file($_FILES["NodeFile"]["tmp_name"],$folder . $_FILES["NodeFile"]["name"]);
	move_uploaded_file($_FILES["OdFile"]["tmp_name"],$folder . $_FILES["OdFile"]["name"]);
}
//----------------------------------------------------------------------------------------------
?>

<style type="text/css">
	#scroller 
	{
    width:800px;
    height:300px;
    overflow:auto;  
 	} 	
</style>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript">


		$(document).ready(function(){
		$("#OD").hide();
		$("#Final").hide();
		$(".btn1").click(function(){
		    $("#link").slideUp("slow");
		    $("#OD").slideDown("slow");
		    
	  });
		$(".btn2").click(function(){
		    $("#OD").slideUp("slow");
		    $("#link").slideDown("slow");
		    
	  });
		  
	});
	</script>	 

<script language="javascript">
function chk1()
{ 
	document.Frm.action="AONModRes.php?Exp=8";	
}
</script>

</head>
<div id="body">
<center> 
<div id ="link">

<?php

// reading Xls file

if($file_ext1 == '.xls')
{
	// Node File
			
		include '../phpExcelReader/Excel/reader.php';
		$dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($folder.$m_NodeFile);
       
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nlinks = $dataTripF->sheets[0]['numRows']-1 ;
        $Col = $dataTripF->sheets[0]['numCols'];
    
        echo '<div id="scroller"><caption><b> Link Flow Characteristics </b></caption><table class="table table-bordered table-hover">';
        for ($i = 1; $i <= $m_nlinks+1; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';    
			for ($j = 1; $j < $Col; $j++)
            {
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
               
                if($i==1)
                {
                	 echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_TripMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	 echo '<td>';
              		echo $m_TripMtx[$i][$j];
              		echo "</td>";
                }
                              
                   
                
            }               
            echo "</tr>";       
        }
        echo "</table></div><br>";
		
}
elseif($file_ext1 == '.csv')
{	
	// reading CSV file
	
	// Node File
    
	$Col=0; 
	$m_nlinks = 0;
	$name = $folder.$m_NodeFile;
    $file1 = fopen($name , "r");
    while (($data = fgetcsv($file1, 8000, ",")) !== FALSE) 
    {
    	$Col = count($data);

    	for ($c=0; $c <$Col-1; $c++)
    	{
    	  
        	$m_Trip[$m_nlinks][$c] = $data[$c];
        	
     	}
     	$m_nlinks++;
    
    }
    for ($i = 0; $i < $m_nlinks; $i++) 
    { 
         for ($j = 0; $j < $Col-1; $j++)
         {
         		$m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j] ;    
         		
         }
    	
    }
    fclose($file1);
    
    echo '<div id="scroller"><caption><b> Link Flow </b></caption><table class="table table-bordered table-hover">';
    for ($i = 1; $i <= $m_nlinks; $i++)
    {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';    
			for ($j = 1; $j < $Col; $j++)
            {
               
                if($i==1)
                {
                	 echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_TripMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	 echo '<td>';
              		echo $m_TripMtx[$i][$j];
              		echo "</td>";
                }
            }               
            echo "</tr>";       
     }
    echo "</table></div><br>";	
	$m_nlinks--;
}

echo "<button class = 'btn1'> Next </button>";
echo "</div>";
// reading XLS file
echo "<div id ='OD'>";
if($file_ext2 == '.xls')
{	      
	// OD File
	
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($folder.$m_OdFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nnodes = $OdTripF->sheets[0]['numRows'] ;
        
        $Col = $OdTripF->sheets[0]['numCols'];
        
   		echo '<div id="scroller"><caption><B>Origin Destination matrix</B></caption><table class="table table-bordered table-hover">';      
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$Col ; $j++)
            {
                $m_ODMtx[$i][$j]=$OdTripF->sheets[0]['cells'][$i][$j];
                
                if($i==1)
                {
                	 echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	if($j==1)
                	{
                	  echo '<td bgcolor="#B8DBFF">';
                	  echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                	  echo "</td>";
                	}
                	else 
                	{
                	echo "<td>";
              		echo $m_ODMtx[$i][$j];
              		echo "</td>";
                	}                
                }
                
            }               
            echo "</tr>";       
        }
        echo "</table></div><br>";
		
}
elseif($file_ext2 == '.csv')
{
	// reading CSV file
	
	// OD file
	
	$Col=0; 
	$m_nnodes = 0;
	$name = $folder.$m_OdFile;
    $file2 = fopen($name , "r");
    while (($data = fgetcsv($file2, 8000, ",")) !== FALSE) 
    {
    	$Col = count($data);

    	for ($c=0; $c <$Col; $c++)
    	{    	   
        	$m_OD[$m_nnodes][$c] = $data[$c];        	
     	}
     	$m_nnodes++;    
    }
    for ($i = 0; $i < $m_nnodes; $i++) 
    { 
         for ($j = 0; $j < $Col; $j++)
         {
         		$m_ODMtx[$i+1][$j+1] = $m_OD[$i][$j] ;      	
         }    	
    }
    fclose($file2);
    echo '<div id="scroller"><caption><B>Origin Destination matrix</B></caption><table class="table table-bordered table-hover">';      
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$Col ; $j++)
            {
                
                if($i==1)
                {
          			echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	if($j==1)
                	{
                	  echo '<td bgcolor="#B8DBFF">';
                	  echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                	  echo "</td>";
                	}
                	else 
                	{
                	echo "<td>";
              		echo $m_ODMtx[$i][$j];
              		echo "</td>";
                	}                
                }                
            }               
            echo "</tr>";       
        }
        echo "</table></div><br>";
		
		$m_nnodes--;
}

////////////////////////////////////////////////////////////////////////////////

?>        

<form enctype="multipart/form-data" method="post" name="Frm"  action="AONUserDisplay.php?Exp=8">
        
<input type="hidden" name="NodeFile" value="<?php echo $m_NodeFile;?>"> 
<input type="hidden" name="OdFile" value="<?php echo $m_OdFile;?>"> 

	
<button class = 'btn2'> Back </button>
<span class="tab"></span>
<td align="left"><input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()">
		<table cellspacing=5 width = "40%" align="center" border=0>
		<tr>
   			<td align="center">&nbsp;&nbsp;<a href="AONModDel.php?Exp=8&NodeFile=<?php echo $m_NodeFile;?>&OdFile=<?php echo $m_OdFile;?>"><H3><input type="Button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
		</tr>
		</table>
		<br>
		
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
