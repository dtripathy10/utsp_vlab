<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment7/";


$m_MethodVal = $_POST['MethodVal'];
$m_FunctionsVal = $_POST['FunctionsVal'];

$m_CostFile = $_FILES['CostFile']['name'];
$m_TripFile = $_FILES['TripFile']['name'];

$m_CostFile = $_POST['CostFile'];
$m_TripFile = $_POST['TripFile'];


if(empty($_POST['submit']))
{
	$m_CostFile = $_POST['CostFile'];
	$m_TripFile = $_POST['TripFile'];
}

//------------------------------ verifying the format of the file -------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));
$b=array();
if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="CaliSingMod.php?Exp=5";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------


//  move uploaded files to user specific folder 

move_uploaded_file($_FILES["CostFile"]["tmp_name"],$folder. $_FILES["CostFile"]["name"]);
move_uploaded_file($_FILES["TripFile"]["tmp_name"],$folder. $_FILES["TripFile"]["name"]);
?>



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

	document.Frm.action="intermediateCaliSingGravMod.php?Exp=5";	
}
function chk2()
{ 
	if(document.Frm.choice.value == "")
	{
		alert ("Select Yes or No. !!");
		document.Frm.choice.focus();
		return false ;
		document.Frm.action="CaliSingMod.php?Exp=5";
		
	}
	document.Frm.action="intermediateCaliSingGravMod.php?Exp=5";
		
}
</script>
</head>
<div id="body">
<center> 

<?php


//------------------------------- Reading Xls file ------------------------------------------

if($file_ext1 == '.xls' && $file_ext2 == '.xls')
{
	// Cost File

	require_once '../phpExcelReader/Excel/reader.php';
	$dataCostF = new Spreadsheet_Excel_Reader();
	$dataCostF->setOutputEncoding('CP1251');
	$dataCostF->read($folder.$m_CostFile);
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
				location = "CaliSingMod.php?Exp=5";			
			</script>
		<?php 		
	}

	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
 
    	for ($j = 1; $j <= $dataCostF->sheets[0]['numCols']; $j++)
    	{            
        	$m_CostMtx[$i][$j]=$dataCostF->sheets[0]['cells'][$i][$j];
        	
        	// check for number
        	
    	    if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliSingMod.php?Exp=5";			
					</script>
				<?php 
			}     
    	}     
	}

     // Trip File
     
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
         
		$TripRow = $dataTripF->sheets[0]['numRows'];
		$TripCol = $dataTripF->sheets[0]['numCols'];
		
		// check for square matrix
		
		if($TripRow != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
						alert("The Trip Matrix must be a square matrix i.e., the number of rows must be equal to the number of columns")
						location = "CaliSingMod.php?Exp=5";			
			</script>
		<?php 		
		}
		
		// Check for dimension of both the files
		
		if($TripRow != $CostRow  && $CostCol != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
						alert("The dimension of both the file must be same.")
						location = "CaliSingMod.php?Exp=5";			
			</script>
		<?php 		
		}   
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {        
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                
                // check for number
                
            	if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliSingMod.php?Exp=5";			
					</script>
				<?php 
				}
                $OriginSum[$i] += $m_TripMtx[$i][$j];   
               }                               
        }
       
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }  
         }   

}
//---------------------------------------------------------------------------------


//----------------------------- Reading csv file ----------------------------------------

