<?php

if(file_exists($folder."DataRegr.xls")):
		$fh = fopen($folder."DataRegr.xls", "a+") or die("can't open file");
		
	
$m_AnalysisVar = $_SESSION['AnalysisVar'];     

      
	if($m_AnalysisVar == "DataAna")
	{
		
		$m_DataChoiceVar = $_POST['DataChoiceVar'];
		
		if ($m_DataChoiceVar == "Correlation")
		{				
			
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
			fwrite($fh, "Descriptive Statistics \n") ;
            fwrite($fh, "\t Minimum \t Maximum \t Mean \t Standard Deviation \n") ;
         	           
            for ($i = 0; $i < $SelectCol; $i++)
            {
                  fwrite($fh, $m_TripMtx[1][$m_CorrDescVar[$i]]."\t") ;  
                  fwrite($fh, ($m_finalrow-1)."\t") ;
                  fwrite($fh, $min[$i]."\t") ;
                  fwrite($fh, $max[$i]."\t") ;
                  fwrite($fh, round($avg[$i],4)."\t") ;
                  fwrite($fh, round($deltaRoot[$i],4)."\t\n") ;
                  
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
                 fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i-count($m_InDep)]].")^2 + ");
             }
             else
             {
                fwrite($fh, "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i-count($m_InDep)]].")^2 ");
             }
             $k++;
      	}
      	fwrite($fh, "\n\n\n");
        
	
		$counted = count($m_InDep);
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
	}
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
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
        
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]*(pow($m_TripMtx[$i][$m_Independent[$j]],$coefficients[$k]));
			$k++;
		}
	}
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
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
        
	
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]*exp($coefficients[$k]*$m_TripMtx[$i][$m_Independent[$j]]);
			$k++;
		}

	}
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
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
        
	
	for ($i = 2; $i <= $nRow; $i++)
	{
		$m_trip[$i]=$coefficients[0];
		$k=1;
		for ($j = 0; $j <count($m_InDep); $j++)
		{
			$m_trip[$i]=$m_trip[$i]+log($m_TripMtx[$i][$m_Independent[$j]])*$coefficients[$k];
			$k++;
		}
	}
	fwrite($fh, "Trip for each zone(T[i])\t Number of Trips \n");
	for ($i = 2; $i <= $nRow; $i++)
	{
		fwrite($fh, "T[".($i-1)."]\t");
		fwrite($fh, $m_trip[$i]."\t\n");
	}
	fwrite($fh, "\n\n\n");	
	
}
		
	
	}

	fclose($fh);

	endif;
	
	
?> 

