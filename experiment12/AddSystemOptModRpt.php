<?php
include '../header.php'; 
// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
$folder = "../user/".$UploadFile."/Experiment12/";

$m_ConCriteria =  $_POST['ConCriteria'];
$m_NodeFile = $_POST['NodeFile'];
$m_OdFile = $_POST['OdFile'];	 

//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_NodeFile, strripos($m_NodeFile, '.'));
$file_ext2= substr($m_OdFile, strripos($m_OdFile, '.'));

if(!($file_ext1 == '.csv'&& $file_ext2 == '.csv'  || $file_ext1 == '.xls' && $file_ext2 == '.xls'))
{
?>
<script language="javascript">
    alert("invalid file format");
    location="SystemOptMod.php?Exp=10";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------
?>


<style type="text/css">

#scroller {
    width:800px;
    height:300px;
    overflow:auto;   
 }
 
 .title1 
		{
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: x-normal;
			color: #00529C;			
			font-weight : bold;
			text-align: center;			
		}
		.lable1
		{ 
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: xx-small;
			color: #00529C;
			background-color: #ECECEC;
			font-weight : bold;
		}
</style>
</head>
<div class="container-fluid1">

<?php


// reading Xls file
if($file_ext1 == '.xls')
{		
	// Node File
	
		include '../phpExcelReader/Excel/reader.php';
		$dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($folder.$m_NodeFile);
       
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nlinks = $dataTripF->sheets[0]['numRows']-1 ;
        $Col = $dataTripF->sheets[0]['numCols']+1;
    
        for ($i = 1; $i <= $m_nlinks+1; $i++)
        {           	  
			for ($j = 1; $j < $Col; $j++)
            {
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
       
            }             
        }
		
}

elseif($file_ext1 == '.csv')
{
	// reading csv file
	
    // Node File
    
	$Col=0; 
	$m_nlinks = 0;
	$name = $folder.$m_NodeFile;
    $file1 = fopen($name , "r");
    while (($data = fgetcsv($file1, 8000, ",")) !== FALSE) 
    {
    	$Col = count($data);

    	for ($c=0; $c <$Col; $c++)
    	{    	  
        	$m_Trip[$m_nlinks][$c] = $data[$c];        	
     	}
     	$m_nlinks++;    
    }
    $Col++;
    for ($i = 0; $i < $m_nlinks; $i++) 
    { 
         for ($j = 0; $j < $Col; $j++)
         {
         		$m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j] ;             		
         }    	
    }
    fclose($file1);

	
	$m_nlinks--;

}

// reading Xls file

if($file_ext2 == '.xls')
{	      
	// OD File
	
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($folder.$m_OdFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nnodes = $OdTripF->sheets[0]['numRows'] ;	//work    
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
                     
            for ($j = 1; $j <=$m_nnodes ; $j++)
            {
               $m_ODMtx[$i][$j]=$OdTripF->sheets[0]['cells'][$i][$j];
  
            }          
        }
		
}

elseif($file_ext2 == '.csv')
{
	// reading csv file
	
	// OD File 
	
	$Col=0; 
	$m_nnodes = 0;
	$name = $folder.$m_OdFile;
    $file2 = fopen($name , "r");
    while (($data = fgetcsv($file2, 8000, ",")) !== FALSE) 
    {
    	$Col = count($data);

    	for ($c=0; $c <$Col; $c++)
    	{
    	   
        	$m_OD[$m_nnodes][$c] = $data[$c];
        	
     	}
     	$m_nnodes++;
    
    }
    for ($i = 0; $i < $m_nnodes; $i++) 
    { 
         for ($j = 0; $j < $Col; $j++)
         {
         		$m_ODMtx[$i+1][$j+1] = $m_OD[$i][$j] ;      	
         }
    	
    }
    fclose($file2);
 
		
		$m_nnodes--;
}
////////////////////////////////////////////////////////////////////////////////

      for ($i = 1; $i <= $m_nlinks+1; $i++)
        {
       $frm[$i] =$m_TripMtx[$i+1][1];
        }
      for ($i = 1; $i <= $m_nlinks+1; $i++)
        {
       $to[$i] =$m_TripMtx[$i+1][2];
        }
      for ($i = 1; $i <= $m_nlinks+1; $i++)
        {
       $trat[$i] =$m_TripMtx[$i+1][3];
        }
         for ($i = 1; $i <= $m_nlinks+1; $i++)
        {
       $cons[$i] =$m_TripMtx[$i+1][4];
        }
        
 // sorting of network
 
        $p=0;
      for ($j = 1; $j < $m_nlinks; $j++)
      {
      for ($i = 1; $i < $m_nlinks; $i++)
      {
      if($frm[$i+1]<$frm[$i]){
      
      $p=$frm[$i];
      $frm[$i]=$frm[$i+1];
      $frm[$i+1]=$p;
      
      $p=$to[$i];
      $to[$i]=$to[$i+1];
      $to[$i+1]=$p;
      
      $p=$trat[$i];
      $trat[$i]=$trat[$i+1];
      $trat[$i+1]=$p;

      $p=$cons[$i];
      $cons[$i]=$cons[$i+1];
      $cons[$i+1]=$p;
      }
      }
      }
   
      
   // declaring artificial time     
   
     function amit($x,$a,$c)
    {
		$t=$a+0.15*$a*pow($x,4)/$c;
		return $t;
	}

	//function of linear search for the value of alpha to minimise the value of Z
	
	function linearsearch($trat,$cons,$m_nlinks,$x,$y,$b)
	{

		while ($b-$a>=0.01){
		$z=0;
		$alpha=($b+$a)/2;
		for ($i=1;$i<=$m_nlinks;$i++)
		{
   			$m=$x[$i]+$alpha*($y[$i]-$x[$i]);

   			$p=amit($m,$trat[$i],$cons[$i]);

  			$z+=($y[$i]-$x[$i])*$p;
		}

		if ($z<=0){
		$a=$alpha;
	}
	else 
	{
		$b=$alpha;
	}

}
$alpha=($b+$a)/2;
return $alpha;
} 
       
