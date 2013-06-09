<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Doubly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment6/";

$m_FunctionsVal = $_POST['FunctionsVal'];

$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];   

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


if(empty($m_FunctionsVal))
{
	$m_FunctionsVal = $_POST['FunctionsVal'];
}
if(empty($m_AccuracyVal))
{
	$m_AccuracyVal = $_POST['AccuracyVal'];
}
if(empty($m_txtAccuracy))
{
	$m_txtAccuracy = $_POST['txtAccuracy'];
}

//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="DoubGravMod.php?Exp=4";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------


//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$folder. $_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["OriginFile"]["tmp_name"],$folder . $_FILES["OriginFile"]["name"]);
move_uploaded_file($_FILES["DestFile"]["tmp_name"],$folder. $_FILES["DestFile"]["name"]);

?>

<script language="javaScript" src="js/exp_col.js"></script>
<style type="text/css">

#scroller 
{
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

<script language="javascript">
function chk1()
{ 
	document.Frm.action="intermediateDoubGravMod.php?Exp=4";
}
</script>
</head>
<div id="body">
<center> 
<?php

//------------------------------- Reading Xls file ------------------------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{
	// Cost File
	
	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	
	//Number of zons
	$n=$dataBaseF->sheets[0]['numRows'];
	
	$CostRow = $dataBaseF->sheets[0]['numRows'];
	$CostCol = $dataBaseF->sheets[0]['numCols'];
	if($CostRow != $CostCol)
	{
		?>
			 <script lanuguage = javascript>		
				// check for square matrix	 
				alert("The Base Year O-D Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
				location = "DoubGravMod.php?Exp=4";			
			</script>
		<?php 		
	}
	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{      
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
        	
        	// check for number
    		if(!is_numeric($m_BaseMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php?Exp=4";			
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
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="DoubGravMod.php?Exp=4";
	    		</script>
	    	<?php
		}
		$sumorigin=0;
        for ($i = 1; $i <= $OriginRow; $i++)
        {       
        	
            for ($j = 1; $j <= $OriginCol; $j++)
            {
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                
                // check for number
            	if(!is_numeric($m_OriginMtx[$i][$j]))
				{
					?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Future Year Origin Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php?Exp=4";			
					</script>
					<?php 
				}
				 $sumorigin += $m_OriginMtx[$i][$j];
               }  
               
               $err[$i] = 99;          
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
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Destination total matrix");
	    		    location="DoubGravMod.php?Exp=4";
	    		</script>
	    	<?php
		}

       
        $m_TotalSum=0;
        for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        {
            for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               {
                   $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                   
                   // check for number
               		if(!is_numeric($m_DestMtx[$i][$j]))
					{
						?>
			 			<script lanuguage = javascript> 			 
							alert("Enter Only Numeric Values in Future Year Destination Total File !! \n Error at [<?=$i?>,<?=$j?>]")
							location = "DoubGravMod.php?Exp=4";			
						</script>
						<?php 
					}
                   $djk[$j] = $m_DestMtx[$i][$j];               
                   $m_TotalSum += $m_DestMtx[$i][$j];
            }
        }
}
//---------------------------------------------------------------------------------


//----------------------------- Reading csv file -------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' && $file_ext3 == '.csv')
{

	// Cost File
	
    $nCol=0; 
	$n = 0;
	$name =$folder.$m_CostFile;
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
				location = "DoubGravMod.php?Exp=4";			
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
						location = "DoubGravMod.php?Exp=4";			
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
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    			location="DoubGravMod.php?Exp=4";
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
						location = "DoubGravMod.php?Exp=4";
			
					</script>
					<?php 
				}
                echo $m_OriginMtx[$i][$j];
               }   
               $err[$i] = 99;          
        }
       
        // Destination File 
       
        
			$nCol = 0; 
			$DestRow = 0;
			$name = $UploadFile."/Experiment6/".$m_DestFile;
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
	    			alert("The number of column in base year OD matrix must be equal to number of column in future year Origin total matrix");
	    		    location="DoubGravMod.php?Exp=4";
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
			 
						alert("Enter Only Numeric Values in Future Year Origin Total File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "DoubGravMod.php?Exp=4";
			
					</script>
				<?php 
				}
                $djk[$j] = $m_DestMtx[$i][$j];               
                $m_TotalSum += $m_DestMtx[$i][$j];
            }
           
        }
}
else 
{

		?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'DoubGravMod.php?Exp=4';
			</script>
		<?php  
}      
      
        $itrbrk=$_POST['Itrbrk'];
		
		if($_POST['first'])
		{
			$itrbrk=1;
		}
		if(empty($itrbrk))
		{
		    $itrbrk=$_POST['Itrbrk'];
		}
        if($_POST['Previous'])
		{
		    if($itrbrk==1000)
		    {
		        $itrOld=$_POST['Itr'];
		        $itrbrk=$itrOld;
		    }
			$itrbrk=$itrbrk-1;
		}
		elseif($_POST['Next'])
		{
			$itrbrk=$itrbrk+1;
		}
		elseif($_POST['FinalRes'])
		{
			$itrbrk = 1000;			
		}
       ?>
          			<table width=80% cellspacing=5 align="center">

			<tr id="DoubGravImp">
				<td colspan="2" class="title1"  onClick="expCol('DoubGravImp',1)">
					Impedance Matrix Calculations (<u>Click Here</u>)</td>
			</tr>
	
			<tr  id="DoubGravImp1" style="display:none">
				<td colspan="2"><div id="div_key_info" style="display:inline-table">
					<table width="100%"  border="0" cellspacing="1" cellpadding="1">
	 				<tr>
						<td class="label1">
						<br><br>  
       
       <?php 
            
    if($m_FunctionsVal == "PowerFun")
    {
    	// Calculation for Power Function
    	
         $m_txtBeta = $_POST['txtBeta'];
         
    	if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}
        
         echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
         echo '<tr align="center" bgcolor="#CCE6FF">';
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {               
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = round(pow($m_BaseMtx[$i][$j],$m_txtBeta),4);
                    echo $ImpCost[$i][$j]."</td>";           
                }
                echo "</tr>";
            }           
           
            echo "</table></div><br><br>";
        
    }
    elseif($m_FunctionsVal == "ExponentialFun")
    {
    	// Calculation for Exponential Function
    	
       	$m_txtBeta = $_POST['txtBeta'];
        if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}
      
       echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
            echo "<tr align='center' bgcolor='#CCE6FF'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {               
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = exp(-(($m_txtBeta)*($m_BaseMtx[$i][$j])));
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
        echo "</table></div><br><br>";      
    }   
    elseif($m_FunctionsVal == "GammaFun")
    {
    	// Calculation for Gamma Function
    	
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        if(empty($m_txtBeta1))
		{
			$m_txtBeta = $_POST['txtBeta1'];
		}
    	if(empty($m_txtBeta2))
		{
			$m_txtBeta = $_POST['txtBeta2'];
		}
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b>Impedance Matrix Calculations [F<sub>ij</sub>] </b></caption>';
        echo "<tr align='center' bgcolor='#CCE6FF'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><B>".$i."</B></td>";
                for ($j = 1; $j <= $n; $j++)
                {
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = ((exp(-($m_txtBeta1)*($m_BaseMtx[$i][$j]))) * (pow($m_BaseMtx[$i][$j],-($m_txtBeta2))));
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
        echo "</table></div><br><br>";   
       
    }
    elseif($m_FunctionsVal == "LinearFun")
    {
    	// Calculation for Linear Function
    	
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        if(empty($m_txtBeta1))
		{
			$m_txtBeta = $_POST['txtBeta1'];
		}
    	if(empty($m_txtBeta2))
		{
			$m_txtBeta = $_POST['txtBeta2'];
		}
       
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Impedance Matrix Calculations </b></caption>';
        echo "<tr align='center'bgcolor='#CCE6FF'>";
            echo'<td><b>Zone</b></td>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<td><b>'.$i.'</b></td>';
            }          
            echo '</tr>';
               for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><td bgcolor='#CCE6FF'><b>".$i."</b></td>";
                for ($j = 1; $j <= $n; $j++)
                {               
                    echo "<td bgcolor='#EBF5FF'>";
                    $ImpCost[$i][$j] = ($m_txtBeta1 + ($m_txtBeta2 * $m_BaseMtx[$i][$j]));
                    echo round($ImpCost[$i][$j],4)."</td>";           
                }
                echo "</tr>";
            }           
           
            echo "</table></div><br><br>";
           
    }
