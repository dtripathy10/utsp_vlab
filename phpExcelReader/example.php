<?php
// Test CVS

require_once 'Excel/reader.php';


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

// Set output Encoding.
$data->setOutputEncoding('CP1251');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/



/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/

$data->read('base_matrix.xls');

/*


 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);
?>

<table border=1 cellspacing=1 align="center">
<?php 
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) 
{
	$sum[$i]=0;
?>
<tr>
<?php 
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) 
	{
	?>
	<td>
	<?php 
	$sum[$i] += (double)$data->sheets[0]['cells'][$i][$j];		
	echo $data->sheets[0]['cells'][$i][$j];	
	?>
	</td>	
	<?php	
	}
	?>
	<td>
	<?php 
	echo $sum[$i];
	?>
	</td>
	</tr>
	<?php 
	echo "\n";
}
?>

<tr>
<?php 
for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) 
	{
		$sum[$j]=0;
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) 
		{
			$sum[$j] += (double)$data->sheets[0]['cells'][$i][$j];
				
		}	
		?>
		<td>
		<?php 
		echo $sum[$j]."\n";
		?>
		</td>		
		<?php 
	}		
?>

</tr>


<?php 
/*
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) 
	{
		$sum[$i]=0;
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) 
		{
			$sum[$i] += (double)$data->sheets[0]['cells'][$i][$j];				
		}	
		?>
		<tr>
		<td>
		<?php 
		echo $sum[$i];
		?>
		</td></tr>
		<?php 
	}	
	*/	
?>


</table>


