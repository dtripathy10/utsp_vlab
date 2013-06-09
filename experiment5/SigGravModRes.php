<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4);
?> 

<?php
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment5/";


$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_FILES['CostFile']['name'];
$m_OriginFile = $_FILES['OriginFile']['name'];
$m_DestFile = $_FILES['DestFile']['name'];


$m_CostFile = $_POST['CostFile'];
$m_OriginFile = $_POST['OriginFile'];
$m_DestFile = $_POST['DestFile'];
if(empty($_POST['submit']))
{
	$m_CostFile = $_POST['CostFile'];
	$m_OriginFile = $_POST['OriginFile'];
	$m_DestFile = $_POST['DestFile'];
}


//---------------------------------- verifying the format of the file ---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="SigGravMod.php?Exp=3";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------


//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$folder. $_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder. $_FILES["OriginFile"]["name"]);
move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder. $_FILES["DestFile"]["name"]);

?>
<style type="text/css">

#scroller {
    width:800px;
    height:300px;
    overflow:auto;   
 }
 
 .title1 
		{
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: x-normal;
			color: #00529C;			
			font-weight : bold;
			text-align: center;			
		}
		.lable1
		{ 
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: xx-small;
			color: #00529C;
			background-color: #ECECEC;
			font-weight : bold;
		}
</style>
<script language="javaScript" src="js/exp_col.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("#calculation").show();
	$("#Final").hide();


	$(".btn7").click(function(){
		
		$("#calculation").slideUp("slow");
		$("#Final").slideDown("slow");
 
	    
  	});
	$(".btn8").click(function(){
		
		$("#Final").slideUp("slow");
		$("#calculation").slideDown("slow");
 
	    
  	});

	  
});
</script>


<script language="javascript">
function chk1()
{ 
	document.Frm.action="intermediateSigGravMod.php?Exp=3";	
}

</script>

</head>
<div id="body">
<center>      

<?php