?>

            				</td>
						</tr>
					</table>
				</td>
				</tr>	
				<tr><td colspan="2">&nbsp;</td>	</tr>
				</table>
				<br><br>

<?php  
$itr = 0;   
$erra=99;
$m_a=0;
for ($i = 1; $i <= $n; $i++)
{
	$Bj[$i]=1;
	$Bjnew[$i]=1;
		$errOri[$i]=99;
		$errDest[$i]=99;

}

 if(!empty($itrbrk))
 {
  do
  {    
     $m_a=0;
     
     if($m_AccuracyVal == "Individual")
     {
   		    // Accuracy Level Individual
   		    
           for ($j = 1; $j <= $n; $j++)
           {             	
               if($errOri[$j] > $m_txtAccuracy || $errDest[$j] > $m_txtAccuracy)
               {
                      $m_a=1; 
                                           
               }      
            
           			$Bj[$j] = $Bjnew[$j];	
                                              
           }          
 
      }
      else if($m_AccuracyVal == "All")
      {
  		    // Accuracy Level All
  		    
           if($erra > $m_txtAccuracy)
           {
                $m_a=1;
                for ($j = 1; $j <= $n; $j++)
           		{ 
                	$Bj[$j] = $Bjnew[$j];
           		}
           }     
      }      
      if($m_a)
      {
        //  echo "iteration no. ".$itr++."<br>";
           $itr++;

           
	        for ($i = 1; $i <= $n; $i++)
            {
                $sumBjDjFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$BjDjFcij[$i][$j] = $Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                	//echo $i."__".$j."___".$BjDjFcij[$i][$j]."<br>";
                    $sumBjDjFcij[$i] += $BjDjFcij[$i][$j]; 
                   
                }   
             //   echo $i."__".$sumBjDjFcij[$i]."<br>";
                $Ai[$i]=1/($sumBjDjFcij[$i]);
               // echo "Ai[".$i."]__".$Ai[$i]."<br>";
            }
            
 
            for ($i = 1; $i <= $n; $i++)
            {
                $sumAiOiFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$AiOiFcij[$i][$j] = $Ai[$j]*$m_OriginMtx[1][$j]*$ImpCost[$i][$j];
                    $sumAiOiFcij[$i] += $AiOiFcij[$i][$j]; 
                   
                }   
                $Bjnew[$i]=1/($sumAiOiFcij[$i]);
            }
           
 
            for ($i = 1; $i <= $n; $i++)
            {
                $sumOi[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$T[$i][$j] = $Ai[$i]*$m_OriginMtx[1][$i]*$Bjnew[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                   
                   
                }   
                
            }

            for ($i = 1; $i <= $n; $i++)
            {
                 $sumOi[$i]=0;
               
                for ($j = 1; $j <= $n; $j++)
                {   
                   $sumOi[$i] +=$T[$i][$j];
                   
                   
                }   
            }
            
            for ($i = 1; $i <= $n; $i++)
            {
                $sumDj[$i]=0;
               
                for ($j = 1; $j <= $n; $j++)
                {   
                   $sumDj[$i] += $T[$j][$i] ;
                   
                }   
            }
            
			
                     
            $erra=0;
            for ($i = 1; $i <= $n; $i++)
            {
              $errOri[$i] = abs((($m_OriginMtx[1][$i] - $sumOi[$i]) * 100) / $m_OriginMtx[1][$i]);
              
             $errDest[$i] = abs((($m_DestMtx[1][$i] - $sumDj[$i]) * 100) / $m_DestMtx[1][$i]);
               $sum = $sumorigin + $m_TotalSum;
               $erra = abs((($m_OriginMtx[1][$i] - $sumOi[$i])+($m_DestMtx[1][$i] - $sumDj[$i])*100)/$sum);                        
            }  
            
                     
        }       
  }while($m_a  && $itr<$itrbrk);


  ///////////////////  31-12-2010

         
        if($itr < $itrbrk)
        {
                echo "<h2>Final Result</h2>";
                echo "<br><br>";
        }
        else
        {
        		echo "<h2>Iteration &nbsp;# ".$itr."</h2>";
                echo "<br><br>";
        }
        

            echo"<table class='table table-bordered table-hover'>";
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo"<th>i</th>
           		<th>j</th>
           		<th>B<sub>j</sub></th>
           		<th>D<sub>j</sub></th>
           		<th>f(C<sub>ij</sub>)</th>
           		<th>B<sub>j</sub>D<sub>j</sub>f(C<sub>ij</sub>)</th>
           		<th>&sum;B<sub>j</sub>D<sub>j</sub>f(C<sub>ij</sub>)</th>
           		<th>A<sub>i</sub> = 1/&sum;B<sub>j</sub>D<sub>j</sub>f(C<sub>ij</sub>)</th>";
            echo "</tr>";
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		echo "<tr>";
            		echo "<td>".$i."</td><td>".$j."<td>".$Bj[$i]."</td><td>".$m_DestMtx[1][$j]."</td><td>".$ImpCost[$i][$j]."</td><td>".$BjDjFcij[$i][$j] ."</td><td>".$sumBjDjFcij[$i]."<td>".$Ai[$i]."</td>";
            		echo "</tr>";
            	}
            	
            }
            echo "</table>";
           echo "<br><br><br><br>";

            echo"<table class='table table-bordered table-hover'>";
            echo "<tr align='center'  bgcolor='#CCE6FF'>";
            echo"<th>j</th>
           		<th>i</th>
           		<th>A<sub>i</sub></th>
           		<th>O<sub>i</sub></th>
           		<th>f(C<sub>ij</sub>)</th>
           		<th>A<sub>i</sub>O<sub>i</sub>f(C<sub>ij</sub>)</th>
           		<th>&sum;A<sub>i</sub>O<sub>i</sub>f(C<sub>ij</sub>)</th>
           		<th>B<sub>j</sub> = 1/&sum;A<sub>i</sub>O<sub>i</sub>f(C<sub>ij</sub>)</th>";
            echo "</tr>";
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		echo "<tr>";
            		echo "<td>".$i."</td><td>".$j."<td>".$Ai[$j]."</td><td>".$m_OriginMtx[1][$j]."</td><td>".$ImpCost[$i][$j]."</td><td>".$AiOiFcij[$i][$j]."</td><td>".$sumAiOiFcij[$i]."<td>".$Bjnew[$i]."</td>";
            		echo "</tr>";
            	}
            	
            }
            echo "</table>";
           echo "<br><br><br><br>";
            

                       
            echo '<table class="table table-bordered table-hover"><caption><b>O-D Matrix [T<sub>ij</sub>] </b></caption>';
            echo "<tr align='center'>";
            echo'<th  bgcolor="#CCE6FF"><b>Zone</b></th>';
            for($i = 1; $i <= $n; $i++)
            {
                 echo '<th  bgcolor="#CCE6FF"><b>'.$i.'</b></th>';
            }          
            echo '<th bgcolor="#B8DBFF"><b>Oi</b></th><th bgcolor="#B8DBFF"><b>New Oi</b></th></tr>';
            for ($i = 1; $i <= $n; $i++)
            {
                echo "<tr align='center'><th  bgcolor='#CCE6FF'><B>".$i."</B></th>";
                for ($j = 1; $j <= $n; $j++)
                {   
                    echo "<td bgcolor='#EBF5FF'>".round($T[$i][$j],4)."</td>";
                }   
                echo "<td bgcolor='#B8DBFF'><b>".$m_OriginMtx[1][$i]."</b></td>";  
                echo "<td bgcolor='#B8DBFF'><b>".$sumOi[$i]."</b></td>";         
                echo "</tr>";
            }
            echo '<tr><th bgcolor="#B8DBFF"><b>Dj</b></th>';
            for ($i = 1; $i <= $n; $i++)
            {
            	 echo "<td bgcolor='#B8DBFF'><b>".$m_DestMtx[1][$i]."</b></td>"; 
            }
            echo '</tr><tr><th bgcolor="#B8DBFF"><b>New Dj</b></th>';
      		for ($i = 1; $i <= $n; $i++)
            {
            	 echo "<td bgcolor='#B8DBFF'><b>".$sumDj[$i]."</b></td>"; 
            }
            echo "</tr></table>";
           
  
 }
  



  
  
