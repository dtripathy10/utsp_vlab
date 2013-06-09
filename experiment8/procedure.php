<?php
  include_once("header.php");
  getHeader(3,"Calibration of Doubly Constrained Gravity Model","Trip Distribution");
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

<p>Go to Model in order to perform Calibration of Doubly Constrained Gravity Model. Browse the required input file.</p>
<br>
<p><center><img src="img/img_2.bmp"/></center></p>
<br>

<p>Select the required Frictional Function among the two functions given below</p>
<p><center><img src="img/img_3.bmp"/></center></p>
<br>
<p>
	<li>Power Function : <b>F<sub>ij</sub>=C<sup>&#x3B2;</sup><sub>ij</sub></b>
	</li>
	<li>Exponential Function : <b>F<sub>ij</sub>=e<sup>-&#x3B2;<sub>1</sub>C<sub>ij</sub></sup></b>
	</li>


</p>
<p>Individual Cell or All cells Model can be performed according to the requirement the select the percentage of accuracy. After given the required data click on 	&#39;OK&#39; in order to get the output.
</p>
<br>
<p><strong>Step 3:</strong></p>
<br>
<p>Sample of the output is given below. Save the output by clicking on &#145;File&#145;. The graph can also be saved in the form of image(.png).</p>
<br>
<p><center><img src="img/img_4.bmp"/></center></p>
<br>
<p>Graphical representation of the output while finding optimal Beta value can also be viewed. Sample image is given below.</p>
<br>
<p><center><img src="img/img_5.bmp"/></center></p>
    
</div>
<?php
  include_once("footer.php");
  getFooter(3);
?>  