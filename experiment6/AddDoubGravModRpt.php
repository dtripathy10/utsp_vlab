<?php
	if(file_exists($folder."DoubGravModReport.xls"))
		$fh = fopen($folder."DoubGravModReport.xls", "a+") or die("can't open file");
		

$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));
//----------------------- Reading Xls file -------------------------------------
if($file_ext1 == '.xls' && $file_ext2 == '.xls' && $file_ext3 == '.xls')
{

	// Cost File

	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_CostFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zons
	$n=$dataBaseF->sheets[0]['numRows'];


	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{      
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];    
    	}
	}

      // Origin File
      
        $dataOriginF = new Spreadsheet_Excel_Reader();
        $dataOriginF->setOutputEncoding('CP1251');
        //$dataOriginF->read('base_matrix.xls');
        $dataOriginF->read($folder.$m_OriginFile);
        error_reporting(E_ALL ^ E_NOTICE);

        //$m_TotalSum=0;
        for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        {       
            for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            {
               $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
            }   
             $err[$i] = 99;          
        }
       
		 // Destination File
      
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        //$dataDestF->read('base_matrix.xls');
        $dataDestF->read($folder.$m_DestFile);
        error_reporting(E_ALL ^ E_NOTICE);

       
        $m_TotalSum=0;
        for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        {
            for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               {
                   $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                   $djk[$j] = $m_DestMtx[$i][$j];               
                   $m_TotalSum += $m_DestMtx[$i][$j];
            }
           
        }
        
        
}
//---------------------------------------------------------------------------------

