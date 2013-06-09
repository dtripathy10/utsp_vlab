<?php


$file_ext1 = substr($m_BaseFile, strripos($m_BaseFile, '.'));
	
	
	if(file_exists($folder."GroFactReport.xls"))
	{
		$fh = fopen($folder."GroFactReport.xls", "a+") or die("can't open file");



//----------------------------------------------------------------------------------------------

    if($m_MethodVal == "UniformGFM")
    {
    		fwrite($fh, "Uniform Growth Factor Method  \n\n");

    }
    elseif($m_MethodVal == "SinglyGFM")
    {
        fwrite($fh, "Singly Constrained Growth Factor Method  \n\n");
    }
    elseif($m_MethodVal == "FratarGFM")
    {
        fwrite($fh, "Fratar Growth Factor Method  \n\n");
    }
    ?>
 
 
 
<?php


//-------------------------------Reading Xls file-------------------------------------------------
if($file_ext1 == '.xls')
{
	require_once '../phpExcelReader/Excel/reader.php';
	$dataBaseF = new Spreadsheet_Excel_Reader();
	$dataBaseF->setOutputEncoding('CP1251');
	$dataBaseF->read($folder.$m_BaseFile);
	error_reporting(E_ALL ^ E_NOTICE);

	//Number of Zones
	$nRow=$dataBaseF->sheets[0]['numRows'];
	$nCol=$dataBaseF->sheets[0]['numCols'];

	for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
	{
   		$sumR[$i]=0;
    	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    	{       
        	$sumR[$i] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$dataBaseF->sheets[0]['cells'][$i][$j];
    	}
	}
	for ($j = 1; $j <= $dataBaseF->sheets[0]['numCols']; $j++)
    {
        $sumC[$j]=0;
        for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        {
            $sumC[$j] += (double)$dataBaseF->sheets[0]['cells'][$i][$j];                     
        }
        $m_TotalBaseSum += $sumC[$j];
    }     
}
//-------------------------------------------------------------------------------
//-----------------------------Raeding csv file--------------------------------------------

elseif($file_ext1 == '.csv')
{
    $nCol = 0; 
	$nRow = 0;
	$name = $folder.$m_BaseFile;
    $file = fopen($name , "r");
    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) 
    {
    	$nCol = count($data);

    	for ($c=0; $c <$nCol; $c++)
    	{
    	   
        	$m_Base[$nRow][$c] = $data[$c];
        	
     	}
     	$nRow++;
    
    }
    for ($i = 0; $i < $nRow; $i++) 
    { 
         for ($j = 0; $j < $nCol; $j++)
         {
         		$m_BaseMtx[$i+1][$j+1] = $m_Base[$i][$j] ;      	
         }
    	
    }
    


	
	for ($i = 1; $i <= $nRow; $i++)
	{
    	$sumR[$i]=0;
    	for ($j = 1; $j <= $nCol; $j++)
    	{         
        	$sumR[$i] += (double)$m_BaseMtx[$i][$j];         
        	//echo $dataBaseF->sheets[0]['cells'][$i][$j];
        	$m_BaseMtx[$i][$j]=$m_BaseMtx[$i][$j];
    	}
	}
	
	for ($j = 1; $j <=$nCol; $j++)
	{
    	    $sumC[$j]=0;
    	    for ($i = 1; $i <= $nRow; $i++)
    	    {
        	    $sumC[$j] += (double)$m_BaseMtx[$i][$j];                     
        	}

    		$m_TotalBaseSum += $sumC[$j];
	}     
     
     
     
     
     
fclose($file);

} 
//-----------------------------------------------------------------------------------
?>
   
</tr>

</table>



