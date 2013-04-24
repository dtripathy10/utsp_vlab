
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
<span class="title">Stochastic User Equilibrium Assignment</span>

<p class="section">Stochastic model as the name suggests is the process whose behaviour is non deterministic. User Equilibrium makes use of Wardrop&rsquo;s principle considering that all the drivers have perfect knowledge about travel costs and choose the best route for them. This assumption may not be realistic, &nbsp;this process selects among alternative paths on which travel time is random. Due to variations in perception and different factors like weather, lighting etc each driver will have their own perceived travel time. Analytically it is represented as</p>
<p>$C_k^{rs}= c_k^{rs} + \zeta_k^{rs} \forall k,r,s$</p>
<p>$C_k^{rs}$ = perceived travel time on route k between r and s.</p>
<p>$c_k^{rs}$ = actual travel time on route k between r and s.</p>
<p>$ \zeta_k^{rs}$= random term
<p>$k$= no of alternatives</p>
<p>When the population of drivers between r and s is large, the share of drivers choosing the $k^{th}$ route</p>
<p>$P_k^{rs}= Pr(C_k^{rs} \le c_k^{rs},\ \forall |\in K )$</p>
<p>The above represents the probability of a given route chosen is the probability that perceived travel time is lowest. Path flow assignment is then represented as</p>
<p>$f_k^{rs} = q_{rs} P_k^{rs} \forall k,r,s$ </p>
<p>Link flows is given as $x_a= \sum\limits_{rs} \sum\limits_{k}f_k^{rs} \delta_{a,k}^{rs} \forall a$. </p>
<span class="title1">Network Loading Models</span>
<p>
 	<ul class="test">
 		<li>Logit based loading Model</li>
 		<li>Probit based loading Model</li>
	 </ul>
</p>
<br>
<span class="title">Logit Model</span>
<p> Assuming the utility for the $k_{th}$ path between origin $r$ and destination $s$ to be as given below:</p>
<p>$U_k^{rs}= -\theta c_k^{rs} + e_k^{rs} \forall k,r,s $</p>
<p>Where $\theta$ is a positive parameter</p>
<p>The route shares are given by Logit Model</p>
<p>$P_k^{rs} = \dfrac {e^{-\theta c_k^{rs}}}{ \sum \limits_{l} e^{-\theta c_k^{rs}}}$</p>
<p>The parameter $\theta$ scales the perceived travel time</p>
<p>The Logit Model can be solved using <strong>Dial's Algorithm</strong> used for Stochastic Network Loading given below:</p>
<ul class="test">
	<li><strong>Step 1: </strong>Let $r(i)$ represent minimum travel time from node $r$ to all other nodes and $s(i)$ as minimum travel time from each node $i$ to node $s$.</li><br>
	<li>Compute link likelihood, $L(i \rightarrow j)$, where</li>
