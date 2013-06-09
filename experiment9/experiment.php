
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	

 <?php
  include_once("../util/system.php");
  include_once("header.php");
  getHeader(4,"Mode Split");
?> 

<div id="body">
<span class="title">Experiment</span>
<p><span class="title1"><a href="CatAnalysisMod.php" style="text-decoration: underline;">Click Here to Perform Experiment with PHP based Simulation</a></span></p>
<span class="title">See the default Excel / CSV input files for file format:</span>
<table class="table table-bordered ">
<tr>
<th >Download &amp; Save each of these files to perform experiment.</th>
<th >Click on the icon </span>to download &amp; Save all XLS/CSV files in zip format.</th>
</tr>
<tr>
<td>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/survey_old.xls"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) Observed Socio-economic Data File (xls)</span></a>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/survey.xls"><img src="img/SmallXLS.jpg" alt="Excel" />(Click Here) Forecasted Socio-economic Data File (xls)</span></a>
</td>
<td align="center" valign="top">
<span class="title1">All XLS Files in zip format</span>
<p><a href="<?php echo DOC_FOLDER;?>/CategoryAnalysis.zip"><img style="display: block; margin-left: auto; margin-right: auto;" src="img/XLS.JPG" alt="Excel"/></a></p>
</td>
</tr>
<td>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/survey_old.csv"><img src="img/SmallCSV.jpg" alt="CSV"/>(Click Here) Observed Socio-economic Data File (csv)</span></a>
<span class="title1"><a href="<?php echo DOC_FOLDER;?>/survey.csv"><img src="img/SmallCSV.jpg" alt="CSV"/> (Click Here) Forecasted Socio-economic Data File (csv) </span></a>
</td>
<td align="center" valign="top">
<span class="title1">All CSV Files in zip format</span>
<p><a href="<?php echo DOC_FOLDER;?>/CategoryAnalysisCSV.zip"><img style="display: block; margin-left: auto; margin-right: auto;" src="img/CSV.JPG" alt="CSV"/></a></p>
</td>
</tr>
</table>

</div>
<?php
  include_once("footer.php");
  getFooter(4);
?>  	
