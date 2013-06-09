
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<?php
  include_once("header.php");
  getHeader(2,"Calibration of Singly Constrained Gravity Model","Trip Distribution");
?> 
<div id="body">
<h1 class="designation">Theory</h1>
<span class="title">
Introduction</span>
<p class="section">Calibration is an important step as it estimates the value of 
	c in the gravity equation given below such that the 
	model best fits the base year observations. Thus proper value of c fixes the 
	relationship between the travel time factor and the interzonal impedance. Initially a 
	value of c is assumed and applied using a base year observation of production, 
	attraction and impedance to compute interzonal volumes which are then compared with the 
	observed volume of the base year condition. If the value obtained of c gives close to the 
	observed value then it can be used otherwise its value is changed and further iteration is done.
	 Iteration is carried until sufficient convergence value of c is obtained. For calibration generally 
	 friction factor F is used rather than parameter c.</p>
$$\nonumber T_{ij} = K \dfrac{P_i A_j}{W_{ij}^c}$$

Let, $\nonumber F_{ij} = K \dfrac{1}{W_{ij}^c}$<br/>
$\nonumber F_{ij}$<strong>=</strong>Friction Factor
$$\nonumber T_{ij} = P_i F_{ij} \dfrac{A_j}{\sum \limits_{j}F_{ij} A_j}$$
<p class="section">The comparison between the computed and the observed values is done with the help 
	of trip length frequency distribution curve. Its a graphical relationship between the percentages of 
	the region wide trips versus their interzonal impedance (example: time etc).
The calibration of Gravity Model mainly depends on the assumed Friction Factor mathematical function. 
Some of the commonly used functions are shown below.</p>

<div>$\nonumber F_{ij} = t_{ij}^\beta$(Polynomial Function)</div>
<div>$\nonumber F_{ij} = e^{\beta t_{ij}}$ (Exponential Function)</div>
<div>$\nonumber F_{ij} = t_{ij}^\beta e^{\beta t_{ij}}$ (Two Parameters)</div>
<div>$\nonumber F_{ij} = $Discontinuous Function (BPR)</div>
<div>Examples of the above equations are given below.</div>
<p><img style="vertical-align: middle; display: block; margin-left: auto; margin-right: auto;" title="Diagram" src="img/fig7.jpg" alt="Diagram"/></p>

<p class="section">If the calibration is correct the observed and the simulated calculations will match but if 
they donot then a set of values of Friction Factor is calculated using the following expression:</p>
$$\nonumber F' = F \dfrac{OD\%}{GM\%} $$
<div><strong>F<sup>'</sup> = </strong>Friction factor to be used in next iteration</div>
<div><strong>F = </strong>Friction used in calibration just completed</div>
<div><strong>OD% = </strong>Percentage of total trips occuring for a given travel time observed in a travel survey</div>
<div><strong>GM% =</strong> Percentage of total trips occuring for a given travel time obtained from Gravity model</div>
<p class="section">This iteration is carried on till the trip length frequency curve of the observed and calculated 
	value is obtained. The final phase of calibration procedure includes the calculation of zone to zone adjustment 
	factor.</p>

$$\nonumber k_{ij} = r_{ij}[ \dfrac{(1-x_i)}{(1-x_i r_{ij})}] $$


<div>$ k_{ij}$ = Adjustment factor applied to movements between zone i and j</div>
<div>$ r_{ij}$ = (number of trips obtained from OD survey ) / (number of trips obtained from gravity model)</div>
<div>$ x_{i}$ = (Number of trips obtained from OD survey) / $ p_{i}$</div>



The mathematical models used for Trip Distribution Model are as follows:
<ul class="test1">
<li>Calibration of single constrained gravity model</li>
<li>Calibration of doubly constrained gravity model</li>
</ul>

<span class="title">Calibration of Singly Constrained Gravity Model</span>
The steps involved for calibration of doubly constraint model is given below:
<ul class="test1">
<li>Assume a trial value of β.</li>
<li>Constraint any one either Trip Production (Origin) or Trip Attraction (Destination), 
	suppose Origin is constraint (Remember: constraint is with respect to future trips).</li>
<li>A mathematical function that is selected in order to find the friction factor is calculated.</li>
<li>These values are substituted in the gravity model, the calculated destination values are compared with the future values, and the error between the two is calculated with the help of Residual Standard Square of Errors.</li>
<li>This error is minimised for an optimised value of β.</li>
<li>At the end of the calibration we get an optimised value of β.</li>
</ul>
<span class="title">Example</span>
<p class="section">Calibration of Singly Constrained Gravity Model (Origin)</p>
<table class="table table-bordered table-hover">
<caption>Cost Matrix</caption>
 <tr><th>Zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>1</td><td>28</td><td>23</td><td>28</td></tr>
<tr><td>2</td><td>29</td><td>26</td><td>27</td></tr>
<tr><td>3</td><td>31</td><td>31</td><td>20</td></tr>
</table>
<table class="table table-bordered table-hover">
<caption>Given Trip Matrix</caption>
<tr><th>Zone</th><th>1</th><th>2</th><th>3</th><th>∑ [O<sub>i</sub>]</th></tr>
<tr><td>1</td>	<td>3413</td>	<td>126</td>	<td>231</td>	<td>3770</td></tr>
<tr><td>2</td>	<td>151</td>	<td>564</td>	<td>729</td>	<td>1444</td></tr>
<tr><td>3</td>	<td>435</td>	<td>289</td>	<td>1806</td>	<td>2530</td></tr>
<tr><td><strong>∑ [D<sub>j</sub>]</strong></td>	<td>3999</td>	<td>979</td>	<td>2766</td><td></td>	</tr>
</table>
<p class="section">Selected Frictional Functions: Exponential Function $\nonumber F_{ij} = e^{-\beta c_{ij}} $</p>
<table class="table table-bordered table-hover">
<caption>Trip Matrix with respect to Optimal Beta Value (Minimum SSE)</caption>
<tr><th>Zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>1</td><td>1794</td><td>735</td><td>1240</td></tr>
<tr><td>2</td><td>661</td><td>220</td><td>562</td></tr>
<tr><td>3</td><td>745</td><td>182</td><td>1601</td></tr>
</table>
<strong>Minimum Residual = </strong>4567836.6438594<br/>
<strong>Optimal Beta = </strong>0.103

<table class="table table-bordered table-hover">
<tr><th>Target O<sub>i</sub></th><th>Modelled O<sub>i</sub></th><th>Target D<sub>j</sub></th><th>Modelled D<sub>j</sub></th></tr>
<tr><td>3770</td><td>3770</td><td>3999</td><td>3201.193385</td></tr>
<tr><td>1444</td><td>1444</td><td>979</td><td>1138.173227</td></tr>
<tr><td>2530</td><td>2530</td><td>2766</td><td>3404.633388</td></tr>
</table>

<p><img style="vertical-align: middle; display: block; margin-left: auto; margin-right: auto;" title="Diagram" src="img/fig2.jpg" alt="Diagram"/></p>
</div>
<?php
  include_once("footer.php");
  getFooter(2);
?> 