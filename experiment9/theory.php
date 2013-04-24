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
    <span class="title">Introduction</span>
    <p class="section">Modal share, Mode split or Mode choice analysis is the third step in the conventional four-step transportation forecasting model, following trip generation and trip distribution but before route assignment. Trip distribution's zonal interchange analysis yields a set of origin destination tables which tells where the trips will be made. Mode choice analysis allows the modeller to determine what mode of transport will be used, and what modal share results.</p>
    <span class="title">Types of Mode Split Models</span>

<ul class="xxxx">
<li><span class="xxxxx">Trip-end modal split models</span>
Traditionally, the objective of transportation planning was to forecast the growth in demand for car trips so that investment 
could be planned to meet the demand. When personal characteristics were thought to be the most important determinants
 of mode choice, attempts were made to apply modal-split models immediately after trip generation. Such a model is called trip-end modal split model.
 In this way different characteristics of the person could be preserved and used to estimate modal split. The modal split models of this time related the 
hoice of mode only to features like income, residential density and car ownership. The advantage is that these models could be very accurate in the short run,
 if public transport is available and there is little congestion. Limitation is that they are insensitive to policy decisions example: Improving public transport, 
restricting parking etc. would have no effect on modal split according to these trip-end models.
</li>
<li><span class="xxxxx">Trip-interchange modal split models</span>
This is the post-distribution model; that is modal split is applied after the distribution stage. 
This has the advantage that it is possible to include the characteristics of the journey and that of the alternative modes available to
 undertake them. It is also possible to include policy decisions. This is beneficial for long term modelling.
 </li>
<li><span class="xxxxx">Aggregate and disaggregate models</span>
Mode choice could be aggregate if they are based on zonal and inter-zonal information. 
They can be called disaggregate if they are based on household or individual data.
 </li>
</ul>
    <span class="title">Logit Model</span>
    <p class="section">Mode choice models are found in numerous formulations, but the most common are based on the probabilities estimated by some variation or sophistication of the logit function.The common logit mode choice relationship states that the probability of choosing a particular mode for a given trip is based on the relative values of the costs and levels of service on the competing modes for the trip interchange being considered.</p>
    <p class="section">The level of service provided by a particular mode for a specific trip interchange is usually represented in part by the travel time for that interchange as computed from the transit and roadway networks. The travel time components used to represent level of service include the in-vehicle travel time for each mode and the out-of-vehicle time required to use that mode, such as walking to a transit stop or from a parking lot. The level of service also includes the waiting time likely to be experienced, either to board transit or to transfer. The delay due to roadway traffic congestion is included inherently by using attenuated speeds for congested roadway network links.</p>
    <p class="section">The travel time and cost of a trip are usually combined using an estimate of the cost of time to convert either cost or time to the terms of the other. The cost of time is usually a variable, based on the economic level of the traveler. Although the mode choice model may be developed using the economic level of individual travelers, forecasts of mode choice are prepared for different economic groups, such as high, medium, and low income travelers. The resulting combination of time and cost is commonly referred to as the "generalized cost." The traveler will associate some value for the utility of each mode. If the utility of one mode is higher than the other, then that mode is chosen. But in transportation, we have disutility also. The disutility here is the travel cost. This can be represented as (for one particular mode from origin i to destination j)
$$\nonumber C_{ij} = a_1t_{ij}^v\ +\ a_2t_{ij}^w\ +\ a_3t_{ij}^t\ +\ a_4t_{nij}\ +\ a_5F_{ij}\ +\ a_6\phi _{ij} +\delta$$</p>
   
<p class="section">Where,
<ul class="yyyy">
<li>$\nonumber t_{ij}^v $ is the in-vehicle travel time between i and j</li>
<li>$\nonumber t_{ij}^w $ is the walking time to and from stops</li>
<li>$\nonumber t_{ij}^t$ is the waiting time at stops</li>
<li>$\nonumber t_{nij}$ is the interchange time, if any;
<li>$\nonumber F_{ij}$ is the fare charged to travel between i and j</li>
<li>$\nonumber \phi _{ij}$ is the parking cost at the destination</li>
<li>$\nonumber \delta$ is a parameter representing comfort and convenience, and a1,a2,.... are the coefficients attached to each element of cost function.</li>
</ul>
</p>

