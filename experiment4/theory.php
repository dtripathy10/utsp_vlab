<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<?php
  include_once("header.php");
  getHeader(2);
?> 
  <div id="body">
  <h1 class="designation">Theory</h1>
  <span class="title">Trip Distribution</span>
   <p class="section">
    The generated trips from each zone is distributed to all other zones based on the choice of destination,
 this is called trip distribution which forms the second stage of travel demand modeling. This step matches trip maker' origins 
and destinations to develop a "trip table" matrix that displays the number of 
trips going from each origin to each destination. A typical trip table is represented below.
  </p>
<table class="table table-bordered table-hover">
<tr><th>Origin/Destination</th><th>1</th><th>2</th><th>3</th><th>j</th><th>$\sum \limits_{j} T_{ij}$</th></tr>
<tr><td>1</td><td>$T_{11}$</td><td>$T_{12}$</td><td>$T_{13}$</td><td>$T_{1j}$</td><td>$O_{1}$</td></tr>
<tr><td>2</td><td>$T_{21}$</td><td>$T_{22}$</td><td>$T_{23}$</td><td>$T_{2j}$</td><td>$O_{2}$</td></tr>
<tr><td>3</td><td>$T_{31}$</td><td>$T_{32}$</td><td>$T_{33}$</td><td>$T_{3j}$</td><td>$O_{3}$</td></tr>
<tr><td>4</td><td>$T_{i1}$</td><td>$T_{i2}$</td><td>$T_{i3}$</td><td>$T_{ij}$</td><td>$O_{i}$</td></tr>
<tr><td>$\sum \limits_{i} T_{ij}$</td><td>$D_{1}$</td><td>$D_{2}$</td><td>$D_{3}$</td><td>$D_{j}$</td><td>$T = \sum \limits_{ij} T_{ij}$</td></tr>
</table>

<p>Where $T_{ij}$ is the number of trips between origin i and destination j,
 $O_{i}$ is total number of trips originating from zone i and $D_{j}$ is the total number 
 of trips attracted to zone j, 
 T is total trips. Note that the practical value of trips on the diagonal, e.g. 
 from zone 1 to zone 1, is zero since no intra-zonal trip occurs.</p>
 
<p>There are a number of methods to distribute trips among destinations; and two such methods are growth factor model and gravity model.</p>
 
<span class="title">Growth Factor Model</span>
   <p class="section"> 
Growth factor model is one of the methods among the number of methods to distribute trips among destinations. Growth factor model is a method which responds only to relative growth rates at origins and destinations and this is suitable for short term trend extrapolation.</p>
   <span class="title1">Types of growth factor models</span>
<ul class="test1">
          <li>Uniform Growth factor method</li>
           <li>Singly constrained growth factor method</li>
           <li>Doubly Constraint growth factor method</li>
  </ul>

<span class="title">Uniform Growth Factor Method</span>
 
<p class="section"> If the only information available is about a general growth rate for the whole of the study 
  area, then we can only assume that it will apply to each cell in the matrix, that is a uniform growth
   rate. The equation can be written as: Tij = f x tij
</p>
<p>
Where f is the uniform growth factor tij is the previous total number of trips, 
Tij is the expanded total number of trips. Advantages are that they are simple to understand, 
and they are useful for short-term planning.
</p>

