<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment8/";

$m_FunctionsVal = $_POST['FunctionsVal'];

$m_AccuracyVal = $_POST['AccuracyVal'];
$m_txtAccuracy = $_POST['txtAccuracy'];  

$m_CostFile = $_FILES['CostFile']['name'];
$m_TripFile = $_FILES['TripFile']['name'];

$m_CostFile = $_POST['CostFile'];
$m_TripFile = $_POST['TripFile'];

if(empty($_POST['submit']))
{
	$m_CostFile = $_POST['CostFile'];
	$m_TripFile = $_POST['TripFile'];
}

//---------------------------------- verifying the format of the file ---------------------------

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));

if(!($file_ext1 == '.csv' || $file_ext1 == '.xls') && !($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
   	location="CaliDoubMod.php?Exp=6";    
</script>
<?php 
}

//----------------------------------------------------------------------------------------------

//  move uploaded files to user specific folder 

//move_uploaded_file($_FILES["CostFile"]["tmp_name"],$UploadFile."/" . $_FILES["CostFile"]["name"]);
//move_uploaded_file($_FILES["TripFile"]["tmp_name"],$UploadFile."/" . $_FILES["TripFile"]["name"]);

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
	if(document.Frm.choice.value == "")
	{
		alert ("Select Yes or No. !!");
		document.Frm.choice.focus();
		return false ;
		document.Frm.action="CaliDoubMod.php?Exp=6";
		
	}
	document.Frm.action="intermediateCaliDoubGravMod.php?Exp=6";	
		
}
</script>

</head>
<div id="body">
<center> 

<?php


//--------------------- Reading Xls file  ----------------------------------------------
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
			alert("The Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
			location = "CaliDoubMod.php?Exp=6";
		</script>
	<?php 		
	}

?>
	<caption><b>Cost Matrix </b></caption>
	<div id="scroller">
	<table class="table table-bordered table-hover">
	
<?php
	echo'<tr align="center" ><td><b>Zone</b></td>';
	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
       echo "<td ><b>".$i."</b></td>";
	}
	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
 
    	echo '<tr align="center"><td ><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $dataCostF->sheets[0]['numCols']; $j++)
    	{     
        	echo "<td >";             
        	$m_CostMtx[$i][$j]=$dataCostF->sheets[0]['cells'][$i][$j];
        	
        	// check for number
        	
        	if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript>			 
						//alert("Enter Only Numeric Values in Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
						//location = "CaliDoubMod.php?Exp=6";			
					</script>
				<?php 
			}
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    	echo "</tr>";
	}
?>
</table>
</div>

<br><br>

<?php
      
     // Trip File
     
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        //$dataTripF->read('base_matrix.xls');
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $TripRow = $dataTripF->sheets[0]['numRows'];
		$TripCol = $dataTripF->sheets[0]['numCols'];

		// check for square matrix
		
		if($TripRow != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
					//	alert("The Trip Matrix must be a square matrix i.e., the number of rows must be equal to the number of columns")
					//	location = "CaliDoubMod.php?Exp=6";			
			</script>
		<?php 		
		}
		
		// Check for Dimension of both the files
		
		if($TripRow != $CostRow  && $CostCol != $TripCol)
		{
		?>
			 <script lanuguage = javascript>			 
			//	alert("The dimension of both the file must be same.")
			//	location = "CaliDoubMod.php?Exp=6";			
			</script>
		<?php 		
		}				
 
        echo '<caption><b> Given  Trip Matrix </b></caption><div id="scroller"><table class="table table-bordered table-hover">';
        echo'<tr align="center" ><td><b>&nbsp;Zone&nbsp;</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo "<td ><b> &#8721;&nbsp;[O<sub>i</sub>]&nbsp;</b></td>";
        echo '</tr>';      
       
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            echo '<tr align="center">';
            echo "<td ><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {
                echo '<td >';               
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                
                // check for number
                
                if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript>			 
					//	alert("Enter Only Numeric Values in Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
					//	location = "CaliDoubMod.php?Exp=6";			
					</script>
				<?php 
				}
                echo $m_TripMtx[$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j];               
                echo "</td>";
               }  
               echo '<td ><b>'.$OriginSum[$i].'</b></td>';
               echo "</tr>";                                  
        }
       
        echo "<tr align='center'>";
        echo "<td ><b> &#8721;&nbsp;[D<sub>j</sub>]&nbsp; </b></td>";
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
            echo "<td ><b>".$Destsum[$j]."</b></td>";    
         }   
         echo "</tr>";      
         echo "</table></div><br><br>";
         
}
//---------------------------------------------------------------------------------


