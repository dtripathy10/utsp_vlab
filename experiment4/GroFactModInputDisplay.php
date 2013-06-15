<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Growth Factor Distribution Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment4/";
if(!is_dir($folder))
{
	mkdir($folder, 0777);
}
if(empty($_POST['Submit']))
{
$m_txtGrowth = $_POST['txtGrowth'];
$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];

}
$m_MethodVal = $_POST['MethodVal'];
$m_ConstraintsVal = $_POST['ConstraintsVal'];
$m_BaseFile = $_FILES['BaseFile']['name'];  //To Read file name uploaded in the folder present in the server
$m_OriginFile = $_FILES['OriginFile']['name'];
$m_DestFile = $_FILES['DestFile']['name'];
$m_txtGrowth = $_POST['txtGrowth'];

//----------------------------------verifying the format of the file---------------------------


$file_ext1= substr($m_BaseFile, strripos($m_BaseFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------


move_uploaded_file($_FILES["BaseFile"]["tmp_name"],$folder . $_FILES["BaseFile"]["name"]);  //to upload file in the folder name present in the server


?>


<script type="text/javascript">


		$(document).ready(function(){
		$("#GF").hide();
		$("#UGF").hide();
		$("#Total").hide();
		$("#submit1").show();


	    	<?php
	    	
	    		if($m_MethodVal == "SinglyGFM")
	    	    {
					
   	    	?>
   	    				$("#submit1").hide();
   						$(".btn1").click(function(){
   		    				$("#base").slideUp("slow");
	    					$("#Total").slideDown("slow");
	    					$("#submit1").slideDown("slow");
   						});
			<?php
 	    	   	}
	    		elseif($m_MethodVal == "FratarGFM")
	    		{	

	    			?>
	    			$("#OriTot").hide();
	    			$("#DestTot").hide();
	    			$("#insert").hide();
	    			$("#submit1").hide();
						$(".btn1").click(function(){
   		    				$("#base").slideUp("slow");
	    					$("#OriTot").slideDown("slow");
   						});
	    			<?php 

	    		}
	    	?>


	 $(".btn9").click(function(){
	    $("#submit1").hide();
	    $("#Total").slideUp("slow");
	    $("#base").slideDown("slow");
	    	    
	});   	
	$(".btn10").click(function(){
		$("#submit1").hide();
	    $("#Total").slideUp("slow");
	    $("#base").slideDown("slow");
	    
   });

	$(".btn15").click(function(){
		$("#submit1").hide();
	    $("#OriTot").slideUp("slow");
	    $("#base").slideDown("slow");
	    
  });
	$(".btn16").click(function(){
		$("#submit1").hide();
	    $("#OriTot").slideUp("slow");
	    $("#DestTot").slideDown("slow");
	    
  });
	$(".btn17").click(function(){
		$("#submit1").hide();
	    $("#DestTot").slideUp("slow");
	    $("#OriTot").slideDown("slow");
	    
  });
	$(".btn18").click(function(){
		$("#submit1").show();
	    $("#DestTot").slideUp("slow");
	    $("#insert").slideDown("slow");
	    
  });
	$(".btn19").click(function(){
		$("#submit1").show();
	    $("#insert").slideUp("slow");
	    $("#DestTot").slideDown("slow");
	    
  });


	  
	  
});
</script>	





<script language="javascript">
function chk1()
{ 
	 
    
    if(document.Frm.MethodVal.value == "UniformGFM")
    {
        if(document.Frm.txtGrowth.value == "")
        {
            alert ("Enter Growth Factor Value !!");
            document.Frm.txtGrowth.focus();
            return false ;
        }
        if(isNaN(document.Frm.txtGrowth.value))
		{
			alert ("Enter Numeric Value Growth Factor !!");
			document.Frm.txtGrowth.focus();
			return false ;
		}
    }
    else if(document.Frm.MethodVal.value == "FratarGFM")
    {
        if(document.Frm.AccuracyVal.value == "")
        {
            alert ("Select Accuracy !!");
            document.Frm.AccuracyVal.focus();
            return false ;
        }
        if(document.Frm.txtAccuracy.value == "")
        {
            alert ("Enter Accuracy Level Value !!");
            document.Frm.txtAccuracy.focus();
            return false ;
        }
        if(isNaN(document.Frm.txtAccuracy.value))
		{
			alert ("Enter Numeric Value For Accuracy Level !!");
			document.Frm.txtAccuracy.focus();
			return false ;
		}
    
    }

	document.Frm.action="GroFactModRes.php";
	
}

</script>

</head>

<div id="body">  
<center>


<div id="base">


<?php
//-------------------------------Reading Xls file-------------------------------------------------

if($file_ext1 == '.xls')
{
	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_BaseFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$nRow=$dataBaseF->sheets[0]['numRows'];
	$nCol=$dataBaseF->sheets[0]['numCols'];
	$BaseRow = $nRow;
	$BaseCol = $nCol;
	
	if( !($BaseRow==$BaseCol))
	{
	    ?>
	    <script lanuguage = javascript>
	    alert("The base year marix must be a square matrix i.e.,the number of rows must be equal to number of column");
	    location="GroFactMod.php";
	    </script>
	    <?php
	}

	?>
	<caption><B>O-D Matrix For Base Year</B></caption>
	<div id="scroller">
	<table class="table table-bordered table-hover">
	<?php
	echo'<tr align="center"><td ><B>Zone</B></td>';
	for ($i = 1; $i <= $nRow; $i++)
	{
    	   echo "<td ><B>".$i."</B></td>";
	}
	echo "<td ><B>Origin Total</B></td>";
	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	echo '<tr align="center"><td ><B>'.$i.'</B></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	echo '<td >';        
        	$sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	
        	//To check whether the entries are numeric in the base file 
        	if(!is_numeric($m_BaseMtx[$i][$j]))
			{
			?>
			 <script lanuguage = javascript> 
			 
					alert("Enter Only Numeric Values in Base year OD file!! \n Error at [<?php echo $i?>,<?php echo $j?>]")
					location = "GroFactMod.php";
			
			</script>
			<?php 
			}
        	echo $m_BaseMtx[$i][$j];     
        	echo "</td>";            
    	}
    	echo '<td ><B>';
    	echo $sumR[$i];
    	echo "</B></td></tr>";   
	}
	?>

	<tr align="center" >
	<td><B>Destination Total</B></td>
	<?php

	for ($j = 1; $j <= $nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];                     
        	}
    ?>
    <td><B>
    <?php
	        echo $sumC[$j];
    ?>
    </B></td>             
    <?php     
    		$m_TotalBaseSum += $sumC[$j];
	} 
	echo "</div>";    
}


