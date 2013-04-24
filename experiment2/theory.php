<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	

<!-- =============================================== -->
<?php
  include_once("header.php");
  getHeader(2);
?> 
<div id="body">
  <h1 class="designation">Theory</h1>
  <span class="title">Regression Models</span>
  <span class="title1">Single Linear Regression Model (SLRM)</span>
  <p class="section">Given a scattered figure shown in Figure 2 it is assumed that the relation between the dependent variable $Y$ and independent variable $X$ is linear. The method of least squares linear regression can be used to find one straight line that fits best for the given scattered diagram. We know that there can be infinite number of such lines each having a unique pair of $Y$ intercept $a$ and slope $b$. Hence our problem is reduced in finding these two variables $a$ and $b$ that defines the best fitting straight line.</p>

  <p>An example below will give you an idea about the Regression Model with only one independent variable x</p>
  <table class="table table-bordered table-hover">
    <tr><th>Y Values</th><th>X Values</th></tr>
    <tr><td>0.3415</td><td>0.7</td></tr>
    <tr><td>0.50705</td><td>0.89</td></tr>
    <tr><td>0.648</td><td>1.2</td></tr>
    <tr><td>0.5554</td><td>1.32</td></tr>
    <tr><td>0.514</td><td>1.2</td></tr>
    <tr><td>1.135</td><td>3</td></tr>
    <tr><td>0.9245</td><td>2.1</td></tr>
  </table>


$$y\  =\ a\ +\ bx$$
<p>The Values of a and b should be selected such that the Linear Equation (1) will best represent the table above.</p>
<p><center><img src="img/1.bmp" /></center></p>



<p class="section">For $i^{th}$ observation $x_i$ let $y_i$ be the observed value and the corresponding estimated value obtained from equation (1) be denoted as $y_e$. The difference between them is called as error, deviation or residual. A best fit curve in our line is obtained only when this error is minimum. Thus to remove the positive and negative signs, sum of squares of error is taken which is minimised and the corresponding value of $a$ and $b$ is found out.</p>
$$\nonumber S =\sum\limits_{i=1}^N (y_i - y_e)^2$$
$$\nonumber S =\sum\limits_{i=1}^N (y_i - a-bx_i)^2$$

<p>Partial derivative with respect a and b is set to zero and after reaaranging the terms we get</p>

$$ \nonumber Na+(\sum\limits_{i=1}^N x_i)b = \sum\limits_{i=1}^N y_i$$

$$ \nonumber (\sum\limits_{i=1}^N x_i)a+(\sum\limits_{i=1}^N (x_i)^2)b = (\sum\limits_{i=1}^N x_iy_i)$$

 <p>The above two equations are called as the characteristics equations. Applying Cramer's Rule we get</p> 
$$ \nonumber b =\dfrac{\sum\limits_{i=1}^N (x_i - x^*)(y_i-y^*)}{\sum\limits_{i=1}^N (x_i - x^*)^2}$$
$$ \nonumber x^* =\dfrac{\sum x_i}{N}$$
$$\nonumber y^* =\dfrac{\sum y_i}{N}$$
$$ \nonumber y^* = a + bx^*$$

<p>That is point ($x^*$,$y^*$) satisfies the equation of best fitting line, this means that the best fitting straight line always passes through the means of the observation.</p>

$$ \nonumber a = y^* - bx^*$$




<p>The proportion of total variation explained by line is the measure of goodness of fit of the regression line. This proportion is explained by goodness Coefficient of Determination
</p>
$$\nonumber r^2 = \dfrac{TSS -ESS}{TSS} = \dfrac{\sum\limits_{i=1}^N (y_e -y^*)^2}{\sum\limits_{i=1}^N (y_i - y^*)^2}$$

<p>Its value ranges from zero when none of the total variation is explained by the regression line to one when all the variation is explained by the regression line. The square root of coefficient of determination is called as coefficient of correlation. If r is near +1 it denotes positive correlation and if is near -1 it denotes negative correlation. Proper magnitude and formula for r is given below:</p>


$$ \nonumber r = \dfrac{N(\sum x_i y_i) - (\sum x_i)(\sum y_i)}{{\{[N(\sum x_i^2)-(\sum x_i)^2][N(\sum y_i^2)-(\sum y_i)^2]\}}^{1/2}}$$



<span class="title1">Correlation</span>
<p>In order to measure the degree to which $Y$ observations are spread around their average value Total Sum of Square (TSS) deviations from the mean is found with the help of formula given below:</p>
$$\nonumber TSS = \sum\limits_{i=1}^N (y_i -y^*)^2$$