<?php
if($m_MethodVal == "UniformGFM")
{
    $m_txtGrowth = $_POST['txtGrowth'];
   	fwrite($fh, "txtGrowth".$m_txtGrowth."\n");
   	fwrite($fh, "Uniform Growth Rate Matrix For Future Year \n");
   	fwrite($fh, "Zone \t");
    for ($i = 1; $i <= $nRow; $i++)
    {
    	fwrite($fh, $i."\t");
    }
    fwrite($fh, "Origin Total \n");
    for ($i = 1; $i <= $nRow; $i++)
    {   
        fwrite($fh, $i."\t");
        $SumUR[$i] = 0;
        for ($j = 1; $j <= $nRow; $j++)
        {     
                            
            //echo $m_BaseMtx[$i][$j]."</td><td>";
            //echo $GFOrigin[$i]."</td><td>";
            $UG[$i][$j] = $m_BaseMtx[$i][$j] * $m_txtGrowth;
            $SumUR[$i] += round($UG[$i][$j]);
            //echo "<td>".$m_BaseMtx[$i][$j]."*".$GFOrigin[$i]."=".$UGOrigin[$i][$j]."</td>";  
             fwrite($fh, round($UG[$i][$j])."\t");
        }
        fwrite($fh, round($SumUR[$i])."\t \n");
    }
    fwrite($fh, "Destination Total \t");  
    for ($j = 1; $j <= $nRow; $j++)
    {
        $sumUC[$j]=0;
        for ($i = 1; $i <= $nRow; $i++)
        {
            $sumUC[$j] += round($UG[$i][$j]);                    
        }
         fwrite($fh, round($sumUC[$j])." \t");    
    }     
     fwrite($fh, " \n"); 
    
}

elseif($m_MethodVal == "SinglyGFM")
{
    $m_ConstraintsVal = $_POST['ConstraintsVal'];

    if($m_ConstraintsVal=="SinglyOrigin")
    {
        $m_OriginFile = $_POST['OriginFile'];
        
        
        
        
//----------------------------------verifying the format of the file---------------------------



$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));


if(!($file_ext2 == '.csv' || $file_ext2 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------

 //------------------------------------------------xls file-------------------------------------       
        if($file_ext2 == '.xls')
		{ 
			require_once '../phpExcelReader/Excel/reader.php';
        	$dataOriginF = new Spreadsheet_Excel_Reader();
        	$dataOriginF->setOutputEncoding('CP1251');
        	//$dataOriginF->read('base_matrix.xls');
        	$dataOriginF->read($folder.$m_OriginFile);
        	error_reporting(E_ALL ^ E_NOTICE);
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $dataOriginF->sheets[0]['numRows']; $i++)
        	{          
            	for ($j = 1; $j <= $dataOriginF->sheets[0]['numCols']; $j++)
            	{
                  	//echo $dataOriginF->sheets[0]['cells'][$i][$j];
                	$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                	$m_TotalSum += $m_OriginMtx[$i][$j];
               }

           }
	 }
//-------------------------------------------------csv-----------------------------------
	 elseif($file_ext2 == '.csv')
     {

        
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
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	echo $m_OriginMtx[$i][$j];
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}               
            }
        }