//---------------------------------------------------------------------------------
//-----------------------------Reading csv file--------------------------------------------

elseif($file_ext1 == '.csv')
{
    $nCol=0; 
	$nRow = 0;
	$name = $folder.$m_BaseFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Base[$nRow][$c] = $data[$c];
        	
     	}
     	$nRow++;
    
    }
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_BaseMtx[$i+1][$j+1] = $m_Base[$i][$j] ;      	
         }
    	
    }
    
    $BaseRow = $nRow;
	$BaseCol = $nCol;
    
    
	if( !($BaseRow==$BaseCol))
	{
	    ?>
	    <script lanuguage = javascript>
	    alert("The base year marix must be a square matrix  i.e..,the number of rows must be equal to number of column");
	    location="GroFactMod.php";
	    </script>
	    <?php
	}
    ?>
	<caption><B>O-D Matrix For Base Year</B></caption>
	<div id="scroller">
	<table class="table table-bordered table-hover">
	<?php

    echo'<tr align="center"><td ><B>Zone</B></td>';
	for ($i = 1; $i <= $nRow; $i++)
	{
    	   echo "<td ><B>".$i."</B></td>";
	}
	echo "<td ><B>Origin Total</B></td>";
	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	echo '<tr align="center"><td ><B>'.$i.'</B></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	echo '<td >';        
        	$sumR[$i] += (double)$m_BaseMtx[$i][$j]; 
        	$m_BaseMtx[$i][$j]=$m_BaseMtx[$i][$j];
    	    if(!is_numeric($m_BaseMtx[$i][$j]))
			{
			?>
			 <script lanuguage = javascript> 
			 
					alert("Enter Only Numeric Values in Base year OD matrix!! \n Error at [<?php echo $i;?>,<?php echo $j;?>]")
					location = "GroFactMod.php";
			
			</script>
			<?php 
			}
        	echo $m_BaseMtx[$i][$j];     
        	echo "</td>";            
    	}
    	echo '<td ><B>';
    	echo $sumR[$i];
    	echo "</B></td></tr>";   
	}
	?>

	<tr align="center" >
	<td><B>Destination Total</B></td>
	<?php

	for ($j = 1; $j <=$nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$m_BaseMtx[$i][$j];                     
        	}
    ?>
    <td><B>
    <?php
	        echo $sumC[$j];
    ?>
    </B></td>             
    <?php     
    		$m_TotalBaseSum += $sumC[$j];
	} 
	fclose($file);
	 

} 
//-----------------------------------------------------------------------------------