?>
        
        <form enctype="multipart/form-data" method="post" name="Frm" action="DoubGravModRes.php?Exp=4">
        
        <table cellspacing=5>
        	<input type="hidden" name="FunctionsVal" size="50" value="<?=$m_FunctionsVal?>"> 
				<?php
 						if($m_FunctionsVal == "PowerFun")
 						{
 							?>
 							<input type="hidden" name="txtBeta" size="50" value="<?=$m_txtBeta?>">
 							<?php  
 						}
 						elseif($m_FunctionsVal == "ExponentialFun")
 						{
 							?>
 							<input type="hidden" name="txtBeta" size="50" value="<?=$m_txtBeta?>">
 							<?php 
 						}
 						elseif($m_FunctionsVal == "GammaFun")
 						{
 							?>
 							<input type="hidden" name="txtBeta1" size="50" value="<?=$m_txtBeta1?>">
 							<input type="hidden" name="txtBeta2" size="50" value="<?=$m_txtBeta2?>">
 							<?php 
 						}
						elseif($m_FunctionsVal == "LinearFun")
						{
 							?>
 							<input type="hidden" name="txtBeta1" size="50" value="<?=$m_txtBeta1?>">
 							<input type="hidden" name="txtBeta2" size="50" value="<?=$m_txtBeta2?>">
 							<?php 
 						}


				?>
        	
        	
        	
        	<input type="hidden" name="AccuracyVal" size="50" value="<?=$m_AccuracyVal?>"> 
        	<input type="hidden" name="txtAccuracy" size="50" value="<?=$m_txtAccuracy?>"> 
        	<input type="hidden" name="CostFile" size="50" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="OriginFile" size="50" value="<?=$m_OriginFile?>"> 
        	<input type="hidden" name="DestFile" size="50" value="<?=$m_DestFile?>"> 
			<input type="hidden" name="DestFile" value="<?=$m_DestFile?>">
        	<input type="hidden" name="Itrbrk" value="<?=$itrbrk?>"> 
        	<input type="hidden" name="Itr" value="<?=$itr?>">
        	
			<tr>
			    <?php 
			    if(!$itrbrk != 1 && !($itr < $itrbrk))
    			{
    			    echo'<td align="left"><input type="submit" class=button value="First " name="first"></td>';
    			}
			    if($itrbrk>1 && $m_a == 1 )
			    {
			        echo'<td align="left"><input type="submit" class=button value="Previous" name="Previous"></td>';
    			}
    			
    			
    			//if($m_a == 1)
    			if(!($itr < $itrbrk))
    			{
    				  			     
    			     echo'<td align="left"><input type="submit" class=button value="Next" name="Next"></td>';
    			     if($itr)
    			     {
    			     	echo'<td align="left"><input type="submit" class=button value="Last" name="FinalRes"></td>';
    			     }
    			}
    			echo'</tr>';
    			if($m_a != 1 && $itr>0)
    			{
    				echo '<tr>';
			        echo'<td align="left"> Select number of iteration to be printed in the report : </td>';
			        echo'<td align="left">';
			        ?>
			        <select name="numItr">
        			<?php 
        			for ($i = 1; $i <= $itr; $i++) 
        			{
        				?>
        					<option><?php echo $i; ?></option>        					
        				<?php 
        			}
        			?>
					</select>
					</td></tr>
					<tr>
					<td colspan="2"><b>(Note: Final iteration will always be printed in the report)</b>

					<?php
    					echo '</td></tr>';
    					//echo'<tr><td align="center" colspan=2><br><input type="submit" class=button value="Generate XLS Report" name="genrepo" OnClick="return chk1()">';
    					//echo'<input type="submit" class=button value="Generate PDF Report" name="genrepo" OnClick="return chk2()"></td></tr>';
						
					?>						
					</tr>
					</table>	    
					<table align="right">
						<tr align ="right">
							<td>
								<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk1()">
							</td>
						</tr>
					</table> 
<?php 
  				}
  				
?>	
<br>
</form>
        

<br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
<!--  <td align="center">&nbsp;&nbsp;<a href="DoubGravMod.php?Exp=4"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td>  -->
<td align="center">&nbsp;&nbsp;<a href="DoubGravModDel.php?Exp=4&CostFile=<?=$m_CostFile?>&OriginFile=<?=$m_OriginFile?>&DestFile=<?=$m_DestFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>     
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
