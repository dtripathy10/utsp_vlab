<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"System Optimal Assignment","Trip Assignment");
// Retrieving the values of variables

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment12/";

if(!is_dir($folder))
{
	mkdir($folder, 0777);
}
$m_alphaValue =  $_POST['alphaValue'];
$m_betaValue =  $_POST['betaValue'];
$m_ConCriteria =  $_POST['ConCriteria'];
$m_NodeFile = $_FILES['NodeFile']['name'];
$m_OdFile = $_FILES['OdFile']['name'];

if(empty($m_NodeFile))
{
	$m_NodeFile = $_POST['NodeFile'];
}
if(empty($m_OdFile))
{
	$m_OdFile = $_POST['OdFile'];
}

//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_NodeFile, strripos($m_NodeFile, '.'));
$file_ext2= substr($m_OdFile, strripos($m_OdFile, '.'));

if(!($file_ext1 == '.csv'&& $file_ext2 == '.csv'  || $file_ext1 == '.xls' && $file_ext2 == '.xls'))
{
	?>
	<script language="javascript">
	    alert("invalid file format");
    	location="SystemOptMod.php";
    </script>
	<?php 
}
else 
{
	//  move uploaded files to user specific folder 
	
	move_uploaded_file($_FILES["NodeFile"]["tmp_name"],$folder . $_FILES["NodeFile"]["name"]);
	move_uploaded_file($_FILES["OdFile"]["tmp_name"],$folder . $_FILES["OdFile"]["name"]);
}
//----------------------------------------------------------------------------------------------
?>



<style type="text/css">
	#scroller 
	{
    width:800px;
    height:300px;
    overflow:auto;  
 	} 	
</style>



<script language="javascript">
function chk1()
{ 
	document.Frm.action="IntermediateSystemOptModRpt.php";	
}

function chkgraph()
{ 
	document.Frm.action="SystemOptModPlot.php";	
	document.Frm.target="_blank";	
}
</script>

</head>
<div id="body">
<center> 
<div id ="link">
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



for ($i = 1; $i <= $m_nlinks; $i++)
{
	
     $frm[$i] =$m_TripMtx[$i+1][1];
}
for ($i = 1; $i <= $m_nlinks; $i++)
{
     $to[$i] =$m_TripMtx[$i+1][2];
}
for ($i = 1; $i <= $m_nlinks; $i++)
{
    $trat[$i] =$m_TripMtx[$i+1][3];
}
for ($i = 1; $i <= $m_nlinks; $i++)
{
    $cons[$i] =$m_TripMtx[$i+1][4];
}
        
// sorting of network