?>
</tr>
</table>
<br><br>

</div>
<?php
if($m_MethodVal == "SinglyGFM" || $m_MethodVal=="FratarGFM" )
{
?>
<button class = 'btn1'> Next </button>
<span class="tab"></span>
<?php 
}
?>
</div>
<br><br>
<?php
 
if($m_MethodVal == "SinglyGFM")
{
    $m_ConstraintsVal = $_POST['ConstraintsVal'];

    if($m_ConstraintsVal=="SinglyOrigin")
    {
    	move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder . $_FILES["OriginFile"]["name"]);
    	
        $m_OriginFile = $_FILES['OriginFile']['name'];
        
                
        
//----------------------------------verifying the format of the file---------------------------



$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));


if(!($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}

//------------------------------------------------Reading xls file-------------------------------------    
if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{ 
       		$dataOriginF = new Spreadsheet_Excel_Reader();
        	$dataOriginF->setOutputEncoding('CP1251');
        	$dataOriginF->read($folder.$m_OriginFile);		//Reading file from server
        	error_reporting(E_ALL ^ E_NOTICE);
        	
   			echo '<div id="Total">';
        	echo '<caption><B>Origins Total For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center"  ><td><B>Zone</B></td>';
        	
        	$OriginCol = $dataOriginF->sheets[0]['numCols'];  //no. of columns 
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	
        	for ($i = 1; $i <= $OriginCol; $i++)
        	{
        	    echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" ><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        	{      
        		    for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
        	    	{
        	        	echo '<td>';
        	        	//echo $dataOriginF->sheets[0]['cells'][$i][$j];
        	        	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];  //reading values into an array
        	    	    if(!is_numeric($m_OriginMtx[$i][$j]))
						{
						?>
			 			<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?php echo $i;?>,<?php echo $j;?>]")
						location = "GroFactMod.php";
			
						</script>
						<?php 
						}
        	        	echo $m_OriginMtx[$i][$j];
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
        	        	echo "</td>";
               		}               
            }
        	echo "</tr></table></div><br> ";

       
}
//------------------------------------------------Reading csv file-----------------------------------
    elseif($file_ext1 == '.csv' && $file_ext2 == '.csv')
{

        
    		$nCol = 0; 
			$OriRow = 0;
			$name = $folder.$m_OriginFile;		//assigning name of the file uploaded in the server
   			$file = fopen($name , "r");
   			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    		{
    			$nCol = count($data);

    			for ($c=0; $c <$nCol; $c++)
    			{
    	   
        			$m_Origin[$OriRow][$c] = $data[$c];
        	
     			}
     			$OriRow++;
    
    		}
    		for ($i = 0; $i < $OriRow; $i++) 
    		{ 
        		for ($j = 0; $j < $nCol; $j++)
         		{
         			$m_OriginMtx[$i+1][$j+1] = $m_Origin[$i][$j] ;      	
         		}
    	
   			}
   			
   			$OriginCol = $nCol;
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	echo '<div id="Total">';
            echo '<caption><B>Origins Total For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center"  ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        	    echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" ><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	echo '<td>';
        	    	    if(!is_numeric($m_OriginMtx[$i][$j]))
						{
						?>
			 			<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?php echo $i;?>,<?php echo $j;?>]")
						location = "GroFactMod.php";
			
						</script>
						<?php 
						}
        	        	echo $m_OriginMtx[$i][$j];
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
        	        	echo "</td>";
               		}               
            }
        	echo "</tr></table></div><br> ";