function shortpath($m_nlinks,$m_nnodes,$frm,$to,$trat,$originnode,$desnode)
{
      for ($i = 1; $i <= $m_nnodes; $i++)
      {
            $lb[$i]=1000000000000000000000;
            $pl[$i]=0;
            $s[$i]=0;

      }
      
      $s[$originnode]=1000000000000000000000;
      $lb[$originnode]=0;
      $top=$originnode;
      $bottom=$originnode;
      
      for ($k = 1; $k <= $m_nlinks; $k++)
      {
           for ($i = 1; $i <= $m_nlinks; $i++)
           {      
				
           	if ($frm[$i]==$top) 
           	{
           	
     		 	if ($lb[$frm[$i]]+$trat[$i]<$lb[$to[$i]])
     		 	{
      				$lb[$to[$i]]=$lb[$frm[$i]]+$trat[$i];
 		     		$pl[$to[$i]]=$frm[$i];
      	
      	
      				if ($s[$to[$i]]==0)
      				{
      					$s[$to[$i]]=1000000000000000000000;
      					$s[$bottom]=$to[$i];
      					$bottom=$to[$i];
      				}     	
      	
      				if ($s[$to[$i]]==-1) 
      				{
      					$s[$to[$i]]=$top;
      					$top=$to[$i];
      					//echo $top."hooooo".$s[$top]."<br>";
      				}
      			}
      	// echo $top."hiiii".$s[$top]."<br>";	
      		}
    
   		}
      
   		if ($top != $bottom)
  		 {      
     		//echo $top."hooooo".$s[$top]."<br>";
      		$d=$top;
      		$top=$s[$top];
		    $s[$d]=-1;
      
      
   		}
}
      
      $ans[0]=$desnode;
       for ($i = 1; $i <= $m_nnodes; $i++)
       {
       echo $pl[$ans[$i-1]];
       		if ($pl[$ans[$i-1]]==0)
       		{
       			break;
       		}
       		$ans[$i]=$pl[$ans[$i-1]];
      }
      $count=1;
       $count= count($ans);
       //echo $count;
       for ($i = 0; $i < $count; $i++) {
       		$ans1[$count-$i]=$ans[$i];
       }
       $t=1;
      for ($i = 1; $i < $count; $i++) {
       for ($k = 1; $k <= $m_nlinks; $k++) {
      
      if($ans1[$i]==$frm[$k] && $ans1[$i+1]==$to[$k]){
     
      $link1[$t]=$k;
      $t++;
      break;
      }
       }
      }

			return compact('ans1', 'count','link1');

        }
   
 
 // All or nothing Assingment  
 
for ($j=1;$j<=$m_nlinks;$j++){
$x[$j]=0;
$y[$j]=0;
}

// initiallization all links 0 flow

for ($i = 1; $i <= $m_nlinks; $i++) {
	$t[$i]=amit (0,$trat[$i],$cons[$i]);
	//echo $t[$i]."<br>";
}

// initiallisation of  x
            
      for ($l=2;$l<=$m_nnodes+1;$l++){
      for ($ll=2;$ll<=$m_nnodes+1;$ll++){
      $originnode=$m_ODMtx[$l][1];
      $desnode=$m_ODMtx[1][$ll];
      $total=$m_ODMtx[$l][$ll];  
      if ($total==0){continue;}
    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$t,$originnode,$desnode));