//---------------------------------------------------------------------------------------  
        ?>
      
      
 		<?php 
 		fwrite($fh, "Growth Factor Calculations \n") ;
 		fwrite($fh, "Zone \t Future year Origin total \t Base year Origin total \t Growth Factor For Each Originating Zone \t \n") ;
       
        for ($j = 1; $j <= $nRow; $j++)
        {
        	fwrite($fh, $j."\t".$m_OriginMtx[1][$j]."\t".$sumR[$j]."\t") ; 
            $GFOrigin[$j] = $m_OriginMtx[1][$j] / $sumR[$j];
            fwrite($fh, round($GFOrigin[$j], 3)."\t \n") ;
        }                  
        
        fwrite($fh, "\n \n \n") ;
   
        fwrite($fh, "Singly Constrained Growth Factor Matrix For Future Year  \n") ;
        fwrite($fh, "Zone \t") ;
        for ($i = 1; $i <= $nRow; $i++)
        {
             fwrite($fh, $i." \t") ;
        }
         fwrite($fh, "Origins Total Future year \n") ;
        for ($i = 1; $i <= $nRow; $i++)
        {  
            $SumOR[$i]=0;     
            fwrite($fh, $i." \t") ;   
            for ($j = 1; $j <= $nRow; $j++)
            {                     
                $UGOrigin[$i][$j] = $m_BaseMtx[$i][$j] * $GFOrigin[$i];
                fwrite($fh, round($UGOrigin[$i][$j])." \t") ; 
                $SumOR[$i]+=round($UGOrigin[$i][$j]);                
              }
              fwrite($fh, $SumOR[$i]." \t") ;
              fwrite($fh, $m_OriginMtx[1][$i]." \t \n") ;
        }
        fwrite($fh, "Destinations Total Base year \t") ;
        for($i=1; $i <= $nRow; $i++)
        {        
            $SumOC[$i]=0;
              for($j=1; $j <= $nRow; $j++)
              {  
                   $SumOC[$i]+=round($UGOrigin[$j][$i]);
                   
              }
              fwrite($fh, round($SumOC[$i])." \t ") ;              
        }
        fwrite($fh, " \n \n \n") ;       
    }
    elseif ($m_ConstraintsVal=="SinglyDest")
    {
    	$m_DestFile = $_POST['DestFile'];
       
    	
//----------------------------------verifying the format of the file---------------------------


$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------
//------------------------------------------------xls file-------------------------------------       
        if($file_ext3 == '.xls')
		{     	
				require_once '../phpExcelReader/Excel/reader.php';
        		$dataDestF = new Spreadsheet_Excel_Reader();
        		$dataDestF->setOutputEncoding('CP1251');
        		//$dataDestF->read('base_matrix.xls');
        		$dataDestF->read($folder.$m_DestFile);
       			error_reporting(E_ALL ^ E_NOTICE);

       			fwrite($fh, "Destinations Total For Future Year \n Zone \t") ;
        		for ($i = 1; $i <= $dataBaseF->sheets[0]['numRows']; $i++)
        		{
        		    fwrite($fh, $i." \t") ; 
        		}
        		fwrite($fh, " \n"); 
        
        		$m_TotalSum=0;
        		for ($i = 1; $i <= $dataDestF->sheets[0]['numRows']; $i++)
        		{
        			fwrite($fh, " \t") ; 
            		for ($j = 1; $j <= $dataDestF->sheets[0]['numCols']; $j++)
               		{  
                   		//echo $dataDestF->sheets[0]['cells'][$i][$j];
                   		
                		 $m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                		fwrite($fh, $m_DestMtx[$i][$j]." \t") ; 
                		$m_TotalSum += $m_DestMtx[$i][$j];
            		}
            		fwrite($fh, " \n"); 
        		}
        		fwrite($fh, " \n \n \n");
		}
		//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext3 == '.csv')
		{ 
		
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
		
		
			fwrite($fh, " Destinations Total For Future Year  \n Zone \t");
        	for ($i = 1; $i <= $nCol; $i++)
        	{
        		fwrite($fh, $i."\t");
        	}
        	fwrite($fh, "\n");
        
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $DestRow; $i++)
        	{
        		fwrite($fh, "\t");
            	for ($j = 1; $j <= $nCol; $j++)
               	{ 
               		fwrite($fh, $m_DestMtx[$i][$j]."\t");
                	$m_TotalSum += $m_DestMtx[$i][$j];
                  	
            	}
           		fwrite($fh, "\n");  
        	}
        	fwrite($fh, "\n\n\n");
		
		}
//---------------------------------------------------------------------------------
		fwrite($fh, "Growth Factor Calculations \n");
		fwrite($fh, "Zone \t Base year Destination total \t Growth Factor For Destination Zone  \n");
        for ($j = 1; $j <= $nRow; $j++)
        {
        	fwrite($fh, $j."\t");     
        	fwrite($fh, $m_DestMtx[1][$j]."\t".$sumC[$j]."\t"); 
            $GFDest[$j] = $m_DestMtx[1][$j] / $sumC[$j];
            fwrite($fh, round($GFDest[$j], 3)."\n");
        }            
        fwrite($fh, "\n\n\n");        
 
			fwrite($fh, "Singly Constrained Growth Factor Matrix For Future Year\n Zone \t");
        	for ($i = 1; $i <= $nRow; $i++)
        	{
        			fwrite($fh, $i." \t");
        	}
        	fwrite($fh, $i." Origins Total Base year \t \n");
        
        	for ($i = 1; $i <= $nRow; $i++)
        	{   
           		$SumDR[$i]=0;  
           		fwrite($fh, $i." \t"); 
            	for ($j = 1; $j <= $nRow; $j++)
            	{    
                	$UGDest[$i][$j] = $m_BaseMtx[$i][$j] * $GFDest[$j];
                	$SumDR[$i] += round($UGDest[$i][$j]); 
                	fwrite($fh, round($UGDest[$i][$j])." \t");    
              	}   
              	fwrite($fh, $SumDR[$i]." \t \n");   
        	}
        
        	fwrite($fh, "Destinations Total Base year \t ");
        	for($i=1; $i <= $nRow; $i++)
        	{
            	$SumDC[$i]=0;
              	for($j=1; $j <= $nRow; $j++)
              	{  
                   	$SumDC[$i] += round($UGDest[$j][$i]);
                   
              	}
              	fwrite($fh, round($SumDC[$i])." \t ");             
        	}
         	fwrite($fh, " \n ");
         	fwrite($fh, " Destination Total Future year \t ");     
        	for($i=1; $i <= $nRow; $i++)
        	{
        		fwrite($fh, $m_DestMtx[1][$i]."\t "); 
        	}
        	fwrite($fh, " \n \n \n");   
    	}
}