<p class="section">
The logit formulation is not a complex mathematical function nor is the utility/disutility function it employs. 
The difficulty in developing a logit model is encountered in estimating the considerable number of parameters 
for variables in the utility/disutility function. The estimation is accomplished using one or 
another multivariate statistical analysis program to optimize the accuracy of estimates of 
coefficients of several independent variables. Thus the proportion of trips by mode 1 is given by
$$P_{ij}^1 = \dfrac{e^{-c_{ij}^1}}{\sum\limits_{k} e^{-c_{ij}^k} }$$
Where,
$\nonumber c_{ij}^k$  is the generalized cost for mode k from origin i to destination j
</p>







    <span class="title">Example</span>
    <p class="section">
The total number of trips from zone i to zone j is 4200. Currently all trips are made by car. Government has two alternatives- to introduce a train or a bus. The travel characteristics and respective coefficients are given in table below. Decide the best alternative in terms of trips carried.
</p>
     <table class="table table-bordered table-hover">
<tr><th></th><th>$\nonumber t_{ij}^v $</th> <th>$\nonumber t_{ij}^w $</th> <th>$\nonumber t_{ij}^t$</th> <th>$\nonumber F_{ij}$</th>  <th>$\nonumber \phi _{ij}$</th></tr>
<tr><td>Coefficient</td>  <td>0.05</td> <td>0.04</td> <td>0.07</td> <td>0.2</td>  <td>0.2</td></tr>
<tr><td>Car</td>  <td>25</td> <td>-</td>  <td>-</td>  <td>22</td> <td>6</td></tr>
<tr><td>Bus</td>  <td>35</td> <td>8</td>  <td>6</td>  <td>8</td>  <td>-</td></tr>
<tr><td>Train</td>  <td>17</td> <td>14</td> <td>5</td>  <td>6</td>  <td>-</td></tr>
</table>

<p class="section">
First, use binary logit model to find the trips when there is only car and bus. 
Then, again use binary logit model to find the trips when there is only car and train. 
Finally compare both and see which alternative carry maximum trips.
<span style="display:block;line-height:40px;">
Cost of travel by car  =  $\nonumber C_{car}\  =\   0.05 * 25 + 0.2 * 22 + 0.2 * 6\ =\ 6.85 $
</span>
<span style="display:block;line-height:40px;">
Cost of travel by bus  =  $\nonumber C_{bus}\  =\   0.05 * 35 + 0.04 * 8 + 0.07 * 6 + 0.2 * 8\ =\ 4.09 $
</span>
<span style="display:block;line-height:40px;">
Cost of travel by train  = $\nonumber C_{train}\  =\   0.05 * 17 + 0.04 * 14 + 0.07 * 5 + 0.2 * 6\ =\ 2.96 $
</span>

<p>
<strong>Case 1:</strong> Considering introduction of bus,
<div style="line-height:40px;margin-left:30px;">

Probability of choosing car, $\nonumber p_{car}\  =\ \dfrac{e^{-6.85}}{e^{-6.85} + e^{-4.09}}\ =\ 0.059  $<br/>

Probability of choosing bus, $\nonumber p_{bus}\  =\ \dfrac{e^{-4.09}}{e^{-6.85} + e^{-4.09}}\ =\ 0.9403   $</div>
</p>

<p>
<strong>Case 2:</strong> Considering introduction of train,
<div style="line-height:40px;margin-left:30px;">

Probability of choosing car, $\nonumber p_{car}\  =\ \dfrac{e^{-6.85}}{e^{-6.85} + e^{-2.96}}\ =\ 0.02003  $<br/>

Probability of choosing train, $\nonumber p_{train}\  =\ \dfrac{e^{-2.96}}{e^{-6.85} + e^{-2.96}}\ =\ 0.979   $</div>
</p>

<p>
Trips carried by each mode,
<p><strong>Case 1:</strong>
  <div style="line-height:40px;margin-left:30px;">
$\nonumber T_{car_{ij}} = 4200 * 0.0596 = 250.32$<br/>
$\nonumber T_{bus_{ij}} = 4200 * 0.9403 = 3949.546$
</div>
</p>
<p><strong>Case 2:</strong>
  <div style="line-height:40px;margin-left:30px;">
$\nonumber T_{car_{ij}} = 4200 * 0.02 = 84.00$<br/>
$\nonumber T_{train_{ij}} = 4200 * 0.979 = 4115.8$
</div>
</p>




  </div>
  <?php
  include_once("footer.php");
  getFooter(2);
?>  