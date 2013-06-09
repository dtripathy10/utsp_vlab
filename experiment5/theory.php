<!--
  Author:   Debabrata Tripathy, IIT Bombay, Mumbai
  Mail ID:  dtriapthy10@gmail.com
  Website:  http://home.iitb.ac.in/~debabratatripathy/
  Phone No: 9004499484
--> 
<?php
  include_once("header.php");
  getHeader(2,"Singly constrained Gravity Model","Trip Distribution");
?> 
  <div id="body">
    <h1 class="designation">Theory</h1>
  <span class="title">Introduction</span>
<p class="section">
  This model is a classic travel demand Model which is originally developed from the Newton's Law of Gravitation.
   It is written in the form as shown below:
</p>

$$T_{ij} = K\dfrac{P_iA_j}{W_{ij}^c}$$

<div>$T_{ij}$ = No. of trips interchanged between zone i and j.</div>
<div>$P_{i}$ = Trips produced from zone i.</div>
<div>$A_{j}$ = Trips attracted to zone j.</div>
<div>K = Proportionality constant.</div>

<div>${W_{ij}^c}$= Impedance factor (Travel time, distance, cost etc) between zone i and j , c 
  is the model parameter depending on the field conditions.</div>
<p class="section">
The above formula states that the interchange volume between production zone i and an attracting zone j 
is directly proportional to the magnitude trips produced from zone i and attracted to zone j 
and inversely proportional to impedance W.
The sum over all trip attracting zones j of the interchange volumes that share i as the 
trip producing zone must be equal to total trip productions of zone i i.e.,</p>

$$P_i = \sum \limits_{j} T_{ij}$$
<p>Substituting (2) in (1) we get,</p>

$$\nonumber P_i = KP_i\sum \limits_{j} \dfrac{A_j}{W_{ij}^c}$$

$$K = (\sum \limits_{j} \dfrac{A_j}{W_{ij}^c})^{-1}$$
<p>Above Equation (3) satisfies Trip production Balance Constraint. Thus in Gravity Model becomes</p>

$$T_{ij} = P_i(\sum \limits_{j} \dfrac{A_j}{W_{ij}^c})^{-1}\dfrac{A_j}{W_{ij}^c}$$

<div>Let $F_{ij} = \dfrac{1}{W_{ij}^c}$</div>

<div>$F_{ij}$  = Friction Factor</div>
Thus Equation (4) becomes

$$T_{ij} = P_i F_{ij}\dfrac{A_j}{\sum \limits_{j} F_{ij}A_j}$$
<p>Finally introducing a set of interzonal socio economic adjustment factors $K_{ij}$ </p>

$$T_{ij}^m = [ P_i F_{ij}^m K_{ij}\dfrac{A_{jk}}{\sum \limits_{j} F_{ij}^m K_{ij}A_{jk}}]_p$$



<div>$P_{i}$ = Trips produced from zone i.</div>
<div>$A_{j}$ = Trips attracted to zone j.</div>
<div>${W_{ij}^c}$ = Impedance factor (Travel time, distance, cost etc) between zone i and j ,
c is the model parameter depending on the field conditions.</div>
<div>$T_{ij}^m$ = Trip produced from zone i attracted to j travelling by mode m in the kth iteration following
 the path p .</div>
<div>$F_{ij}^m$ = factor derived which represent area wide effect of spatial separation of 
  trip interchange between zone i and zone j </div>
<div>$F_{ij}$ = $\dfrac{1}{W_{ij}^c}$</div>
<div>k = iteration number</div>
<div>p = trip purpose
  <p class="section">
At the end of first iteration trip production values will match the predicted values because 
of the condition used in Equation (3) thus further iteration in order to match the trip attraction 
values should be followed:</p>

$$A_{jk} = \dfrac{A_j}{ c_{j(k-1)}}*A_{j(k-1)}$$



<div>$A_{jk}$ = Adjusted trip attraction for kth iteration.</div>
<div>$c_{j}$ = desired trip attraction.j.</div>
<div>$A_{j(k-1)}$ = Adjusted trip attraction for iteraction (k-1).</div>
<div>$c_{j(k-1)}$ = calculated trip attraction for iteration (k-1) (obtained from gravity model calculation (6)).
  j. Iteration is carried on till the satisfactory value of trip attraction is obtained.</div>

 <span class="title">Singly constrained gravity model </span>
<p class="section">Singly Constraint Gravity Model is a type when either the origin (production) or 
  destination (Attraction) is constraint. Equation (5) is derived when Trip Production is constraint. 
  In the equation (5) the proportionality constant k is chosen such that the sum over all the trip attracting zones 
  j interchanging volume with the trip producing volume i is indicated as the total number of trips.
$$\nonumber P_i = \sum \limits_{j} T_{ij}$$</p>
<p>
Similarly k can also be defined by stating that sum of all the trips exchanged 
by Trip Attracting zone j with all other Trip Producing zone i.</p>
<p>
The sum over all trip attracting zones j of the interchange volumes that share i as 
the trip producing zone must be equal to total trip productions of zone i i.e.,
 K proportionality constant, equation 5 is modified with respect to Trip Production. Other 
 constraint is adjusted with the help of iterative procedure. The model has one constraint thus it 
 is called Singly Constraint Model</p>