$p=0;
for ($j = 1; $j < $m_nlinks; $j++)
{
    for ($i = 1; $i < $m_nlinks; $i++)
    {
      	if($frm[$i+1]<$frm[$i])
      	{
      
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


$merge_1= array_merge((array)$frm, (array)$to);

for ($i = 1; $i <= 2*$m_nlinks; $i++)
    {
//$merge_1[$i]."<br>";

}
$node=array_unique($merge_1);
$m_nnodes=count($node);

//echo "<button class = 'btn1'> Next </button>";
//echo "</div>";
// reading Xls file
//echo "<div id ='OD'>";
if($file_ext2 == '.xls')
{
	// OD File
		      
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($folder.$m_OdFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_ndemand = $OdTripF->sheets[0]['numRows'] ;    // work
        
       
//   		echo '<div id="scroller"><table border=1 cellspacing=0 width="100%"><caption><B>Origin Destination matrix</B></caption>';      
		for ($i = 1; $i <= $m_ndemand; $i++)
        {           	
//            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$m_ndemand; $j++)
            {
                $m_ODMtx[$i][$j]=$OdTripF->sheets[0]['cells'][$i][$j];

            }               
//            echo "</tr>";       
        }
//        echo "</table></div><br>";
		
}
elseif($file_ext2 == '.csv')
{
	// reading csv file
	
	// OD File 
	
	 $Col=0; 
	 $m_ndemand = 0;
	$name = $folder.$m_OdFile;
    $file2 = fopen($name , "r");
    while (($data = fgetcsv($file2, 8000, ",")) !== FALSE) 
    {
    	$Col = count($data);

    	for ($c=0; $c <$Col; $c++)
    	{    	   
        	$m_OD[$m_ndemand][$c] = $data[$c];        	
     	}
     	 $m_ndemand++;    
    }
    for ($i = 0; $i < $m_ndemand; $i++) 
    { 
         for ($j = 0; $j < $Col; $j++)
         {
         		$m_ODMtx[$i+1][$j+1] = $m_OD[$i][$j] ;      	
         }
    	
    }
    fclose($file2);


}

   
 //-------------------------------------- 
   
      
// declaring artificial time     

function amit($x,$a,$c)
{
$t1 = $a+$_POST['alphaValue']*$a*pow($x/$c,$_POST['betaValue']);
return $t1;
}     
function timeaxa($x,$a,$c)
   {
$taxa=amit($x,$a,$c)+$x*derivative($x,$a,$c);
 //echo $taxa."ejdkwjk"."&nbsp;";
return $taxa;
}     

// w.r.t xa

function derivative($x,$a,$c){
$h=0.0001;
$derv=(amit($x+$h,$a,$c)-amit($x-$h,$a,$c))/(2*$h);
//echo amit($a,$x+$h)-amit($a,$x-$h)."jai". $derv."</br>";
//$derv = round ($derv,5);
return $derv;
}

//w.r.t. Alpha

function derivativ($alpha,$x,$y,$a,$c){
$h=0.0001;
$dd=$x+($alpha-$h)*($y-$x);
$ddh=$x+($alpha+$h)*($y-$x);
$derv1=(amit($ddh,$a,$c)-amit($dd,$a,$c))/(2*$h);
//echo $dd."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;".$ddh;
// echo  $derv1."</br>";
//$derv1 = round ($derv1,5);
return $derv1;
}

// function of linear search for the value of alpha to minimise the value of Z

function linearsearch($trat,$cons,$m_nlinks,$x,$y,$b){
$a=0;
while ($b-$a >=0.001){
$z=0;
$alpha=($b+$a)/2;	
//echo $alpha."ggg".$a."jih".$b."</br>";
for ($j=1;$j<=$m_nlinks;$j++){
//echo $x[$j]."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;".$y[$j]."&nbsp;"."</br>";
$m=$x[$j]+$alpha*($y[$j]-$x[$j]);
//echo ($y[$j]-$x[$j]);
$p=amit($m,$trat[$j],$cons[$j]);
$q=derivativ($alpha,$x[$j],$y[$j],$trat[$j],$cons[$j]);
//echo ($y[$j]-$x[$j])."nnnn"."</br>";
$z+=(($y[$j]-$x[$j])*($p))+($q*$m);

//echo $trat[$j]."lalalalalal";
}
 //echo $z."hhhh".$alpha."</br>";
//echo("</br>");

if ($z<=0){
$a=$alpha;
}
else {
$b=$alpha;
}

}
$alpha=($b+$a)/2;
//echo $alpha;
return $alpha;
}        

       
// function to find shortest path

      function shortpath($m_nlinks,$m_nnodes,$frm,$to,$trat,$originnode,$desnode){

      // defining label list  and predeserror list

      //echo $m_nlinks."amit".$m_nnodes."kumar".$originnode."singh".$desnode."</br>";
      
      for ($i = 1; $i <= $m_nnodes; $i++)
      {
            $lb[$i]=1000000000000000000000;
            $pl[$i]=-2;
            $s[$i]=0;

      }
      
      // assigning origin node value 0 putting it on sequence list , top and bottom of list
      
      $s[$originnode]=1000000000000000000000;
      $lb[$originnode]=0;
      
      // top and bottom are denoted by special pointer 
      
      $top=$originnode;
      $bottom=$originnode;
      $tenp=0;  
      for ($k = 1; $k <= $m_nlinks; $k++){
     // echo "kumar"."<br>";
      for ($i = 1; $i <= $m_nlinks; $i++){      
      /*
      for ($j = 1; $j <= $m_nnodes; $j++){
      if ($s[$j]!=0 ){if( $s[$j]!=-1){
     
      $temp=1;
      }}
              } 
       if($temp!=1){
       break;
       }
       $temp=0;*/
      // echo "amit"."<br>";
      if ($frm[$i]==$top) {
       
      for ($j = 1; $j <= $m_nnodes; $j++){
       // echo $lb[$j]."&nbsp;"."&nbsp;";
       }
      for ($j = 1; $j <= $m_nnodes; $j++){
       // echo $pl[$j]."&nbsp;"."&nbsp;";
              }
              
        for ($j = 1; $j <= $m_nnodes; $j++){
        //echo $s[$j]."jfd"."&nbsp;"."&nbsp;";
              } 
              // echo $top."amit".$bottom;    
      // echo "<br>".$k."<br>";
      	if ($lb[$frm[$i]]+$trat[$i]<$lb[$to[$i]]){
      	$lb[$to[$i]]=$lb[$frm[$i]]+$trat[$i];
      	$pl[$to[$i]]=$frm[$i];
      	
      	
      	if ($s[$to[$i]]==0){
      	$s[$to[$i]]=1000000000000000000000;
      	$s[$bottom]=$to[$i];
      	$bottom=$to[$i];
      	//echo $bottom."hiiiii".$s[$bottom]."<br>";
      	}     	
      	
      	if ($s[$to[$i]]==-1) {
      	$s[$to[$i]]=$top;
      	$top=$to[$i];
      	//echo $top."hooooo".$s[$top]."<br>";
      	}
      	}
      	// echo $top."hiiii".$s[$top]."<br>";	
      }
    
      }
      
      if ($top != $bottom) {      
     //echo $top."hooooo".$s[$top]."<br>";
      $d=$top;
      $top=$s[$top];
      $s[$d]=-1;
      
      
      }
      }
      
      $ans[0]=$desnode;
       for ($i = 1; $i <= $m_nnodes; $i++){
       if ($pl[$ans[$i-1]]==-2) {
       	
       break;}
       $ans[$i]=$pl[$ans[$i-1]];
      
       }
      // echo "<br>";
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
            for ($i = 1; $i < $count; $i++) {
       //echo $link1[$i]."hgfdsa"."&nbsp"."</br>";
            }
            //echo "<br>";
return compact('ans1', 'count','link1');

        }

// All or nothing Assingment

for ($j=1;$j<=$m_nlinks;$j++){
$x[$j]=0;
$y[$j]=0;
}

//initiallization all links 0 flow

for ($i = 1; $i <= $m_nlinks; $i++) {
	$t[$i]=amit (0,$trat[$i],$cons[$i]);
	$tt[$i]=timeaxa(0,$trat[$i],$cons[$i]);
	//echo $tt[$i]."<br>";
}
//echo "</br>";

//echo $m_ndemand;
      for ($l=2;$l<=$m_ndemand;$l++){
     // echo "Amit";
	//echo "</br>";
       $originnode=$m_ODMtx[$l][1];
       $desnode=$m_ODMtx[$l][2];
       $total=$m_ODMtx[$l][3];  

      if ($total==0){continue;}
    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$tt,$originnode,$desnode));
//if($count==1){continue;}
//echo "</br>";

for ($j=1;$j<$count;$j++){
//echo $link1[$j]."</br>";
}

//break ;
for ($j = 1; $j <$count ; $j++) { 
         
$x[$link1[$j]]=$x[$link1[$j]]+$total;
//unset($link1[$j]);
}
      
      }
    
// convergence criteria based on step size

if ($m_ConCriteria == "Alpha")
{      
$ii=1;
$alph=1;
while ($alph>0.005 && $ii<=1000){$ii++;
//Update
  //echo "Alpha  :".$alph."<br>";
for ($j = 1; $j <= $m_nlinks; $j++) {

  
	$t[$j]=amit ($x[$j],$trat[$j],$cons[$j]);
	$tt[$j]=timeaxa ($x[$j],$trat[$j],$cons[$j]);
	///echo $x[$j]."ddddddd"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$tt[$j]."fff"."</br>";
	}
//echo  "</br>";
for ($j=1;$j<=$m_nlinks;$j++){
$y[$j]=0;
}
// Auxilary Flow
	
	for ($l=2;$l<=$m_ndemand;$l++){
      	
        $originnode=$m_ODMtx[$l][1];
       	$desnode=$m_ODMtx[$l][2];
	$total=$m_ODMtx[$l][3];  

      if ($total==0){continue;}
    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$tt,$originnode,$desnode));
//if($count==1){continue;}


for ($j=1;$j<$count;$j++){
 $link1[$j]."</br>";
}

//break ;
for ($j = 1; $j <$count ; $j++) { 
         
$y[$link1[$j]]=$y[$link1[$j]]+$total;
//unset($link1[$j]);
}
      
      }


// step size i.e. alpha

 for ($i = 1; $i <= $m_nlinks; $i++)
      {
     // echo  $x[$i]."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$y[$i]."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$t[$i]."</br>";
      }
$alph=linearsearch($trat,$cons,$m_nlinks,$x,$y,1);
//echo $alph."</br>";
//break;
for ($j=1;$j<=$m_nlinks;$j++){

$x[$j]=$x[$j]+$alph*($y[$j]-$x[$j]);

//echo "Xi ".$x[$j]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."traveltime".$y[$j]."</br>";
}
//break;
$PlotY[$ii] = $alph;
}
$PlotX = $ii;
/*
$mmmm=0;
 for ($j=1;$j<=$m_nlinks;$j++){
$mmmm+=$t[$j]*$x[$j];
}
*/
}