<span class="title1">Example</span>
<p class="section">
Trips originating from zone 1, 2, 3 of a study area are 78, 92 and 82 respectively and those terminating at zones 1,2,3 are given as 88,96 and 78 respectively. If the growth factor is 1.3 and the cost matrix is as shown below, find the expanded origin-constrained growth trip table.
</p>
<table class="table table-bordered table-hover">
<tr><td>Zone</th><th>1</th><th>2</th><th>3</th><th>$O_{i}$</th></tr>
<tr><td>1</td><td>20</td><td>30</td><td>28</td><td>78</td></tr>
<tr><td>2</td><td>36</td><td>32</td><td>24</td><td>92</td></tr>
<tr><td>3</td><td>22</td><td>34</td><td>26</td><td>82</td></tr>
<tr><td>$D_{j}$</td><td>88</td><td>96</td><td>78</td><td>252</td></tr>
</table>
<span class="title1">Solution</span>
<p class="section">
Given growth factor = 1.3, Therefore, multiplying the growth factor with each of the cells 
in the matrix gives the solution as shown below.
</p>
<table class="table table-bordered table-hover">
<tr><td>Zone</th><th>1</th><th>2</th><th>3</th><th>$O_{i}$</th></tr>
<tr><td>1</td><td>26</td><td>39</td><td>36.4</td><td>101.4</td></tr>
<tr><td>2</td><td>46.8</td><td>41.6</td><td>31.2</td><td>101.4</td></tr>
<tr><td>3</td><td>28.6</td><td>44.2</td><td>33.8</td><td>106.2</td></tr>
<tr><td>$D_{j}$</td><td>101.4</td><td>124.8</td><td>124.8</td><td>327.6</td></tr>
</table>
<span class="title">Singly Constrained Growth Factor method</span>
<p class="section">
This method is used when the expected growth of either trips originated or trips destined are available.
An example below illustrates how to solve for such models
</p>
<span class="title1">Example</span>
<p>Consider the following matrix.</p>
<table class="table table-bordered table-hover">
<tr><th>Zones</th><th>1</th><th>2</th><th>3</th><th>4</th><th>Total</th><th>Target</th></tr>
<tr><td>1</td><td>5</td><td>50</td><td>100</td><td> 200</td><td>355</td><td>400</td></tr>
<tr><td>2</td><td> 50</td><td> 5</td><td> 100</td><td> 300</td><td>455</td><td>460</td></tr>
<tr><td>3</td><td> 50</td><td> 100</td><td> 5</td><td> 1000</td><td>255</td><td>400</td></tr>
<tr><td>4</td><td> 100</td><td> 200</td><td> 250</td><td> 20</td><td>570</td><td>702</td></tr>
<tr><td>Total</td><td>205</td><td>355</td><td>455</td><td>620</td><td>1635</td><td>1962</td></tr>
</table>

<span class="title1">Method</span>
<div>Multiply each cell in Row 1 by 400/355</div>
<div>Multiply each cell in Row 2 by 460/455</div>
<div>Multiply each cell in Row 3 by 400/255</div>
<div>Multiply each cell in Row 4 by 702/570</div>
<div style="margin:30px;"></div>
<table class="table table-bordered table-hover">
<tr><th>Zones</th><th>1</th><th>2</th><th>3</th><th>4</th><th>Total</th><th>Target</th></tr>
<tr><td>1</td><td> 5.6</td><td> 56.3</td><td> 112.7</td><td> 225.4</td><td>400</td><td>400</td></tr>
<tr><td>2</td><td> 50.5</td><td> 5.1</td><td> 101.1</td><td> 303.3</td><td>460</td><td>460</td></tr>
<tr><td>3</td><td>78.4</td><td> 156.9</td><td> 7.8</td><td> 156.9</td><td>400</td><td>400</td></tr>
<tr><td>4</td><td> 123.2</td><td> 246.3</td><td> 307.9</td><td> 24.6</td><td>702</td><td>702</td></tr>
<tr><td>Total</td><td>257.7</td><td>464.6</td><td>529.5</td><td>710.2</td><td>1962</td><td>1962</td></tr>
</table>

<span class="title">Doubly Constraint Growth Factor method</span>
<span class="title1">Example</span>
<p class="section">
  This method is used when the growth of trips originated and distributed for each zone is available. 
  Thus two growth factor sets are available for each zones. Consequently there are two constraints and 
  such a model is called as Double Constraint Growth Factor model
</p>
<p>An example below illustrates how to solve for such models</p>

