<?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4,"Growth Factor Distribution Model","Trip Distribution");
?> 
<script language="JavaScript"> 
function fullScreen1(theURL) { 
	 var width=screen.availWidth-20;//screen.width;
	 var height=screen.availHeight-70;//screen.height;
	 theURL= theURL + "?width="+ width + "&height=" + height;
	 window.open(theURL, 'windowName', 'fullscreen=yes,scrollbars=yes,resizable=no,menubar=yes,titlebar=yes,toolbar=yes'); 
} 
</script>
<div id="body">
<span class="title">Experiment</span>
<p><span class="title1"><a href="javascript:void(0);" onClick="fullScreen1('applet/gfm.php')";><strong> <span style="text-decoration: underline;">Click Here</span> To Perform Experiment with JAVA based Simulation</strong></a></p>
<!-- <p><a href="javascript:void(0);" onClick="fullScreen('checkprerequisite.php')";><span style="color:#FF0000;">( Click to check your system settings to execute above simulation )</span></a></p>
<br> -->
<p><span class="title1"><a href="GroFactMod.php"><strong> <span style="text-decoration: underline;">Click Here</span> To Perform Experiment with PHP based Simultation</strong></a></span>
</span></p>
<span class="title">See the default Excel / CSV input files for file format:</span>
<table class="table table-bordered ">
<tr>
<th >Download &amp; Save each of these files to perform experiment.</th>
<th >Click on the icon </span>to download &amp; Save all XLS/CSV files in zip format.</th>
</tr>
<tr>
<td>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/origin_future.xls"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) For Future Year Origins Total File (xls)</span></a>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/destination_future.xls"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) For Future Year Destinations Total File (xls)</span></a>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/base_matrix.xls"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) For Base Year O-D Matrix File (xls)</span></a>
</td>
<td align="center" valign="top">
<span class="title1">All XLS Files in zip format</span>
<p><a href="<?php echo DOC_FOLDER;?>/Gravity Model XLS.zip"><img style="display: block; margin-left: auto; margin-right: auto;" src="img/XLS.JPG" alt="Excel"/></a></p>
</td>
</tr>
<td>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/origin_futurecsv.csv"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) For Future Year Origins Total File (csv)</span></a>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/destination_futurecsv.csv"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) For Future Year Destinations Total File (csv)</span></a>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/base_matrixcsv.csv"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) For Base Year O-D Matrix File (csv)</span></a></td>
<td align="center" valign="top">
<span class="title1">All CSV Files in zip format</span>
<p><a href="<?php echo DOC_FOLDER;?>/Gravity Model CSV.zip"><img style="display: block; margin-left: auto; margin-right: auto;" src="img/CSV.JPG" alt="CSV"/></a></p>
</td>
</tr>
</table>

</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
