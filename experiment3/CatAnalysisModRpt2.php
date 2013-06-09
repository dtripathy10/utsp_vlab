<?php
if(file_exists($folder."/CategoryAnalysisReport.xls"))
{
		$fh = fopen($folder."/CategoryAnalysisReport.xls", "a+") or die("can't open file");  



//---------------------------------- verifying the format of the file ---------------------------

$file_ext1= substr($m_CatAnalysis2, strripos($m_CatAnalysis2, '.'));

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

?>

<!DOCTYPE HTML>
<html>
<head>
<body bgcolor="#FFFFFF">

<?php 
fwrite($fh, "Trip Generation: Category analysis  \n\n") ;
fwrite($fh, "Inputs  \n\n") ;
?>
<?php 

//  move uploaded files to user specific folder 

		 move_uploaded_file($_FILES["CatFile2"]["tmp_name"],$UploadFile."/Experiment3/" . $_FILES["CatFile2"]["name"]);		
//------------------------------- reading Xls file-------------------------------------------------
if($file_ext1 == '.xls' )
{

	// Trip File

		require_once EXCELREADER.'/Excel/reader.php';
        $dataCatF = new Spreadsheet_Excel_Reader();
        $dataCatF->setOutputEncoding('CP1251');       
        $dataCatF->read($folder.$m_CatAnalysis2);
        error_reporting(E_ALL ^ E_NOTICE);
       	$nRow = $dataCatF->sheets[0]['numRows'];
        $nCol = $dataCatF->sheets[0]['numCols'];
        
        fwrite($fh, " Forecasted Socio-Economic Data   \n\n") ;
        for ($i = 1; $i <= $nRow; $i++)
        {                        
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
                	fwrite($fh, $m_CatMtx[$i][$j]."\t") ;
                }
                else
                {    
                     fwrite($fh, $m_CatMtx[$i][$j]."\t") ;
                }        
            }               
            fwrite($fh,"\n") ;      
        }  
         fwrite($fh,"\n \n") ;   

        

}
//----------------------------------------------------------------------------------

//----------------------------- reading csv file---------------------------------------------

elseif($file_ext1 == '.csv' )
{

 	$nCol=0; 
	$nRow = 0;
	$name = Sfolder.$m_CatAnalysis2;
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
    
     fwrite($fh, " Forecasted Socio-Economic Data   \n\n") ;
     for ($i = 1; $i <= $nRow; $i++)
     {                          
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
                	fwrite($fh, $m_CatMtx[$i][$j]."\t") ;
                }
                else
                {    
                     fwrite($fh, $m_CatMtx[$i][$j]."\t") ;
                }        
            }               
            fwrite($fh,"\n") ;      
        }  
         fwrite($fh,"\n \n") ;
        
        
}
fwrite($fh,"\n \n \n \n") ;

