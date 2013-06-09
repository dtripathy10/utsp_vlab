 <?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4);
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment3/";

$m_CatAnalysis = $_FILES['CatFile']['name'];

if(empty($m_CatAnalysis) )
{
	$m_CatAnalysis = $_POST['CatFile'];
}



$m_no_of_criteria = $_POST['no_of_criteria'];


for ($i = 0; $i < $m_no_of_criteria; $i++)
{
			
  		$m_Category[$i] = $_POST['Category'][$i];
}

$tot=0;
for ($i = 0; $i < $m_no_of_criteria; $i++)
{

  			 $m_no_of_groups[$i] = $_POST['no_of_groups'][$i];
  			 $tot = $tot+ $m_no_of_groups[$i];
}
/*
for ($i = 1; $i <= $m_no_of_criteria; $i++)
{
	for ($j = 1; $j <= $m_no_of_groups[$i-1]; $j++) 
	{
	
		echo	$m_lower_criGrp[$i][$j] = $_POST['lower_criGrp'][$i][$j];
		echo 	$m_upper_criGrp[$i][$j] = $_POST['upper_criGrp'][$i][$j];


	}
}

*/

	for ($j = 0; $j <= $tot; $j++) 
	{
		 $m_lower_criGrp[$j] = $_POST['lower_criGrp'][$j];
		//echo $m_upper_criGrp[$j] = $_POST['upper_criGrp'][$j];	
						 	
	}
		for ($j = 0; $j <= $tot; $j++) 
	{
		//echo $m_lower_criGrp[$j] = $_POST['lower_criGrp'][$j];
		 $m_upper_criGrp[$j] = $_POST['upper_criGrp'][$j];	
						 	
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


//include("CatAnalysisModRpt.php");
//include("CatAnalysisModRptPdf.php");
?>


<style type="text/css">
#scroller 
{
    width:900px;
    height:300px;
    overflow:auto;
    border-bottom:2px solid #999;
 }
</style>



<!-- Validation for Form Controls -->

<script language="javascript">
function chk1()
{	
	
	if(document.Frm.CatFile.value == "")
	{
		alert ("Select File !!");
		document.Frm.CatFile.focus();
		return false ;
	}
	document.Frm.action="CatAnalysisModRes2.php?Exp=17";
	//document.Frm.target="_blank"; 
}
</script>


</head>
<div id="body">
<center>   
<form enctype="multipart/form-data" method="post" name="Frm" action="CatAnalysisMod3.php?Exp=17">
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
        echo "</table></div><br>";  
        
        
}
echo '<br><br><br><br>';

$m=0;
$n=0;


