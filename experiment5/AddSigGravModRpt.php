<?php

$UploadFile = $_SESSION['user'];
$folder = "../user/".$UploadFile."/Experiment5/";

	if(file_exists($folder."SigGravModReport.xls"))
		$fh = fopen($folder."SigGravModReport.xls", "a+") or die("can't open file");

//------------------------------ Reading Xls file ----------------------------------
$file_ext1= substr($m_CostFile, strripos($m_CostFile, '.'));
$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));
		
		
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

        for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        {        
            for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            {
                $m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                
               }                
        }
        
        // Destination File 
       
        $dataDestF = new Spreadsheet_Excel_Reader();
        $dataDestF->setOutputEncoding('CP1251');
        $dataDestF->read($folder.$m_DestFile);
        error_reporting(E_ALL ^ E_NOTICE);

        $m_TotalSum=0;
        for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        {
            for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               {
                $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                $m_TotalSum += $m_DestMtx[$i][$j];
               }
        }
        
}
//---------------------------------------------------------------------------------

//---------------------------- Reading csv file -----------------------------------

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
                	$m_TotalSum += $m_DestMtx[$i][$j];
            }
        }
        
//-----------------------------------------------------------------------------
}     


		if($m_FunctionsVal == "PowerFun")
         {
         	fwrite($fh, "Selected Impedence Functions : Power Function \n") ;
         }
         elseif ($m_FunctionsVal == "ExponentialFun")   
         {
         	fwrite($fh, "Selected Impedence Functions : Exponential Function \n") ;
         	
         }
         elseif ($m_FunctionsVal == "GammaFun")   
         {
         	fwrite($fh, "Selected Impedence Functions : Gamma Function \n") ;
         }
         elseif ($m_FunctionsVal == "LinearFun")   
         {
         	fwrite($fh, "Selected Impedence Functions : Linear Function \n") ;
         }                   
               
    if($m_FunctionsVal == "PowerFun")
    {
    	// Calculation for Power Function	
    	
        	$m_txtBeta = $_POST['txtBeta'];
       
        	fwrite($fh, "Impedance Matrix Calculations Fij \n");
        	fwrite($fh, "Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
            	fwrite($fh, $i."\t");
            }           
            fwrite($fh, " \n");
            for ($i = 1; $i <= $n; $i++)
            {
            	fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {                
                    $ImpCost[$i][$j] = pow($m_BaseMtx[$i][$j],$m_txtBeta);
                    fwrite($fh, round($ImpCost[$i][$j],4)."\t");        
                }
                fwrite($fh, " \n");
            }            
            fwrite($fh, " \n \n \n");
       
    }
    elseif($m_FunctionsVal == "ExponentialFun")
    {
       // Calculation for Exponential Function	
       
    		$m_txtBeta = $_POST['txtBeta'];
 
        	fwrite($fh, "Impedance Matrix Calculations Fij \n");
        	fwrite($fh, "Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
            	fwrite($fh, $i."\t");
            }               
            fwrite($fh, " \n");
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {                
                    $ImpCost[$i][$j] = exp(-(($m_txtBeta)*($m_BaseMtx[$i][$j])));
                    fwrite($fh, round($ImpCost[$i][$j],4)."\t");           
                }
               fwrite($fh, " \n");
            }            
            
        fwrite($fh, " \n \n \n");      
         
    }    
    elseif($m_FunctionsVal == "GammaFun")
    {
        // Calculation for Gamma Function	
        
    		$m_txtBeta1 = $_POST['txtBeta1'];
        	$m_txtBeta2 = $_POST['txtBeta2'];
     
        	fwrite($fh, "Impedance Matrix Calculations Fij \n");
        	fwrite($fh, "Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
            	fwrite($fh, $i."\t");
            }               
            fwrite($fh, " \n");
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {                
                    $ImpCost[$i][$j] = ((exp(-($m_txtBeta1)*($m_BaseMtx[$i][$j]))) * (pow($m_BaseMtx[$i][$j],-($m_txtBeta2))));
                    fwrite($fh, round($ImpCost[$i][$j],4)."\t");            
                }
               fwrite($fh, " \n");
            }            
            
        fwrite($fh, " \n \n \n");      
            
      
    }
    elseif($m_FunctionsVal == "LinearFun")
    {
    	// Calculation for Linear Function	
    	
        $m_txtBeta1 = $_POST['txtBeta1'];
        $m_txtBeta2 = $_POST['txtBeta2'];
        
        	fwrite($fh, "Impedance Matrix Calculations Fij \n");
        	fwrite($fh, "Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
            	fwrite($fh, $i."\t");
            }               
            fwrite($fh, " \n");
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {                
                    $ImpCost[$i][$j] = ($m_txtBeta1 + ($m_txtBeta2 * $m_BaseMtx[$i][$j]));
                    fwrite($fh, round($ImpCost[$i][$j],4)."\t");            
                }
               fwrite($fh, " \n");
            }            
            
        fwrite($fh, " \n \n \n");      
            
    }
      
    if($m_MethodVal == "SinglyOrigin")
    {         
        	// Calculation for Singly Constrained Gravity Model (Origin) 
        	fwrite($fh, " Singly Constrained Gravity Model (Origin) \n \n");
    		fwrite($fh, " Dij*Fij \n Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i."\t");
            }           
            fwrite($fh, " Summation of Dj*Fij \n");
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                $sumR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $DF[$i][$j] = $m_DestMtx[1][$j] * $ImpCost[$i][$j];         
                    $sumR[$i] += $DF[$i][$j];  
                    fwrite($fh, round($DF[$i][$j],4)."\t");
                }    
                fwrite($fh,round($sumR[$i],4)."\t \n"); 
            }
            fwrite($fh, " \n \n \n");     
              
            fwrite($fh, " Interaction Probabilities Pr[ij] \n Zone \t"); 
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i."\t");
            } 
            fwrite($fh, " \n");    
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $PR[$i][$j] = $DF[$i][$j] / $sumR[$i]; 
                    fwrite($fh, round($PR[$i][$j],4)."\t");             
                }             
                fwrite($fh, " \n");
            }
            fwrite($fh, " \n \n \n");   
            

            fwrite($fh, " Final Result  \n O-D Matrix T(ij) \n Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i."\t");
            }        
            fwrite($fh, " Summation of Dj*Fij  \t Future year Origins Total \t \n");   
            for ($i = 1; $i <= $n; $i++)
            {
               fwrite($fh, $i."\t");
                $sumTR[$i]=0;
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $T[$i][$j] = $m_OriginMtx[1][$i] * $PR[$i][$j];      
                    $sumTR[$i] += $T[$i][$j];   
                    fwrite($fh, round($T[$i][$j],4)."\t");
                }    
                fwrite($fh, $sumTR[$i]."\t".$m_OriginMtx[1][$i]."\t \n");
            }     
             fwrite($fh, " \n \n \n");
        }
       
        elseif($m_MethodVal == "SinglyDest")
        {
        	// Calculation for Singly Constrained Gravity Model (Destination) 	
        	fwrite($fh, " Singly Constrained Gravity Model (Origin) \n \n");
        	fwrite($fh, " Oi*Fij  \n Zone \t");
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i."\t");
            }

            fwrite($fh, "\n");
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {             
                    $OF[$i][$j] = $m_OriginMtx[1][$i] * $ImpCost[$i][$j];
                    fwrite($fh, round($OF[$i][$j],4)."\t");  
                }                     
                fwrite($fh, "\n");
            }
            fwrite($fh, " Summation of Oi*Fij \t");
            for ($j = 1; $j <= $n; $j++)
            {                 
                $sumC[$j]=0;
                for ($i = 1; $i <= $n; $i++)
                {   
                    $sumC[$j] += $OF[$i][$j];                      
                }    
                fwrite($fh, round($sumC[$j],4)."\t");                  
            }
            fwrite($fh, "\n");
            fwrite($fh, "\n\n");      
   
            fwrite($fh, "Interaction Probabilities Pr[ij] \n Zone\t");
            for($i = 1; $i <= $n; $i++)
            {
            	 fwrite($fh, $i."\t");
            }           
            fwrite($fh, "\n");
            for ($i = 1; $i <= $n; $i++)
            {
                fwrite($fh, $i."\t");
                for ($j = 1; $j <= $n; $j++)
                {                 
                    $PR[$i][$j] = $OF[$j][$i] / $sumC[$i];
                    fwrite($fh, round($PR[$i][$j],4)."\t");                 
                }                     
                fwrite($fh, "\n");
            }
            fwrite($fh, "\n \n \n");   
            

        	fwrite($fh, "Final Result \n  O-D Matrix T[ij] \n Zone \b");
            for($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i."\t");
            }           
            fwrite($fh, "\n");
            for ($i = 1; $i <= $n; $i++)
            {
                 fwrite($fh, $i."\t");                
                for ($j = 1; $j <= $n; $j++)
                {     
                     $T[$i][$j] = $m_DestMtx[1][$i] * $PR[$i][$j];  
                     fwrite($fh, round($T[$i][$j],4)."\t");                
                }                      
                fwrite($fh, "\n");
            }
        
            fwrite($fh, "Summation of Oi*Fij \t"); 
            for ($j = 1; $j <= $n; $j++)
            {
                $sumTC[$j]=0;   
                for ($i = 1; $i <= $n; $i++)
                {
                    $sumTC[$j] += $T[$j][$i];                  
                }
                fwrite($fh, round($sumTC[$j],4)."\t");   
            }     
            fwrite($fh, "\n");    
            
            fwrite($fh, "Future year Destinations Total \t");  
           	for ($i = 1; $i <= $n; $i++)
           	{
           		fwrite($fh, $m_DestMtx[1][$i]."\t");    
            }     
            fwrite($fh, "\n");
                  
            fwrite($fh, "\n \n \n");           
        } 
        fclose($fh);
                          
?>
