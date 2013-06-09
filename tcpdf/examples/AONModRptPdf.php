<?php
session_start();	//To check whether the session has started or not
include"conn.php";	// Database Connection file
$UploadFile = $_SESSION['user'];

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
    location="AONMod.php";    
</script>
<?php 
}
//----------------------------------------------------------------------------------------------
?>

 <?php
 

// reading Xls file
//reference the class so you can use it
 require_once(’tcpdf/tcpdf.php’);

 // create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
 
 //do not show header or footer
$pdf->SetPrintHeader(false); $pdf->SetPrintFooter(false);

 // add a page - landscape style
$pdf->AddPage(”L”);

 // set font
$pdf->SetFont("freeserif", "", 11);

 /////////////////////////////////////////////
 //  START TABLE HEADER
 /////////////////////////////////////////////
 
 //Colors, line width and bold font for the header
$pdf->SetFillColor(11, 47, 132); //background color of next Cell
$pdf->SetTextColor(255); //font color of next cell
$pdf->SetFont("",'B'); //b for bold
$pdf->SetDrawColor(0); //cell borders - similiar to border color
$pdf->SetLineWidth(.3); //similiar to cellspacing

for($i = 0; $i < count($cols); $i++)
{
     //void Cell( float $w, [float $h = 0], [string $txt = ''], [mixed $border = 0],
     //[int $ln = 0], [string $align = ''], [int $fill = 0], [mixed $link = ''], [int $stretch = 0]) 
     $pdf->Cell(20,7,$cols[$i],1,0,'C',1);
 }
  

if($file_ext1 == '.xls')
{
	// Node File
			
		include 'phpExcelReader/Excel/reader.php';
		$dataTripF = new Spreadsheet_Excel_Reader();
        $dataTripF->setOutputEncoding('CP1251');       
        $dataTripF->read($UploadFile."/".$m_NodeFile);
       
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nlinks = $dataTripF->sheets[0]['numRows']-1 ;
        $Col = $dataTripF->sheets[0]['numCols'];
    
        
        for ($i = 1; $i <= $m_nlinks+1; $i++)
        {           	
               
			for ($j = 1; $j < $Col; $j++)
            {
                $m_TripMtx[$i][$j]=$dataTripF->sheets[0]['cells'][$i][$j];
               
                if($i==1)
                {
                	$pdf->Cell(20,7,$cols[$i],1,0,'C',1);
                }
                else 
                {
                	 $pdf->Cell(20,7,$m_TripMtx[$i][$j],1,0,'C',1);
                }
            }               
            ;       
        }
           $pdf->Ln(); //new row
 

 //output the PDF to the browser
 $pdf->Output("./pdfs/example.pdf", "F"); //F for saving output to file
   
}
elseif($file_ext1 == '.csv')
{
	// reading csv file
    
	// Node File
    
	$Col=0; 
	$m_nlinks = 0;
	$name = $UploadFile."/".$m_NodeFile;
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
    
    echo '<table border=1 cellspacing=0 align="center" width="100%"><caption><b> Link Flow </b></caption>';
    for ($i = 1; $i <= $m_nlinks; $i++)
    {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';    
			for ($j = 1; $j < $Col; $j++)
            {               
                if($i==1)
                {
                	echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_TripMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	 echo '<td>';
              		echo $m_TripMtx[$i][$j];
              		echo "</td>";
                }
            }               
            echo "</tr>";       
     }
    echo "</table><br>";
	
	$m_nlinks--;
}

// reading Xls file

if($file_ext2 == '.xls')
{
	// OD File
		      
        $OdTripF = new Spreadsheet_Excel_Reader();
        $OdTripF->setOutputEncoding('CP1251');       
        $OdTripF->read($UploadFile."/".$m_OdFile);
        
        error_reporting(E_ALL ^ E_NOTICE);
        $m_nnodes = $dataTripF->sheets[0]['numRows']-1 ;
   		echo '<table border=1 cellspacing=0 width="100%"><caption><B>Origin Destination matrix</B></caption>';      
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$m_nnodes ; $j++)
            {
                $m_ODMtx[$i][$j]=$OdTripF->sheets[0]['cells'][$i][$j];
                
                if($i==1)
                {
                	 echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	if($j==1)
                	{
                	  echo '<td bgcolor="#B8DBFF">';
                	  echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                	  echo "</td>";
                	}
                	else 
                	{
                	echo "<td>";
              		echo $m_ODMtx[$i][$j];
              		echo "</td>";
                	}                
                }
                
            }               
            echo "</tr>";       
        }
        echo "</table><br>";
		
}
elseif($file_ext2 == '.csv')
{
	// reading Xls file
	
	// OD file
	
	$Col=0; 
	$m_nnodes = 0;
	$name = $UploadFile."/".$m_OdFile;
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
    echo '<table border="1" cellspacing=0 width="100%"><caption><B>Origin Destination matrix</B></caption>';      
		for ($i = 1; $i <= $m_nnodes; $i++)
        {           	
            echo '<tr align="center" bgcolor="#EBF5FF">';  
                     
            for ($j = 1; $j <=$m_nnodes ; $j++)
            {
                
                if($i==1)
                {
                	 echo '<td bgcolor="#B8DBFF">';
                    echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                    echo "</td>";
                }
                else 
                {
                	if($j==1)
                	{
                	  echo '<td bgcolor="#B8DBFF">';
                	  echo '<b>'.$m_ODMtx[$i][$j].'</b>';
                	  echo "</td>";
                	}
                	else 
                	{
                	echo "<td>";
              		echo $m_ODMtx[$i][$j];
              		echo "</td>";
                	}                
                }
                
            }               
            echo "</tr>";       
        }
        echo "</table><br>";
		
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


   for ($i = 1,$j = 2; $i < $m_nlinks+1 && $j<$m_nlinks+2; $i++,$j++)
   {           	
   		$y[$j]=$x[$i];
        
   } 
      
   echo '<table border=1 cellspacing=0 width="100%"><caption><B>Final Assignment</B></caption>';
   echo '<tr align="center" bgcolor="#B8DBFF">';
   echo '<td><b>From</b></td><td><b>To</b></td><td><b>Flow</b></td></tr>';
   for ($i = 2; $i <= $m_nlinks+1; $i++)
   {           	
   		echo '<tr align="center" bgcolor="#EBF5FF">';           
        for ($j = 1; $j < $m_nlinks-2; $j++)
        {
        		
                echo '<td >';                
                echo $m_TripMtx[$i][$j];                    
                echo "</td>";
        		
            }
            echo "<td>".$y[$i]."</td>";               
            echo "</tr>";       
   }
   echo "</table><br>";
?>     
<BR>
</body>
</html>