<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4,"All or Nothing (AON) Assignment","Trip Assignment");

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment10/";

$m_ConCriteria =  $_POST['ConCriteria'];
$m_NodeFile = $_FILES['NodeFile']['name'];
$m_ODFile = $_FILES['ODFile']['name'];

 $m_NodeFile = $_SESSION['NodeFile'];
 $m_ODFile = $_SESSION['ODFile'];
if(empty($m_NodeFile))
{
	$m_NodeFile = $_POST['NodeFile'];
}
if(empty($m_ODFile))
{
	$m_ODFile = $_POST['ODFile'];
}

//----------------------------------verifying the format of the file---------------------------

$file_ext1= substr($m_NodeFile, strripos($m_NodeFile, '.'));
$file_ext2= substr($m_ODFile, strripos($m_ODFile, '.'));

if(!($file_ext1 == '.csv'&& $file_ext2 == '.csv'  || $file_ext1 == '.xls' && $file_ext2 == '.xls'))
{
	?>
	<script language="javascript">
	 //   alert("invalid file format");
    //	location="AONMod.php?Exp=8";
    </script>
	<?php 
}
else 
{
	//  move uploaded files to user specific folder 
	
	move_uploaded_file($_FILES["NodeFile"]["tmp_name"],$folder . $_FILES["NodeFile"]["name"]);
	move_uploaded_file($_FILES["ODFile"]["tmp_name"],$folder . $_FILES["ODFile"]["name"]);
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
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/jquery.inputfocus-0.9.min.js"></script>
 

<script language="javascript">
function chk1()
{ 
	document.Frm.action="intermediateAllorNothingModelReport.php?Exp=8";	
}

</script>
</head>
<div id="body">
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


$node1=array_unique($merge_1);


$z=1;

for($i = 0; $i < 2*$m_nlinks; $i++){

if($node1[$i]!= null){
$node[$z]=$node1[$i];
$z++;
}
}

$m_nnodes =count($node);



for ($i = 1; $i <= $m_nlinks; $i++)
{
	$frm[$i] = array_search($frm[$i], $node);
	$to[$i]= array_search($to[$i], $node);
}

if($file_ext2 == '.xls')
{
	// OD File
		      
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($folder.$m_ODFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_ndemand = $OdTripF->sheets[0]['numRows'] ;    // work
        
          
		for ($i = 1; $i <= $m_ndemand; $i++)
        {           	
            for ($j = 1; $j <=$m_ndemand; $j++)
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
	 $m_ndemand = 0;
	$name = $folder.$m_ODFile;
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
//////////////////////////////////////////////////////////////////////

// Array to OD format



for ($i = 2; $i <= $m_ndemand+1; $i++)
{
	$m_ODMtx[$i][1] = array_search($m_ODMtx[$i][1], $node);
	$m_ODMtx[$i][2] = array_search($m_ODMtx[$i][2], $node);
}

$m_ODMtx1[1][1]="Amit";
for ($i = 2; $i <= $m_nnodes+1; $i++)
{
$m_ODMtx1[$i][1]= $i-1;
$m_ODMtx1[1][$i]= $i-1;
}

for ($i = 2; $i <= $m_nnodes+1; $i++)
{
for ($j = 2; $j <= $m_nnodes+1; $j++)
{
$m_ODMtx1[$i][$j]=0;
}
}


for ($i = 1; $i <= $m_ndemand+1; $i++)
{

$m_ODMtx1[$m_ODMtx[$i][1]+1][$m_ODMtx[$i][2]+1]=$m_ODMtx[$i][3];

}


////////////////////////////////////////////////////////////////////////////////
      
// declaring artificial time     
    
// x is a flow on any link
// a is a free flow travel time
// c is link capacity
function amit($x,$a,$c)
{
	$time = $a+0.15*$a*pow($x/$c,4);
	return $time;
}

//function of linear search for the value of alpha to minimise the value of Z
function linearsearch($trat,$cons,$m_nlinks,$x,$y,$b)
{
$a=0;
		while ($b-$a>=0.01)
		{
			$z=0;
			$alpha=($b+$a)/2;
			for ($i=1;$i<=$m_nlinks;$i++)
			{
   				$m=$x[$i]+$alpha*($y[$i]-$x[$i]);

   				$p=amit($m,$trat[$i],$cons[$i]);

  				$z+=($y[$i]-$x[$i])*$p;
			}
			//echo "a  :".$a."   b : ".$b."  z:".$z."<br>"; 
			if ($z<=0)
			{
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
       
function pathextractor($m_nlinks,$m_nnodes,$frm,$to,$originnode,$desnode,$pl){

$ans[0]=$desnode;
	for ($i = 1; $i <= $m_nnodes; $i++)
	{
		if ($pl[$ans[$i-1]]==0)
    	{
    		break;
    	}
    	$ans[$i]=$pl[$ans[$i-1]];
	}
	
	$count=1;
	$count= count($ans);
	
	
	//echo $count;
	for ($i = 0; $i < $count; $i++)
	{
   		 $ans1[$count-$i]=$ans[$i];
	}
	$m=1;
	for ($i = 1; $i < $count; $i++)
	{
       for ($k = 1; $k <= $m_nlinks; $k++)
       {
      
      		if($ans1[$i]==$frm[$k] && $ans1[$i+1]==$to[$k])
      		{
     	    	$link1[$m]=$k;
      			$m++;
      			break;
      		}
       }
	}	
	return compact('count','link1');
}

function shortpath($m_nlinks,$m_nnodes,$frm,$to,$trat,$originnode,$desnode,$temp,$pl)
{			
	if($temp==0){
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
	}
	
	extract (pathextractor($m_nlinks,$m_nnodes,$frm,$to,$originnode,$desnode,$pl));
	return compact('count','link1','pl');	
}
   
 
// All or nothing Assingment  
$m_nnodes=$m_nnodes;
for ($j=1;$j<=$m_nlinks;$j++)
{
	$x[$j]=0;
	$y[$j]=0;
}

// initiallization all links 0 flow

for ($i = 1; $i <= $m_nlinks; $i++) 
{
	$t[$i]=amit (0,$trat[$i],$cons[$i]);
	//echo $t[$i]."<br>";
}

for($i=1;$i<=$m_nnodes;$i++){
		$pl[$i]=0;
}

for ($l=2;$l<=$m_nnodes+1;$l++)
{
	$temp=0;
    for ($ll=2;$ll<=$m_nnodes+1;$ll++)
    {
      	$originnode=$m_ODMtx1[$l][1];
      	$desnode=$m_ODMtx1[1][$ll];
      	$total=$m_ODMtx1[$l][$ll];  
      	if ($total==0)
      	{
      		continue;
      	}
    	//echo $originnode."&nbsp;&nbsp;".$desnode."&nbsp;&nbsp;".$total."</br>";
  		extract (shortpath ($m_nlinks,$m_nnodes,$frm,$to,$t,$originnode,$desnode,$temp,$pl));
		//if($count==1){continue;}
		for ($j=1;$j<$count;$j++)
		{
			//echo $link1[$j]."</br>";
		}
		//echo "</br>";
		//break ;
		$temp=1;
		for ($j = 1; $j <$count ; $j++) 
		{ 
        	$x[$link1[$j]]=$x[$link1[$j]]+$total;
		//unset($link1[$j]);
		}
	}
	
}


$sum=0; 
//echo $ii;
//echo '<div id = "Final">';
echo '<div id="scroller"><caption><b> Result </font></b></caption><table class="table table-bordered table-hover">';
	echo '<tr align="center" bgcolor="#EBF5FF">'; 
             echo '<td bgcolor="#B8DBFF">';echo "<b>From</b>"; echo "</td>";
             echo '<td bgcolor="#B8DBFF">';echo "<b>to</b>"; echo "</td>";           
             echo '<td bgcolor="#B8DBFF">';echo "<b>Link Flow(X<sub>i</sub>)</b>"; echo "</td>";
             echo '<td bgcolor="#B8DBFF">';echo "<b>Link Travel time(t<sub>ij</sub>)</b>"; echo "</td>";
          //   echo '<td bgcolor="#B8DBFF">';echo "<b>Total System Travel time</b>"; echo "</td>";
    echo  '</tr>';
 	for ($i = 1; $i <= $m_nlinks; $i++)
        {           	
             echo '<tr align="center" bgcolor="#EBF5FF">';
             echo '<td>';echo $node[$frm[$i]]; echo "</td>";echo '<td >';
             echo $node[$to[$i]]; echo "</td>";           
             echo '<td>';echo (int)($x[$i]); echo "</td>";
             echo '<td>';echo round($t[$i],2); echo "</td>";
            //echo '<td>';echo $t[$i]/10000000; echo "</td>";
            // echo '<td>'; echo ($x[$i]*$t[$i])/10000000; echo "</td>";
            $sum +=($x[$i]*$t[$i]); 
             echo "</tr>";       
        }
        echo "</table></div><br>";
            
        echo '<table class="table table-bordered table-hover">'; 
        echo '<tr align="center">';
        echo '<td bgcolor="#B8DBFF"><b> Total System Travel Time </b></td >';
        echo '<td bgcolor="#EBF5FF">'.round($sum,2).'</td>';
        echo "</tr>";
        echo  '</table>';
?>        

<form enctype="multipart/form-data" method="post" name="Frm" action="AONModRes.php?Exp=8">
   
        	<input type="hidden" name="NodeFile" value="<?=$m_NodeFile?>"> 
        	<input type="hidden" name="ODFile" value="<?=$m_ODFile?>">
 

<input type="submit" class="x  pull-right" value="Add To Report" name="Submit" OnClick="return chk1();">
<br><br>
<center>
 <a href="AONModDel.php?Exp=8&NodeFile=<?=$m_NodeFile?>&ODFile=<?=$m_ODFile?>"><H3><input  type="button" value="Restart Experiment"></H3></a>
		
</center>		
</form>
</div></div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  

