<?php
  include_once("header.php");
  getHeader(3,"Doubly constrained Gravity Model","Trip Distribution");
?> 
<div id="body">
<p><strong>Step 1:</strong></p>
<p>
	<li>Click on &#145;Click Here To Perform Experiment with GUI&#146;.</li>
	<li>In order to start with the experiments make sure that the input files are available in the format given in the default file. The default file can be downloaded from the table as shown in the image.</li>
</p>
<p><center><img src="img/img_1.bmp"/></center></p>
<br>
<p><strong>Step 2:</strong></p>
<p>Go to Methods to select the type of experiment to be performed. Browse the required input file  </p>
<p><center><img src="img/img_2.bmp"/></center></p>
<br>
<p>There four types of Impedance Functions</p>
<p>
	<li >Power Function : <b>F<sub>ij</sub>=C<sup>&#x3B2;</sup><sub>ij</sub></b>
	</li>
	<li >Exponential Function : <b>F<sub>ij</sub>=e<sup>-&#x3B2;<sub>1</sub>C<sub>ij</sub></sup></b>
	</li>
	<li >Gamma Function : <b>F<sub>ij</sub>=e<sup>-&#x3B2;<sub>1</sub>C<sub>ij</sub></sup>C<sup>-&#x3B2;<sub>2</sub></sup><sub>ij</sub></b>
	</li>
	<li >Linear Function : <b>F<sub>ij</sub>=&#x3B2;<sub>1</sub>+&#x3B2;<sub>2</sub>C<sub>ij</sub></b>
	</li>
</p>
<p>Select the required impedance function and value of &#x3B2;<sub>1</sub>, &#x3B2;<sub>2</sub>,C<sub>ij</sub> Then click &#39;OK&#39; to get the output.</p>
<p>Example of the output file of Origin Constrained experiment</p>
<br>
<p><center><img src="img/img_3.bmp"/></center></p>
</div>
  <?php
  include_once("footer.php");
  getFooter(3);
?>  