//---------------------------------------------------------------------------------------   
          
}
else 
{
    
	?>
	
	<script language= 'javascript'>
		alert("All input files must be in the same format i.e..either .xls or .csv ");
		location = 'GroFactMod.php';
	</script>
	<?php  
}
			
 }

elseif ($m_ConstraintsVal=="SinglyDest")
    {
    	move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder . $_FILES["DestFile"]["name"]);   //uploading or moving file to server
    	
        $m_DestFile = $_FILES['DestFile']['name'];
        
//----------------------------------verifying the format of the file---------------------------


$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------        
//------------------------------------------------Reading xls file-------------------------------------       
if($file_ext1 == '.xls' && $file_ext3 == '.xls')
{ 
       
        	$dataDestF = new Spreadsheet_Excel_Reader();
        	$dataDestF->setOutputEncoding('CP1251');
        	//$dataDestF->read('base_matrix.xls');
        	$dataDestF->read($folder.$m_DestFile);
        	error_reporting(E_ALL ^ E_NOTICE);

        	$DestinationCol = $dataDestF->sheets[0]['numCols'];
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    			location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	
			//showing destination totals for future year
			echo '<div id="Total">';
        	echo '<caption><B>Destinations Total For Future Year </B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center" ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $dataDestF->sheets[0]['numCols']; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        	{
            	echo '<tr align="center" ><td>&nbsp</td>';
            	for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               	{
                	echo "<td>";   
                	$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?php echo $i;?>,<?php echo $j;?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	echo "</td>";   
            	}
           		echo "</tr>";  
        	}
        	echo "</table></div><br> ";
        	
		}
//------------------------------------------------Reading CSV file-------------------------------------       
         elseif($file_ext1=='.csv' && $file_ext3 == '.csv')
		{ 
		
			$nCol = 0; 
			$DestRow = 0;
			$name = $folder.$m_DestFile;
   			$file = fopen($name , "r");
   			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    		{
    			$nCol = count($data);

    			for ($c=0; $c <$nCol; $c++)
    			{
    	   
        			$m_Dest[$DestRow][$c] = $data[$c];
        	
     			}
     			$DestRow++;
    
    		}
    		for ($i = 0; $i < $DestRow; $i++) 
    		{ 
        		for ($j = 0; $j < $nCol; $j++)
         		{
         			$m_DestMtx[$i+1][$j+1] = $m_Dest[$i][$j] ;      	
         		}
    	
   			}
   			
		    $DestinationCol = $nCol;
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    			location="GroFactMod.php";
	    		</script>
	    	<?php
			}
		
			echo '<div id="Total">';
			echo '<caption><B>Destinations Total For Future Year </B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center" ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	echo '<tr align="center" ><td>&nbsp</td>';
            	for ($j = 1; $j <= $nCol; $j++)
               	{
                	echo "<td>";   
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?php echo $i;?>,<?php echo $j;?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	echo "</td>";   
            	}
           		echo "</tr>";  
        	}
        	echo "</table></div><br> ";
  
		
		}
		else 
		{
		
		    
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'GroFactMod.php';
			</script>
			<?php  
		
		}
//---------------------------------------------------------------------------------
 
 
    }
   
}

elseif($m_MethodVal == "FratarGFM")
    {

        $m_AccuracyVal = $_POST['AccuracyVal'];
        $m_txtAccuracy = $_POST['txtAccuracy'];      

        move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder . $_FILES["OriginFile"]["name"]);
        move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder . $_FILES["DestFile"]["name"]);
        

//----------------------------------verifying the format of the file---------------------------



$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>
<?php 
}