$$\nonumber T_{ij} = P_i F_{ij}\dfrac{A_j}{\sum \limits_{j} F_{ij}A_j}$$

<span class="title">Example</span>
<p>
  The future $O_{i}$ & $D_{j}$ and cost matrix is given below
</p>
<div>$[O_{i}^f] = \begin{bmatrix}10 & 15 & 8\end{bmatrix}$</div>

<div>$[D_{j}^f] = \begin{bmatrix}7 & 16 & 10\end{bmatrix}$</div>








<table class="table table-bordered table-hover">
  <caption>$C_{ij}$</caption>
<tr><th>zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>1</td><td>3</td><td>10</td><td>15</td></tr>
<tr><td>2</td><td>10</td><td>5</td><td>10</td></tr>
<tr><td>3</td><td>15</td><td>10</td><td>5</td></tr>
</table>
<p>
Gravity Model calibration has resulted into following impedance function

<div>$F_{ij} = f(C_{ij}) = 10 - 0.5 C_{ij}$</div>
 
Here origin constrained gravity model is used to obtain the future year trip matrix.
</p>
<span class="title1">To Calculate $T_{ij}$</span>

<div>$ T_{ij} = O_i\dfrac{D_j F_{ij}}{\sum D_j F_{ij}}$</div>


<span class="title1">Step- 1</span>
 
<div>$F_{ij} = f(C_{ij}) = 10 - 0.5 C_{ij}$</div>

<table class="table table-bordered table-hover">
    <caption>$F_{ij}$</caption>
<tr><th>zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>1</td><td>8.5</td><td>5</td><td>2.5</td></tr>
<tr><td>2</td><td>5</td><td>7.5</td><td>5</td></tr>
<tr><td>3</td><td>2.5</td><td>5</td><td>7.5</td></tr>
</table>
<br/>
<span class="title1">Step- 2</span>
<table class="table table-bordered table-hover">
<caption>$D_{j} * F_{ij}$</caption>
<tr><th>i/j</th><th>$D_{1}F_{i1}$</th><th>$D_{2}F_{i2}$</th><th>$D_{3}F_{i3}$</th><th>${\sum D_j F_{ij}}$</th></tr>
<tr><td>$D_{1}F_{1j}$</td><td>59.5</td><td>80</td><td>25</td><td>164.5</td></tr>
<tr><td>$D_{2}F_{2j}$</td><td>35</td><td>120</td><td>50</td><td>205</td></tr>
<tr><td>$D_{3}F_{3j}$</td><td>17.5</td><td>80</td><td>75</td><td>172.5</td></tr>
</table>

<br/>
<span class="title1">Step- 3</span>
$$\nonumber \dfrac{D_j F_{ij}}{\sum D_j F_{ij}} = Pr_{ij} = \begin{bmatrix}0.3617 & 0.4863 & 0.152\\0.1707 & 0.5854 & 0.2439\\0.1014 & 0.4638 & 0.4348\end{bmatrix}$$

<table class="table table-bordered table-hover">
<caption> Interaction Probabilities $(Pr_{ij}$)</caption>
<tr><th>zone</th><th>1</th><th>2</th><th>3</th></tr>
<tr><td>1</td><td>0.3617</td><td>0.4863</td><td>0.152</td></tr>
<tr><td>2</td><td>0.1707</td><td>0.5854</td><td>0.2439</td></tr>
<tr><td>3</td><td>0.1014</td><td>0.4638</td><td>0.4348</td></tr>
</table>

<span class="title1">Step - 4</span>
$\nonumber T_{ij} = O_{j}Pr_{ij}$
<table class="table table-bordered table-hover">
<caption>$T_{ij}$</caption>
<tr><th>zone</th><th>$O_{i}Pr_{i1}$</th><th>$O_{i}Pr_{i2}$</th><th>$O_{i}Pr_{i3}$</th><th>${\sum O_i Pr_{ij}}$</th></tr>
<tr><td>$O_{1}Pr_{1j}$</td><td>3.617</td><td>4.8632</td><td>1.5198</td><td>10</td></tr>
<tr><td>$O_{2}Pr_{2j}$</td><td>2.561</td><td>8.7805</td><td>3.6585</td><td>15</td></tr>
<tr><td>$O_{3}Pr_{3j}$</td><td>0.8116</td><td>3.7101</td><td>3.4783</td><td>8</td></tr>
</table>

<table class="table table-bordered table-hover">
   <caption>$T_{ij}$</caption>
<tr><th>zone</th><th>1</th><th>2</th><th>3</th><th>${\sum D_j F_{ij}}$</th><th>Future year origin Total</th></tr>
<tr><td>1</td><td>3.617</td><td>4.8632</td><td>1.5198</td><td>10</td><td>10</td></tr>
<tr><td>2</td><td>2.561</td><td>8.7805</td><td>3.6585</td><td>15</td><td>15</td></tr>
<tr><td>3</td><td>0.8116</td><td>3.7101</td><td>3.4783</td><td>8</td><td>8</td></tr>
</table>
  </div></div>
  <?php
  include_once("footer.php");
  getFooter(2);
?>  