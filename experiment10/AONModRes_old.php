<?php
session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
//include "userchk.php";	//To check user's session

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];

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
    	location="AONMod.php";
    </script>
	<?php 
}
else 
{
//  move uploaded files to user specific folder
 
	move_uploaded_file($_FILES["NodeFile"]["tmp_name"],$UploadFile."/Experiment10/" . $_FILES["NodeFile"]["name"]);
	move_uploaded_file($_FILES["OdFile"]["tmp_name"],$UploadFile."/Experiment10/" . $_FILES["OdFile"]["name"]);
}
//----------------------------------------------------------------------------------------------
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Virtual Labs - IIT Bombay</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<style type="text/css">@import "css/flexnav.css";</style>
<script type="text/javascript" src="js/beethoven.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
<link href="css/custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="ddtabmenufiles/ddtabmenu.js"></script>
<link rel="stylesheet" type="text/css" href="ddtabmenufiles/glowtabs.css" />

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
	document.Frm.action="AddAONModRpt.php";	
}
/*
function chk2()
{ 
	document.Frm.action="AONModRptPdf.php";	
}
*/
</script>

</head>

<body bgcolor="#FFFFFF" >
<div id="header_main"></div>
 <div id="no_print">
<!-- start header -->
<div id="header">
         <ul id="menuTop">
           <li><a href="home.php">Home</a></li>
           <li><a href="logout.php">Log Out</a></li>
        </ul>

</div>

<div style="position: relative; margin:auto; width: 1024px; background-color:#e3f2fc"><br/>
  <span class="title"> All or Nothing Assignment</span>
</div>

 <div id="no_print"></div>
 
<div style="background-image:url(images/content_bg.jpg);position: relative; margin:auto; width: 1024px; min-height:400px;">
        <div id="contentBox" style=" padding:0px; padding-left:50px; padding-right:50px;">
<ul>

<center>
<BR><BR><BR>

<div id ="link">

<?php

// reading Xls file

if($file_ext1 == '.xls')
{
	// Node File
			
		include 'phpExcelReader/Excel/reader.php';
		$dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($UploadFile."/Experiment10/".$m_NodeFile);
       
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nlinks = $dataTripF->sheets[0]['numRows']-1 ;
        $Col = $dataTripF->sheets[0]['numCols'];
    
//        echo '<div id="scroller"><table border=1 cellspacing=0 align="center" width="100%"><caption><b> Link Flow Characteristics </b></caption>';
        for ($i = 1; $i <= $m_nlinks+1; $i++)
        {           	
//            echo '<tr align="center" bgcolor="#EBF5FF">';    
			for ($j = 1; $j < $Col; $j++)
            {
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
               
                if($i==1)
                {
//                	 echo '<td bgcolor="#B8DBFF">';
//                    echo '<b>'.$m_TripMtx[$i][$j].'</b>';
//                    echo "</td>";
                }
                else 
                {
//                	 echo '<td>';
//              		echo $m_TripMtx[$i][$j];
//              		echo "</td>";
                }
                              
                   
                
            }               
//            echo "</tr>";       
        }
//        echo "</table></div><br>";
		
}
elseif($file_ext1 == '.csv')
{	
	// reading CSV file
	
	// Node File
    
	$Col=0; 
	$m_nlinks = 0;
	$name = $UploadFile."/Experiment10/".$m_NodeFile;
    $file1 = fopen($name , "r");
    while (($data = fgetcsv($file1, 8000, ",")) !== FALSE) 
    {
    	$Col = count($data);

    	for ($c=0; $c <$Col-1; $c++)
    	{
    	  
        	$m_Trip[$m_nlinks][$c] = $data[$c];
        	
     	}
     	$m_nlinks++;
    
    }
    for ($i = 0; $i < $m_nlinks; $i++) 
    { 
         for ($j = 0; $j < $Col-1; $j++)
         {
         		$m_TripMtx[$i+1][$j+1] = $m_Trip[$i][$j] ;    
         		
         }
    	
    }
    fclose($file1);
    
//    echo '<div id="scroller"><table border=1 cellspacing=0 align="center" width="100%"><caption><b> Link Flow </b></caption>';
    for ($i = 1; $i <= $m_nlinks; $i++)
    {           	
 //           echo '<tr align="center" bgcolor="#EBF5FF">';    
			for ($j = 1; $j < $Col; $j++)
            {
               
                if($i==1)
                {
//                	 echo '<td bgcolor="#B8DBFF">';
//                    echo '<b>'.$m_TripMtx[$i][$j].'</b>';
//                    echo "</td>";
                }
                else 
                {
//                	 echo '<td>';
//              		echo $m_TripMtx[$i][$j];
//              		echo "</td>";
                }
            }               
//            echo "</tr>";       
     }
//    echo "</table></div><br>";	
	$m_nlinks--;
}