// convergence criteria based on Travel Time

else if ($m_ConCriteria == "TravelTime")
{
$alph=1;
$ii=0;

//Update Travel time

do{$ii++;
for ($j = 1; $j <= $m_nlinks; $j++) {

    // echo $x[$j]."check".$trat[$j]."<br>";
    $temptime[$j]=$t[$j];
	$t[$j]=amit ($x[$j],$trat[$j],$cons[$j]);
	$tt[$j]=timeaxa ($x[$j],$trat[$j],$cons[$j]);
	///echo $x[$j]."ddddddd"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$tt[$j]."fff"."</br>";
	}
//echo  "</br>";
for ($j=1;$j<=$m_nlinks;$j++){
$y[$j]=0;
}

   // Auxilary Flow
	
	for ($l=2;$l<=$m_ndemand;$l++){
      	
        $originnode=$m_ODMtx[$l][1];
       	$desnode=$m_ODMtx[$l][2];
	$total=$m_ODMtx[$l][3];  

      if ($total==0){continue;}
    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$tt,$originnode,$desnode));
//if($count==1){continue;}


for ($j=1;$j<$count;$j++){
 $link1[$j]."</br>";
}

//break ;
for ($j = 1; $j <$count ; $j++) { 
         
$y[$link1[$j]]=$y[$link1[$j]]+$total;
//unset($link1[$j]);
}
      
      }