<br>
<li>$L(i \rightarrow j) = e^{\theta[r(j)-r(i)-t(i\rightarrow  j)]}$ if $r(i) \lt r(j)$ and $s(i) \gt s(j)$ otherwise $L(i \rightarrow j)=0$. <br>$t(i \rightarrow j)$ is the measured link travel time on link $(i \rightarrow j)$.<br>$O_i$ denotes set of downstream nodes of all links leaving node $i$.<br>$F_i$ denotes set of upstream nodes of all links arriving at node $i$.</p></li>
<br>
<li><strong>Step 2: Forward Pass</strong> Considering nodes in ascending order of $r(i)$ starting with origin $r$, link weight $w(i\rightarrow j)$is calculated for each $j\in O_i$,where
<p><center>$w(i\rightarrow j) = L(i\rightarrow j)$ if $i=r$ otherwise </center></p>
<p><center>$L(\rightarrow j) \sum\limits_{m \in F_i} w(m \rightarrow i)$</center></p> </li>
<br>
<li><strong>Step 2: Backward Pass</strong> Considering nodes in ascending values of $s(j)$ starting with destination $s$ calculate link flows as given below:
<p><center>$x(i\rightarrow j)= q_{rs} [\dfrac{w(i\rightarrow j)}{\sum \limits_{m\in F_i} w(m \rightarrow j)}]$ for $j=s$. </center></p>
<p><center> = $\sum \limits_{ m \in  O_j} x(j\rightarrow m) [\dfrac{w(i\rightarrow j)}{ \sum\limits_{ m \in F_i} w(m\rightarrow j)}]$ for all other links</center></p>
<br>
<p><strong>The Algorithm using Method of Successive Averages is given below is given below: </strong></p>
<p>
 	<ul class="test">
 		<li>Step 0: Obtain link flows $x_a^1$ by performing stochastic network loading based on initial travel time $t_a^0$.</li>
		<li>Step 1: Update Set $t_a^1 = t_a(x_a^n),\ \forall a$ </li>
		<li>Step 2: Get auxiliary link flow pattern ${y_a^n}$ from current link travel times by performing stochastic network loading.
		<br>
		<p><center>$y_a^n = \sum\limits_{rs} \sum\limits_{k} q_{rs} P_k^{rs}(c^{rsn}) \delta_{a,k}^{rs}$</center></p>
		</li>
		<li>Step 3: Set: $x_a^{n+1} = x_a^n (\dfrac{1}{n})(y_a^n - x_a^n)$ to obtain new link flows.</li>
		<li>Step 4: Stop if convergence criteria is obtained otherwise set $n = n+1$ and go to step 1. </li>
	 </ul>
</p>

<br>
<span class="title">Probit Model</span>
<p>Assume normal distribution of perceived path travel time along any given path  with mean equal to actual travel time. Let $T_a$ denote link travel time of link $a$ perceived by a randomly chosen motorist from a population of drivers. Thus $T_a$ is a random variable to be randomly distributed with mean equal to measured link travel time and variance proportional to the measured link travel time.</p>
<p>$T_a \sim N(T_a, \beta T_a)$</p>
<p>$\beta$ = proportionality constant</p>
<br>
<p><strong>The Algorithm using Probit Model is given below:</strong></p>
<ul class="test">
<li>Step 0: Initialization Step $l = 1$</li>
<li>Step 1: Sample $T_a^{(l)}$ from $T_a \sim N(T_a, \beta T_a)$ for each link $a$. </li>
<li>Step 2: Assign $\{q_{rs}\}$ to shortest path connecting OD pair $r,s$ based on $\{T_a^{(l)}\}$. </li>
<li>Step 3: Let $x_a^{(l)} = \dfrac{[(l-1)x_a^{(l-1)} + x_a^{(l)}]}{l}, \forall a$.   </li>
<li>Step 4: Stopping criteria is given below: 
<p>If max $\{\dfrac{\sigma_a^{(l)}}{x_a^{(l)}}\} \le \kappa$ then stop otherwise set $l = l + 1$ and go to step 1.</p>
</li>
</ul>
<br>
<span class="title">Example</span>
<p><center><img src="img/stochastic.png" /></center></p>
<p>Lets consider a simple example for solving logit route choice model with parameter $\theta = 1\  min^{- 1}$.</p>
<p>Take a case where travel time functions for both the links is given by: </p>
<p>$t_1= 1.25[1+{(\dfrac{x_1}{800})}^4]$</p>
<p>$t_2= 2.50[1+{(\dfrac{x_2}{800})}^4]$</p>
<p>and total flows from $1$ to $2$. </p>
<p>$q_{12}=4000$ veh/hr</b></font></p>
<p>$ \dfrac{x_1}{q} = \dfrac{1}{(1 + e^{\theta (t_1 - t _2)})}$</p>
<p>Solving the above equations simultaneously we get $x_1 = 1845$ veh\hr   and $x_2 = 2155$ veh\hr</p>
</div>
<?php
  include_once("footer.php");
  getFooter(2);
?> 