$m=0;
$n=0;
/*
for ($i = 0; $i < $m_no_of_criteria; $i++)
{

echo "Category :".$i."<br><br><br>";

  		for ($j = 1; $j <= $m_no_of_groups[$i]; $j++) 
  		{
  			echo "Group : ".$j."<br><br>";	
  			echo "range :".$m_lower_criGrp[$n]." to ".$m_upper_criGrp[$n]."<br>";		
  			for ($k= 1; $k <= $nRow; $k++) 
  			{
  				
  			 	if($m_CatMtx[$k][$m_Category[$i]]>= $m_lower_criGrp[$n] && $m_CatMtx[$k][$m_Category[$i]]<=$m_upper_criGrp[$n])
  			 	{
  			 				
  			 		$m++;
  			 		echo $m_CatMtx[$k][$m_Category[$i]]."&nbsp;";
  			 	}
  			}
  			echo '<br>total :'.$m.'<br>';
  			$m=0;
  			$n++;
  		}
  		
  		
  		
}	
*/
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
				fwrite($fh," Forecasted Socio-Economic Data  \n \n") ;
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					fwrite($fh,$m_CatMtx[1][$m_Category[$i]]."\t") ;
				}
				fwrite($fh,"Household \t Forecasted No. Of Trips = Forecasted No. of Household*Observed Trip rates\n");
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
						fwrite($fh,"Group".$i."\t");
						if($NoOfHouseHold[$i]==0 || $m_TripRateValues[$counter]==0)
						{
							fwrite($fh,"No Data Available \t");
						}
						else 
						{
							fwrite($fh,$NoOfHouseHold[$i]*$m_TripRateValues[$counter]."\t") ;
						}
						$counter++;
						fwrite($fh,"\n");
					
					
				}
				fwrite($fh,"\n \n \n \n"); 
				
				
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
				fwrite($fh," Forecasted Socio-Economic Data  \n \n") ;
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					fwrite($fh,$m_CatMtx[1][$m_Category[$i]]."\t") ;
				}
				fwrite($fh,"Household \t Forecasted No. Of Trips = Forecasted No. of Household*Observed Trip rates\n");
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						fwrite($fh,"Group ".$i."\t"."Group ".$j."\t".$Cat[$i][$j]."\t") ;
						if($Cat[$i][$j]==0 || $m_TripRateValues[$counter]==0)
						{
							fwrite($fh,"No Data Available \t");
						}
						else 
						{
							fwrite($fh,$Cat[$i][$j]*$m_TripRateValues[$counter]."\t");
						}
						$counter++;
						fwrite($fh,"\n");
					}
					
				}
				fwrite($fh,"\n \n \n \n"); 
				
				
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
				fwrite($fh," Forecasted Socio-Economic Data  \n \n") ;
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					fwrite($fh,$m_CatMtx[1][$m_Category[$i]]."\t") ;
				}
				fwrite($fh,"Household \t Forecasted No. Of Trips = Forecasted No. of Household*Observed Trip rates\n");
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							fwrite($fh,"Group ".$i."\t Group ".$j."\t Group ".$k."\t".$Cat[$i][$j][$k]."\t") ;
							if($Cat[$i][$j][$k]==0 || $m_TripRateValues[$counter]==0)
							{
								fwrite($fh,"No Data Available \t") ;
							}
							else 
							{
								fwrite($fh,$Cat[$i][$j][$k]*$m_TripRateValues[$counter]."\t") ;
							}
							
							$counter++;
							fwrite($fh,"\n") ;
						}
					}
				}
				fwrite($fh,"\n \n \n \n") ; 
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
				//	$NoOfTrip[$x][$y][$z][$a] += $m_CatMtx[$i+1][$nCol];
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
				$count4=0;
				fwrite($fh," Forecasted Socio-Economic Data  \n \n") ;
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					fwrite($fh,$m_CatMtx[1][$m_Category[$i]]."\t") ;
				}
				fwrite($fh,"Household \t Forecasted No. Of Trips = Forecasted No. of Household*Observed Trip rates\n");
				for($i=1;$i<=$m_no_of_groups[0];$i++)
				{
					
					for($j=1;$j<=$m_no_of_groups[1];$j++)
					{
						for($k=1;$k<=$m_no_of_groups[2];$k++)
						{
							for($l=1;$l<=$m_no_of_groups[3];$l++)
							{
								fwrite($fh,"Group ".$i."\t Group ".$j."\t Group ".$k."\t Group ".$l."\t".$Cat[$i][$j][$k][$l]."\t") ;
								if($Cat[$i][$j][$k][$l]==0 || $m_TripRateValues[$counter]==0)
								{
									fwrite($fh,"No Data Available \t");
								}
								else 
								{					
									fwrite($fh,$Cat[$i][$j][$k][$l]*$m_TripRateValues[$counter]."\t");		
								}
								
								$counter++;
								fwrite($fh,"\n") ;

							}
						}
					}
				}
				fwrite($fh,"\n \n \n \n") ; 
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
				
				fwrite($fh," Forecasted Socio-Economic Data  \n \n") ;
				for($i=0;$i<$m_no_of_criteria;$i++)
				{
					fwrite($fh,$m_CatMtx[1][$m_Category[$i]]."\t") ;
				}
				fwrite($fh,"Household \t Forecasted No. Of Trips = Forecasted No. of Household*Observed Trip rates\n");
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
									fwrite($fh,"Group ".$i."\t Group ".$j."\t Group ".$k."\t Group ".$l."\t Group ".$p."\t".$Cat[$i][$j][$k][$l][$p]."\t".$NoOfTrip[$i][$j][$k][$l][$p]."\t");
									if($Cat[$i][$j][$k][$l][$p]==0 || $m_TripRateValues[$counter]==0)
									{
										fwrite($fh,"No Data Available \t") ;
									}
									else 
									{
										fwrite($fh,$Cat[$i][$j][$k][$l][$p]*$m_TripRateValues[$counter]."\t") ;
									}
								
									$counter++;								
									fwrite($fh,"\n") ;
								}
							}
						}
					}
				}
				fwrite($fh,"\n \n \n \n") ; 
				break;
				
	default: echo "No. of Criteria must not exceed more than 5";
	break;
}


}



?>