$counter=0;
switch($m_no_of_criteria)
{
		case 1: for($i=0;$i<=$m_no_of_groups[0];$i++)
				{	
					$NoOfHouseHold[$i+1]=0;
				}
				$NoOfTrip[$k][0] =0;
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=0;
						$m=1;
						$flag = False;
				//		echo $m_CatMtx[$i+1][$m_Category[0]]."<br>";
						while($k < $m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[0]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[0]]<=$m_upper_criGrp[$k])
							{
								if($k ==0)
								{
									
									$NoOfTrip[$k+1] +=$m_CatMtx[$i+1][$nCol];
									$NoOfHouseHold[$k+1] = $NoOfHouseHold[$k+1]+1;
									
									
								}
								else 
								{
									
									$NoOfTrip[$k+1] +=$m_CatMtx[$i+1][$nCol];
									$NoOfHouseHold[$k+1] = $NoOfHouseHold[$k+1]+1;
									
								}
								$flag = True;
								break;
							}
							
							$k++;
							//$NoOfTrip[$k][1] +=$m_CatMtx[$i+1][$m_Category[0]];
							               
						}
				}

				for($i=0;$i<=$m_no_of_groups[0];$i++)
				{
						
					if($i==0)
					{
				//		echo "Does not belong to any category : ".$categorisation[$i]."<br>";
					}
					else 
					{
				//		echo "Group : ".$i."<br>";
  				//		echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  				//		echo $NoOfHouseHold[$i]."<br>";
  				//		echo "No. of Trips :".$NoOfTrip[$i]."<br>";
					}
  				//	echo "<br>";
				}
				echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        		echo '<div id="scroller"><table class="table table-bordered table-hover">';
				echo '<tr align="center" >';
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					echo "<td>".$m_CatMtx[1][$m_Category[$i]]."</td>";
				}
				echo "<td>Household</td><td>No. Of Trips</td><td>Trip rate</td></tr>";
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
						echo '<tr align ="center">';
						echo '<td >Group '.$i.'</td><td>';
						echo $NoOfHouseHold[$i];
						echo '</td >';

						echo '<td>'.$NoOfTrip[$i].'</td>';
						if($NoOfHouseHold[$i] != 0)
						{
							echo '<td>'.($NoOfTrip[$i]/$NoOfHouseHold[$i]).'</td>';
						}
						else 
						{
							echo '<td>No Data Available</td>';
						}
						if($NoOfHouseHold[$i] != 0)
						{
							$m_TripRateValues[$counter]=($NoOfTrip[$i]/$NoOfHouseHold[$i]);
						}
						else 
						{
							$m_TripRateValues[$counter]=0;
						}
						$counter++; 
						echo '</tr >';
					
					
				}
				 echo "</table></div><br><br>"; 
				
				
				break;	

		
		
		case 2:	for($i=0;$i<=$m_no_of_groups[0];$i++)
				{	
					$categorisation1[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=0;
						$m=1;
						$flag = False;
				//		echo $m_CatMtx[$i+1][$m_Category[0]]."<br>";
						while($k < $m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[0]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[0]]<=$m_upper_criGrp[$k])
							{
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category1[$i]=0;
						  	$categorisation1[0] = $categorisation1[0]+1;
						  	
						}
						else
						{
							 $category1[$i]=$m;
							 $categorisation1[$m] = $categorisation1[$m]+1;
						}
				//		echo $category1[$i]."<br>";
						
						
				}

				for($i=0;$i<=$m_no_of_groups[0];$i++)
				{
						
					if($i==0)
					{
				//		echo "Does not belong to any category : ".$categorisation1[$i]."<br>";
					}
					else 
					{
				//		echo "Group : ".($i)."<br>";
  				//		echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  				//		echo $categorisation1[$i]."<br>";
					}
  				//	echo "<br>";
				}
				//echo  $m_no_of_groups[1]."hiiiiiiii<br>";
				for($i=0;$i<=$m_no_of_groups[1];$i++)
				{	
					$categorisation2[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0];
						
						$m=1;
						$flag = False;
				//		echo $m_CatMtx[$i+1][$m_Category[1]]."<br>";
						while($k < $m_no_of_groups[1]+$m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[1]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[1]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category2[$i]=0;
						  	$categorisation2[0] = $categorisation2[0]+1;
						  	
						}
						else
						{
							 $category2[$i]=$m;
							 $categorisation2[$m] = $categorisation2[$m]+1;
						}
				//		echo $category2[$i]."<br>";
						
				}
				$k=0;
				for($i=$m_no_of_groups[0];$i<=($m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==$m_no_of_groups[0])
					{
				//		echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
				//		echo "Group : ".($k)."<br>";
  				//		echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  				//		echo $categorisation2[$k]."<br>";
					}
					$k++;
  				//	echo "<br>";
				}
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
								$Cat[$i][$j]= 0;
						
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					for( $j=0;$j<=$nRow;$j++)
					{
						$NoOfTrip[$i][$j] = 0;
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$Cat[$x][$y] =  $Cat[$x][$y]+1;
					$NoOfTrip[$x][$y] += $m_CatMtx[$i+1][$nCol];
				}
				/*
				for( $i=0;$i<=$m_no_of_groups[0];$i++)
				{
					for( $j=0;$j<=$m_no_of_groups[1];$j++)
					{
						echo $Cat[$i][$j];
						echo "   ".$NoOfTrip[$i][$j]."   .........                ";
						
					}
					
					
				}
				*/
				echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        		echo '<div id="scroller"><table class="table table-bordered table-hover">';
				echo '<tr align="center" >';
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					echo "<td>".$m_CatMtx[1][$m_Category[$i]]."</td>";
				}
				echo "<td>Household</td><td>No. Of Trips</td><td>Trip rates</td></tr>";
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						echo '<tr align ="center">';
						echo '<td >Group '.$i.'</td><td>Group '.$j.'</td><td>';
						echo $Cat[$i][$j];
						echo '</td >'; 

						echo '<td>'.$NoOfTrip[$i][$j].'</td>';
						if($Cat[$i][$j] != 0)
						{
							echo '<td>'.($NoOfTrip[$i][$j]/$Cat[$i][$j]).'</td>';
						}
						else 
						{
							echo '<td>No Data Available</td>';
						}
						if($Cat[$i][$j] != 0)
						{
							$m_TripRateValues[$counter]=($NoOfTrip[$i][$j]/$Cat[$i][$j]);
						}
						else 
						{
							$m_TripRateValues[$counter]=0;
						}
						$counter++;
						echo '</tr >';
					}
					
				}
				 echo "</table></div><br><br>"; 
				
				
				break;
				
		case 3:for($i=0;$i<=$m_no_of_groups[0];$i++)
				{	
					$categorisation1[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=0;
						$m=1;
						$flag = False;
				//		echo $m_CatMtx[$i+1][$m_Category[0]]."<br>";
						while($k < $m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[0]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[0]]<=$m_upper_criGrp[$k])
							{
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category1[$i]=0;
						  	$categorisation1[0] = $categorisation1[0]+1;
						  	
						}
						else
						{
							 $category1[$i]=$m;
							 $categorisation1[$m] = $categorisation1[$m]+1;
						}
				//		echo $category1[$i]."<br>";
						
				}

				for($i=0;$i<=$m_no_of_groups[0];$i++)
				{
						
					if($i==0)
					{
				//		echo "Does not belong to any category : ".$categorisation1[$i]."<br>";
					}
					else 
					{
				//		echo "Group : ".($i)."<br>";
  				//		echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  				//		echo $categorisation1[$i]."<br>";
					}
  				//	echo "<br>";
				}
				
				for($i=0;$i<=$m_no_of_groups[1];$i++)
				{	
					$categorisation2[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0];
						
						$m=1;
						$flag = False;
			//			echo $m_CatMtx[$i+1][$m_Category[1]]."<br>";
						while($k < $m_no_of_groups[1]+$m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[1]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[1]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category2[$i]=0;
						  	$categorisation2[0] = $categorisation2[0]+1;
						  	
						}
						else
						{
							 $category2[$i]=$m;
							 $categorisation2[$m] = $categorisation2[$m]+1;
						}
			//			echo $category2[$i]."<br>";
						
				}
				$k=0;
				for($i=$m_no_of_groups[0];$i<=($m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==$m_no_of_groups[0])
					{
			//			echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
			//			echo "Group : ".($k)."<br>";
  			//			echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  			//			echo $categorisation2[$k]."<br>";
					}
					$k++;
  			//		echo "<br>";
				}
				for($i=0;$i<=$m_no_of_groups[2];$i++)
				{	
					$categorisation3[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0]+$m_no_of_groups[1];
						
						$m=1;
						$flag = False;
			//			echo $m_CatMtx[$i+1][$m_Category[2]]."<br>";
						while($k < ($m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]))
						{	
							if($m_CatMtx[$i+1][$m_Category[2]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[2]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category3[$i]=0;
						  	$categorisation3[0] = $categorisation3[0]+1;
						  	
						}
						else
						{
							 $category3[$i]=$m;
							 $categorisation3[$m] = $categorisation3[$m]+1;
						}
			//			echo $category3[$i]."<br>";
						
				}
				$k=0;
				for($i=($m_no_of_groups[0]+$m_no_of_groups[1]);$i<=($m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==$m_no_of_groups[0])
					{
			//			echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
			//			echo "Group : ".($k)."<br>";
  			//			echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  			//			echo $categorisation3[$k]."<br>";
					}
					$k++;
  			//		echo "<br>";
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					for( $j=0;$j<=$nRow;$j++)
					{
						for($k=0;$k<=$nRow;$k++)
						{
							$Cat[$i][$j][$k]= 0;
							$NoOfTrip[$i][$j][$k] = 0;
							
						}
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$z = $category3[$i];
					$Cat[$x][$y][$z] =  $Cat[$x][$y][$z]+1;
					$NoOfTrip[$x][$y][$z] += $m_CatMtx[$i+1][$nCol];
				}/*
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
								$Cat[$i][$j][$k]= 0;
							
						}
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$z = $category3[$i];
					$Cat[$x][$y][$z] =  $Cat[$x][$y][$z]+1;
				}
				*/
				echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        		echo '<div id="scroller"><table class="table table-bordered table-hover">';
				echo '<tr align="center" >';
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					echo "<td>".$m_CatMtx[1][$m_Category[$i]]."</td>";
				}
				echo "<td>Household</td><td>No. of Trips</td><td>Trip rate</td></tr>";
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							echo '<tr align ="center">';
							echo '<td >Group '.$i.'</td><td>Group '.$j.'</td><td>Group '.$k.'</td><td>';
							echo $Cat[$i][$j][$k];
							echo '</td >'; 

							echo '<td>'.$NoOfTrip[$i][$j][$k].'</td>';
							if($Cat[$i][$j][$k] != 0)
							{
								echo '<td>'.($NoOfTrip[$i][$j][$k]/$Cat[$i][$j][$k]).'</td>';
							}
							else 
							{
								echo '<td>No Data Available</td>';
							}
							if($Cat[$i][$j][$k] != 0)
							{
								$m_TripRateValues[$counter]=($NoOfTrip[$i][$j][$k]/$Cat[$i][$j][$k]);
							}
							else 
							{
								$m_TripRateValues[$counter]=0;
							}
							$counter++;
							
							echo '</tr >';
						}
					}
				}
				 echo "</table></div><br><br>"; 
				break;
				
				
		case 4:for($i=0;$i<=$m_no_of_groups[0];$i++)
				{	
					$categorisation1[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=0;
						$m=1;
						$flag = False;
			//			echo $m_CatMtx[$i+1][$m_Category[0]]."<br>";
						while($k < $m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[0]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[0]]<=$m_upper_criGrp[$k])
							{
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category1[$i]=0;
						  	$categorisation1[0] = $categorisation1[0]+1;
						  	
						}
						else
						{
							 $category1[$i]=$m;
							 $categorisation1[$m] = $categorisation1[$m]+1;
						}
			//			echo $category1[$i]."<br>";
						
				}

				for($i=0;$i<=$m_no_of_groups[0];$i++)
				{
						
					if($i==0)
					{
			//			echo "Does not belong to any category : ".$categorisation1[$i]."<br>";
					}
					else 
					{
			//			echo "Group : ".($i)."<br>";
  			//			echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  			//			echo $categorisation1[$i]."<br>";
					}
  			//		echo "<br>";
				}
				
				for($i=0;$i<=$m_no_of_groups[1];$i++)
				{	
					$categorisation2[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0];
						
						$m=1;
						$flag = False;
			//			echo $m_CatMtx[$i+1][$m_Category[1]]."<br>";
						while($k < $m_no_of_groups[1]+$m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[1]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[1]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category2[$i]=0;
						  	$categorisation2[0] = $categorisation2[0]+1;
						  	
						}
						else
						{
							 $category2[$i]=$m;
							 $categorisation2[$m] = $categorisation2[$m]+1;
						}
			//			echo $category2[$i]."<br>";
						
				}
				$k=0;
				for($i=$m_no_of_groups[0];$i<=($m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==$m_no_of_groups[1])
					{
			//			echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
			//			echo "Group : ".($k)."<br>";
  			//			echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  			//			echo $categorisation2[$k]."<br>";
					}
					$k++;
  			//		echo "<br>";
				}
				for($i=0;$i<=$m_no_of_groups[2];$i++)
				{	
					$categorisation3[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0]+$m_no_of_groups[1];
						
						$m=1;
						$flag = False;
			//			echo $m_CatMtx[$i+1][$m_Category[2]]."<br>";
						while($k < ($m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]))
						{	
							if($m_CatMtx[$i+1][$m_Category[2]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[2]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category3[$i]=0;
						  	$categorisation3[0] = $categorisation3[0]+1;
						  	
						}
						else
						{
							 $category3[$i]=$m;
							 $categorisation3[$m] = $categorisation3[$m]+1;
						}
			//			echo $category3[$i]."<br>";
						
				}
				$k=0;
				for($i=($m_no_of_groups[0]+$m_no_of_groups[1]);$i<=($m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==($m_no_of_groups[0]+$m_no_of_groups[1]))
					{
			//			echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
			//			echo "Group : ".($k)."<br>";
  			//			echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  			//			echo $categorisation3[$k]."<br>";
					}
					$k++;
  			//		echo "<br>";
				}
				for($i=0;$i<=$m_no_of_groups[3];$i++)
				{	
					$categorisation4[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2];
						
						$m=1;
						$flag = False;
			//			echo $m_CatMtx[$i+1][$m_Category[3]]."<br>";
						while($k < ($m_no_of_groups[3]+$m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]))
						{	
							if($m_CatMtx[$i+1][$m_Category[3]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[3]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category4[$i]=0;
						  	$categorisation4[0] = $categorisation4[0]+1;
						  	
						}
						else
						{
							 $category4[$i]=$m;
							 $categorisation4[$m] = $categorisation4[$m]+1;
						}
			//			echo $category4[$i]."<br>";
						
				}
				$k=0;
				for($i=($m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2]);$i<=($m_no_of_groups[3]+$m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==($m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2]))
					{
			//			echo "Does not belong to any category : ".$categorisation4[$k]."<br>";
					}
					else 
					{
			//			echo "Group : ".($k)."<br>";
  			//			echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  			//			echo $categorisation4[$k]."<br>";
					}
					$k++;
  			//		echo "<br>";
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					for( $j=0;$j<=$nRow;$j++)
					{
						for($k=0;$k<=$nRow;$k++)
						{
							for($l=0;$l<=$nRow;$l++)
							{
								$Cat[$i][$j][$k][$l]= 0;
								$NoOfTrip[$i][$j][$k][$l] = 0;
							}
						}
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$z = $category3[$i];
					$a = $category4[$i];
					$Cat[$x][$y][$z][$a] =  $Cat[$x][$y][$z][$a]+1;
					$NoOfTrip[$x][$y][$z][$a] += $m_CatMtx[$i+1][$nCol];
				}
				/*
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							for($l=1;$l<=$m_no_of_groups[3];$l++)
							{
								$Cat[$i][$j][$k][$l]= 0;
							}
						}
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$z = $category3[$i];
					$a = $category4[$i];
					$Cat[$x][$y][$z][$a] =  $Cat[$x][$y][$z][$a]+1;
				}
				*/
				
				echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        		echo '<div id="scroller"><table class="table table-bordered table-hover">';
				echo '<tr align="center" >';
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					echo "<td>".$m_CatMtx[1][$m_Category[$i]]."</td>";
				}
				echo "<td>Household</td><td>No of Trips</td><td>Trip rate</td></tr>";

				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							for($l=1;$l<=$m_no_of_groups[3];$l++)
							{
								echo '<tr align ="center">';
								echo '<td >Group '.$i.'</td><td>Group '.$j.'</td><td>Group '.$k.'</td><td>Group '.$l.'</td><td>';
								echo $Cat[$i][$j][$k][$l];
								echo '</td >'; 
								echo '<td>'.$NoOfTrip[$i][$j][$k][$l].'</td>';
								if($Cat[$i][$j][$k][$l] != 0)
								{
									echo '<td>'.($NoOfTrip[$i][$j][$k][$l]/$Cat[$i][$j][$k][$l]).'</td>';
								}
								else 
								{
									echo '<td>No Data Available</td>';
								}
								if($Cat[$i][$j][$k][$l] != 0)
								{
									$m_TripRateValues[$counter]=($NoOfTrip[$i][$j][$k][$l]/$Cat[$i][$j][$k][$l]);
								}
								else 
								{
									$m_TripRateValues[$counter]=0;
								}
								$counter++;
								echo '</tr >';
							}
						}
					}
				}
				 echo "</table></div><br><br>"; 

				 
				break;
				
		case 5:for($i=0;$i<=$m_no_of_groups[0];$i++)
				{	
					$categorisation1[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=0;
						$m=1;
						$flag = False;
					//	echo $m_CatMtx[$i+1][$m_Category[0]]."<br>";
						while($k < $m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[0]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[0]]<=$m_upper_criGrp[$k])
							{
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category1[$i]=0;
						  	$categorisation1[0] = $categorisation1[0]+1;
						  	
						}
						else
						{
							 $category1[$i]=$m;
							 $categorisation1[$m] = $categorisation1[$m]+1;
						}
				//		echo $category1[$i]."<br>";
						
				}

				for($i=0;$i<=$m_no_of_groups[0];$i++)
				{
						
					if($i==0)
					{
				//		echo "Does not belong to any category : ".$categorisation1[$i]."<br>";
					}
					else 
					{
				//		echo "Group : ".($i)."<br>";
  				//		echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  				//		echo $categorisation1[$i]."<br>";
					}
  				//	echo "<br>";
				}
				
				for($i=0;$i<=$m_no_of_groups[1];$i++)
				{	
					$categorisation2[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0];
						
						$m=1;
						$flag = False;
				//		echo $m_CatMtx[$i+1][$m_Category[1]]."<br>";
						while($k < $m_no_of_groups[1]+$m_no_of_groups[0])
						{	
							if($m_CatMtx[$i+1][$m_Category[1]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[1]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category2[$i]=0;
						  	$categorisation2[0] = $categorisation2[0]+1;
						  	
						}
						else
						{
							 $category2[$i]=$m;
							 $categorisation2[$m] = $categorisation2[$m]+1;
						}
				//		echo $category2[$i]."<br>";
						
				}
				$k=0;
				for($i=$m_no_of_groups[0];$i<=($m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==$m_no_of_groups[1])
					{
				//		echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
				//		echo "Group : ".($k)."<br>";
  				//		echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  				//		echo $categorisation2[$k]."<br>";
					}
					$k++;
  				//	echo "<br>";
				}
				for($i=0;$i<=$m_no_of_groups[2];$i++)
				{	
					$categorisation3[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0]+$m_no_of_groups[1];
						
						$m=1;
						$flag = False;
				//		echo $m_CatMtx[$i+1][$m_Category[2]]."<br>";
						while($k < ($m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]))
						{	
							if($m_CatMtx[$i+1][$m_Category[2]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[2]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category3[$i]=0;
						  	$categorisation3[0] = $categorisation3[0]+1;
						  	
						}
						else
						{
							 $category3[$i]=$m;
							 $categorisation3[$m] = $categorisation3[$m]+1;
						}
				//		echo $category3[$i]."<br>";
						
				}
				$k=0;
				for($i=($m_no_of_groups[0]+$m_no_of_groups[1]);$i<=($m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==($m_no_of_groups[0]+$m_no_of_groups[1]))
					{
					//	echo "Does not belong to any category : ".$categorisation1[$k]."<br>";
					}
					else 
					{
					//	echo "Group : ".($k)."<br>";
  					//	echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  					//	echo $categorisation3[$k]."<br>";
					}
					$k++;
  				//	echo "<br>";
				}
				for($i=0;$i<=$m_no_of_groups[3];$i++)
				{	
					$categorisation4[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2];
						
						$m=1;
						$flag = False;
					//	echo $m_CatMtx[$i+1][$m_Category[3]]."<br>";
						while($k < ($m_no_of_groups[3]+$m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]))
						{	
							if($m_CatMtx[$i+1][$m_Category[3]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[3]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category4[$i]=0;
						  	$categorisation4[0] = $categorisation4[0]+1;
						  	
						}
						else
						{
							 $category4[$i]=$m;
							 $categorisation4[$m] = $categorisation4[$m]+1;
						}
						//echo $category4[$i]."<br>";
						
				}
				for($i=0;$i<=$m_no_of_groups[4];$i++)
				{	
					$categorisation5[$i]=0;
				}
				for ($i = 1; $i < $nRow; $i++) 
				{
						$k=$m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2]+$m_no_of_groups[3];
						
						$m=1;
						$flag = False;
						//echo $m_CatMtx[$i+1][$m_Category[3]]."<br>";
						while($k < ($m_no_of_groups[4]+$m_no_of_groups[3]+$m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]))
						{	
							if($m_CatMtx[$i+1][$m_Category[4]] >= $m_lower_criGrp[$k] && $m_CatMtx[$i+1][$m_Category[4]]<=$m_upper_criGrp[$k])
							{
								
								$flag = True;
								break;
							}
							$k++;
							$m++;
						}
						if($flag == False)
						{
						  	$category5[$i]=0;
						  	$categorisation5[0] = $categorisation5[0]+1;
						  	
						}
						else
						{
							 $category5[$i]=$m;
							 $categorisation5[$m] = $categorisation5[$m]+1;
						}
						//echo $category5[$i]."<br>";
						
				}
				$k=0;
				for($i=($m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2]);$i<=($m_no_of_groups[3]+$m_no_of_groups[2]+$m_no_of_groups[1]+$m_no_of_groups[0]) ;$i++)
				{
						
					if($i==($m_no_of_groups[0]+$m_no_of_groups[1]+$m_no_of_groups[2]))
					{
						//echo "Does not belong to any category : ".$categorisation4[$k]."<br>";
					}
					else 
					{
						//echo "Group : ".($k)."<br>";
  						//echo "range :".$m_lower_criGrp[$i-1]." to ".$m_upper_criGrp[$i-1]."<br>";
  						//echo $categorisation4[$k]."<br>";
					}
					$k++;
  				//	echo "<br>";
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					for( $j=0;$j<=$nRow;$j++)
					{
						for($k=0;$k<=$nRow;$k++)
						{
							for($l=0;$l<=$nRow;$l++)
							{
								for($p=0;$p<=$nRow;$p++)
								{
									$Cat[$i][$j][$k][$l][$p]= 0;
									$NoOfTrip[$i][$j][$k][$l][$p] = 0;
								}
							}
						}
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$z = $category3[$i];
					$a = $category4[$i];
					$p = $category5[$i];
					$Cat[$x][$y][$z][$a][$p] =  $Cat[$x][$y][$z][$a][$p]+1;
					$NoOfTrip[$x][$y][$z][$a][$p] += $m_CatMtx[$i+1][$nCol];
				}
				/*
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							for($l=1;$l<=$m_no_of_groups[3];$l++)
							{
								$Cat[$i][$j][$k][$l]= 0;
							}
						}
					}
				}
				for( $i=0;$i<=$nRow;$i++)
				{
					$x = $category1[$i];
					$y = $category2[$i];
					$z = $category3[$i];
					$a = $category4[$i];
					$Cat[$x][$y][$z][$a] =  $Cat[$x][$y][$z][$a]+1;
				}
				*/
				
				echo "<caption><b> Observed Socio-Economic Data </b></caption>";
        		echo '<div id="scroller"><table class="table table-bordered table-hover">';
				echo '<tr align="center" >';
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					echo "<td>".$m_CatMtx[1][$m_Category[$i]]."</td>";
				}
				echo "<td>Household</td><td>No of Trips</td><td>Trip rate</td></tr>";
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							for($l=1;$l<=$m_no_of_groups[3];$l++)
							{
								for($p=1;$p<=$m_no_of_groups[4];$p++)
								{
									echo '<tr align ="center">';
									echo '<td >Group '.$i.'</td><td>Group '.$j.'</td><td>Group '.$k.'</td><td>Group '.$l.'</td><td>Group '.$p.'</td><td>';
									echo $Cat[$i][$j][$k][$l][$p];
									echo '</td >';
									echo '<td>'.$NoOfTrip[$i][$j][$k][$l][$p].'</td>';
									if($Cat[$i][$j][$k][$l][$p] != 0)
									{
										echo '<td>'.($NoOfTrip[$i][$j][$k][$l][$p]/$Cat[$i][$j][$k][$l][$p]).'</td>';
									}
									else 
									{
										echo '<td>No Data Available</td>';
									}
									if($Cat[$i][$j][$k][$l][$p] != 0)
									{
										$m_TripRateValues[$counter]=($NoOfTrip[$i][$j][$k][$l][$p]/$Cat[$i][$j][$k][$l][$p]);
									}
									else 
									{
										$m_TripRateValues[$counter]=0;
									}
									$counter++;	 							
									echo '</tr >';
								}
							}
						}
					}
				}
				 echo "</table></div>"; 
				break;
				
	default: echo "No. of Criteria must not exceed more than 5";
	break;
}