//----------------------------------------------------------------------------------------------		 
 //------------------------------------------------xls file-------------------------------------       
        if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
		{    
		
			$dataOriginF = new Spreadsheet_Excel_Reader();
        	$dataOriginF->setOutputEncoding('CP1251');
        	$dataOriginF->read($folder.$m_OriginFile); 			//Reading origin file	
        	error_reporting(E_ALL ^ E_NOTICE);
        	
        	
        	
        	$OriginCol = $dataOriginF->sheets[0]['numCols'];
        	$OriginRow = $dataOriginF->sheets[0]['numRows'];
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	echo "<div id ='OriTot'>";
        	echo '<caption><B>Origins Total For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';

        	echo'<tr align="center" ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nRow; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" ><td>&nbsp</td>';    
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriginRow; $i++)
        	{
            
         		for ($j = 1; $j <= $nCol; $j++)
            	{
                	echo "<td>";
                  	//echo $dataOriginF->sheets[0]['cells'][$i][$j];
                	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                	if(!is_numeric($m_OriginMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	echo $m_OriginMtx[$i][$j];
                	$m_TotalSum += $m_OriginMtx[$i][$j];
                	echo "</td>";
               	}

                 
        	}
        	echo "</tr>";
        	echo "</table></div><br><br>";
        	echo "<button class = 'btn15'>Previous</button>";
        	echo '<span class="tab"></span>';
        	echo "<button class = 'btn16'>Next</button>";
    		echo "</div>"; 

        	
       
        	$dataDestF = new Spreadsheet_Excel_Reader();
        	$dataDestF->setOutputEncoding('CP1251');
        	$dataDestF->read($folder.$m_DestFile);			//	Reading Destination file
        	error_reporting(E_ALL ^ E_NOTICE);
        	
        	
        	
			$DestinationCol = $dataDestF->sheets[0]['numCols'];
			$DestinationRow = $dataDestF->sheets[0]['numRows'];
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    			location="GroFactMod.php";
	    		</script>
	    	<?php
			}
			echo "<div id ='DestTot'>";
        	echo '<caption><B>Destinations Total For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';

        	echo'<tr align="center" ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nRow; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" ><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestinationRow; $i++)
        	{
            
           		for ($j = 1; $j <= $DestinationCol; $j++)
               	{
                	echo "<td>";   
                	$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	echo "</td>";   
            	}
            	echo "</tr>";  
        	}
        	echo "</table></div><br><br>"; 

        	echo "<button class = 'btn17'>Previous</button>";
        	echo '<span class="tab"></span>';
        	echo "<button class = 'btn18'>Next</button>";
    		echo "</div>";
        	
		
        	
		}

