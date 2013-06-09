<?php
$folder = USER_ROOT."/".$UploadFile."/Experiment2/";
if(file_exists($folder."DataRegr.xls")):
		$fh = fopen($folder."DataRegr.xls", "a+") or die("can't open file");
		
	
$m_AnalysisVar = $_SESSION['AnalysisVar'];     

$file_ext1= substr($m_TripFile, strripos($m_TripFile, '.'));	
if($file_ext1 == '.xls' )
{

	// Trip File		

     	require_once EXCELREADER.'/Excel/reader.php';
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $nRow = $dataTripF->sheets[0]['numRows'];
        $nCol = $dataTripF->sheets[0]['numCols'];
 
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {  
                for ($j = 1; $j <= $dataTripF->sheets[0]['numRows']; $j++)
        		{       
        			$m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
        		} 
        } 
}      
elseif($file_ext1 == '.csv' )
{

 	$nCol=0; 
	$nRow = 0;
	$name = $folder.$m_TripFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Trip[$nRow][$c] = $data[$c];
        	
     	}
     	$nRow++;
    
    }
    
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		 $m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j];      	
         }
    	
    }
        
        
}      
  
      
	if($m_AnalysisVar == "DataAna")
	{
		
		$m_DataChoiceVar = $_POST['DataChoiceVar'];
		
		if ($m_DataChoiceVar == "Correlation")
		{				
			for ($i=0; $i < count($_POST['CorrDescVar']);$i++)
			{	
    			$m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];
			}
			
			// Correlation Analysis starts from here
			
			$SelectCol = $i;
		   	$m_finalrow = $nRow;
		   	
    		for ($j = 0; $j < $SelectCol; $j++)
        	{
        	
            	$SumC[$j]=0;
            	$avg[$j]=0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
            		
                	$tripmatrix[$i][$j]=$m_TripMtx[$i][$m_CorrDescVar[$j]];                	
                	$SumC[$j] += $tripmatrix[$i][$j];                                   
            	}
            	$avg[$j] = $SumC[$j] / ($m_finalrow-1);
         	}  
          
         	for ($j = 0; $j < $SelectCol; $j++)
         	{
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{                
                	$delta[$i][$j] =  $tripmatrix[$i][$j] - $avg[$j];               
            	}
         	}  

        	for ($j = 0; $j < $SelectCol; $j++)
        	{     
            	$deltaSum[$j] = 0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$deltaPro[$i][$j] =  $delta[$i][$j] * $delta[$i][$j];
                	$deltaSum[$j] += $deltaPro[$i][$j];
        		}
            	$deltaRoot[$j] = sqrt($deltaSum[$j]);   
        	}       	
                
        	for ($j = 0; $j < $SelectCol; $j++)
        	{     
            	for ($i = 0; $i < $SelectCol; $i++)
            	{
            		$sump[$j][$i]=0;
            		for ($k = 2; $k <= $m_finalrow; $k++)
            		{
            			$sump[$j][$i]+=$delta[$k][$j]*$delta[$k][$i];            
	            	}
    	        }
        	}
        
        	for ($j = 0; $j < $SelectCol; $j++)
        	{    
            	for ($i = 0; $i < $SelectCol; $i++)
            	{
            		if($deltaRoot[$j] == 0)
            		{
            			           	
            		}
            		else 
            		{	
                 		$reg[$i][$j] =  $sump[$j][$i]/($deltaRoot[$j]*$deltaRoot[$i]);
            		}
        		}
        	}
        
        	fwrite($fh, "Correlation Matrix \n") ;
         	fwrite($fh, "\t") ;
         	for ($i = 0; $i < $SelectCol; $i++)
         	{
         		fwrite($fh, $m_TripMtx[1][$m_CorrDescVar[$i]]."\t") ;
         	}
         	fwrite($fh, "\n") ;
         	for ($j = 0; $j < $SelectCol; $j++)
         	{     
            	fwrite($fh, $m_TripMtx[1][$m_CorrDescVar[$j]]."\t") ;
            	for ($i = 0; $i < $SelectCol; $i++)
            	{
            		
            		fwrite($fh, round($reg[$j][$i],4)."\t");
            		
            	}
            	fwrite($fh, "\n");
        	}
        	fwrite($fh, "\n\n\n") ;
		}			
		elseif ($m_DataChoiceVar == "Descriptives")
		{
			for ($i=0; $i < count($_POST['CorrDescVar']);$i++)
			{	
    			$m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];
			}		
			
			// Descriptives Analysis start from here
			
			$SelectCol = $i;
		   	$m_finalrow = $nRow;
		   	
    		for ($j = 0; $j < $SelectCol; $j++)
        	{
            	$SumC[$j]=0;
            	$avg[$j]=0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$tripmatrix[$i][$j]=$m_TripMtx[$i][$m_CorrDescVar[$j]];                	
                	$SumC[$j] += $tripmatrix[$i][$j];                                   
            	}
            	$avg[$j] = $SumC[$j] / ($m_finalrow-1);
         	}    
         	
         	for ($j = 0; $j < $SelectCol; $j++)
        	{
        		$max[$j] = 0;
        		$min[$j] = $tripmatrix[2][1];
        		for ($i = 2; $i <= $m_finalrow; $i++)
            	{
            		if($tripmatrix[$i][$j] > $max[$j])
            		{
            			$max[$j] = $tripmatrix[$i][$j];
            		}
            		elseif ($tripmatrix[$i][$j] < $min[$j])
            		{
            			$min[$j] = $tripmatrix[$i][$j];            			
            		}
        		}
        	}         	
          
         	for ($j = 0; $j < $SelectCol; $j++)
         	{
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{                
                	$delta[$i][$j] =  $tripmatrix[$i][$j] - $avg[$j];               
            	}
         	}  

        	for ($j = 0; $j < $SelectCol; $j++)
        	{     
            	$deltaSum[$j] = 0;
            	for ($i = 2; $i <= $m_finalrow; $i++)
            	{
                	$deltaPro[$i][$j] =  $delta[$i][$j] * $delta[$i][$j];
                	$deltaSum[$j] += $deltaPro[$i][$j];
        		}
            	$deltaRoot[$j] = sqrt(($deltaSum[$j])/($m_finalrow-2));   
        	}


            fwrite($fh, "Descriptive Statistics \n") ;
            fwrite($fh, "\t Minimum \t Maximum \t Mean \t Standard Deviation \n") ;
         	           
            for ($i = 0; $i < $SelectCol; $i++)
            {
                  fwrite($fh, $m_TripMtx[1][$m_CorrDescVar[$i]]."\t") ;  
                  fwrite($fh, ($m_finalrow-1)."\t") ;
                  fwrite($fh, $min[$i]."\t") ;
                  fwrite($fh, $max[$i]."\t") ;
                  fwrite($fh, round($avg[$i],4)."\t") ;
                  fwrite($fh, round($avg[$i],4)."\t\n") ;
                  
          	}  
        	//fwrite($fh, round($avg[$i],4)."\n") ;
        	fwrite($fh, "\n\n\n") ;
        	
		}		

	}
	elseif($m_AnalysisVar == "RegrAna")
	{
		$ans =  $_SESSION['ANS'];
for($i=1;$i<=count($ans);$i++)
{
	$coefficients[$i-1] =  $_SESSION['ANS'][$i];
}

$m_RegrType = $_SESSION['RegrType'];
$m_Dep =  $_SESSION['RegrDepdVar'];
$m_InDep =  $_SESSION['RegrInpdVar'];
$m_type=$_SESSION['Type'] ;

for($i=0;$i<=count($m_InDep);$i++)
{
	$m_Independent[$i]=  $_SESSION['RegrInpdVar'][$i];
	
}
if($m_type == "Linear")
{
	fwrite($fh, "Model Used : Linear Regression\n");
		$k=1;
		fwrite($fh, "\nEquation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ");
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             	
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             elseif($i <= count($m_InDep)-1)
             {
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             else
             {
                  fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].")");
             }
             $k++;
      	}
      	fwrite($fh, "\n\n\n");
        
	
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <=count($m_InDep); $j++)
		{
			//echo $m_TripMtx[$i][$m_Independent[$j]]."*".$coefficients[$k]."   ";
			$m_trip[$i]=$m_trip[$i]+$m_TripMtx[$i][$m_Independent[$j]]*$coefficients[$k];
			$k++;
		}
		fwrite($fh, "T[".($i-1)."]\t");
		fwrite($fh, $m_trip[$i]."\t\n");
	}
	fwrite($fh, "\n\n\n");
}
if($m_RegrType == "Quadratic")
{
	
	fwrite($fh, "Model Used : Quadratic Regression\n");
	
	    $k=1;
		fwrite($fh, "\nEquation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ");
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             	fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             elseif($i <= $SelectCol-2)
             {
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             else
             {
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             $k++;
      	}
      	for ($i = count($m_InDep); $i < 2*count($m_InDep); $i++)
      	{
            if($i < 2*count($m_InDep)-1)
             {
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i-count($m_InDep)]].") + ");
             }
             else
             {
                fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i-count($m_InDep)]].") ");
             }
             $k++;
      	}
      	fwrite($fh, "\n\n\n");
        
	
		$counted = count($m_InDep);
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <$counted; $j++)
		{
			
			$m_trip[$i]=$m_trip[$i]+$m_TripMtx[$i][$m_Independent[$j]]*$coefficients[$k];
			$k++;
		}
		for ($j = 0; $j <$counted; $j++)
		{
			
			$m_trip[$i]=$m_trip[$i]+pow($m_TripMtx[$i][$m_Independent[$j]],2)*$coefficients[$k];
			$k++;
			
		}
		fwrite($fh, "T[".($i-1)."]\t");
		fwrite($fh, $m_trip[$i]."\t\n");
	}
	fwrite($fh, "\n\n\n");
}
if($m_RegrType == "Power")
{
	fwrite($fh, "Model Used : Power Regression \n");
	   	$k=1;
		fwrite($fh, "\nEquation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." * ");
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i <count($m_InDep)-1)
             {
                 fwrite($fh, "(".$m_TripMtx[1][$m_Independent[$i]].")^(".$ans[$k].") * ");
             }
             else
             {
                fwrite($fh, "(".$m_TripMtx[1][$m_Independent[$i]].")^(".$ans[$k].") ");
             }
             $k++;
      	}
      	fwrite($fh, "\n\n\n");
        
	
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			//echo ($coefficients[$k])."^".$m_TripMtx[$i][$m_Independent[$j]]." =  ".pow($coefficients[$k],$m_TripMtx[$i][$m_Independent[$j]])."<br>";
			$m_trip[$i]=$m_trip[$i]*(pow($m_TripMtx[$i][$m_Independent[$j]],$coefficients[$k]));
			$k++;
		}
		fwrite($fh, "T[".($i-1)."]\t");
		fwrite($fh, $m_trip[$i]."\t\n");
	}
	fwrite($fh, "\n\n\n");	
	
}
if($m_RegrType == "Exponential")
{
		fwrite($fh, "Model Used : Exponential Regression \n");
	   	$k=1;
		fwrite($fh, "\nEquation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." * ");
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
                 fwrite($fh, "exp((".$ans[$k].")* ".$m_TripMtx[1][$m_InDep[$i]].") * ");
             }
             elseif($i <= count($m_InDep)-2)
             {
                  fwrite($fh, "((".$ans[$k].")*".$m_TripMtx[1][$m_InDep[$i]].") * ");
             }
             else
             {
                  fwrite($fh, "((".$ans[$k].")*".$m_TripMtx[1][$m_InDep[$i]].") ");
             }
             $k++;
      	}
      	fwrite($fh, "\n\n\n");
        
	
	
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		$m_trip[$i]."<br>";
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			
			//echo exp($coefficients[$k])."*".$m_TripMtx[$i][$m_Independent[$j]]." =  ".exp($coefficients[$k])*$m_TripMtx[$i][$m_Independent[$j]]."<br>";
			$m_trip[$i]=$m_trip[$i]*exp($coefficients[$k]*$m_TripMtx[$i][$m_Independent[$j]]);
			$k++;
		}
		fwrite($fh, "T[".($i-1)."]\t");
		fwrite($fh, $m_trip[$i]."\t\n");
	}
	fwrite($fh, "\n\n\n");	
	
}
if($m_RegrType == "Logarithmic")
{
		fwrite($fh, "Model Used : Logarithmic Regression \n");
	   	$k=1;
		fwrite($fh, "\nEquation: ".$m_TripMtx[1][$m_Dep]." = ".$ans[$k]." + ");
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
                fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             elseif($i <=count($m_InDep)-2)
             {
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].") + ");
             }
             else
             {
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_InDep[$i]].")");
             }
             $k++;
      	}
      	fwrite($fh, "\n\n\n");
        
	
	
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			//echo log($m_TripMtx[$i][$m_Independent[$j]])."*".$coefficients[$k]." =  ".log($m_TripMtx[$i][$m_Independent[$j]])*$coefficients[$k]."<br>";
			$m_trip[$i]=$m_trip[$i]+log($m_TripMtx[$i][$m_Independent[$j]])*$coefficients[$k];
			$k++;
		}
		fwrite($fh, "T[".($i-1)."]\t");
		fwrite($fh, $m_trip[$i]."\t\n");
	}
	fwrite($fh, "\n\n\n");	
	
}
		
	
	}

	fclose($fh);

	endif;
	
	
?> 