// step size i.e. alpha
/*
 for ($i = 1; $i <= $m_nlinks; $i++)
      {
      //echo  $x[$i]."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$y[$i]."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$t[$i]."gggg".$alph."</br>";
      }*/
$alph=linearsearch($trat,$cons,$m_nlinks,$x,$y,1);
//echo $alph."</br>";
//break;
for ($j=1;$j<=$m_nlinks;$j++){
$tempflow[$j]=$x[$j];
$x[$j]=$x[$j]+$alph*($y[$j]-$x[$j]);

//echo "Xi ".$x[$j]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."traveltime".$y[$j]."</br>";
}
//break;

// ---------- check 1 start ------------

$check1 = 0;
for ($j = 1; $j <= $m_nlinks; $j++) {
     $check1+= (abs ($t[$j]-$temptime[$j]))/$t[$j];
}
//echo $check1."<br>";
$PlotY[$ii] = $check1;

// ------------ check 1 end -------------

}while ($ii<=1000 && $check1>0.01);
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

    // echo $x[$j]."check".$trat[$j]."<br>";
    $temptime[$j]=$t[$j];
	$t[$j]=amit ($x[$j],$trat[$j],$cons[$j]);
	$tt[$j]=timeaxa ($x[$j],$trat[$j],$cons[$j]);
	///echo $x[$j]."ddddddd"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$tt[$j]."fff"."</br>";
	}
//echo  "</br>";
for ($j=1;$j<=$m_nlinks;$j++){
$y[$j]=0;
}

      // Auxilary Flow
	
	for ($l=2;$l<=$m_ndemand;$l++){
      	
        $originnode=$m_ODMtx[$l][1];
       	$desnode=$m_ODMtx[$l][2];
	$total=$m_ODMtx[$l][3];  

      if ($total==0){continue;}
    //echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  
extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$tt,$originnode,$desnode));
//if($count==1){continue;}


for ($j=1;$j<$count;$j++){
 $link1[$j]."</br>";
}

//break ;
for ($j = 1; $j <$count ; $j++) { 
         
$y[$link1[$j]]=$y[$link1[$j]]+$total;
//unset($link1[$j]);
}
      
      }

// step size i.e. alpha
/*
 for ($i = 1; $i <= $m_nlinks; $i++)
      {
      //echo  $x[$i]."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$y[$i]."&nbsp;&nbsp;"."&nbsp;&nbsp;"."&nbsp;&nbsp;".$t[$i]."gggg".$alph."</br>";
      }*/