elseif($m_MethodVal == "FratarGFM")
    {
    	        
    	
			$m_AccuracyVal = $_POST['AccuracyVal'];
		
			$m_txtAccuracy = $_POST['txtAccuracy'];
		
			$m_OriginFile = $_POST['OriginFile'];
		
			$m_DestFile = $_POST['DestFile'];
		
			$m_numItr = $_POST['numItr'];
       
	
		$itrbrk=$_POST['Itrbrk'];
		
		if(empty($itrbrk))
		{
		    $itrbrk=$_POST['Itrbrk'];
		    echo $itrbrk;
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
		
		
		
//----------------------------------verifying the format of the file---------------------------



$file_ext2= substr($m_OriginFile, strripos($m_OriginFile, '.'));
$file_ext3= substr($m_DestFile, strripos($m_DestFile, '.'));

if(!($file_ext2 == '.csv' || $file_ext2 == '.xls') && !($file_ext3 == '.csv' || $file_ext3 == '.xls'))
{
?>
<script language="javascript">

    alert("invalid file format");
    location="GroFactMod.php";
    
</script>

<?php 

}
//----------------------------------------------------------------------------------------------
//------------------------------------------------xls file-------------------------------------       
        if($file_ext2 == '.xls' && $file_ext3 == '.xls')
		{  
				require_once '../phpExcelReader/Excel/reader.php';
				$dataOriginF = new Spreadsheet_Excel_Reader();
        		$dataOriginF->setOutputEncoding('CP1251');
        		//$dataOriginF->read('base_matrix.xls');
        		$dataOriginF->read($folder.$m_OriginFile);
        		error_reporting(E_ALL ^ E_NOTICE);
        		
        		        	
        	
        		$OriginCol = $dataOriginF->sheets[0]['numCols'];
        		$OriginRow = $dataOriginF->sheets[0]['numRows'];
   
   
        		$m_TotalSum=0;
        		for ($i = 1; $i <= $OriginRow; $i++)
        		{
            
            		for ($j = 1; $j <= $OriginCol; $j++)
            		{
                		$m_OriginMtx[$i][$j]=$dataOriginF->sheets[0]['cells'][$i][$j];
                		
                		$m_TotalSum += $m_OriginMtx[$i][$j];
                		
               		}

                 
        		}
       
        		$dataDestF = new Spreadsheet_Excel_Reader();
        		$dataDestF->setOutputEncoding('CP1251');
        		$dataDestF->read($folder.$m_DestFile);
        		error_reporting(E_ALL ^ E_NOTICE);
        		
        		$DestinationCol = $dataDestF->sheets[0]['numCols'];
				$DestinationRow = $dataDestF->sheets[0]['numRows'];

        		$m_TotalSum=0;
       			 for ($i = 1; $i <= $DestinationRow; $i++)
       			 {
            
            			for ($j = 1; $j <= $DestinationCol; $j++)
               			{
                			$m_DestMtx[$i][$j]=$dataDestF->sheets[0]['cells'][$i][$j];
                			
                			$m_TotalSum += $m_DestMtx[$i][$j]; 
            			}
        		} 

		}

//------------------------------------------------csv file-------------------------------------       
        elseif($file_ext2 == '.csv' && $file_ext3 == '.csv')
		{

		           
    		$nCol = 0; 
			$OriRow = 0;
			$name = $Ufolder.$m_OriginFile;
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
        	$m_TotalSum=0;
        	for ($i = 1; $i <= $OriRow; $i++)
        	{      
        		    for ($j = 1; $j <= $nCol; $j++)
        	    	{
        	        	$m_TotalSum += $m_OriginMtx[$i][$j];
               		}              

        	
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

		
		
		}	
		}		
 		fwrite($fh, " Selected Accuracy : ".$m_AccuracyVal." Cell \n");
 		fwrite($fh, "Entered Accuracy Level (i.e., percentage of error): ".$m_txtAccuracy." Cell \n");
       
   
        $TotalBaseSumR=0;
        for ($i = 1; $i <= $nRow; $i++)
        {
            $sumRD[$i]=$sumR[$i];
            $sumCD[$i]=$sumC[$i];
            $TotalFutureR +=$m_OriginMtx[1][$i];
            $TotalBaseSumR+=$sumR[$i];          
        }
       
        $itr=0;
       
	
           
        do
        {  
           if($m_AccuracyVal=="Individual")
            {
            	for ($j = 1; $j <= $nRow; $j++)
            	{
                 	$m_a=(((($m_OriginMtx[1][$j]-$sumRD[$j])*100)/$sumRD[$j])> $m_txtAccuracy || ((($m_DestMtx[1][$j]-$sumCD[$j])*100)/$sumCD[$j])> $m_txtAccuracy);
            	}
            }
            else
            {                        
                 $m_a= ((($TotalFutureR-$TotalBaseSumR)*100)/$TotalBaseSumR)>$m_txtAccuracy;               
            }       
            if($m_a)
            {            	           	
                $itr++;
                fwrite($fh, "Iteration # ".$itr." \n \n");		                            

                for ($k = 1; $k <= $nRow; $k++)
                {
                    $sumRD[$k]=0;                
                     for ($l = 1; $l <= $nRow; $l++)
                     {                         
                        $sumRD[$k] += $m_BaseMtx[$k][$l];            
                     }          
                   }
          
                for ($l = 1; $l <= $nRow; $l++)
                {
                       $a[$l]=($m_OriginMtx[1][$l] / $sumRD[$l]);                     
                }   
        
                fwrite($fh, "Fratar Growth Factor Matrix For Future Year \n ");
                fwrite($fh, "Zone \t");	
                for ($i = 1; $i <= $nRow; $i++)
                {
                	fwrite($fh, $i." \t");
                }      
                fwrite($fh, "Current Origins Total \t Origins Total Future year \t \n");	  
				
                for ($k = 1; $k <= $nRow; $k++)
                {          
                	fwrite($fh, $k." \t");

                    $SumDobR1[$k]=0;  
                    
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           $s[$k][$l] = $m_BaseMtx[$k][$l] * $a[$k];
                           $SumDobR1[$k] += $s[$k][$l];  
                           fwrite($fh, round($s[$k][$l],3)." \t");
                    }   
                    fwrite($fh, round($SumDobR1[$k],3)." \t");
                    fwrite($fh, $m_OriginMtx[1][$k]." \t \n ");
                }
               
                
                 fwrite($fh, "Current Destinations Total \n ");	
                
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC1[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC1[$k] += $s[$l][$k];;                   
                      }
                      fwrite($fh, round($SumDobC1[$k],3)." \t");       
                }
				fwrite($fh, "\n ");	
              	fwrite($fh, "Destinations Total Future year \t ");
                for ($l = 1; $l<= $nRow; $l++)
                {
                  		fwrite($fh, $m_DestMtx[1][$l]." \t");
               	}
                fwrite($fh, "\n \n \n ");
               
                for ($l = 1; $l<= $nRow; $l++)
                {
                    $sumCD[$l]=0;
                    for ($k = 1; $k <= $nRow; $k++)
                    {
                        $sumCD[$l] += $s[$k][$l];                    
                    } 
                }

                for ($l = 1; $l <= $nRow; $l++)
                {
                      $b[$l]=$m_DestMtx[1][$l] / $sumCD[$l];                     
                }              
				fwrite($fh, "Fratar Growth Factor Matrix For Future Year \n  Zone \t ");
                for ($i = 1; $i <= $nRow; $i++)
                {
                	fwrite($fh, $i." \t");
                }      
                fwrite($fh, "Current Origins Total \t Origins Total Future year \t \n");                
                for ($l = 1; $l <= $nRow; $l++)
                {
                	fwrite($fh, $l." \t");
                    $SumDobR2[$l]=0; 
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        $t[$k][$l] = $s[$l][$k] * $b[$k];  
                        $SumDobR2[$l] += $t[$k][$l];      
                        fwrite($fh, round($t[$k][$l],3)." \t");                    
                    }  
                    fwrite($fh, round($SumDobR2[$l],3)." \t" .$m_OriginMtx[1][$l]."\t \n");  
                            
                }
                fwrite($fh, "Current Destinations Total \t ");
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC2[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC2[$k] += $t[$k][$l];;                   
                      }
                       fwrite($fh, round($SumDobC2[$k],3)." \t");   
                }
                fwrite($fh," \n ");  
                fwrite($fh,"Destinations Total Future year \t "); 
                for ($l = 1; $l<= $nRow; $l++)
                {
                	fwrite($fh, $m_DestMtx[1][$l]." \t"); 
                }
                fwrite($fh," \n  \n \n");   
                
                
                $TotalBaseSumC=0;
                $TotalBaseSumR=0;
                $TotalFutureC=0;
                $TotalFutureR=0;
                for ($k = 1; $k <= $nRow; $k++)
                {
                     $TotalBaseSumC +=$SumDobC2[$k];
                     $TotalBaseSumR +=$SumDobR2[$k];
                     $TotalFutureC  +=$m_DestMtx[1][$k];
                     $TotalFutureR  +=$m_OriginMtx[1][$k];
                }
           
                for ($k = 1; $k <= $nRow; $k++)
                {                       
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                        $m_BaseMtx[$k][$l] = round($t[$l][$k]);  
                                           
                    }                       
                }                  
               fwrite($fh," \n  \n \n");	
            }          
        }while($m_a==1 && $itr < $itrbrk && $itr < $m_numItr);  
