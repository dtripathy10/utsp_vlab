<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"System Optimal Assignment","Trip Assignment");
// Retrieving the values of variables

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment12/";

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}


$file = fopen($folder."SystemOptModReport.xls", "a+");   
fclose($file);

$file1 = fopen($folder."NodeFile.xls", "w");
$url = "../Docs/link.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."NodeFile.xls");

$m_NodeFile = "NodeFile.xls";

$file2 = fopen($folder."ODFile.xls", "w");
$url = "../Docs/OD.xls"; 
//$m_TripFile = basename($url);
copy($url,$folder."ODFile.xls");

$m_OdFile = "ODFile.xls";

move_uploaded_file($_FILES["NodeFile"]["tmp_name"],$folder . $_FILES["NodeFile"]["name"]);
move_uploaded_file($_FILES["OdFile"]["tmp_name"],$folder . $_FILES["OdFile"]["name"]);
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
	if(document.Frm.ConCriteria.value == "")
	{
    	alert ("Select Convergence Criteria !!");
    	document.Frm.ConCriteria.focus();
    	return false ;
	}   
	document.Frm.action="SystemOptModRes.php?Exp=10";	
}

</script>
</head>
<div id="body">
<center> 
<div id ="link">

<?php

// reading Xls file


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
			for ($j = 1; $j <= $Col; $j++)
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
		

echo "<button class = 'btn1'> Next </button>";
echo "</div>";
// reading XLS file
echo "<div id ='OD'>";
     
	// OD File
	
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($folder.$m_OdFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nnodes = $dataTripF->sheets[0]['numRows']-1 ;
        $m_Column = $dataTripF->sheets[0]['numCols'] ;
        
   		echo '<div id="scroller"><caption><B>Origin Destination matrix</B></caption><table class="table table-bordered table-hover">';      
		for ($i = 1; $i <= $m_nnodes+1; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <$m_Column ; $j++)
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
		
?>

		<td align="left"><button class = "btn2"> Previous </button></td>
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

<button class = 'btn2'> Previous </button>
<span class="tab"></span>
<input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()">
		
		<table cellspacing=5 width = "40%" align="center" border=0>
		<tr>
   			<td align="center">&nbsp;&nbsp;<a href="SystemOptModDel.php?Exp=10&NodeFile=<?=$m_NodeFile?>&OdFile=<?=$m_OdFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
		</tr>
		</table>
		<br>
		
</form>
</div>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  