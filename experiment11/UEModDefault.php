<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"User Equilibrium Assignment","Trip Assignment");
// Retrieving the values of variables

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment11/";

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}



$file = fopen($folder."UEModReport.xls", "a+");   
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

$m_ODFile = "ODFile.xls";

move_uploaded_file($_FILES["NodeFile"]["tmp_name"],$folder . $_FILES["NodeFile"]["name"]);
move_uploaded_file($_FILES["ODFile"]["tmp_name"],$folder . $_FILES["ODFile"]["name"]);
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
	if(document.Frm.alphaValue.value == "")
	{
    	alert ("Enter alpha value !!");
    	document.Frm.alphaValue.focus();
    	return false ;
	}

	if(document.Frm.alphaValue.value <0 || document.Frm.alphaValue.value>1 )
	{
		alert ("Enter the alpha value within the specied range !!");
		document.Frm.alphaValue.focus();
		return false ;
	}

	
	if(document.Frm.betaValue.value == "")
	{
    	alert ("Enter beta value !!");
    	document.Frm.betaValue.focus();
    	return false ;
	}
	document.Frm.action="UEModRes.php?Exp=9";	
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
    
        echo '<div id="scroller"><caption><b> Link Flow Characteristics </b></caption><table class="table table-bordered table-hover">';
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
        $OdTripF->read($folder.$m_ODFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nnodes = $OdTripF->sheets[0]['numRows']-1 ;
		$m_Column = $OdTripF->sheets[0]['numCols']-1 ;
   		echo '<div id="scroller"><caption><B>Origin Destination matrix</B></caption><table class="table table-bordered table-hover">';      
		for ($i = 1; $i <= $m_nnodes+1; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=3 ; $j++)
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
		<button class = "btn2"> Previous </button>
                <span class="tab"></span>
		<button class = "btn3"> Next </button>
	</div>	     
        
<!-- ////////////////////////////////////////////////////////////////////////////////  -->
     



<div id ='Inputs'>
<form enctype="multipart/form-data" method="post" name="Frm" >
      
        
<input type="hidden" name="NodeFile" value="<?=$m_NodeFile?>"> 
<input type="hidden" name="ODFile" value="<?=$m_ODFile?>"> 
<table class="table table-bordered table-hover">

<tr >
	<th  align="left"> Select Convergence Criteria </th>
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
	<input type="text" name="alphaValue" > <b>(Range: 0 &le; &alpha; &le; 1)</b>
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

<button class = 'btn4'> Previous </button>
<span class="tab"></span>
<input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()">
		<table >
		<tr>
   			<td align="center">&nbsp;&nbsp;<a href="UEModDel.php?Exp=9&NodeFile=<?=$m_NodeFile?>&ODFile=<?=$m_ODFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
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