<table class="table table-bordered table-hover">
<caption>O-D Matrix For Base Year</caption>
<tr><th>Zone</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>Total</th><th>Target</th></tr>
<tr><td>1</td><td> 10</td><td> 15</td><td> 20</td><td> 5</td><td> 0</td><td>50</td><td>150</td></tr>
<tr><td>2</td><td> 5</td><td> 2</td><td> 32</td><td> 12</td><td> 32</td><td>83</td><td>120</td></tr>
<tr><td>3</td><td> 2</td><td> 3</td><td> 3</td><td> 14</td><td> 20</td><td>42</td><td>75</td></tr>
<tr><td>4</td><td> 1</td><td> 5</td><td> 1</td><td> 4</td><td> 5</td><td>16</td><td>45</td></tr>
<tr><td>5</td><td> 0</td><td> 4</td><td> 3</td><td> 5</td><td> 5</td><td>17</td><td>120</td></tr>
<tr><td>Total</td><td>18</td><td>29</td><td>59</td><td>40</td><td>62</td><td>208</td><td>---</td></tr>
<tr><td>Target</td><td>48</td><td>75</td><td>48</td><td>150</td><td>189</td><td>---</td><td>510</td></tr>
</table>
<div class="text-error">Iteration # 1</div>
<div>Multiply each cell in the 1st  row by 150/50</div>
<div>Multiply each cell in the 2nd row by 120/83</div>
<div>Multiply each cell in the 3rd  row by 75/42</div>
<div>Multiply each cell in the 4th  row by 45/163</div>
<div>Multiply each cell in the 5th  row by 120/17</div>
<table class="table table-bordered table-hover">
  <caption>Doubly Constraint Growth Factor Matrix For Future Year</caption>
<tr><th>Zone</th> <th>1</th>  <th>2</th>  <th>3</th>  <th>4</th>  <th>5</th>  <th>Current Origins Total </th><th>Origins Total Future year</th></tr>
<tr><td>1 </td><td>30 </td><td>45 </td><td>60 </td><td>15 </td><td>0</td> <td>150</td>  <td>150</td></tr>
<tr><td>2 </td><td>7.229  </td><td>2.892  </td><td>46.265 </td><td>17.349 </td><td>46.265</td>  <td>120</td>  <td>120</td></tr>
<tr><td>3 </td><td>3.571  </td><td>5.357  </td><td>5.357  </td><td>25 </td><td>35.714</td>  <td>75</td> <td>75</td></tr>
<tr><td>4 </td><td>2.813  </td><td>14.063 </td><td>2.813  </td><td>11.25  </td><td>14.063</td>  <td>45</td> <td>45</td></tr>
<tr><td>5 </td><td>0  </td><td>28.235 </td><td>21.176 </td><td>35.294 </td><td>35.294</td>  <td>120</td>  <td>120</td></tr>
<tr><td>Current Destinations Total</td><td> 43.613</td> <td>95.547</td> <td>135.611</td>  <td>103.894</td>  <td>131.336</td><td></td>  <td></td></tr>
<tr><td>Destinations Total Future year</td><td> 48</td> <td>75</td> <td>48</td> <td>150</td>  <td>189</td></tr>
</table>
<p>
<div>Multiply each cell in the 1st  column  by 48/43.613</div>
<div>Multiply each cell in the 2nd column by 75/95.547</div>
<div>Multiply each cell in the 3rd  column  by 48/135.611</div>
<div>Multiply each cell in the 4th  column  by 150/103.894</div>
<div>Multiply each cell in the 5th  column  by 189/131.336</div>
</p>
<div style="margin:30px;"></div>
<table class="table table-bordered table-hover">
   <caption>Doubly Constraint Growth Factor Matrix For Future Year</caption>