//if($count==1){continue;}
for ($j=1;$j<$count;$j++){
//echo $link1[$j]."</br>";
}
//echo "</br>";
//break ;
for ($j = 1; $j <$count ; $j++) { 
         
$x[$link1[$j]]=$x[$link1[$j]]+$total;
//unset($link1[$j]);
}

      }
      }

      
//user equilibrium algorithm

// convergence criteria based on step size

if ($m_ConCriteria == "Alpha")
{
	$alph=1;
	$ii=0;
	
	while ($alph>0.0001&& $ii<=5000)
	{
		$ii++;
		//Update Travel time
	
		//echo $alph."<br>";
		
	for ($j = 1; $j <= $m_nlinks; $j++) 
	{
//echo $j."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$x[$j]."check".$trat[$j]."<br>";
	$t[$j]=amit ($x[$j],$trat[$j],$cons[$j]);
	//echo $j."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$t[$j]."fff"."</br>";
	}
for ($j=1;$j<=$m_nlinks;$j++){
$y[$j]=0;
}
	// Auxilary Flow
      for ($l=2;$l<=$m_nnodes+1;$l++){
      for ($ll=2;$ll<=$m_nnodes+1;$ll++){
      $originnode=$m_ODMtx[$l][1];
      $desnode=$m_ODMtx[1][$ll];
      $total=$m_ODMtx[$l][$ll];  
      if ($total==0){continue;}

    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
      
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$t,$originnode,$desnode));
/*for ($j=1;$j<$count;$j++){
echo $link1[$j]."</br>";
}
echo "</br>";*/
for ($j = 1; $j <$count ; $j++) { 
$y[$link1[$j]]=$y[$link1[$j]]+$total;
}
      }
      }
// step size i.e. alpha
/*
 for ($i = 1; $i <= $m_nlinks; $i++)
      {
      echo  $x[$i]."&nbsp;&nbsp;".$y[$i]."&nbsp;&nbsp;".$t[$i]."gggg".$alph."</br>";
      }*/

$alph=linearsearch($trat,$cons,$m_nlinks,$x,$y,1);

//echo $alph."<br>";

$mmmm=0;
//echo $alph."</br>";
 for ($j=1;$j<=$m_nlinks;$j++){
$mmmm += $t[$j]*$x[$j];
}

//echo"</br>".$mmmm."TSTT"."</br>";

for ($j=1;$j<=$m_nlinks;$j++){
$x[$j]=$x[$j]+$alph*($y[$j]-$x[$j]);
//echo "Xi ".$x[$j]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."traveltime".$t[$j]."</br>";
}

//echo"</br>"."heyhey"."</br>";
$PlotY[$ii] = $alph;
}
$PlotX = $ii;
}

// convergence criteria based on Travel Time

else if ($m_ConCriteria == "TravelTime")
{
	$alph=1;
$ii=0;

//Update Travel time

do{$ii++;
for ($j = 1; $j <= $m_nlinks; $j++) {
//echo $j."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$x[$j]."check".$trat[$j]."<br>";
    $temptime[$j]=$t[$j];
	$t[$j]=amit ($x[$j],$trat[$j],$cons[$j]);
	//echo $j."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$t[$j]."fff"."</br>";
	}
for ($j=1;$j<=$m_nlinks;$j++){
$y[$j]=0;
}
	// Auxilary Flow
      for ($l=2;$l<=$m_nnodes+1;$l++){
      for ($ll=2;$ll<=$m_nnodes+1;$ll++){
      $originnode=$m_ODMtx[$l][1];
      $desnode=$m_ODMtx[1][$ll];
      $total=$m_ODMtx[$l][$ll];  
      if ($total==0){continue;}

    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
        
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$t,$originnode,$desnode));
/*for ($j=1;$j<$count;$j++){
echo $link1[$j]."</br>";
}
echo "</br>";*/
for ($j = 1; $j <$count ; $j++) { 
$y[$link1[$j]]=$y[$link1[$j]]+$total;
}
      }
      }
// step size i.e. alpha
/*
 for ($i = 1; $i <= $m_nlinks; $i++)
      {
      echo  $x[$i]."&nbsp;&nbsp;".$y[$i]."&nbsp;&nbsp;".$t[$i]."gggg".$alph."</br>";
      }*/

$alph=linearsearch($trat,$cons,$m_nlinks,$x,$y,1);

//echo $alph."<br>";

$mmmm=0;
//echo $alph."</br>";
 for ($j=1;$j<=$m_nlinks;$j++){
$mmmm += $t[$j]*$x[$j];
}

//echo"</br>".$mmmm."TSTT"."</br>";