$$\nonumber \sum\limits_{i=1}^N (y_i -y^*)^2 = \sum\limits_{i=1}^N (y_i -y_e)^2 + \sum\limits_{i=1}^N (y_e -y^*)^2$$

$$\nonumber Error \  Sum\  of\  Squares (ESS) = \sum\limits_{i=1}^N (y_i -y_e)^2$$


<span class="title1">Multiple Linear Regression Model (MLRM)</span>
<p class="section">SLRM includes 2 variable while in case of Multiple linear regression model includes more than two variables. It is more appropriate to represent the independent variable (mostly no of trips/unit) in a linear equation involving more than 2 variables.</p>
$$\nonumber Y = a_0\ +\ a_1x_1\ +\ a_2x_2\ +\ ...\  ...\ .a_nx_n$$
<p>Characteristics of MLRM are::
        <ul class="test">
          <li>There should be (n+1) observations where n is the number of independent variables used for the calibration of the above equation.</li>
           <li>The independent variables chosen must not be highly correlated among each other. A coefficient of correlation as mentioned earlier will help in finding out the relation between independent terms. Only those variables which are not highly related should be mentioned in the MLRM. In case when two variables are highly related then it would be difficult to capture the effect of one on the dependent variable because varying any one of the two X's will involve change of the other.</li>
               <li>The selected independent variables must be highly correlated to the dependent variable. The relation between coefficients of variable can be determined by obtaining correlation matrix.</li>
        </ul>

The goodness to fit can be assessed by obtaining coefficient of multiple correlation and required statistical test results.</p>


<span class="title1">Non Linear Regression Model (NLRM)</span>
<p class="section">These models are calibrated by one of the two methods. First method consists of specifying the non linear model and proceeding through minimization of the sum of the squared deviations as in the LRM.</p>
<span class="title1">Example</span>

<table class="table table-bordered table-hover">
    <tr><th>Y Values</th><th>X Values</th></tr>
    <tr><td>0.3415</td><td>0.7</td></tr>
    <tr><td>0.50705</td><td>0.89</td></tr>
    <tr><td>0.648</td><td>1.2</td></tr>
    <tr><td>0.5554</td><td>1.32</td></tr>
    <tr><td>0.514</td><td>1.2</td></tr>
    <tr><td>1.135</td><td>3</td></tr>
    <tr><td>0.9245</td><td>2.1</td></tr>
  </table>
<br>
<center><img src="img/2.bmp" width="550px" height="350" /></center>
<br>
<p>Considering <b>Linear Regression Model (LRM)</b><br>From the formulas of $a$ and $b$ given above we get <br>$a = 0.78$ and $b = 0.56$</p>
<p >Considering <b>Non Linear Regression Model (NLRM)</b><br><center>$y  =  ax^b$</center><br>Taking log both the side<br><center>$logy = loga + blogx$</center></p>
<p>The above equation can be written as $y' = a' + bx'$ where </p>
<p>From the formulas of $a$ and $b$ given above we get</p>
<p><center>$y' = logy$<br>$a' = loga$<br>$x' = logx$<br></center></p>
<p>While in the second method the non linear form of equation is represented in a linear format and then calibration is done for the new linear equation obtained. Few examples of such non linear equation are given below</b>
<p><table class="table table-bordered table-hover">
<tr><th>Equation</th><th>Derivation</th><tr>
<tr align="center">
<td>$y = ab^x$</td><td>Taking log both the side<br>$logy = loga + xlogb$<br>Thus new linear equation obtained is,<br>$y' = a' + b'x$</td>
</tr>
<tr align="center">
<td>$y = ax^b$</td><td>Taking log both the side<br>$logy = loga + blogx $<br>Thus new linear equation obtained is,<br>$y' = a' + bx'$<br></td>
</tr>
<tr align="center">
<td>$y = \dfrac{1}{(a+bx)}$</td><td>Taking reciprocal of the equation we get<br>$ \dfrac{1}{y} = a + bx $<br>Thus new linear equation obtained is,<br>$y' = a + bx$</td>
</tr>
</table></p>
<p>The solution for SLRM can be obtained from the procedure above. You can perform experiments not only on SLRM but also on MLRM and Non linear Models since it is tedious to work on them manually. </p>
<p>The Non Linear Models are</p>
<p>
 	<ul class="test">
 		<li>Quadratic</li>
 		<li>Power eg $(y\ =\ a_0x_0^{b_0}\ +\ a_1x_1^{b_1}+\ ....)$</li>
 		<li>Exponential eg $(y\ =\ a_0e_0^{x_0}\ +\ a_1e_1^{x_1}+\ ....)$</li>
 		<li>Logarithmic eg  $(y\ =\ a_0\ +\ a_1 ln(x_0)\ +\ a_2 ln(x_1)+\ ....)$</li>
	 </ul>