elseif($file_ext1 == '.csv' && $file_ext2 == '.csv' )
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
						location = "CaliSingMod.php?Exp=5";			
			</script>
		<?php 		
	}
	
	for ($i = 1; $i <= $n; $i++)
	{
 
    	for ($j = 1; $j <= $nCol; $j++)
    	{     
    		
        	// check for number
        	
        	if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript>			 
						alert("Enter Only Numeric Values in Base Year O-D Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliSingMod.php?Exp=5";			
					</script>
				<?php 
			}        
    	}     
	}

    // Trip File
    
    $nCol=0; 
	$n = 0;
	$name = $folder.$m_TripFile;
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
						location = "CaliSingMod.php?Exp=5";			
			</script>
		<?php 		
		}
		
		// Check for dimension of both the files
		
		if($TripRow != $CostRow  && $CostCol != $TripCol)
		{
		?>
			 <script lanuguage = javascript>			 
						alert("The dimension of both the file must be same.")
						location = "CaliSingMod.php?Exp=5";			
			</script>
		<?php 		
		}
        for ($i = 1; $i <= $n; $i++)
        {    
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
                
                // check for number
                
    			if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript> 			 
						alert("Enter Only Numeric Values in Base Year O-D Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						location = "CaliSingMod.php?Exp=5";			
					</script>
				<?php 
				}
                
                $OriginSum[$i] += $m_TripMtx[$i][$j];               

               }                                  
        }
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
         }   
}
else
{
			?>
			<script language= 'javascript'>
				alert("All input files must be in the same format i.e., either .xls or .csv ");
				location = 'CaliSingMod.php?Exp=5';
			</script>
			<?php  
}
   
           $l = 1;
          
           //Beta

        for ($bt = 0.001; $bt < 1; $bt = $bt + 0.001)
        {
               $res[$l] = 0 ;
           
              
               if($m_FunctionsVal == "PowerFun")
               {
               		// Calculation for Power Function
               	
                     for ($i = 1; $i <= $n; $i++)
                     {
                         for ($j = 1; $j <= $n; $j++)
                         {                
                               $ImpCost[$i][$j] = pow($m_CostMtx[$i][$j],$bt);
                         }                          
                     }            
                }
                
                   elseif($m_FunctionsVal == "ExponentialFun")
                   {                   		
                   		// Calculation for Exponential Function	 
                   
                       for ($i = 1; $i <= $n; $i++)
                        {
                              for ($j = 1; $j <= $n; $j++)
                              {
                                     $ImpCost[$i][$j] = exp(-($bt*$m_CostMtx[$i][$j]));   
                              }
                      	}                 
                	}    
   
                if($m_MethodVal == "SinglyOrigin")
                {
                	// Origin Constrained 
                	
                       for ($i = 1; $i <= $n; $i++)
                       {
                                  $sumR[$i]=0;
                                  for ($j = 1; $j <= $n; $j++)
                                  {                 
                                           $DF[$i][$j] = $Destsum[$j] * $ImpCost[$i][$j];         
                                        	$sumR[$i] += $DF[$i][$j];  
                                           
                                  }
                        }
                           for ($i = 1; $i <= $n; $i++)
                        {
                                for ($j = 1; $j <= $n; $j++)
                                {                 
                                        $PR[$i][$j] = $DF[$i][$j] / $sumR[$i];               
                                }
                        }
                        for ($i = 1; $i <= $n; $i++)
                        {
                                   $sumTR[$i]=0;
                                   for ($j = 1; $j <= $n; $j++)
                                   {                 
                                     $tijk[$i][$j] = $OriginSum[$i] * $PR[$i][$j];      
                                     $sumTR[$i] += $tijk[$i][$j];    
                                                  
                                 }    
                                   
                        }
                        for ($j = 1; $j <= $n; $j++)
                        {
                                   $sumTC[$j]=0;   
                                   for ($i = 1; $i <= $n; $i++)
                                   {
                                          $sumTC[$j] += $tijk[$i][$j];                  
                                   }    
                           }
                 }
                 elseif($m_MethodVal == "SinglyDest")
                 {
                 	// Destination Constrained 
                 	
                        for ($i = 1; $i <= $n; $i++)
                        {
                                for ($j = 1; $j <= $n; $j++)
                                {
                                $OF[$i][$j] = $OriginSum[$i] * $ImpCost[$i][$j];   
                                }
                           }
                        for ($j = 1; $j <= $n; $j++)
                        {                 
                               $sumC[$j]=0;
                               for ($i = 1; $i <= $n; $i++)
                               {   
                                       $sumC[$j] += $OF[$i][$j];                      
                               }                               
                  		}
                  
                  for ($i = 1; $i <= $n; $i++)
                  {
                        for ($j = 1; $j <= $n; $j++)
                        {                 
                            $PR[$i][$j] = $OF[$j][$i] / $sumC[$i];   
                        }
                  }
                  for ($i = 1; $i <= $n; $i++)
                  {
                         for ($j = 1; $j <= $n; $j++)
                         {     
                                $tijk[$i][$j] = $Destsum[$i] * $PR[$i][$j];   
                                   
                                  //  $sumTR[$j] += $tijk[$i][$j];                 
                                
                        }    
                        //echo "<td>".$sumTR[$j]."</td>";
                  }
         
                  for ($j = 1; $j <= $n; $j++)
                   {
                          $sumTC[$j]=0;   
                        for ($i = 1; $i <= $n; $i++)
                        {
                            $sumTC[$j] += $tijk[$j][$i];                  
                           }     
                     }
             }
             
             //RESIDUAL FOR 'l'th VALUE OF BETA
             
             for ($i = 1; $i <= $n; $i++)
             {
                for ($j = 1; $j <= $n; $j++)
                {
                    $res[$l] = $res[$l] + ($m_TripMtx[$i][$j] - $tijk[$i][$j]) * ($m_TripMtx[$i][$j] - $tijk[$i][$j]);   
                                  
                }
             }
             
           
           
            $b[$l]=$bt;
            $l++;   
   }
   
   // Finding Minimum SSE And Optimum Beta
   
        $nbt = $l ;  //number of beta value tried   
        $res_min = $res[1];       
        $b_opt = $b[1];
        for ($i = 1; $i <= $l-1; $i++)       
        {
        	
            if($res[$i] < $res_min)
            {
                $res_min = $res[$i];
                $b_opt = $b[$i];
            }
        }
     
        
   // Finding the Trip Matrix for Optimum value of Beta
         
        $bt = $b_opt;
       
        if($m_FunctionsVal == "ExponentialFun")
        {
        	// Calculation for Exponential Function	 
        	
            for ($i = 1; $i <= $n; $i++)
               {               
                   for ($j = 1; $j <= $n; $j++)
                   {        
                       $ImpCost[$i][$j] = exp(-($bt*$m_CostMtx[$i][$j]));                   
                   }              
               }
        }
        
        elseif ($m_FunctionsVal == "PowerFun")   
        {
        	// Calculation for Power Function
        	
            for ($i = 1; $i <= $n; $i++)
               {               
                   for ($j = 1; $j <= $n; $j++)
                   {        
                       $ImpCost[$i][$j] = pow($m_CostMtx[$i][$j],$bt);                
                   }              
               }
        }
        
        if($m_MethodVal == "SinglyOrigin")
        {
        	// Origin Constrained 
        	
               for ($i = 1; $i <= $n; $i++)
               {
                       $sumR[$i]=0;
                       for ($j = 1; $j <= $n; $j++)
                       {                 
                             $DF[$i][$j] = $Destsum[$j] * $ImpCost[$i][$j];         
                             $sumR[$i] += $DF[$i][$j]; 
                       }
               }
               for ($i = 1; $i <= $n; $i++)
               {
                        for ($j = 1; $j <= $n; $j++)
                        {                 
                             $PR[$i][$j] = $DF[$i][$j] / $sumR[$i]; 
                        }
               }
               for ($i = 1; $i <= $n; $i++)
               {
                        $sumTR[$i]=0;
                        for ($j = 1; $j <= $n; $j++)
                        {                 
                             $tijk[$i][$j] = $OriginSum[$i] * $PR[$i][$j];      
                             $sumTR[$i] += $tijk[$i][$j];                 
                        }    
                                   
             }
             for ($j = 1; $j <= $n; $j++)
             {
                        $sumTC[$j]=0;   
                        for ($i = 1; $i <= $n; $i++)
                        {
                            $sumTC[$j] += $tijk[$i][$j];                  
                        }    
            }
       }
       elseif($m_MethodVal == "SinglyDest")
       {
           		// Destination Constrained 
                 
           			for ($i = 1; $i <= $n; $i++)
                 	{
                            for ($j = 1; $j <= $n; $j++)
                            {             
                                    $OF[$i][$j] = $OriginSum[$i] * $ImpCost[$i][$j];   
                            }
                    }
                 for ($j = 1; $j <= $n; $j++)
                    {                 
                            $sumC[$j]=0;
                            for ($i = 1; $i <= $n; $i++)
                            {   
                                    $sumC[$j] += $OF[$i][$j];                      
                            }              
                  }
                  
                  for ($i = 1; $i <= $n; $i++)
                  {
                        for ($j = 1; $j <= $n; $j++)
                        {                 
                            $PR[$i][$j] = $OF[$j][$i] / $sumC[$i];   
                        }
                  }
                  for ($i = 1; $i <= $n; $i++)
                  {
                         for ($j = 1; $j <= $n; $j++)
                         {     
                                $tijk[$i][$j] = $Destsum[$i] * $PR[$i][$j];    
                        }                            
                  }
                  
         		// Finding Origin & Destination Total
         		
                  for ($j = 1; $j <= $n; $j++)
                  {
                          $sumTC[$j]=0;   
                          $sumTR[$j] = 0;
                        for ($i = 1; $i <= $n; $i++)
                        {
                            $sumTC[$j] += $tijk[$j][$i]; 
                            $sumTR[$j] += $tijk[$i][$j];                            
                           }     
                     }
             	 }
             	 
  
                  
           //Output
          
        echo '<caption><b> Trip Matrix with respect to Optimal Beta Value (Minimum SSE) </b></caption><div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr>";
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
                 echo "<td bgcolor='#EBF5FF'>".(int)$tijk[$i][$j]."</td>";          
           }
                 echo "</tr>";
        }   
        echo "</table></div><br><br>";
       
        echo '<table class="table table-bordered table-hover">';
        echo "<tr align='center'>";
        echo "<td bgcolor='#EBF5FF' width='50%'><b> Minimum Residual = ".$res_min." </b></td>";    
        echo "<td bgcolor='#EBF5FF' width='50%'><b> Optimal Beta = ".$b_opt." </b></td>";      
        echo "</tr>";      
        echo "</table><br><br>";
                  
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr>";
        echo "<TH> Target Oi</TH> <TH> Modelled Oi</TH> <TH> Target Dj</TH> <TH> Modelled Dj</TH>";    
        echo '</tr>';
          
        for ($i = 1; $i <= $n; $i++)
        {
               echo "<tr align='center'>";
               echo "<td bgcolor='#EBF5FF'>".$OriginSum[$i]."</td>";
               echo "<td bgcolor='#EBF5FF'>".$sumTR[$i]."</td>";
               echo "<td bgcolor='#EBF5FF'>".$Destsum[$i]."</td>";
               echo "<td bgcolor='#EBF5FF'>".$sumTC[$i]."</td>";   
               echo "</tr>";
        }   
        echo "</table></div><br><br>";
       
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr>";
        echo "<TH> Beta </TH> <TH> Residual SSE</TH>";    
        echo '</tr>';
        for ($i = 1; $i <= $nbt; $i++)
        {
              echo "<tr align='center'>";
              echo "<td bgcolor='#EBF5FF'>".$b[$i]."</td>";
              echo "<td bgcolor='#EBF5FF'>".$res[$i]."</td>";
              echo "</tr>";
        }   
        echo "</table></div><br><br>";
 
