<?php
include_once("../util/system.php");
require_once ('../jpgraph/jpgraph.php');
require_once ('../jpgraph/jpgraph_scatter.php');
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment2/";

		$m_AnalysisVar = $_GET['AnalysisVar'];
		$m_TripFile = $_GET['TripFile'];
		$file_ext1 = $_GET['file_ext1'];
		
		
	
		//-------------------------------Xls file-------------------------------------------------
		if($file_ext1 == '.xls' )
		{
        	
            
			require_once EXCELREADER.'/Excel/reader.php';
        	$dataTripF = new Spreadsheet_Excel_Reader();
        	$dataTripF->setOutputEncoding('CP1251');       
        	$dataTripF->read($folder.$m_TripFile);
        	error_reporting(E_ALL ^ E_NOTICE);
      
        		
            $nRow = $dataTripF->sheets[0]['numRows'];
            $nCol = $dataTripF->sheets[0]['numCols'];
            
        	for ($i = 1; $i <= $nRow; $i++)
        	{  
        		for ($j = 1; $j <= $nCol; $j++)
            	{             
                	$m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
            	}               
        	}  
        
        }
		//----------------------------------------------------------------------------------
		//-----------------------------csv file---------------------------------------------

		elseif($file_ext1 == '.csv' )
		{
		
		
			$nCol = 0; 
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
		
		//-------------------------------------------------------------------------------------------
		
        if($m_AnalysisVar == "DataAna")
		{
		$m_DataChoiceVar = $_GET['DataChoiceVar'];
	
		
        if ($m_DataChoiceVar == "Plot")
		{
			$m_PlotXVar = $_GET['PlotXVar'];
			$m_PlotYVar = $_GET['PlotYVar'];  		
			
			$n = $nRow;
			for ($i = 2; $i < $nRow; $i++)
       		{
            	$px[$i] = $m_TripMtx[$i][$m_PlotXVar];
              	$py[$i] = $m_TripMtx[$i][$m_PlotYVar];                    
       		}
            $k=2;
			for($i=0;$i<$n-2;$i++)
			{
    			$x[$i]=$px[$k];
    			$y[$i]=$py[$k];
    			$k++;
			}
       		
			$datax = $x;
			$datay = $y;

			$graph = new Graph(1000,800);
			$graph->SetScale("linlin");

			$graph->img->SetMargin(80,80,80,80);	
			//$graph->img->SetImgFormat( "jpeg");		//
			$graph->SetShadow();
            
			$titlebar = $m_TripMtx[1][$m_PlotXVar]."  vs  ".$m_TripMtx[1][$m_PlotYVar];
			
			$graph->title->Set($titlebar);
			$graph->title->SetFont(FF_FONT1,FS_BOLD);
						
			$graph->xaxis->title->Set($m_TripMtx[1][$m_PlotXVar]);
			$graph->xaxis->title->SetMargin(20);
			$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			
			$graph->yaxis->title->Set($m_TripMtx[1][$m_PlotYVar]);
			$graph->yaxis->title->SetMargin(30);
			$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
			

			$sp1 = new ScatterPlot($datay,$datax);

			$sp1->mark->SetType(MARK_FILLEDCIRCLE);
			$sp1->mark->SetFillColor("red");
			$sp1->mark->SetWidth(3);

			$graph->Add($sp1);
			$graph->Stroke();
			
			/*
			//delete file
			$myFile = $UploadFile."/".$m_TripFile;
			$fh = fopen($myFile, 'w') or die("can't open file");
			fclose($fh);

			unlink($UploadFile."/".$m_TripFile);
			*/
		}
	}

?>