<tr><th>Zone</th> <th>1</th>  <th>2</th>  <th>3</th>  <th>4</th>  <th>5</th>  <th>Current Origins Total </th><th>Origins Total Future year</th></tr>
<tr><td>1 </td><td>30 </td><td>45 </td><td>60 </td><td>15 </td><td>0</td> <td>150</td>  <td>150</td></tr>
<tr><td>2 </td><td>7.229  </td><td>2.892  </td><td>46.265 </td><td>17.349 </td><td>46.265</td>  <td>120</td>  <td>120</td></tr>
<tr><td>3 </td><td>3.571  </td><td>5.357  </td><td>5.357  </td><td>25 </td><td>35.714</td>  <td>75</td> <td>75</td></tr>
<tr><td>4 </td><td>2.813  </td><td>14.063 </td><td>2.813  </td><td>11.25  </td><td>14.063</td>  <td>45</td> <td>45</td></tr>
<tr><td>5 </td><td>0  </td><td>28.235 </td><td>21.176 </td><td>35.294 </td><td>35.294</td>  <td>120</td>  <td>120</td></tr>
<tr><td>Current Destinations Total</td><td> 43.613</td> <td>95.547</td> <td>135.611</td>  <td>103.894</td>  <td>131.336</td><td></td>  <td></td></tr>
<tr><td>Destinations Total Future year</td><td> 48</td> <td>75</td> <td>48</td> <td>150</td>  <td>189</td></tr>
</table>
<div class="text-error">Iteration # 2</div>
<div>Multiply each cell in the 1st  row by 150/111.235</div>
<div>Multiply each cell in the 2nd row by 120/118.228</div>
<div>Multiply each cell in the 3rd  row by 75/97.522</div>
<div>Multiply each cell in the 4th  row by 45/51.609</div>
<div>Multiply each cell in the 5th  row by 120/131.406</div>


<table class="table table-bordered table-hover">
   <caption> Doubly Constraint Growth Factor Matrix For Future Year</caption>
<tr><th>Zone</th> <th>1</th>  <th>2</th>  <th>3</th>  <th>4</th>  <th>5</th>  <th>Current Origins Total </th><th>Origins Total Future year</th></tr>
<tr><td>1 </td><td>30 </td><td>45 </td><td>60 </td><td>15 </td><td>0</td> <td>150</td>  <td>150</td></tr>
<tr><td>2 </td><td>7.229  </td><td>2.892  </td><td>46.265 </td><td>17.349 </td><td>46.265</td>  <td>120</td>  <td>120</td></tr>
<tr><td>3 </td><td>3.571  </td><td>5.357  </td><td>5.357  </td><td>25 </td><td>35.714</td>  <td>75</td> <td>75</td></tr>
<tr><td>4 </td><td>2.813  </td><td>14.063 </td><td>2.813  </td><td>11.25  </td><td>14.063</td>  <td>45</td> <td>45</td></tr>
<tr><td>5 </td><td>0  </td><td>28.235 </td><td>21.176 </td><td>35.294 </td><td>35.294</td>  <td>120</td>  <td>120</td></tr>
<tr><td>Current Destinations Total</td><td> 43.613</td> <td>95.547</td> <td>135.611</td>  <td>103.894</td>  <td>131.336</td><td></td>  <td></td></tr>
<tr><td>Destinations Total Future year</td><td> 48</td> <td>75</td> <td>48</td> <td>150</td>  <td>189</td></tr>
</table>
<p>
<div>Multiply each cell in the 1st  column  by 48/43.613</div>
<div>Multiply each cell in the 2nd column by 75/95.547</div>
<div>Multiply each cell in the 3rd  column  by 48/135.611</div>
<div>Multiply each cell in the 4th  column  by 150/103.894</div>
<div>Multiply each cell in the 5th  column  by 189/131.336</div>
</p>
<table class="table table-bordered table-hover">
  <caption>Doubly Constraint Growth Factor Matrix For Future Year</caption>
<tr><th>Zone</th> <th>1</th>  <th>2</th>  <th>3</th>  <th>4</th>  <th>5</th>  <th>Current Origins Total </th><th>Origins Total Future year</th></tr>
<tr><td>1 </td><td>30 </td><td>45 </td><td>60 </td><td>15 </td><td>0</td> <td>150</td>  <td>150</td></tr>
<tr><td>2 </td><td>7.229  </td><td>2.892  </td><td>46.265 </td><td>17.349 </td><td>46.265</td>  <td>120</td>  <td>120</td></tr>
<tr><td>3 </td><td>3.571  </td><td>5.357  </td><td>5.357  </td><td>25 </td><td>35.714</td>  <td>75</td> <td>75</td></tr>
<tr><td>4 </td><td>2.813  </td><td>14.063 </td><td>2.813  </td><td>11.25  </td><td>14.063</td>  <td>45</td> <td>45</td></tr>
<tr><td>5 </td><td>0  </td><td>28.235 </td><td>21.176 </td><td>35.294 </td><td>35.294</td>  <td>120</td>  <td>120</td></tr>
<tr><td>Current Destinations Total</td><td> 43.613</td> <td>95.547</td> <td>135.611</td>  <td>103.894</td>  <td>131.336</td><td></td>  <td></td></tr>
<tr><td>Destinations Total Future year</td><td> 48</td> <td>75</td> <td>48</td> <td>150</td>  <td>189</td></tr>
</table>

