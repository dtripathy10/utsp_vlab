<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"System Optimal Assignment","Trip Assignment");
// Retrieving the values of variables

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment12/";
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}
$file = fopen($folder."SystemOptModReport.xls", "a+");   
fclose($file);



$m_NodeFile = $_FILES['NodeFile']['name'];
$m_OdFile = $_FILES['OdFile']['name'];

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
    	location="SystemOptMod.php?Exp=10";
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
<script type="text/javascript">


		$(document).ready(function(){
		$("#OD").hide();
		$("#Inputs").hide();
		$(".btn1").click(function(){
		    $("#link").slideUp("slow");
		    $("#OD").slideDown("slow");
		    
	  });
		$(".btn2").click(function(){
		    $("#OD").slideUp("slow");
		    $("#link").slideDown("slow");
		    
	  });
		$(".btn3").click(function(){
		    $("#OD").slideUp("slow");
		    $("#Inputs").slideDown("slow");
		    
	  });
	  
		$(".btn4").click(function(){
		   	$("#Inputs").slideUp("slow");
		    $("#OD").slideDown("slow");
		    
	  });
  
		  
	});
	</script> 

<script language="javascript">
function chk1()
{ 
	document.Frm.action="SystemOptModRes.php?Exp=10";	
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
    
        echo '<caption><b> Link Flow Characteristics </b></caption>';
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
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
    
    echo '<caption><b> Link Flow Characteristics </b></caption>';
    echo '<div id="scroller"><table class="table table-bordered table-hover">';
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
        
       	echo '<caption><b> Origin Destination matrix </b></caption>';
    	echo '<div id="scroller"><table class="table table-bordered table-hover">';    
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
       	echo '<caption><b> Origin Destination matrix </b></caption>';
    	echo '<div id="scroller"><table class="table table-bordered table-hover">';        
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

		<td align="left"><button class = "btn2"> Back </button></td>
		<td align="left"><button class = "btn3"> Next </button></td>
		</div>     

    

<div id ='Inputs'>
<form enctype="multipart/form-data" method="post" name="Frm" >


<input type="hidden" name="NodeFile" value="<?=$m_NodeFile?>"> 
<input type="hidden" name="OdFile" value="<?=$m_OdFile?>"> 
<table class="table table-bordered table-hover">

<tr align="center">
	<th align="center"  > Select Convergence Criteria : </th>
	<td align="left">
	<select name="ConCriteria">
        <option value="" >Select</option>
        <option value="Alpha" >Alpha</option>
        <option value="TravelTime" >Travel Time</option>
        <option value="FlowOnLink">Flow On Link</option>       
    </select>   
	</td>
	</tr><tr>
	<th  align="left" > Enter the &alpha; value </th>
	<td align="left">
	<input type="text" name="alphaValue" >
	</td>
	</tr><tr>
	<th  align="left" > Enter the &beta; value </th>
	<td align="left">
	<input type="text" name="betaValue" >
	</td>
</tr>	

</table>
<br>

<br><br><br>		

<button class = 'btn2'> Back </button>
<span class="tab"></span>
<input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()">
		<table cellspacing=5 width = "40%" align="center" border=0>
		<tr>
   			<td align="center">&nbsp;&nbsp;<a href="SystemOptModDel.php?Exp=10&NodeFile=<?=$m_NodeFile?>&OdFile=<?=$m_OdFile?>"><H3><input type="Button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
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