if($m_CatAnalysis !="observedSurvey.xls")
{
?>
<table class="table table-bordered table-hover">
<tr align="center">
	<th align="left"  width="30%">Forecasted Socio-economic Data File (xls/csv) : </th>
	<td align="left"><input type="File" name="CatFile2" size="50" value="<?=$m_CatAnalysis2?>"></td>
</tr>
<tr >
<td colspan="2"><span style="font-size: small; color: #ff0000;"><strong><br><br>See the default Excel / CSV input files for file format:</strong></span></td>
</tr>
<tr>
<td align="right"><img src="img/SmallXLS.jpg" alt="Excel" /></td><td align="left"><strong><a href="<?php echo DOC_FOLDER;?>/pune.xls">- (Click Here) for Input File (xls)</a></strong></td>
</tr>
<td align="right"><img src="img/SmallCSV.jpg" alt="CSV" /></td><td align="left"><strong><a href="<?php echo DOC_FOLDER;?>/pune.csv">- (Click Here) for Input File (csv)</a></strong></td>
</tr>
</table>


<?php 
}
else 
{
	$file1 = fopen($folder."forecasted.xls", "w");
	$url = DOC_FOLDER."/survey.xls"; 
	//$m_TripFile = basename($url);
	copy($url,$folder."forecasted.xls");

	$m_CatAnalysis2 = "forecasted.xls";
}
?>


<input type="hidden" name="CatFile2"  value="<?=$m_CatAnalysis2?>"> 
<input type="hidden" name="CatFile"  value="<?=$m_CatAnalysis?>"> 
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

for ($i = 0; $i < $tot; $i++)
{ 	
?>
    	<td><input type="hidden" name="lower_criGrp[]" size="30" value="<?=$m_lower_criGrp[$i]?>"></td>
    	<td><input type="hidden" name="upper_criGrp[]" size="30" value="<?=$m_upper_criGrp[$i]?>"></td>
<?php 
}

for ($i = 0; $i < $counter; $i++)
{
?>
    	<input type="hidden" name="TripRateValues[]" size="50" value="<?=$m_TripRateValues[$i]?>">

<?php 
}
?>
<input type="hidden" name="counter" size="50" value="<?=$counter?>">
<input type="hidden" name="tot" size="50" value=<?=$tot?>">
<table cellspacing=5>
<tr>
<td align="left"><input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()"></td>
</tr>
</table> 
<a href="CatAnalysisMod2.php?Exp=17&CatFile=<?php echo $m_CatAnalysis?>"><H2><input type ="button" value="Back"></H2></a>

</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  