?>

<form enctype="multipart/form-data" method="post" name="Frm" action="CaliSingModRes.php?Exp=5">
        
        
        	<input type="hidden" name="FunctionsVal" value="<?=$m_FunctionsVal?>">        	
        	<input type="hidden" name="MethodVal" value="<?=$m_MethodVal?>">
        	<input type="hidden" name="CostFile" value="<?=$m_CostFile?>"> 
        	<input type="hidden" name="TripFile" value="<?=$m_TripFile?>"> 
      		<table cellspacing=5>
			<tr>
				<td align="center" colspan=1><h3><b> Do u want input files to be dispalyed in the report: </b></h3></td>
			        <td align="left">
			        	<select name="choice">
			        		<option value="">Select</option> 
			        		<option value="1">Yes</option> 
			       			<option value="2">No</option>  
						</select>
					</td>
			</tr>
		</table> 

<table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk2()">
</td>
</tr>

</table>   
		
</form>


<br><br><br><br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
	<!--  <td align="center">&nbsp;&nbsp;<a href="CaliSingMod.php?Exp=5"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td>	-->
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;<a href="CaliSingModDel.php?Exp=5&CostFile=<?=$m_CostFile?>&TripFile=<?=$m_TripFile?>"><H3>Restart Experiment</H3></a>&nbsp;&nbsp;</td>
</tr>
</table>
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  