//echo "<button class = 'btn1'> Next </button>";
//echo "</div>";
// reading XLS file
//echo "<div id ='OD'>";
if($file_ext2 == '.xls')
{	      
	// OD File
	
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($UploadFile."/Experiment10/".$m_OdFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nnodes = $OdTripF->sheets[0]['numRows'] ;
        $z=1;
        for ($i = 1; $i <= $m_nnodes; $i++)
        {
        	if($OdTripF->sheets[0]['cells'][1][$i] != 0)
        	{
        			$z++;
        	}
        
        }

       $m_nnodes =$z;
//   		echo '<div id="scroller"><table border=1 cellspacing=0 width="100%"><caption><B>Origin Destination matrix</B></caption>';      
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
//            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$m_nnodes ; $j++)
            {
                $m_ODMtx[$i][$j]=$OdTripF->sheets[0]['cells'][$i][$j];
                
                if($i==1)
                {
//                	 echo '<td bgcolor="#B8DBFF">';
//                    echo '<b>'.$m_ODMtx[$i][$j].'</b>';
//                    echo "</td>";
                }
                else 
                {
                	if($j==1)
                	{
 //               	  echo '<td bgcolor="#B8DBFF">';
//                	  echo '<b>'.$m_ODMtx[$i][$j].'</b>';
//                	  echo "</td>";
                	}
                	else 
                	{
//                	echo "<td>";
//              		echo $m_ODMtx[$i][$j];
//              		echo "</td>";
                	}                
                }
                
            }               
//            echo "</tr>";       
        }
//        echo "</table></div><br>";
		
}
elseif($file_ext2 == '.csv')
{
	// reading CSV file
	
	// OD file
	
	$Col=0; 
	$m_nnodes = 0;
	$name = $UploadFile."/Experiment10/".$m_OdFile;
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
//    echo '<div id="scroller"><table border="1" cellspacing=0 width="100%"><caption><B>Origin Destination matrix</B></caption>';      
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
 //           echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$m_nnodes ; $j++)
            {
                
                if($i==1)
                {
//          			echo '<td bgcolor="#B8DBFF">';
//                    echo '<b>'.$m_ODMtx[$i][$j].'</b>';
//                    echo "</td>";
                }
                else 
                {
                	if($j==1)
                	{
//                	  echo '<td bgcolor="#B8DBFF">';
//                	  echo '<b>'.$m_ODMtx[$i][$j].'</b>';
//                	  echo "</td>";
                	}
                	else 
                	{
//                	echo "<td>";
//              		echo $m_ODMtx[$i][$j];
//              		echo "</td>";
                	}                
                }                
            }               
//            echo "</tr>";       
        }
//        echo "</table></div><br>";
		
		$m_nnodes--;
}
//echo "<button class = 'btn2'> Previous </button>";
//echo "<button class = 'btn3'> Next </button>";
//echo "</div>";
////////////////////////////////////////////////////////////////////////////////