//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
		{


			//	Reading Destination file
			
    		$nCol = 0; 
			$OriRow = 0;
			$name = $folder.$m_OriginFile;
   			$file = fopen($name , "r");
   			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    		{
    			$nCol = count($data);

    			for ($c=0; $c <$nCol; $c++)
    			{
    	   
        			$m_Origin[$OriRow][$c] = $data[$c];
        	
     			}
     			$OriRow++;
    
    		}
    		for ($i = 0; $i < $OriRow; $i++) 
    		{ 
        		for ($j = 0; $j < $nCol; $j++)
         		{
         			$m_OriginMtx[$i+1][$j+1] = $m_Origin[$i][$j] ;      	
         		}
    	
   			}
   			
   			        	
        	$OriginCol = $nCol;
        	
			if( !($OriginCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="GroFactMod.php";
	    		</script>
	    	<?php
			}
        	echo "<div id ='OriTot'>";
            echo '<caption><B>Origins Total For Future Year</B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center"  ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        	    echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        	echo '<tr align="center" ><td>&nbsp</td>';
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	echo '<td>';
        	        	if(!is_numeric($m_OriginMtx[$i][$j]))
						{
						?>
			 			<script lanuguage = javascript> 
			 
							alert("Enter Only Numeric Values in future year origin file !! \n Error at [<?=$i?>,<?=$j?>]")
							location = "GroFactMod.php";
			
						</script>
						<?php 
						}
        	        	echo $m_OriginMtx[$i][$j];
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
        	        	echo "</td>";
               		}               
            }
        	echo "</tr></table></div><br> ";
     		echo "<button class = 'btn15'>Previous</button>";
     		echo '<span class="tab"></span>';
        	echo "<button class = 'btn16'>Next</button>";
    		echo "</div>";
				
        	
        	
        	//	Reading Destination file
        	
        	$nCol = 0; 
			$DestRow = 0;
			$name = $folder.$m_DestFile;
   			$file = fopen($name , "r");
   			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    		{
    			$nCol = count($data);

    			for ($c=0; $c <$nCol; $c++)
    			{
    	   
        			$m_Dest[$DestRow][$c] = $data[$c];
        	
     			}
     			$DestRow++;
    
    		}
    		for ($i = 0; $i < $DestRow; $i++) 
    		{ 
        		for ($j = 0; $j < $nCol; $j++)
         		{
         			$m_DestMtx[$i+1][$j+1] = $m_Dest[$i][$j] ;      	
         		}
    	
   			}
   			
   			
   			$DestinationCol = $nCol;
        	
			if( !($DestinationCol == $BaseCol))
			{
	   			?>
	   			<script lanuguage = javascript>
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix.");
	    			location="GroFactMod.php";
	    		</script>
	    		<?php
			}
		
			echo "<div id ='DestTot'>";
			echo '<caption><B>Destinations Total For Future Year </B></caption><div id="scroller"><table class="table table-bordered table-hover">';
        	echo'<tr align="center" ><td><B>Zone</B></td>';
        	for ($i = 1; $i <= $nCol; $i++)
        	{
            	echo '<td><B>'.$i.'</B></td>';
        	}
        	echo "</tr>";
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
            	echo '<tr align="center" ><td>&nbsp</td>';
            	for ($j = 1; $j <= $nCol; $j++)
               	{
                	echo "<td>";   
               	    if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 		<script lanuguage = javascript> 
			 
						alert("Enter Only Numeric Values in future year destination file !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "GroFactMod.php";
			
					</script>
					<?php 
					}
                	echo $m_DestMtx[$i][$j];
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	echo "</td>";   
            	}
           		echo "</tr>";  
        	}
        	echo "</table></div><br> ";

			echo "<button class = 'btn17'>Previous</button>";
			echo '<span class="tab"></span>';
        	echo "<button class = 'btn18'>Next</button>";
    		echo "</div>";
		
		
		}
		
		else 
		{
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'GroFactMod.php';
			</script>
			<?php  
		
		}
		
//---------------------------------------------------------------------------------

 
    }

?>
<form enctype="multipart/form-data" method="post" name="Frm" action="GroFactModRes.php">
<?php
if($m_MethodVal == "UniformGFM")
{
?>
<table align= "Center">
<tr>
        <th align="left"  width="50%"> Enter Growth Factor : </th>
        <td align="left">
            <input type="Text" name="txtGrowth" size="20" value="<?php $m_txtGrowth ?>">   
        </td>
</tr>
 </table>
 <?php 
}
if($m_MethodVal == "FratarGFM")
{
?>
<div id ="insert">
<table class="table table-bordered table-hover">
<tr>
            <th align="left"  width="30%"> Select Accuracy : </th>
            <td align="left"  width="70%">
            <select name="AccuracyVal">       
                <option value="" >Select</option>
                <option value="Individual" >Individual Cell</option>
                <option value="All">All Cell</option>                       
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="javascript:Popup('AccuracyHelp.php')"><b><u>Click Here To Know</u></b></a>
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
            <th align="left"  width="50%"> Enter Accuracy Level : </th>
            <td align="left">
                <input type="Text" name="txtAccuracy" size="15" value="<?php $m_txtAccuracy ?>"> <b>(&#37;)</b>  
            </td>
        </tr>

</table>
			

<?php 
}
?>

        	<input type="hidden" name="MethodVal" value="<?=$m_MethodVal?>">
        	<input type="hidden" name="ConstraintsVal" value="<?=$m_ConstraintsVal?>"> 
        	<input type="hidden" name="BaseFile" value="<?=$m_BaseFile?>"> 
        	<input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
        	<input type="hidden" name="DestFile" value="<?=$m_DestFile?>">



<div id ="submit1">
<table cellspacing=5 align="center">
<tr>
<td align="left"><input type="submit" class=button value="Submit" name="Submit" OnClick="return chk1()"></td>

</tr>
</table>
<td align="center">&nbsp;&nbsp;<a href="GroFactModDel.php?MethodVal=<?=$m_MethodVal?>&BaseFile=<?=$m_BaseFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</div>
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