for ($j=1;$j<=$m_nlinks;$j++){
$tempflow[$j]=$x[$j];
$x[$j]=$x[$j]+$alph*($y[$j]-$x[$j]);
//echo "Xi ".$x[$j]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."traveltime".$t[$j]."</br>";
}

// ---------- check 1 start ------------

$check1 = 0;
for ($j = 1; $j <= $m_nlinks; $j++) {
     $check1+= (abs ($t[$j]-$temptime[$j]))/$t[$j];
}
//echo $check1."<br>";
$PlotY[$ii] = $check1;

// ------------ check 1 end -------------

}while ($ii<=200);
$PlotX = $ii - 1;
}

// convergence criteria based on Flow On Link

else if ($m_ConCriteria == "FlowOnLink")
{
	$alph=1;
$ii=0;

//Update Travel time
do{$ii++;
for ($j = 1; $j <= $m_nlinks; $j++) {
//echo $j."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$x[$j]."check".$trat[$j]."<br>";
    $temptime[$j]=$t[$j];
	$t[$j]=amit ($x[$j],$trat[$j],$cons[$j]);
	//echo $j."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$t[$j]."fff"."</br>";
	}
for ($j=1;$j<=$m_nlinks;$j++){
$y[$j]=0;
}
	// Auxilary Flow
      for ($l=2;$l<=$m_nnodes+1;$l++){
      for ($ll=2;$ll<=$m_nnodes+1;$ll++){
      $originnode=$m_ODMtx[$l][1];
      $desnode=$m_ODMtx[1][$ll];
      $total=$m_ODMtx[$l][$ll];  
      if ($total==0){continue;}

    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
      
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$t,$originnode,$desnode));
/*for ($j=1;$j<$count;$j++){
echo $link1[$j]."</br>";
}
echo "</br>";*/
for ($j = 1; $j <$count ; $j++) { 
$y[$link1[$j]]=$y[$link1[$j]]+$total;
}
      }
      }
// step size i.e. alpha
/*
 for ($i = 1; $i <= $m_nlinks; $i++)
      {
      echo  $x[$i]."&nbsp;&nbsp;".$y[$i]."&nbsp;&nbsp;".$t[$i]."gggg".$alph."</br>";
      }*/

$alph=linearsearch($trat,$cons,$m_nlinks,$x,$y,1);

//echo $alph."<br>";

$mmmm=0;
//echo $alph."</br>";
 for ($j=1;$j<=$m_nlinks;$j++){
$mmmm += $t[$j]*$x[$j];
}

//echo"</br>".$mmmm."TSTT"."</br>";

for ($j=1;$j<=$m_nlinks;$j++){
$tempflow[$j]=$x[$j];
$x[$j]=$x[$j]+$alph*($y[$j]-$x[$j]);
//echo "Xi ".$x[$j]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."traveltime".$t[$j]."</br>";
}

// ---------- check 2 start ------------

$temp1=0;
$temp2=0;
for($j = 1; $j <= $m_nlinks; $j++){
$temp1+=(($tempflow[$j]-$x[$j])*($tempflow[$j]-$x[$j]));
$temp2+=$tempflow[$j];
}
$check2= sqrt($temp1)/$temp2;
//echo $check2."<br>";

$PlotY[$ii] = $check2;

// ------------ check 2 end -------------

}while ($ii<=200);
$PlotX = $ii - 1;
}
 
 
//echo $ii;
$sum=0;
if(file_exists($folder."SystemOptModReport.xls"))
{
		$fh = fopen($folder."SystemOptModReport.xls", "a+") or die("can't open file");
}
fwrite($fh, "System Optimal Assignment  \n \n") ;
fwrite($fh, "Result \n") ;
fwrite($fh, "From \t To \t Link Flow(Xi) \t Link Traveltime Tij \n") ;
 for ($i = 1; $i <= $m_nlinks; $i++)
{    
			fwrite($fh, $frm[$i]."\t ") ;
			fwrite($fh, $to[$i]."\t ") ;
			fwrite($fh, $x[$i]."\t ") ;
			fwrite($fh, $t[$i]."\n ") ; 
            $sum +=($x[$i]*$t[$i]);
}
fwrite($fh, "\n \n") ;
            
fwrite($fh, "Total System Travel Time \t ".$sum." \n") ;
fwrite($fh, "\n \n \n") ;
fclose($fh);
?>        
<form enctype="multipart/form-data" method="post" name="Frm" >
<h1><font color="Black">Data Successfully added to the Report.</h1><br>
<br>
<a href='../user/<?php echo $UploadFile?>/Experiment12/SystemOptModReport.xls' target="new"><h3>Click to Download Overall Report</h2></a><br><br>
<a href = "SystemOptMod.phpExp=10"><h3>Go back to experiment</h2></a>
</form>
</div>
<?php include '../footer.php'; ?>