//------------------------- Reading csv file --------------------------------------

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
			//	alert("The Cost Matrix must be a square i.e., the number of rows must be equal to the number of columns")
			//	location = "CaliDoubMod.php?Exp=6";			
			</script>
		<?php 		
	}
    

?>
	<caption><b>Cost Matrix </b></caption>
	<div id="scroller">
	<table class="table table-bordered table-hover">

<?php
	echo'<tr align="center" ><td><b>Zone</b></td>';
	for ($i = 1; $i <= $n; $i++)
	{
       echo "<td ><b>".$i."</b></td>";
	}
	for ($i = 1; $i <= $n; $i++)
	{
 
    	echo '<tr align="center"><td ><b>'.$i.'</b></td>';
    	for ($j = 1; $j <= $nCol; $j++)
    	{     
        	echo "<td >";
        	
        	// check for number
        	
    		if(!is_numeric($m_CostMtx[$i][$j]))
			{
				?>
			 		<script lanuguage = javascript> 			 
					//	alert("Enter Only Numeric Values in Cost Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
					//	location = "CaliDoubMod.php?Exp=6";			
					</script>
				<?php 
			}
        	echo $m_CostMtx[$i][$j];   
        	echo "</td>";          
    	}     
    	echo "</tr>";
	}
?>
</table>
</div>

<br><br>

<?php

    // Trip File
    
    $nCol=0; 
	$n = 0;
	$name =$folder.$m_TripFile;
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
				//		alert("The Trip Matrix must be a square matrix i.e., the number of rows must be equal to the number of columns")
				//		location = "CaliDoubMod.php?Exp=6";			
			</script>
		<?php 		
		}
		
		// Check for Dimension of both the files
		
		if($TripRow != $CostRow  && $CostCol != $TripCol)
		{
		?>
			 <script lanuguage = javascript> 			 
				//		alert("The dimension of both the file must be same.")
				//		location = "CaliDoubMod.php?Exp=6";			
			</script>
		<?php 		
		}
    

        echo '<caption><b> Given  Trip Matrix </b></caption><div id="scroller"><table class="table table-bordered table-hover">';
        echo'<tr align="center" ><td><b>&nbsp;Zone&nbsp;</b></td>';
        for ($i = 1; $i <= $n; $i++)
        {
            echo '<td><b>'.$i.'</b></td>';
        }
        echo "<td ><b> &#8721;&nbsp;[O<sub>i</sub>]&nbsp;</b></td>";
        echo '</tr>';      
       
        for ($i = 1; $i <= $n; $i++)
        {    
            echo '<tr align="center">';
            echo "<td ><b>".$i."</b></td>";
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
                echo '<td >';
                
                // check for number
                
            	if(!is_numeric($m_TripMtx[$i][$j]))
				{
				?>
			 		<script lanuguage = javascript> 			 
					//	alert("Enter Only Numeric Values in Trip Matrix File !! \n Error at [<?=$i?>,<?=$j?>]")
					//	location = "CaliDoubMod.php?Exp=6";			
					</script>
				<?php 
				}
                echo $m_TripMtx[$i][$j];
                $OriginSum[$i] += $m_TripMtx[$i][$j];               
                echo "</td>";
               }  
               echo '<td ><b>'.$OriginSum[$i].'</b></td>';
               echo "</tr>";                                  
        }
       
        echo "<tr align='center'>";
        echo "<td ><b> &#8721;&nbsp;[D<sub>j</sub>]&nbsp; </b></td>";
       
        for ($j = 1; $j <= $n; $j++)
        {
            $Destsum[$j]=0;
            for ($i = 1; $i <= $n; $i++)
            {
                $Destsum[$j] += $m_TripMtx[$i][$j];                                   
            }
            echo "<td ><b>".$Destsum[$j]."</b></td>";    
         }   
         echo "</tr>";      
         echo "</table></div><br><br>";
    
    
}
else
{

			?>
			<script language= 'javascript'>
			
			//	alert("All input files must be in the same format i.e., either .xls or .csv ");
			//	location = 'CaliDoubMod.php?Exp=6';
			</script>
			<?php  

}
    
    $b=array();        