$alph=linearsearch($trat,$cons,$m_nlinks,$x,$y,1);
//echo $alph."</br>";
//break;
for ($j=1;$j<=$m_nlinks;$j++){
$tempflow[$j]=$x[$j];
$x[$j]=$x[$j]+$alph*($y[$j]-$x[$j]);

//echo "Xi ".$x[$j]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."traveltime".$y[$j]."</br>";
}
//break;

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

}while ($ii<=200 && $check2>0.0005);
$PlotX = $ii - 1;
}

$mmmm=0;
 for ($j=1;$j<=$m_nlinks;$j++){
$mmmm+=$t[$j]*$x[$j];
}

//echo"</br>".$mmmm."tstt"."</br>";
echo '<div id = "Final">';
echo '<div id="scroller"><caption><b> Result </b></caption><table class="table table-bordered table-hover">';
echo '<tr align="center" bgcolor="#EBF5FF">';     
              echo '<td bgcolor="#B8DBFF">';echo "<b>From</b>"; echo "</td>";
              echo '<td bgcolor="#B8DBFF">';echo "<b>to</b>"; echo "</td>";      
              echo '<td bgcolor="#B8DBFF">';echo "<b>Link Flow(Xi)</b>"; echo "</td>";
              echo '<td bgcolor="#B8DBFF">';echo "<b>Link Travel Time(Ti)</b>"; echo "</td>";
              echo '<td bgcolor="#B8DBFF">';echo "<b>Marginal Total Travel Time</b>"; echo "</td>";             
             // echo '<td bgcolor="#B8DBFF">';echo "<b>Total System Travel time</b>"; echo "</td>";
              echo  '</tr>';
 for ($i = 1; $i <= $m_nlinks; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';   
            echo '<td>';echo $frm[$i]; echo "</td>";
            echo '<td>';echo $to[$i]; echo "</td>";        
            echo '<td>';echo (int)$x[$i]; echo "</td>";
            echo '<td>';echo round($t[$i],2); echo "</td>";
            echo '<td>';echo round($tt[$i],2); echo "</td>";
            //echo '<td>';echo $t[$i]*$x[$i]/10000000; echo "</td>"; 
            echo "</tr>";       
        }
        echo "</br>"."</br>";
        
        echo "</table></div><br><br>";
        
         echo '<table class="table table-bordered table-hover">'; 
        echo '<tr align="center">';
        echo '<td bgcolor="#B8DBFF"><b> Total System Travel Time </b></td >';
        echo '<td bgcolor="#EBF5FF">'.round($mmmm,2).'</td>';
        echo "</tr>";
        echo  '</table><br><br>';
//        echo "<button class = 'btn4'> Previous </button>";
//		echo "<div>";       
        
?>        
      
  <br><br>

<form enctype="multipart/form-data" method="post" name="Frm" action="SystemOptModRes.php">
        
        <table cellspacing=5>
        	<input type="hidden" name="NodeFile" value="<?=$m_NodeFile?>"> 
        	<input type="hidden" name="OdFile" value="<?=$m_OdFile?>">
        	<input type="hidden" name="ConCriteria" value="<?=$m_ConCriteria?>">  
        	
        	<input type="hidden" name="PlotX" value="<?=$PlotX?>">   
        	<?php 
        	$_SESSION['ConCriteria'] = $m_ConCriteria; 
        	$_SESSION['alphaValue'] = $_POST['alphaValue'];
        	$_SESSION['betaValue'] = $_POST['betaValue'];
        	?>
        	
        	<?php for($i=0 ; $i < $ii; $i++ ) 
        	{
        	?>
        	<input type="hidden" name="PlotY[]" value="<?=$PlotY[$i]?>">       
        	<?php 
        	}
        	?>
        	        	
        	<tr>
<!--        		<td align="center"><input type="submit" class=button value="Generate XLS Report" name="genrepo" OnClick="return chk1()"></td>-->
<!--        		<td align="center"><input type="submit" class=button value="Generate PDF Report" name="genrepo" OnClick="return chk2()"></td>-->
        		<td align="center"><input type="submit" class=button value="Generate Graph" name="gengrph" OnClick="return chkgraph()"></td>
        	</tr>
									
		</table>
		
		<br>
<table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk1()">
</td></tr>
</table> 
<br><br>		
		<table cellspacing=5 width = "40%" align="center" border=0>
		<tr>
   			<td align="center">&nbsp;&nbsp;<a href="SystemOptModDel.php&NodeFile=<?=$m_NodeFile?>&OdFile=<?=$m_OdFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
		</tr>
		</table>
		<br>
		
</form>
</center>
</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  