//-------------------------------------------------------------------------------------------------------------------

        
        
        do
        {  
           if($m_AccuracyVal=="Individual")
            {
            	for ($j = 1; $j <= $nRow; $j++)
            	{
                 	$m_a=(((($m_OriginMtx[1][$j]-$sumRD[$j])*100)/$sumRD[$j])> $m_txtAccuracy || ((($m_DestMtx[1][$j]-$sumCD[$j])*100)/$sumCD[$j])> $m_txtAccuracy);
            	}
            }
            else
            {                        
                 $m_a= ((($TotalFutureR-$TotalBaseSumR)*100)/$TotalBaseSumR)>$m_txtAccuracy;               
            }       
            if($m_a)
            {            	           	
                $itr++;
                								                            

                for ($k = 1; $k <= $nRow; $k++)
                {
                    $sumRD[$k]=0;                
                     for ($l = 1; $l <= $nRow; $l++)
                     {                         
                        $sumRD[$k] += $m_BaseMtx[$k][$l];            
                     }          
                   }
          
                for ($l = 1; $l <= $nRow; $l++)
                {
                       $a[$l]=($m_OriginMtx[1][$l] / $sumRD[$l]);                     
                }   

                for ($k = 1; $k <= $nRow; $k++)
                {          
               

                    $SumDobR1[$k]=0;  
                    
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                           $s[$k][$l] = $m_BaseMtx[$k][$l] * $a[$k];
                           $SumDobR1[$k] += $s[$k][$l];  
                           
                    }   

                }
               	
                
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC1[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC1[$k] += $s[$l][$k];;                   
                      }
                           
                }
				
              
                
               
                for ($l = 1; $l<= $nRow; $l++)
                {
                    $sumCD[$l]=0;
                    for ($k = 1; $k <= $nRow; $k++)
                    {
                        $sumCD[$l] += $s[$k][$l];                    
                    } 
                }

                for ($l = 1; $l <= $n; $l++)
                {
                      $b[$l]=$m_DestMtx[1][$l] / $sumCD[$l];                     
                }              

                
                for ($l = 1; $l <= $nRow; $l++)
                {
                   
                    $SumDobR2[$l]=0; 
                    for ($k = 1; $k <= $nRow; $k++)
                    {                        
                        $t[$k][$l] = $s[$l][$k] * $b[$k];  
                        $SumDobR2[$l] += $t[$k][$l];                       
                            
                    }  
                
                            
                }
                
                 
               
                for ($k = 1; $k <= $nRow; $k++)
                {
                    $SumDobC2[$k]=0;
                      for ($l = 1; $l <= $nRow; $l++)
                      {  
                           $SumDobC2[$k] += $t[$k][$l];;                   
                      }
                        
                }
                
               
                
                     $TotalBaseSumC=0;
                     $TotalBaseSumR=0;
                     $TotalFutureC=0;
                     $TotalFutureR=0;
                for ($k = 1; $k <= $nRow; $k++)
                {
                     $TotalBaseSumC +=$SumDobC2[$k];
                     $TotalBaseSumR +=$SumDobR2[$k];
                     $TotalFutureC  +=$m_DestMtx[1][$k];
                     $TotalFutureR  +=$m_OriginMtx[1][$k];
                }
           
                for ($k = 1; $k <= $nRow; $k++)
                {                       
                    for ($l = 1; $l <= $nRow; $l++)
                    {
                        $m_BaseMtx[$k][$l] = round($t[$l][$k]);  
                                           
                    }                       
                }                  
               
            }          
        }while($m_a==1 && $itr < $itrbrk );  
        
        
        
