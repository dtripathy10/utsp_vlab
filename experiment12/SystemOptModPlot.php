<?php
session_start();
// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

if ($_SESSION['user'] == "")
{
	header("Location:../login.php");
}

// content="text/plain; charset=utf-8"

require_once ('../jpgraph/jpgraph.php');
require_once ('../jpgraph/jpgraph_scatter.php');

			$UploadFile = $_SESSION['user'];
			$m_ConCriteria =  $_POST['ConCriteria'];
						
			$m_PlotXVar = $_POST['PlotX'];
			
			for ($i = 0; $i < $m_PlotXVar; $i++) 
			{
				$m_PlotYVar[$i] = $_POST['PlotY'][$i];
			}
			
			for($i = 0; $i < $m_PlotXVar; $i++)
			{
    			$x[$i] = $i;
    			$y[$i] = $m_PlotYVar[$i];    			
			}
       		
			$datax = $x;
			$datay = $y;

			$graph = new Graph(1000,800);
			$graph->SetScale("linlin");

			$graph->img->SetMargin(80,80,80,80);	
			//$graph->img->SetImgFormat( "jpeg");		//
			$graph->SetShadow();
            
			$titlebar = "Iteration  vs  ".$m_ConCriteria ;
			
			$graph->title->Set($titlebar);
			$graph->title->SetFont(FF_FONT1,FS_BOLD);
						
			$graph->xaxis->title->Set("Iteration");
			$graph->xaxis->title->SetMargin(20);
			$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			
			$graph->yaxis->title->Set($m_ConCriteria);
			$graph->yaxis->title->SetMargin(30);
			$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
			

			$sp1 = new ScatterPlot($datay,$datax);

			$sp1->mark->SetType(MARK_FILLEDCIRCLE);
			$sp1->mark->SetFillColor("red");
			$sp1->mark->SetWidth(3);

			$graph->Add($sp1);
			$graph->Stroke();
								
	
?>


