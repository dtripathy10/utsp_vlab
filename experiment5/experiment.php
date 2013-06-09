<?php
  include_once("header.php");
  getHeader(4,"Singly constrained Gravity Model","Trip Distribution");
?> 
<head>
<script language="JavaScript"> 
function fullScreen(theURL) { 
	 var width=screen.availWidth-20;//screen.width;
	 var height=screen.availHeight-70;//screen.height;
	 theURL= theURL + "?width="+ width + "&height=" + height;
	 window.open(theURL, '', 'fullscreen=yes,scrollbars=no,resizable=no'); 
} 
</script>
</head>
<div id="body">
<span class="title">Experiment</span>
<p><span class="title1"><a href="javascript:void(0);" onClick="fullScreen('applet/GravModel.php')"; style="text-decoration: underline;">Click Here to Perform Experiment with JAVA based Simulation</a></span></p>
<p><span class="title1"><a href="SigGravMod.php" style="text-decoration: underline;">Click Here to Perform Experiment with PHP based Simulation</a></span></p>
<br>
<span class="title">See the default Excel / CSV input files for file format:</span>
<table class="table table-bordered ">
<tr>
<th >Download &amp; Save each of these files to&nbsp; perform experiment.</th>
<th >Click on the icon </span>to download &amp; Save all XLS/CSV files in zip format.</th>
</tr>
<tr>
<td>
<span class="title1"><a href="../Docs/costmatrix.xls"><img src="img/SmallXLS.jpg" alt="Excel" width="16" height="16" />(Click Here) For Base Year O-D Cost Matrix File (xls)</span></a>
<span class="title1"><a href="../Docs/Origin_gravity.xls"><img src="img/SmallXLS.jpg" alt="Excel" width="16" height="16" />(Click Here) For Future Year Origin Total File (xls)</span></a>
<span class="title1"><a href="../Docs/destination_gravity.xls"><img src="img/SmallXLS.jpg" alt="Excel" width="16" height="16" />(Click Here) For Future Year Destination Total File (xls)</span></a>
</td>
<td align="center" valign="top">
<span class="title1">All XLS Files in zip format</span>
<p><a href="../Docs/Gravity Model XLS.zip"><img style="display: block; margin-left: auto; margin-right: auto;" src="img/XLS.JPG" alt="Excel" width="56" height="56" /></a></p>
</td>
</tr>
<td>
<span class="title1"><a href="../Docs/costmatrixcsv.csv"><img src="img/SmallCSV.jpg" alt="CSV" width="16" height="16" />(Click Here) For Base Year O-D Cost Matrix File (csv)</span></a>
<span class="title1"><a href="../Docs/origin_futurecsv.csv"><img src="img/SmallCSV.jpg" alt="CSV" width="16" height="16" />(Click Here) For Future Year Origin Total File (csv) </span></a>
<span class="title1"><a href="../Docs/destination_gravitycsv.csv"><img src="img/SmallXLS.jpg" alt="Excel" width="16" height="16" />(Click Here) For Future Year Destination Total File (csv)</span></a>
</td>
<td align="center" valign="top">
<span class="title1">All CSV Files in zip format</span>
<p><a href="../Docs/Gravity Model CSV.zip"><img style="display: block; margin-left: auto; margin-right: auto;" src="img/CSV.JPG" alt="CSV" width="56" height="56" /></a></p>
</td>
</tr>
</table>
</div>
  <?php
  include_once("footer.php");
  getFooter(4);
?>  