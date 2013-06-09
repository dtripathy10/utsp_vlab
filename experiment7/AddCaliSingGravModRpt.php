<?php

if(file_exists($folder."CaliSingGravModReport.xls"))
		$fh = fopen($folder."CaliSingGravModReport.xls", "a+") or die("can't open file");

		
		
$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_TripFile, strripos($m_TripFile, '.'));
		
		

    if($m_MethodVal == "SinglyOrigin")
    {

        fwrite($fh,"Singly Constrained Gravity Model (Origin) \n \n");

    }
    elseif($m_MethodVal == "SinglyDest")
    {
        fwrite($fh,"Singly Constrained Gravity Model (Destination) \n \n");
    }    

$b=array();
//---------------------- Reading Xls file -----------------------------------------

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

	for ($i = 1; $i <= $dataCostF->sheets[0]['numRows']; $i++)
	{
	    for ($j = 1; $j <= $dataCostF->sheets[0]['numCols']; $j++)
	    {        
	        $m_CostMtx[$i][$j]=$dataCostF->sheets[0]['cells'][$i][$j];
	    }     
	}
	// Trip File
	
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');
        //$dataTripF->read('base_matrix.xls');
        $dataTripF->read($folder.$m_TripFile);
        error_reporting(E_ALL ^ E_NOTICE);
 
        for ($i = 1; $i <= $dataTripF->sheets[0]['numRows']; $i++)
        {    
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $dataTripF->sheets[0]['numCols']; $j++)
            {
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
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
    

        for ($i = 1; $i <= $n; $i++)
        {    
            $OriginSum[$i]=0;
            for ($j = 1; $j <= $nCol; $j++)
            {
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
		if($m_FunctionsVal == "PowerFun")
         {
         	fwrite($fh, "Selected Impedence Functions : Power Function \n") ;
         }
         elseif ($m_FunctionsVal == "ExponentialFun")   
         {
         	fwrite($fh, "Selected Impedence Functions : Exponential Function \n") ;
         	
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
                                     $ImpCost[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));
                               }
                      }                 
                }    
   
                if($m_MethodVal == "SinglyOrigin")
                {
                	//Origin Constrained 
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
                 	//Destination Constrained 
                 
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
                       $ImpCost[$i][$j] = exp(-(($bt)*($m_CostMtx[$i][$j])));                   
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
        	//Origin Constrained 
        	
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
           		
           		//Destination Constrained 
           		
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
          
        
        
        fwrite($fh, " Trip Matrix with respect to Optimal Beta Value (Minimum SSE) \n Zone \t") ;  
       for($i = 1; $i <= $n; $i++)
       {
       		 fwrite($fh, $i." \t") ; 
       }         
       fwrite($fh, " \n") ; 
          
       for ($i = 1; $i <= $n; $i++)
       {
       	   fwrite($fh, $i." \t") ; 
           for ($j = 1; $j <= $n; $j++)
           {              
           		fwrite($fh, (int)$tijk[$i][$j]." \t") ;          
           }
           fwrite($fh, " \n") ;
        }   
        fwrite($fh, " \n \n \n") ;
       
        fwrite($fh," Minimum Residual = ".$res_min." \n") ;
        fwrite($fh," Optimal Beta = ".$b_opt."  \n\n\n") ;
                  
        fwrite($fh," Target Oi \t Modelled Oi \t Target Dj \t Modelled Dj \n") ;
        for ($i = 1; $i <= $n; $i++)
        {
        	   fwrite($fh,$OriginSum[$i]." \t".$sumTR[$i]." \t ".$Destsum[$i]." \t".$sumTC[$i]." \n") ;
        }   
        fwrite($fh, " \n \n \n") ;
        
        
       fwrite($fh, " Beta \t Residual SSE \n") ;
       for ($i = 1; $i <= $nbt; $i++)
       {
       		  fwrite($fh, $b[$i]."\t".$res[$i]." \n") ;
       }   
       fwrite($fh, " \n \n \n") ;
 
?>