//-------------------------------------------------------------------------------------------------------------------
        
        
	     
        if($itr < $itrbrk)
        {
        		fwrite($fh," Final Result \n \n");
        }
        else
        {
        		fwrite($fh,$itr." \n \n");
        }
        fwrite($fh," Fratar Growth Factor Matrix For Future Year \n Zone \t");
        for ($i = 1; $i <= $nRow; $i++)
        {
        		fwrite($fh,$i." \t");
        }      
        fwrite($fh,"Current Origins Total \t Origins Total Future year \t \n");
        for ($k = 1; $k <= $nRow; $k++)
        {        
        		fwrite($fh,$k." \t");  

                for ($l = 1; $l <= $nRow; $l++)
                {
                		fwrite($fh,round($s[$k][$l],3)." \t");    
                }   
                fwrite($fh,round($SumDobR1[$k],3)." \t"); 
                fwrite($fh,$m_OriginMtx[1][$k]." \t \n"); 

        }
        fwrite($fh,"Current Destinations Total \t");
        for ($k = 1; $k <= $nRow; $k++)
        {
        		fwrite($fh,round($SumDobC1[$k],3)." \t");           
        }
        fwrite($fh," \n"); 
        fwrite($fh," Destinations Total Future year \t "); 
        for ($l = 1; $l<= $nRow; $l++)
        {
                fwrite($fh,$m_DestMtx[1][$l]." \t");   
        }
        fwrite($fh," \n \n \n "); 
        
        fwrite($fh,"Fratar Growth Factor Matrix For Future Year \n Zone \t "); 
		for ($i = 1; $i <= $nRow; $i++)
        {
        
                 fwrite($fh,$i." \t");
        }      
        fwrite($fh,"Current Origins Total \t Origins Total Future year \t \n");
        for ($l = 1; $l <= $nRow; $l++)
        {
        		 fwrite($fh,$l." \t");
                 for ($k = 1; $k <= $nRow; $k++)
                 {        
                 		fwrite($fh,round($t[$k][$l],3)." \t");                  
                 }  
                 fwrite($fh,round($SumDobR2[$l],3)." \t"); 
                 fwrite($fh,$m_OriginMtx[1][$l]." \t \n");
         }
         fwrite($fh,"Current Destinations Total \t"); 
         for ($k = 1; $k <= $nRow; $k++)
         {
         		 fwrite($fh,round($SumDobC2[$k],3)." \t");            
         }
         fwrite($fh," \n ");
         fwrite($fh,"Destinations Total Future year \t ");
         for ($l = 1; $l<= $nRow; $l++)
         {
         		 fwrite($fh,$m_DestMtx[1][$l]." \t");
         }
         fwrite($fh," \n \n ");
         fwrite($fh,"No. of Iteration taken to reach final result : ".$itr." \n \n ");
        
    }   
	fclose($fh);
	
}



?>