//---------------------------- Reading csv file ---------------------------------

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



	for ($i = 1; $i <= $n; $i++)
	{
   		
    	for ($j = 1; $j <= $nCol; $j++)
    	{            
        	$m_BaseMtx[$i][$j];    
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

        for ($i = 1; $i <= $OriRow; $i++)
        {    
               
               $err[$i] = 99;          
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


       
        $m_TotalSum=0;
        for ($i = 1; $i <= $DestRow; $i++)
        {
            for ($j = 1; $j <= $nCol; $j++)
               {
                   $djk[$j] = $m_DestMtx[$i][$j];               
                   $m_TotalSum += $m_DestMtx[$i][$j];
            }
        }
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
              
	if($m_FunctionsVal == "PowerFun")
    {
    	// Calculation for Power Function
    	
         $m_txtBeta = $_POST['txtBeta'];
                  
    	if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}
		fwrite($fh, "Impedance Function used : Power function \n");
		
		fwrite($fh, "Impedance Matrix Calculations Fij \n Zone \t");
        
        for($i = 1; $i <= $n; $i++)
        {
            	fwrite($fh, $i." \t");
        } 
        fwrite($fh," \n");  
        for ($i = 1; $i <= $n; $i++)
        {
                fwrite($fh, $i." \t");
                for ($j = 1; $j <= $n; $j++)
                {               
                    $ImpCost[$i][$j] = pow($m_BaseMtx[$i][$j],$m_txtBeta);
                    fwrite($fh, round($ImpCost[$i][$j],4)." \t");         
                }
                fwrite($fh," \n"); 
        }           
        fwrite($fh," \n \n");
        
    }
    elseif($m_FunctionsVal == "ExponentialFun")
    {
    	// Calculation for Exponential Function	
    	
       $m_txtBeta = $_POST['txtBeta'];
       
        if(empty($m_txtBeta))
		{
			$m_txtBeta = $_POST['txtBeta'];
		}
		fwrite($fh,"Impedance Function used : Exponential function \n");
		fwrite($fh, "Impedance Matrix Calculations Fij \n Zone \t");
        for($i = 1; $i <= $n; $i++)
        {
                 fwrite($fh, $i." \t");
        }          
        fwrite($fh," \n");
        for ($i = 1; $i <= $n; $i++)
        {
                fwrite($fh, $i." \t");
                for ($j = 1; $j <= $n; $j++)
                {               
                    $ImpCost[$i][$j] = exp(-(($m_txtBeta)*($m_BaseMtx[$i][$j])));
                    fwrite($fh, round($ImpCost[$i][$j],4)." \t");       
                }
                fwrite($fh," \n");
            }           
           
        fwrite($fh," \n \n");     
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
		fwrite($fh,"Impedance Function used : Gamma function \n");
		fwrite($fh, "Impedance Matrix Calculations Fij \n Zone \t");
        for($i = 1; $i <= $n; $i++)
        {
                 fwrite($fh, $i." \t");
        }          
        fwrite($fh," \n");
        for ($i = 1; $i <= $n; $i++)
        {
                fwrite($fh, $i." \t");
                for ($j = 1; $j <= $n; $j++)
                {
                    $ImpCost[$i][$j] = ((exp(-($m_txtBeta1)*($m_BaseMtx[$i][$j]))) * (pow($m_BaseMtx[$i][$j],-($m_txtBeta2))));
                    fwrite($fh,round($ImpCost[$i][$j],4)." \t");           
                }
                fwrite($fh," \n");
            }           
           	fwrite($fh," \n \n");  
       
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
		fwrite($fh,"Impedance Function used : Linear function \n");
		fwrite($fh, "Impedance Matrix Calculations Fij \n Zone \t");	
        for($i = 1; $i <= $n; $i++)
        {
                 fwrite($fh, $i." \t");
        }          
        fwrite($fh," \n");
        for ($i = 1; $i <= $n; $i++)
        {
                fwrite($fh, $i." \t");
                for ($j = 1; $j <= $n; $j++)
                {               
                    
                    $ImpCost[$i][$j] = ($m_txtBeta1 + ($m_txtBeta2 * $m_BaseMtx[$i][$j]));
                    fwrite($fh, round($ImpCost[$i][$j],4)." \t");      
                }
                fwrite($fh," \n");
            }           
           	fwrite($fh,"\n \n");
            
                     
    }
    fwrite($fh,"Selected Accuracy : ".$m_AccuracyVal." Cell  \n");
    fwrite($fh,"Entered Accuracy Level (i.e., percentage of error): ".$m_txtAccuracy." % \n");
 
$itr = 0;   
$erra=99;
$m_a=0;
for ($i = 1; $i <= $n; $i++)
{
	$Bj[$i]=1;
		$errOri[$i]=99;
		$errDest[$i]=99;

}
//-----------------------------------------------------------------------------------------------------------


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
            $itr++;
            fwrite($fh, " \n");
			fwrite($fh, "Iteration # ".$itr." \t\n");
           	
			
			
			
			for ($i = 1; $i <= $n; $i++)
            {
                $sumBjDjFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$BjDjFcij[$i][$j] = $Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                    $sumBjDjFcij[$i] += $BjDjFcij[$i][$j]; 
                   
                }   
                $Ai[$i]=1/($sumBjDjFcij[$i]);
            }
            
     		fwrite($fh, "i \t");
     		fwrite($fh, "j \t");
     		fwrite($fh, "Bj \t");
     		fwrite($fh, "Dj \t");
     		fwrite($fh, "F(Cij) \t");
     		fwrite($fh, "BjDjF(Cij) \t");
     		fwrite($fh, "SumBjDjF(Cij) \t");
     		fwrite($fh, "Ai \t \n");
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		            
     				fwrite($fh, $i." \t");
     				fwrite($fh, $j." \t");
     				fwrite($fh, $Bj[$i]." \t");
     				fwrite($fh, $m_DestMtx[1][$j]." \t");
     				fwrite($fh, $ImpCost[$i][$j]." \t");
     				fwrite($fh, $BjDjFcij[$i][$j] ."\t");
     				fwrite($fh, $sumBjDjFcij[$i]."\t");
     				fwrite($fh, $Ai[$i]."\t \n");
            	}
            	
            }
           fwrite($fh, " \n");
           fwrite($fh, " \n");
			
			
			
			for ($i = 1; $i <= $n; $i++)
            {
                $sumAiOiFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$AiOiFcij[$i][$j] = $Ai[$j]*$m_OriginMtx[1][$j]*$ImpCost[$i][$j];
                    $sumAiOiFcij[$i] += $AiOiFcij[$i][$j]; 
                   
                }   
                $Bj[$i]=1/($sumAiOiFcij[$i]);
            }
            fwrite($fh, "i \t");
     		fwrite($fh, "j \t");
     		fwrite($fh, "Ai \t");
     		fwrite($fh, "Oi \t");
     		fwrite($fh, "F(Cij) \t");
     		fwrite($fh, "AiOiF(Cij) \t");
     		fwrite($fh, "SumAiOiF(Cij) \t");
     		fwrite($fh, "Bj \t \n");
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		fwrite($fh, $i." \t");
     				fwrite($fh, $j." \t");
     				fwrite($fh, $Ai[$j]." \t");
     				fwrite($fh, $m_OriginMtx[1][$j]." \t");
     				fwrite($fh, $ImpCost[$i][$j]." \t");
     				fwrite($fh, $AiOiFcij[$i][$j] ."\t");
     				fwrite($fh, $sumAiOiFcij[$i]."\t");
     				fwrite($fh, $Bj[$i]."\t \n");
            	}
            	
            }
			fwrite($fh, " \n");
            fwrite($fh, " \n");
            fwrite($fh, " \n");
            
			for ($i = 1; $i <= $n; $i++)
            {
                $sumOi[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$T[$i][$j] = $Ai[$i]*$m_OriginMtx[1][$i]*$Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
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
            

           
           	fwrite($fh,"OD Matrix  Tij \n Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i." \t");
            }          
            fwrite($fh, "Oi \t");    
            fwrite($fh, "Oi' \t \n");      
            
            
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i." \t");
                for ($j = 1; $j <= $n; $j++)
                {                
                    fwrite($fh, round($T[$i][$j],4)." \t");  
                }   
                fwrite($fh,$m_OriginMtx[1][$i]." \t");
                fwrite($fh, $sumOi[$i]." \t \n");
            }
          	fwrite($fh,"Dj \t"); 
            for ($i = 1; $i <= $n; $i++)
            {
            	 fwrite($fh, $m_DestMtx[1][$i]."\t");
            }
            fwrite($fh," \n"); 
          	fwrite($fh,"Dj' \t"); 
            for ($i = 1; $i <= $n; $i++)
            {
            	 fwrite($fh, $sumDj[$i]."\t");
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
  }while($m_a==1  && $itr<$itrbrk);

 }