//------------------------------- Reading Xls file ----------------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{
	// Cost File

	require_once EXCELREADER.'/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	//$n=$dataBaseF->sheets[0]['numRows'];
	$n = $dataBaseF->sheets[0]['numRows'];
	$nCol = $dataBaseF->sheets[0]['numCols'];
	
	$CostRow = $dataBaseF->sheets[0]['numRows'];
	$CostCol = $dataBaseF->sheets[0]['numCols'];
	if($CostRow != $CostCol)
	{
		?>
		<script lanuguage = javascript> 
 			// check for square matrix
			alert("The Base Year O-D Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
			location = "SigGravMod.php?Exp=3";			
		</script>
		<?php 		
	}

	for ($i = 1; $i <= $n; $i++)
	{
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
       		$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
    		
       		// check for number
       		if(!is_numeric($m_BaseMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 
			 			alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "SigGravMod.php?Exp=3";
					</script>
				<?php 
			}         
    	}
	}
	
	
		// Origin File
               
        $dataOriginF = new Spreadsheet_Excel_Reader();
        $dataOriginF->setOutputEncoding('CP1251');
        //$dataOriginF->read('base_matrix.xls');
        $dataOriginF->read($folder.$m_OriginFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $OriginRow = $dataOriginF->sheets[0]['numRows'];
        $OriginCol = $dataOriginF->sheets[0]['numCols'];
        
		if( !($OriginCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
	   				// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="SigGravMod.php?Exp=3";
	    		</script>
	    	<?php
		} 

        for ($i = 1; $i <= $OriginRow; $i++)
        {        
 
            for ($j = 1; $j <= $nCol; $j++)
            {
 
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                
                // check for number
                if(!is_numeric($m_OriginMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 			
						alert("Enter Only Numeric Values in Future Year Origin Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "SigGravMod.php?Exp=3";			
					</script>
					<?php 
				}
               }                 
        }
        // Destination File 
       
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        //$dataDestF->read('base_matrix.xls');
        $dataDestF->read($folder.$m_DestFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        
        $DestRow = $dataDestF->sheets[0]['numRows'];
        $DestCol = $dataDestF->sheets[0]['numCols'];
        
		if( !($DestCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
	   				// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    		    location="SigGravMod.php?Exp=3";
	    		</script>
	    	<?php
		}
      
        $m_TotalSum=0;
        for ($i = 1; $i <= $DestRow; $i++)
        {
            for ($j = 1; $j <= $nCol; $j++)
           {
                $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                
                // check for number
                if(!is_numeric($m_DestMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 			
						alert("Enter Only Numeric Values in Future Year Destination Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "SigGravMod.php?Exp=3";			
					</script>
					<?php 
				}
                $m_TotalSum += $m_DestMtx[$i][$j];
            }
        }
}
//---------------------------------------------------------------------------------


//----------------------------- Reading csv file --------------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
{
	// Cost File
	
    $nCol=0; 
	$n = 0;
	$name = $folder.$m_CostFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Base[$n][$c] = $data[$c];
        	
     	}
     	$n++;
    
    }
    for ($i = 0; $i < $n; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_BaseMtx[$i+1][$j+1] = $m_Base[$i][$j] ;      	
         }    	
    }
    
	$CostRow = $n;
	$CostCol = $nCol;

	if($CostRow != $CostCol)
	{
		?>
		<script lanuguage = javascript> 
			// check for square matrix
			alert("The Base Year O-D Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
			location = "SigGravMod.php?Exp=3";
		</script>
		<?php 		
	}

	for ($i = 1; $i <= $n; $i++)
	{
    	for ($j = 1; $j <= $nCol; $j++)
    	{       
        	
        	// check for number
    		if(!is_numeric($m_BaseMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "SigGravMod.php?Exp=3";			
					</script>
				<?php 
			}          
    	}
	}
		// Origin File
		
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
		$OriginRow = $OriRow;
		$OriginCol = $nCol;
		if( !($OriginCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
			   		// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    			location="SigGravMod.php?Exp=3";
	    		</script>
	   		<?php
		}
        for ($i = 1; $i <= $OriRow; $i++)
        {        
            for ($j = 1; $j <= $nCol; $j++)
            {
                
                // check for number
                if(!is_numeric($m_OriginMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Future Year Origin Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "SigGravMod.php?Exp=3";			
					</script>
					<?php 
				}
               }           
        }
        // Destination File 
       
        
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
       
        $DestCol = $nCol;
		if( !($DestCol == $CostCol))
		{
	   		?>
	   			<script lanuguage = javascript>
	   				// check for square matrix
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="SigGravMod.php?Exp=3";
	    		</script>
	    	<?php
		}
        $m_TotalSum=0;
        for ($i = 1; $i <= $DestRow; $i++)
        {
            for ($j = 1; $j <= $nCol; $j++)
            {
                   	
                   	// check for number
              		if(!is_numeric($m_DestMtx[$i][$j]))
					{
					?>
			 			<script lanuguage = javascript> 
			 				alert("Enter Only Numeric Values in Future Year Destination Total File !! \n Error at [<?=$i?>,<?=$j?>]")
							location = "SigGravMod.php?Exp=3";
						</script>
					<?php 
					}   
                	$m_TotalSum += $m_DestMtx[$i][$j];
                 	 
            }
        }
//-----------------------------------------------------------------------------

}
else
{
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'SigGravMod.php?Exp=3';
			</script>
			<?php  
}
        
?>

<div id ='calculation'>

<?php   
		       
    if($m_FunctionsVal == "PowerFun")
    {
    	// Calculation for Power Function	      
    	
         $m_txtBeta = $_POST['txtBeta'];
       	 echo '<caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
         echo '<div id="scroller"><table class="table table-bordered table-hover">';
         echo '<tr align="center" >';
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }           
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td ><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {                
                    echo "<td >";
                    $ImpCost[$i][$j] = pow($m_BaseMtx[$i][$j],$m_txtBeta);
                    echo round($ImpCost[$i][$j],4)."</td>";            
                }
                echo "</tr>";
            }            
            
            echo "</table></div><br>";
       
    }    
    elseif($m_FunctionsVal == "ExponentialFun")
    {
    	// Calculation for Exponential Function	      
    	
       		$m_txtBeta = $_POST['txtBeta'];
 
            echo '<caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
       		echo "<tr align='center' >";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }           
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td ><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {                
                    echo "<td >";
                    $ImpCost[$i][$j] = exp(-(($m_txtBeta)*($m_BaseMtx[$i][$j])));
                    echo round($ImpCost[$i][$j],4)."</td>";            
                }
                echo "</tr>";
            }            
            
        echo "</table></div><br>";       
         
    }    
    elseif($m_FunctionsVal == "GammaFun")
    {
    	// Calculation for Gamma Function	
    	
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        echo '<caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr align='center' >";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }           
            echo '</tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td ><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {
                    echo "<td >";
                    $ImpCost[$i][$j] = ((exp(-($m_txtBeta1)*($m_BaseMtx[$i][$j]))) * (pow($m_BaseMtx[$i][$j],-($m_txtBeta2))));
                    echo round($ImpCost[$i][$j],4)."</td>";            
                }
                echo "</tr>";
            }            
            
        echo "</table></div><br>";    
      
    }
    elseif($m_FunctionsVal == "LinearFun")
    {
    	// Calculation for Linear Function	
    
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        
        echo '<caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr align='center'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }           
            echo '</tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td ><b>".$i."</b></td>";
                for ($j = 1; $j <= $n; $j++)
                {                
                    echo "<td >";
                    $ImpCost[$i][$j] = ($m_txtBeta1 + ($m_txtBeta2 * $m_BaseMtx[$i][$j]));
                    echo round($ImpCost[$i][$j],4)."</td>";            
                }
                echo "</tr>";
            }            
            
            echo "</table></div><br>";
    }
?>

<?php        
        if($m_MethodVal == "SinglyOrigin")
        {         
        	// Calculation for Singly Constrained Gravity Model (Origin) 
        	echo '<caption><b> [D<sub>j</sub>][F<sub>ij</sub>] </b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
            echo "<tr align='center'>";
            echo'<td  ><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo "<td ><b>".$i."</b></td>";
            }           
            echo '<td ><b>&#8721;[D<sub>j</sub>][F<sub>ij</sub>]</b></td></tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td ><b>".$i."</b></td>";
                $sumR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $DF[$i][$j] = $m_DestMtx[1][$j] * $ImpCost[$i][$j];         
                    $sumR[$i] += $DF[$i][$j];  
                    echo "<td >".round($DF[$i][$j],4)."</td>";
                }     
                echo "<td ><b>".round($sumR[$i],4)."</b></td>";  
                echo "</tr>";
            }
            
            echo "</table></div><br>";   
            echo '<caption><b> Interaction Probabilities [Pr<sub>ij</sub>]</b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
            echo "<tr align='center'  >";
            echo'<td><B>Zone</B></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><B>'.$i.'</B></td>';
            }           
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  ><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $PR[$i][$j] = $DF[$i][$j] / $sumR[$i];   

                    echo "<td >".round($PR[$i][$j],4)."</td>";
                }             
                echo "</tr>";
            }
            
            echo "</table></div><br>";   
            
            ?>

            </td>
			</tr>
				</table>
				</td>
				</tr>	
				<tr><td colspan="2">&nbsp;</td>	</tr>
				</table>
				<br>
				<button class="btn7">Next</button>

            <?php 
        	echo '<div id="Final"><center>';
            echo '<h2>Final Result</h2><br>';
            echo '<caption><b>  O-D Matrix [T<sub>ij</sub>]</b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
            echo "<tr align='center'>";
            echo'<td  ><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td  ><b>'.$i.'</b></td>';
            }           
            echo '<td ><b>&#8721;[D<sub>j</sub>][F<sub>ij</sub>]</b></td><td  width="20%"><b>Future year Origins Total</b></td></tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  ><B>".$i."</B></td>";
                $sumTR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $T[$i][$j] = $m_OriginMtx[1][$i] * $PR[$i][$j];      
                    $sumTR[$i] += $T[$i][$j];                 
                    echo "<td >".round($T[$i][$j],4)."</td>";
                }    
                echo "<td ><b>".$sumTR[$i]."</b></td>"; 
                echo "<td ><b>".$m_OriginMtx[1][$i]."</b></td>";          
                echo "</tr>";
            }
        
           /* echo "<tr align='center'>";
            echo "<td ><b>&#8721;[O<sub>i</sub>][F<sub>ij</sub>]</b></td>";   
            for ($j = 1; $j <= $n; $j++)
            {
                $sumTC[$j]=0;   
                for ($i = 1; $i <= $n; $i++)
                {
                    $sumTC[$j] += $T[$i][$j];                  
                   }
                   echo "<td ><b>".round($sumTC[$j],4)."</b></td>";      
            }     
             echo "</tr>";      */    
            echo "</table></div><br>";
            echo '<button class="btn8">Back</button>';
            echo '<div></center>';
        }
        
        elseif($m_MethodVal == "SinglyDest")
        {
        	// Calculation for Singly Constrained Gravity Model (Destination) 
        	
            echo '<caption><b> [O<sub>i</sub>][F<sub>ij</sub>] </b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
            echo "<tr align='center'>";
            echo'<td  ><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo "<td ><b>".$i."</b></td>";
            }

            echo '</tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td ><b>".$i."</b></td>";
                for ($j = 1; $j <= $n; $j++)
                {             
                    $OF[$i][$j] = $m_OriginMtx[1][$i] * $ImpCost[$i][$j];   
                    echo "<td >".round($OF[$i][$j],4)."</td>";
                }                     
                echo "</tr>";
            }
            echo '<tr align="center" >';
            echo '<td><b>&#8721;[O<sub>i</sub>][F<sub>ij</sub>]</b></td>';
            for ($j = 1; $j <= $n; $j++)
            {                 
                $sumC[$j]=0;
                for ($i = 1; $i <= $n; $i++)
                {   
                    $sumC[$j] += $OF[$i][$j];                      
                }     
                echo "<td><B>".round($sumC[$j],4)."</<B></td>";                  
            }
            echo "</tr>";
            
            echo "</table></div><br>";       
   
            echo '<caption><b>Interaction Probabilities [Pr<sub>ij</sub>]</b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
            echo "<tr align='center'  >";
            echo'<td><B>Zone</B></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><B>'.$i.'</B></td>';
            }           
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  ><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $PR[$i][$j] = $OF[$j][$i] / $sumC[$i];               
                    echo "<td >".round($PR[$i][$j],4)."</td>";     
                }                     
                echo "</tr>";
            }
            
            echo "</table></div><br>";   
            
            ?>
            

				<br><br>
				<button class="btn6">Back</button>
				<button class="btn7">Next</button>
				</div>
            <?php 
        
            echo '<div id="Final"><center>';
            echo '<h2>Final Result</h2><br>';
            echo '<caption><b> O-D Matrix [T<sub>ij</sub>] </b></caption>';
         	echo '<div id="scroller"><table class="table table-bordered table-hover">';
            echo "<tr align='center'>";
            echo'<td  ><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td  ><b>'.$i.'</b></td>';
            }           
           echo "</tr>";
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td  ><B>".$i."</B></td>";                
                for ($j = 1; $j <= $n; $j++)
                {     
                    $T[$i][$j] = $m_DestMtx[1][$i] * $PR[$i][$j];                                      
                    echo "<td >".round($T[$i][$j],4)."</td>";
                }                      
                echo "</tr>";
            }
        
            echo "<tr align='center'><td ><b>&#8721;[O<sub>i</sub>][F<sub>ij</sub>]</b></td>";    
            for ($j = 1; $j <= $n; $j++)
            {
                    $sumTC[$j]=0;   
                for ($i = 1; $i <= $n; $i++)
                {
                    $sumTC[$j] += $T[$j][$i];                  
                   }
                   echo "<td ><B>".round($sumTC[$j],4)."</B></td>";      
            }     
            echo "</tr>";     

            echo "<tr align='center'><td  width='35%'><b>Future year Destinations Total</b></td>";    
           	for ($i = 1; $i <= $n; $i++)
           	{
           		echo "<td ><B>".$m_DestMtx[1][$i]."</B></td>";      
            }     
            echo "</tr>";             
            echo "</table></div><br>";
            echo '<button class="btn8">Back</button>';
            echo '<div></center>';

        }

 
