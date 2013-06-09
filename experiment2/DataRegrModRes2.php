<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4);


session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment2/";
$m_TripFile = $_POST['TripFile'];
$m_TripFile2 = $_FILES['tripfile2']['name'];


//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_TripFile2, strripos($m_TripFile2, '.'));
if(!($file_ext1 == '.csv' || $file_ext1 == '.xls'))
{
	?>
<script language="javascript">

   alert("invalid file format");
   location="experiment.php";
    
</script>



<?php 

}

//----------------------------------------------------------------------------------------------

//  move uploaded files to user specific folder

move_uploaded_file($_FILES["tripfile2"]["tmp_name"],$folder . $_FILES["tripfile2"]["name"]);
?>

<style type="text/css">
#scroller 
{
    width:800px;
    height:300px;
    overflow:auto;    
 }
 #vert
 {
    /* for firefox, safari, chrome, etc. */
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    /* for ie */
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
 }
</style>
<script language="javascript">
function chk3()
{
	
	document.Frm.action="intermediateDataRegr.php";
	//document.Frm.action="AddDataRegrRpt.php";
}
</script>
<script type="text/x-mathjax-config">
	  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
   	  MathJax.Hub.Config({ TeX: { equationNumbers: {autoNumber: "all"} } });
	  MathJax.Hub.Config({"HTML-CSS": { linebreaks: { automatic: true } },SVG: { linebreaks: { automatic: true } }});
</script>
  <script type="text/javascript" src="../mathjax-MathJax-24a378e/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

</head>

<div id="body">