//-----------------------------------------------------------------------------------------------------------
 if(!empty($itrbrk))
 {
  do
  {    
     $m_a=0;
     if($m_AccuracyVal == "Individual")
     {
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
           if($erra > $m_txtAccuracy)
           {
                $m_a=1;
           }     
      }      
      if($m_a)
      {
            $itr++;

			
			
			for ($i = 1; $i <= $n; $i++)
            {
                $sumBjDjFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$BjDjFcij[$i][$j] = $Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
                    $sumBjDjFcij[$i] += $BjDjFcij[$i][$j]; 
                   
                }   
                $Ai[$i]=1/($sumBjDjFcij[$i]);
            }
            

			
			
			for ($i = 1; $i <= $n; $i++)
            {
                $sumAiOiFcij[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$AiOiFcij[$i][$j] = $Ai[$j]*$m_OriginMtx[1][$j]*$ImpCost[$i][$j];
                    $sumAiOiFcij[$i] += $AiOiFcij[$i][$j]; 
                   
                }   
                $Bj[$i]=1/($sumAiOiFcij[$i]);
            }

            
			for ($i = 1; $i <= $n; $i++)
            {
                $sumOi[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                
                	$T[$i][$j] = $Ai[$i]*$m_OriginMtx[1][$i]*$Bj[$j]*$m_DestMtx[1][$j]*$ImpCost[$i][$j];
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
  
 }
        if($itr < $itrbrk)
        {
        		fwrite($fh, " \n");
        		fwrite($fh, " Final Result \n\n");
        }
        else
        {
        		fwrite($fh, " \n");
        		fwrite($fh, " Iteration #".$itr."\n \n");
        }
          

     		fwrite($fh, "i \t");
     		fwrite($fh, "j \t");
     		fwrite($fh, "Bj \t");
     		fwrite($fh, "Dj \t");
     		fwrite($fh, "F(Cij) \t");
     		fwrite($fh, "BjDjF(Cij) \t");
     		fwrite($fh, "SumBjDjF(Cij) \t");
     		fwrite($fh, "Ai \t \n");
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		            
     				fwrite($fh, $i." \t");
     				fwrite($fh, $j." \t");
     				fwrite($fh, $Bj[$i]." \t");
     				fwrite($fh, $m_DestMtx[1][$j]." \t");
     				fwrite($fh, $ImpCost[$i][$j]." \t");
     				fwrite($fh, $BjDjFcij[$i][$j] ."\t");
     				fwrite($fh, $sumBjDjFcij[$i]."\t");
     				fwrite($fh, $Ai[$i]."\t \n");
            	}
            	
            }
           fwrite($fh, " \n");
           fwrite($fh, " \n");

            fwrite($fh, "i \t");
     		fwrite($fh, "j \t");
     		fwrite($fh, "Ai \t");
     		fwrite($fh, "Oi \t");
     		fwrite($fh, "F(Cij) \t");
     		fwrite($fh, "AiOiF(Cij) \t");
     		fwrite($fh, "SumAiOiF(Cij) \t");
     		fwrite($fh, "Bj \t \n");
            for ($i = 1; $i <= $n; $i++)
            {
            	
            	for ($j = 1; $j <= $n; $j++)
            	{
            		fwrite($fh, $i." \t");
     				fwrite($fh, $j." \t");
     				fwrite($fh, $Ai[$j]." \t");
     				fwrite($fh, $m_OriginMtx[1][$j]." \t");
     				fwrite($fh, $ImpCost[$i][$j]." \t");
     				fwrite($fh, $AiOiFcij[$i][$j] ."\t");
     				fwrite($fh, $sumAiOiFcij[$i]."\t");
     				fwrite($fh, $Bj[$i]."\t \n");
            	}
            	
            }
			fwrite($fh, " \n");
            fwrite($fh, " \n");
            fwrite($fh, " \n");

           
           	fwrite($fh,"OD Matrix  Tij \n Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i." \t");
            }          
            fwrite($fh, "Oi \t ");    
            fwrite($fh, "Oi' \t \n");      
            
            
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i." \t");
                for ($j = 1; $j <= $n; $j++)
                {                
                    fwrite($fh, round($T[$i][$j],4)." \t");  
                }   
                fwrite($fh,$m_OriginMtx[1][$i]." \t");
                fwrite($fh, $sumOi[$i]." \t \n");
            }
          	fwrite($fh,"Dj \t"); 
            for ($i = 1; $i <= $n; $i++)
            {
            	 fwrite($fh, $m_DestMtx[1][$i]."\t");
            }
            fwrite($fh, " \n");
          	fwrite($fh,"Dj' \t"); 
            for ($i = 1; $i <= $n; $i++)
            {
            	 fwrite($fh, $sumDj[$i]."\t");
            }
 
           
         fwrite($fh," \n \n"); 
    
  		if($itr < $itrbrk)
        {
        	fwrite($fh, " \n");
        	//	fwrite($fh,"No. of Iteration taken to reach final result : ".$itr." \n\n");
        }
        else
        {
        		fwrite($fh, " \n");
        		//fwrite($fh,"Current Iteration # ".$itr." \n\n");
        }
 
?>							

