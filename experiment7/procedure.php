<?php
  include_once("header.php");
  getHeader(3,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
?> 
<div id="body">
<p><strong>Step 1:</strong></p>
<p>
	<li>Click on &#145;Click Here To Perform Experiment with GUI&#146;.  
	</li>
	<li>In order to start with the experiments make sure that the input files are available in the format given in the default file. The default file can be downloaded from the table as shown in the image.	</li>
</p>
<p><center><img src="img/img_1.bmp"/></center></p>
<br>
<p><strong>Step 2:</strong></p>
<p>Go to Model in order to perform Calibration of Singly Constrained Gravity Model. Browse the required input file.</p>
<br>
<p><center><img src="img/img_2.bmp"/></center></p>
<br>
<p>There are two types of Impedance Functions</p>
<p><center><img src="img/img_3.bmp"/></center></p>
<br>
<p>
	<li>Power Function : <b>F<sub>ij</sub>=C<sup>&#x3B2;</sup><sub>ij</sub></b>
	</li>
	<li>Exponential Function : <b>F<sub>ij</sub>=e<sup>-&#x3B2;<sub>1</sub>C<sub>ij</sub></sup></b>
	</li>
</p>
<br>
<p>Select the method of model (Origin or Destination Constrained) and the frinctional factor function required then click &#145;OK&#145; in order to get the output. </p>
<br>
<p><strong>Step 2:</strong></p>
<p>Sample of the output is given below. Save the output by clicking on &#145;File&#145;. The graph can also be saved in the form of image(.png).</p>
<br>
<p><center><img src="img/img_4.bmp"/></center></p>
<br>
<p>Graphical representation of the output while finding optimal Beta value can also be viewed. Sample image is given below.</p>
<p><center><img src="img/img_5.bmp"/></center></p>
</div>
<?php
  include_once("footer.php");
  getFooter(3);
?>  