<center>     
<?php 
//--------------------- reading Xls file-----------------------------------------------
if($file_ext1 == '.xls' )
{

	// Trip File


       	require_once  EXCELREADER.'/Excel/reader.php';
        $dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($folder.$m_TripFile2);
        error_reporting(E_ALL ^ E_NOTICE);
        
        $nRow = $dataTripF->sheets[0]['numRows'];
        $nCol = $dataTripF->sheets[0]['numCols'];
  

        
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
        for ($i = 1; $i <= $nRow; $i++)
        {               
            echo '<tr align="center" >';  
            
            if($i == 1)
            {
            	echo "<td ><b>Zone</b></td>";
            }
            else 
            {
            	echo "<td ><b>".($i-1)."</b></td>"; 
            }          
            for ($j = 1; $j <= $nCol; $j++)
            {
                // saving excel file data in to $m_TripMtx 2-Dimension array varible
                            
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
                
                if($i>=2)
                {
               		if(!is_numeric($m_TripMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "DataRegrMod.php";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td ><b>".$m_TripMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_TripMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br><br><br>";   
        ?>   	
        	</td>
			</tr>
			</table>
			
		<?php 

}
//----------------------------------------------------------------------------------

//----------------------------- reading csv file---------------------------------------------

elseif($file_ext1 == '.csv' )
{

 	$nCol=0; 
	$nRow = 0;
	$name = $folder.$m_TripFile2;
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
 
	
     echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
     for ($i = 1; $i <= $nRow; $i++)
     {               
            echo '<tr align="center" >';  

            if($i == 1)
            {
            	echo "<td ><b>Zone</b></td>";
            }
            else 
            {
            	echo "<td ><b>".($i-1)."</b></td>"; 
            }                   
            for ($j = 1; $j <= $nCol; $j++)
            {
                         
                if($i>=2)
                {
               		if(!is_numeric($m_TripMtx[$i][$j]))
                	{
                	?>
                		<script>
                			alert("Numeric value is missing in some cell, please check your file !!!");                	
                			document.location = "DataRegrMod.php";
               			</script>	
               		<?php	 
                	}
                }                
               
                if($i==1)
                {
                     echo "<td ><b>".$m_TripMtx[$i][$j]."</b></td>" ;
                }
                else
                {    
                     echo '<td >';   
                     echo $m_TripMtx[$i][$j];    
                     echo "</td>";
                }        
            }               
            echo "</tr>";       
        }  
        echo "</table></div><br><br>";  
        ?>  	
        	</td>
			</tr>
			</table>
			
		<?php 
        
}
//------------------------------------------------------------------------------------------------  


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
	
	
	
	 $k=1;
      //	echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
     // 	echo "<tr ><td align='center'><b>";
      echo "$\begin{align*}";
      	echo $m_TripMtx[1][$m_Dep]."=".round($ans[$k],4)."+";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
             	
                echo "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_Independent[$i]].")+";
             }
             elseif($i <= count($m_InDep)-2)
             {
                 echo "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_Independent[$i]].")+";
             }
             else
             {
                 echo "(".round($ans[$k],4).")*(".$m_TripMtx[1][$m_Independent[$i]].")";
             }
             $k++;
      	}
      	echo "\end{align*}$<br><br><br>";
      	//echo "</b></td></tr></table><br><br>";
        
	
	echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Trip Data </b></caption>';
	echo "<tr ><th>Trip for each zone(T<sub>i</sub>)</th><th>Number of Trips</th></tr>";
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
		echo "<tr  ><td align='center'><b> T<sub>".($i-1)."</sub></b></td>";
		echo "<td align='center'>".round($m_trip[$i],4)."</td></tr>";
	}
	echo "</table>";
}
if($m_RegrType == "Quadratic")
{
	
	
	
	    $k=1;
      	//echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
      	//echo "<tr ><td align='center'><b>";
      	 echo "$\begin{align*}";
      	echo $m_TripMtx[1][$m_Dep]."=".$ans[$k]."+";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
                echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i]].")+";
             }
             elseif($i <= $SelectCol-2)
             {
                 echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i]].")+";
             }
             else
             {
                 echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i]].") +";
             }
             $k++;
      	}
      	for ($i = count($m_InDep); $i < 2*count($m_InDep); $i++)
      	{
            if($i < 2*count($m_InDep)-1)
             {
                 echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i-count($m_InDep)]].")^2+";
             }
             else
             {
                 echo "(".$ans[$k].")*(".$m_TripMtx[1][$m_Independent[$i-count($m_InDep)]].")^2";
             }
             $k++;
      	}
      	echo "\end{align*}$<br><br><br>";
      	//echo "</b></td></tr></table><br><br>";
        
	$counted = count($m_InDep);

	echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Trip Data </b></caption>';
	echo "<tr ><th>Trip for each zone(T<sub>i</sub>)</th><th>Number of Trips</th></tr>";
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
		echo "<tr  ><td align='center'><b> T<sub>".($i-1)."</sub></b></td>";
		echo "<td align='center'>".round($m_trip[$i],4)."</td></tr>";
	}
	echo "</table>";	
	
}
if($m_RegrType == "Power")
{
	
	    $k=1;
      //	echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
      //	echo "<tr ><td align='center'><b>";
       echo "$\begin{align*}";
      	echo $m_TripMtx[1][$m_Dep]."=".$ans[$k]."*";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i <count($m_InDep)-1)
             {
                 echo "(".$m_TripMtx[1][$m_Independent[$i]].")^{(".$ans[$k].")}*";
             }
             else
             {
                 echo "(".$m_TripMtx[1][$m_Independent[$i]].")^{(".$ans[$k].")}";
             }
             $k++;
      	}
      	echo "\end{align*}$<br><br><br>";
      	//echo "</b></td></tr></table><br><br>";
        
	
	
	echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Trip Data </b></caption>';
	echo "<tr ><th>Trip for each zone(T<sub>i</sub>)</th><th>Number of Trips</th></tr>";
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
		echo "<tr  ><td align='center'><b> T<sub>".($i-1)."</sub></b></td>";
		echo "<td align='center'>".round($m_trip[$i],4)."</td></tr>";
	}
	echo "</table>";	
	
}
if($m_RegrType == "Exponential")
{
	
	        $k=1;
      	//echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
      //	echo "<tr ><td align='center'><b>";
       echo "$\begin{align*}";
      	echo $m_TripMtx[1][$m_Dep]."=".$ans[$k]."*";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
                echo "e^{(".$ans[$k].")*".$m_TripMtx[1][$m_Independent[$i]].")}*";
             }
             elseif($i <= count($m_InDep)-2)
             {
                 echo "e^{(".$ans[$k].")*".$m_TripMtx[1][$m_Independent[$i]].")}*";
             }
             else
             {
                 echo "e^{(".$ans[$k].")*".$m_TripMtx[1][$m_Independent[$i]].")}";
             }
             $k++;
      	}
      	echo "\end{align*}$<br><br><br>";
      	//echo "</b></td></tr></table><br><br>";
        
	
	
	
	echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Trip Data </b></caption>';
	echo "<tr ><th>Trip for each zone(T<sub>i</sub>)</th><th>Number of Trips</th></tr>";
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
		echo "<tr  ><td align='center'><b> T<sub>".($i-1)."</sub></b></td>";
		echo "<td align='center'>".$m_trip[$i]."</td></tr>";
	}
	echo "</table>";	
	
}
if($m_RegrType == "Logarithmic")
{
	
	        $k=1;
     // 	echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
     // 	echo "<tr ><td align='center'><b>";
      echo "$\begin{align*}";
      	echo $m_TripMtx[1][$m_Dep]."=".round($ans[$k],6)."+";
      	$k++;
      	for ($i = 0; $i < count($m_InDep); $i++)
      	{
            if($i==0)
             {
                echo "(".round($ans[$k],6).")ln(".$m_TripMtx[1][$m_Independent[$i]].")+";
             }
             elseif($i <= $p-3)
             {
                 echo "(".round($ans[$k],6).")ln(".$m_TripMtx[1][$m_Independent[$i]].")+";
             }
             else
             {
                 echo "(".round($ans[$k],6).")ln(".$m_TripMtx[1][$m_Independent[$i]].")";
             }
             $k++;
      	}
      	echo "\end{align*}$<br><br><br>";
      	//echo "</b></td></tr></table><br><br>";
        
	
	
	
	
	echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Future Year Trip Data </b></caption>';
	echo "<tr ><th>Trip for each zone(T<sub>i</sub>)</th><th>Number of Trips</th></tr>";
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
		echo "<tr  ><td align='center'><b> T<sub>".($i-1)."</sub></b></td>";
		echo "<td align='center'>".round($m_trip[$i],4)."</td></tr>";
	}
	echo "</table>";	
	
}



?>


</div><br><br>
<form enctype="multipart/form-data" method="post" name="Frm">
<?php $_SESSION['ANS'] = $ans;?>
<?php $_SESSION['TripFile'] = $m_TripFile;?>

<?php $_SESSION['DataChoiceVar'] = $m_DataChoiceVar;?>
<?php $_SESSION['Type'] =$_POST['Type'];?>
<table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk3()">
</td>
</tr>
</table>
<br>
<a href="DataRegrMod.php"><H2><input type ="button" value="Back"></H2></a>
<br>

</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?> 	