?>

</div>
<form enctype="multipart/form-data" method="post" name="Frm" action="SigGravModRes.php?Exp=3">
        
        <table cellspacing=5>
                	        
        	<input type="hidden" name="FunctionsVal" value="<?=$m_FunctionsVal?>">        	
        	<input type="hidden" name="MethodVal" value="<?=$m_MethodVal?>">
        	
        	<input type="hidden" name="txtBeta" value="<?=$m_txtBeta?>">
        	<input type="hidden" name="txtBeta1" value="<?=$m_txtBeta1?>">
        	<input type="hidden" name="txtBeta2" value="<?=$m_txtBeta2?>">        	
        
        	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="OriginFile" value="<?=$m_OriginFile?>"> 
        	<input type="hidden" name="DestFile" value="<?=$m_DestFile?>"> 
        	
        	
    	
        	
			<tr><td align="center" colspan=2>
<!--				<input type="submit" class=button value="Generate XLS Report" name="genrepo" OnClick="return chk1()">-->
			</td>
			<td align="center" colspan=2>
<!--				<input type="submit" class=button value="Generate PDF Report" name="genrepo" OnClick="return chk2()">-->
			</td></tr>		
		</table>
<table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk1()">
</td></tr>
</table>    
		
</form>

<br><br><br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>

<!--  <td align="center">&nbsp;&nbsp;<a href="SigGravMod.php"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td> -->

<td align="center">&nbsp;&nbsp;<a href="SigGravModDel.php?Exp=3&CostFile=<?=$m_CostFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type="button" value ="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>     
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