<p>Similarly continuing till 4th iteration we will get
 the final result with accuracy level 3% of each individual cell as shown below.</p>
<span class="title1">Final Result</span>
<table class="table table-bordered table-hover">
  <caption>Doubly Constraint Growth Factor Matrix For Future Year</caption>
<tr><th>Zone</th> <th>1</th>  <th>2</th>  <th>3</th>  <th>4</th>  <th>5</th>  <th>Current Origins Total </th><th>Origins Total Future year</th></tr>
<tr><td>1 </td><td>30 </td><td>45 </td><td>60 </td><td>15 </td><td>0</td> <td>150</td>  <td>150</td></tr>
<tr><td>2 </td><td>7.229  </td><td>2.892  </td><td>46.265 </td><td>17.349 </td><td>46.265</td>  <td>120</td>  <td>120</td></tr>
<tr><td>3 </td><td>3.571  </td><td>5.357  </td><td>5.357  </td><td>25 </td><td>35.714</td>  <td>75</td> <td>75</td></tr>
<tr><td>4 </td><td>2.813  </td><td>14.063 </td><td>2.813  </td><td>11.25  </td><td>14.063</td>  <td>45</td> <td>45</td></tr>
<tr><td>5 </td><td>0  </td><td>28.235 </td><td>21.176 </td><td>35.294 </td><td>35.294</td>  <td>120</td>  <td>120</td></tr>
<tr><td>Current Destinations Total</td><td> 43.613</td> <td>95.547</td> <td>135.611</td>  <td>103.894</td>  <td>131.336</td><td></td>  <td></td></tr>
<tr><td>Destinations Total Future year</td><td> 48</td> <td>75</td> <td>48</td> <td>150</td>  <td>189</td></tr>
</table>
<table class="table table-bordered table-hover">
<caption>Doubly Constraint Growth Factor Matrix For Future Year</caption>
<tr><th>Zone</th> <th>1</th>  <th>2</th>  <th>3</th>  <th>4</th>  <th>5</th>  <th>Current Origins Total </th><th>Origins Total Future year</th></tr>
<tr><td>1 </td><td>37.598</td><td>46.202</td><td>27.301</td><td>35.716</td><td>0</td><td>146.817</td><td>150</td></tr>
<tr><td>2 </td><td>5.671</td><td>1.91</td><td>13.166</td><td>25.403</td><td>75.058</td><td>121.207</td>  <td>120</td></tr>
<tr><td>3 </td><td>2.794</td><td>2.823</td><td>0.927</td><td>26.962</td><td>42.412</td><td>75.919</td><td>75</td></tr>
<tr><td>4 </td><td>1.937</td><td>7.83</td><td>0.964</td><td>15.022</td><td>19.49</td><td>45.244</td><td>45</td></tr>
<tr><td>5 </td><td>0</td><td>16.234</td><td>5.643</td><td>46.897</td><td>52.04</td><td>120.814</td><td>120</td></tr>
<tr><td>Current Destinations Total</td><td> 48</td> <td>75</td> <td>48</td>  <td>150</td>  <td>189</td><td></td>  <td></td></tr>
<tr><td>Destinations Total Future year</td><td> 48</td> <td>75</td> <td>48</td> <td>150</td>  <td>189</td></tr>
</table>

  </div>
  <?php
  include_once("footer.php");
  getFooter(2);
?>  