$m_nnodes=$m_nnodes-1;

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
   
      
   // declaring artificial time     
    function amit($x,$a,$c,$b)
    {
		$t=$a+$b*pow($x/$c,4);
		return $t;
	}

	//function of linear search for the value of alpha to minimise the value of Z
	
	function linearsearch($trat,$cons,$m_nlinks,$x,$y,$b,$bb)
	{

		while ($b-$a>=0.01){
		$z=0;
		$alpha=($b+$a)/2;
		for ($i=1;$i<=$m_nlinks;$i++)
		{
   			$m=$x[$i]+$alpha*($y[$i]-$x[$i]);

   			$p=amit($m,$trat[$i],$cons[$i],$bb[$i]);

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

// initiallization all links 0 flow

for ($i = 1; $i <= $m_nlinks; $i++) {
	$t[$i]=amit (0,$trat[$i],$cons[$i],$B0[$i]);
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


   for ($i = 1,$j = 2; $i < $m_nlinks+1 && $j<$m_nlinks+2; $i++,$j++)
   {           	
   		$y[$j]=$x[$i];
        
   } 

	// Final Assignment
//   echo '<div id = "Final">';	      
   echo '<div id="scroller"><table border=1 cellspacing=0 width="100%"><caption><B>Final Assignment</B></caption>';
   echo '<tr align="center" bgcolor="#B8DBFF">';
   echo '<td><b>From</b></td><td><b>To</b></td><td><b>Flow</b></td></tr><tr>';
   /*
   for ($i = 2; $i <= $m_nlinks+1; $i++)
   {           	
   		echo '<tr align="center" bgcolor="#EBF5FF">';           
        for ($j = 1; $j < 3; $j++)
        {
        		
                echo '<td >';                
                echo $m_TripMtx[$i][$j];                    
                echo "</td>";
        		
            }
            echo "<td>".$y[$i]."</td>";               
            echo "</tr>";       
   }
   */
    	for ($i = 1; $i <= $m_nlinks; $i++)
        {           	
             echo '<tr align="center" bgcolor="#EBF5FF">';
             echo '<td>';echo $frm[$i]; echo "</td>";echo '<td >';
             echo $to[$i]; echo "</td>";           
             echo '<td>';echo round($x[$i],6); echo "</td>";
             echo "</tr>";       
        }
   echo "</table></div><br>";
//echo "<button class = 'btn4'> Previous </button>";
//echo "<div>";
?>        

<form enctype="multipart/form-data" method="post" name="Frm" action="AONModRes.php">
 <table align="right">
<tr align ="right"><td>
<input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk1()">
</td></tr>
</table>        
        <table cellspacing=5>
        	<input type="hidden" name="NodeFile" value="<?=$m_NodeFile?>"> 
        	<input type="hidden" name="OdFile" value="<?=$m_OdFile?>"> 
        	
        	<tr><td align="center">
<!--        	<input type="submit" class=button value="Generate XLS Report" name="genrepo" OnClick="return chk1()">-->
<!--        	<input type="submit" class=button value="Generate PDF Report" name="genrepo" OnClick="return chk2()">-->
        	</td></tr>
									
		</table>
		
		<br>
		
		<table cellspacing=5 width = "40%" align="center" border=0>
		<!-- 
		<tr>
  			<td align="center">&nbsp;&nbsp;<a href="AONMod.php"><H2><u>Back</u></H2></a>&nbsp;&nbsp;</td>
		</tr>
		-->

		<tr>
   			<td align="center">&nbsp;&nbsp;<a href="AONModDel.php?NodeFile=<?=$m_NodeFile?>&OdFile=<?=$m_OdFile?>"><H3><input type="button" value="Restart Experiment"></H3></a>&nbsp;&nbsp;</td>
		</tr>
		</table>
		<br>
		
</form>

<br>

</ul>
</center>

</div> 

<br><br>
    </p>
 
  </div>
</div>
<div style="position: relative; margin:auto; width: 1024px; background-color:#0e8de0">
<img src="images/footer-curve.jpg" width="1024" height="31" alt=""><div class="copyright">Copyright &copy; 2010-2011</div><br>
</div>

</body>
</html>