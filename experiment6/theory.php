<!--
  Author:   Debabrata Tripathy, IIT Bombay, Mumbai
  Mail ID:  dtriapthy10@gmail.com
  Website:  http://home.iitb.ac.in/~debabratatripathy/
  Phone No: 9004499484
--> 
<?php
  include_once("header.php");
  getHeader(2,"Doubly constrained Gravity Model","Trip Distribution");
?> 
  <div id="body">
<h1 class="designation">Theory</h1>
  <span class="title">Introduction</span>
<p class="section">
  As the name suggests Doubly Constraint Gravity Model 
  is a model where both the Trip Production and Trip Attraction are constrained.
</p>
<p>
$$\nonumber T_{ij} = A_{i}O_{i}B_{j}D_{j}f(C_{ij}) $$
Where,
<div>$ A_{i} = $Trip production balancing factor </div>
<div>$ B_{j} = $Trip attraction balancing factor </div>
<div>$ f(C_{ij}) = $Impedance Function </div>
</p>
<p>
<div style="float:left;">
$$\nonumber A_{i} = \dfrac{1}{\sum {B_{j}D_{j}f(C_{ij})}}$$
$$\nonumber B_{j} = \dfrac{1}{\sum {A_{i}O_{i}f(C_{ij})}}$$
</div>
<div style="clear:both;"></div>
</p>
<span class="title">Example</span>
<div style="margin:30px;"></div>
<table class="table table-bordered table-hover">
<caption>Table1</caption>
<tr><th>Zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>$O_{i}$</td><td>200</td><td>400</td><td>400</td></tr>
<tr><td>$D_{j}$</td><td>500</td><td>400</td><td>400</td></tr>
</table>
$ Impedance\ Matrix(Cost) = \begin{bmatrix}8 & 1 & 4\\3 & 6 & 5\\2 & 7 & 4\end{bmatrix}$
<div style="margin:30px;"></div>
<span class="title1">Obtain a trip matrix that satisfy origin & destination constraint</span>
<span class="title1">Iteration-1</span>

<div>$X_{i}=1$and substitute in equation (c)</div>
<div>α=-2</div>
<div>The value of $Y_{i}$ is obtained</div>
<div style="margin:10px;"></div>
<table class="table table-bordered table-hover">
<tr><th>Zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>1</td><td>0.0156</td><td>1</td><td>0.0625</td></tr>
<tr><td>2</td><td>0.1111</td><td>0.0278</td><td>0.04</td></tr>
<tr><td>3</td><td>0.25</td><td>0.0204</td><td>0.0625</td></tr>
</table>

<div style="margin:30px;"></div>
<table class="table table-bordered table-hover">
<tr><th>i</th><th>j</th><th>$Y_{j}$</th></tr>
<tr><td>1</td><td>1</td><td>0.00231</td></tr>
<tr><td>1</td><td>2</td><td>0.00231</td></tr>
<tr><td>1</td><td>3</td><td>0.00231</td></tr>
<tr><td>2</td><td>1</td><td>0.0121</td></tr>
<tr><td>2</td><td>2</td><td>0.0121</td></tr>
<tr><td>2</td><td>3</td><td>0.0121</td></tr>
<tr><td>3</td><td>1</td><td>0.00632</td></tr>
<tr><td>3</td><td>2</td><td>0.00632</td></tr>
<tr><td>3</td><td>3</td><td>0.00632</td></tr>
</table>

<div style="margin:30px;"></div>
Substitute these values of Yj in equation (b)
The results obtain is given below
<div style="margin:20px;"></div>
<table class="table table-bordered table-hover">
<tr><th>i</th><th>j</th><th>$X_{i}$</th></tr>
<tr><td>1</td><td>1</td><td>0.199</td></tr>
<tr><td>1</td><td>2</td><td>0.199</td></tr>
<tr><td>1</td><td>3</td><td>0.199</td></tr>
<tr><td>2</td><td>1</td><td>3.484</td></tr>
<tr><td>2</td><td>2</td><td>3.484</td></tr>
<tr><td>2</td><td>3</td><td>3.484</td></tr>
<tr><td>3</td><td>1</td><td>2.686</td></tr>
<tr><td>3</td><td>2</td><td>2.686</td></tr>
<tr><td>3</td><td>3</td><td>2.686</td></tr>
</table>
  <table class="table table-bordered table-hover">
<tr><th>Zone</th><th>1</th><th>2</th><th>3</th><th>$O_{i}$</th><td>New $O_{i}$</td></tr>
<tr><td>1</td><td>0.72</td><td>644</td><td>31.03</td><td>200</td><td>675</td></tr>
<tr><td>2</td><td>53</td><td>187</td><td>208</td><td>400</td><td>450</td></tr>
<tr><td>3</td><td>63</td><td>72</td><td>170</td><td>400</td><td>305</td></tr>
<tr><td>Dj</td><td>500</td><td>400</td><td>400</td><td></td><td></td></tr>
<tr><td>New $D_{j}$</td><td>118</td><td>903</td><td>408</td></tr>
</table>

This Iteration is continued till the satisfying convergence criteria is obtained.
  </div>
  <?php
  include_once("footer.php");
  getFooter(2);
?>  