//-------------------------------------------------------------------------------------------       
           $l = 1;
          
           //Beta
        for ($bt = 0.001; $bt < 1; $bt = $bt + 0.001)
        {
               $res[$l] = 0 ;
           
            if($m_FunctionsVal == "ExponentialFun")
            {
            	// Calculation for Exponential Function	
            	
                for ($i = 1; $i <= $n; $i++)
                {               
                    for ($j = 1; $j <= $n; $j++)
                    {        
                          $fijk[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));                   
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
                          $fijk[$i][$j] = pow($m_CostMtx[$i][$j],$bt);                
                    }              
                }
            }
           
            for ($i = 1; $i <= $n; $i++)
            {
                $djk[$i] = $Destsum[$i];
                $err[$i] = 99;
            }
           $erra=99;  
            for ($m = 1; $m <= 10; $m++)
            {

             $m_a=0;
             if($m_AccuracyVal == "Individual")
             {
             	// Accuracy Level Individual
             	
                       for ($j = 1; $j <= $n; $j++)
                       {                   
                           if($err[$j] > $m_txtAccuracy)
                           {
                                  $m_a=1;                      
                            }                                          
                      }           
              }
               else if($m_AccuracyVal == "All")
              {
              	// Accuracy Level All
              	
                  if($erra > $m_txtAccuracy)
                  {
                       $m_a=1;
                  }     
             }      
             if($m_a)
              {
                    for ($i = 1; $i <= $n; $i++)
                    {            
                       for ($j = 1; $j <= $n; $j++)
                       {               
                             $d_fijk[$i][$j] = $djk[$j] * $fijk[$i][$j];                  
                       }   
                    }              

                    for ($i = 1; $i <= $n; $i++)
                    {
                         $djkfij[$i]=0;
                         for ($j = 1; $j <= $n; $j++)
                         {
                               $djkfij[$i] = $djkfij[$i] + $d_fijk[$i][$j];
                         }
                    }
                       
                    for ($i = 1; $i <= $n; $i++)
                    {                   
                         for ($j = 1; $j <= $n; $j++)
                         {
                                $tijk[$i][$j] = $OriginSum[$i] * $djk[$j] * $fijk[$i][$j] / $djkfij[$i];  //Tij TAKING ORIGIN CONSTRAINT
                         }
                   }
                       
                   for ($i = 1; $i <= $n; $i++)
                   {
                            $mdjk[$i]=0;
                            for ($j = 1; $j <= $n; $j++)
                            {
                                $mdjk[$i] = $mdjk[$i] + $tijk[$j][$i];   //MODELED Dj's
                            }
                    }
                       
                    for ($i = 1; $i <= $n; $i++)
                    {
                            $djk[$i] = $Destsum[$i] * $djk[$i] / $mdjk[$i];    //Dj's FOR NEXT ITERATION
                    }
                    for ($i = 1; $i <= $n; $i++)
                    {
                           $err[$i] = abs(($Destsum[$i] - $djk[$i]) / $Destsum[$i] * 100);   //DIFFERENCE IN TARGET ANS OBTAINED Dj's
                           $erra +=$err[$i];                          
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
                       $fijk[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));                   
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
                       $fijk[$i][$j] = pow($m_CostMtx[$i][$j],$bt);                
                   }              
               }
        }
        
       
        for ($i = 1; $i <= $n; $i++)
        {
            $djk[$i] = $Destsum[$i];
            $err[$i] = 99;
       
        }
         $erra=99;  
         
        for ($m = 1; $m <= 10; $m++)
        {
             $m_a=0;
             if($m_AccuracyVal == "Individual")
             {
                   // Accuracy Level Individual
                   
             		for ($j = 1; $j <= $n; $j++)
                   	{                   
                       if($err[$j] > $m_txtAccuracy)
                       {
                            $m_a=1;                      
                       }                                          
                   }           
              }
               else if($m_AccuracyVal == "All")
              {
              		// Accuracy Level All
              		
                     if($erra > $m_txtAccuracy)
                     {
                            $m_a=1;
                     }     
             }      
             if($m_a)
             {
                    for ($k = 1; $k <= $n; $k++)
                    {
                   if($err[$k] > $m_txtAccuracy)
                   {
                      	for ($i = 1; $i <= $n; $i++)
                     	{            
                           for ($j = 1; $j <= $n; $j++)
                           {               
                               $d_fijk[$i][$j] = $djk[$j] * $fijk[$i][$j];                  
                        	}   
                       	}              


            
                       	
                       	
                      	for ($i = 1; $i <= $n; $i++)
                    	{
                        	$djkfij[$i]=0;
                        	for ($j = 1; $j <= $n; $j++)
                        	{
                         	   $djkfij[$i] = $djkfij[$i] + $d_fijk[$i][$j];
                        	}
                    	}
                       
                       for ($i = 1; $i <= $n; $i++)
                    {                   
                        for ($j = 1; $j <= $n; $j++)
                        {
                            $tijk[$i][$j] = $OriginSum[$i] * $djk[$j] * $fijk[$i][$j] / $djkfij[$i];  //Tij TAKING ORIGIN CONSTRAINT
                        }
                    }
                       
                       for ($i = 1; $i <= $n; $i++)
                    {
                        $mdjk[$i]=0;
                        for ($j = 1; $j <= $n; $j++)
                        {
                            $mdjk[$i] = $mdjk[$i] + $tijk[$j][$i];   //MODELED Dj's
                        }
                    }
                       
                           for ($i = 1; $i <= $n; $i++)
                        {
                            $djk[$i] = $Destsum[$i] * $djk[$i] / $mdjk[$i];    //Dj's FOR NEXT ITERATION
                        }

                        for ($i = 1; $i <= $n; $i++)
                        {
                            $err[$i] = abs(($Destsum[$i] - $djk[$i]) / $Destsum[$i] * 100);   //DIFFERENCE IN TARGET ANS OBTAINED Dj's
                            $erra +=$err[$i];
                        }               
                       }  
                }
            }
        }
          
        // Finding Origin & Destination Total
         
        for ($i = 1; $i <= $n; $i++)
        {
            $oik[$i] = 0;
            $djk[$i] = 0;
            for ($j = 1; $j <= $n; $j++)
            {
                $oik[$i] = $oik[$i] + $tijk[$i][$j];
                $djk[$i] = $djk[$i] + $tijk[$j][$i];
            }
        }
                 
         

           //Output
          
        echo '<caption><b> Trip Matrix with respect to Optimal Beta Value (Minimum SSE) </b></caption><div id="scroller"><table class="table table-bordered table-hover">';
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
                   echo "<td >".(int)$tijk[$i][$j]."</td>";          
            }
            echo "</tr>";
          }   
        echo "</table></div><br><br>";
       
        echo '<table class="table table-bordered table-hover">';
        echo "<tr align='center'>";
        echo "<td  width='50%'><b> Minimum Residual = ".$res_min." </b></td>";    
        echo "<td  width='50%'><b> Optimal Beta = ".$b_opt." </b></td>";      
        echo "</tr>";      
          echo "</table><br><br>";
                  
          echo '<div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr align='center' >";
        echo "<TH> Target Oi</TH> <TH> Modelled Oi</TH> <TH> Target Dj</TH> <TH> Modelled Dj</TH>";    
           echo '</tr>';
          
           for ($i = 1; $i <= $n; $i++)
           {
               echo "<tr align='center'>";
                   echo "<td >".$OriginSum[$i]."</td>";
                   echo "<td >".$oik[$i]."</td>";
                   echo "<td >".$Destsum[$i]."</td>";
                   echo "<td >".$djk[$i]."</td>";   
            echo "</tr>";
          }   
        echo "</table></div><br><br>";
       
        echo '<div id="scroller"><table class="table table-bordered table-hover">';
        echo "<tr align='center' >";
        echo "<TH> Beta </TH> <TH> Residual SSE</TH>";    
           echo '</tr>';
          for ($i = 1; $i <= $nbt; $i++)
           {
               echo "<tr align='center'>";
            echo "<td >".$b[$i]."</td>";
               echo "<td >".$res[$i]."</td>";
               echo "</tr>";
          }   
        echo "</table></div><br><br>";
       
?>


<form enctype="multipart/form-data" method="post" name="Frm" action="CaliDoubModRes.php?Exp=6">
        
        
        	<input type="hidden" name="FunctionsVal" value="<?=$m_FunctionsVal?>">        	
        	<input type="hidden" name="AccuracyVal" value="<?=$m_AccuracyVal?>">        	
        	<input type="hidden" name="txtAccuracy" value="<?=$m_txtAccuracy?>">
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
<tr align ="right">
<td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk1()">
</td>
</tr>

</table>   
			
</form>

<br><br><br><br>
<br>
<table cellspacing=5 width = "40%" align="center" border=0>
<tr>
	<!--  <td align="center">&nbsp;&nbsp;<a href="CaliDoubMod.php?Exp=6"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td>	-->
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;<a href="CaliDoubModDel.php?Exp=6&CostFile=<?=$m_CostFile?>&TripFile=<?=$m_TripFile?>"><H3><input Type="button" value="Restart Experiment"></u></H3></a>&nbsp;&nbsp;</td>
</tr>
</table>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  
 