</p>
<p>Regression Analysis will give a relation between the trip production (attraction) and its relevant independent variables. This relationship can be assumed to continue for futuristic scenario. Thus by obtaining future census data of variables we can get future Production Attraction table.</p>
<p>To get an idea you can perform experiment by default file which is recent census data of Pune city. </p>
<span class="title">Example</span>
<p>Planners have estimated the following models for the AM Peak Hour</p>
<p>$T_i=1.5*H_i$</p>
<p>$T_j=(1.5*E_{off,j})+(1*E_{oth,j})+(0.5*E_{ret,j})$</p>
<p>where,</p>
<p>$T_i$ = Person trips originating in zone $i$.</p>
<p>$T_j$ = Person trips destined in zone $i$.</p>
<p>$H_i$= Number of House holds in zone $i$</p>
<br>
<p>You are also given the following data</p>

   <table class="table table-bordered table-hover">
     <tr><th>Variable</th>  <th>City1</th>  <th>City2</th></tr>
     <tr><td>H</td> <td>10000</td>  <td>15000</td></tr>
     <tr><td>E<sub>off</sub></td> <td>10000</td>  <td>15000</td></tr>
     <tr><td>E<sub>oth</sub></td>   <td>10000</td>  <td>15000</td></tr>
     <tr><td>E<sub>ret</sub></td>  <td>10000</td> <td>15000</td></tr>
   </table>
<p>A. What are the number of person trips originating in and destined for each city?</p>
<p>B. Normalize the number of person trips so that the number of person trip origins = the number of person trip destinations.</p>
<span class="title1">Solution</span>
<p>A. The number of person trips originating in and destined for each city:</p>
<table class="table table-bordered table-hover">
    <caption>Solution to Trip Generation Problem Part A<caption>
     <tr><th></th><th>Households (H<sub>i</sub>)</th>  <th>Office Employees (E<sub>off</sub>)</th> <th>Other Employees (E<sub>oth</sub>)</th>  <th>Retail Employees (E<sub>ret</sub>)</th> <th>Origins T<sub>i</sub> = 1.5 * H<sub>i</sub></th>  <th>Destinations T<sub>j</sub> = (1.5 * E<sub>off,j</sub>) + (1 * E<sub>oth,j</sub>) + (0.5 * E<sub>ret,j</sub>)</th></tr>
     <tr><td>City1</td>   <td>10000</td> <td> 8000</td>   <td>3000</td>   <td>2000</td>   <td>15000</td>  <td>16000</td></tr>
     <tr><td>City2</td>   <td>15000</td>  <td>10000</td>  <td>5000</td>   <td>1500</td>  <td> 22500</td> <td> 20750</td></tr>
     <tr><td>Total</td>   <td>25000</td>  <td>18000</td> <td> 8000</td>  <td> 3000</td>   <td>37500</td> <td> 36750</td></tr>
</table>
<p>B. Normalize the number of person trips so that the number of person trip origins = the number of person trip destinations. Assume the model for person trip origins is more accurate. Use:</p>

<p>$$ \nonumber T'_j\ =\ T_j\dfrac{\sum\limits_{i=1}^I T_i}{\sum\limits_{j=1}^J T_j} = Tj\dfrac{37500}{36750} = T_j*1.0204 $$</p>

 <table class="table table-bordered table-hover">
    <caption>Solution to Trip Generation Problem Part B</caption>
    <tr><th></th><th>Originss (T<sub>i</sub>)</th> <th>Destinations (T<sub>j</sub>)</th>  <th>Adjustment Factor</th>  <th>Normalized Destinations (T<sub>j</sub>)</th> <th>Rounded</th></tr>
    <tr><td>City1</td>  <td>15000</td>  <td>16000</td>  <td>1.0204</td> <td>16326.53</td> <td>16327</td></tr>
    <tr><td>City2</td>  <td>22500</td>  <td>20750</td>  <td>1.0204</td> <td>21173.47</td> <td>21173</td></tr>
    <tr><td>Total</td>  <td>37500</td>  <td>36750</td>  <td>1.0204</td> <td>37500</td>  <td>37500</td></tr>
  </table>




 </div>
 <!-- ======================================================= -->
 <?php
  include_once("footer.php");
  getFooter(2);
?> 