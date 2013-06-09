
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<?php
  include_once("header.php");
  getHeader(2,"User Equilibrium Assignment","Trip Assignment");
?> 
<div id="body">
<h1 class="designation">Theory</h1>
<span class="title">User Equilibrium Assignment</span>
<p class="section">The user equilibrium assignment is based on Wardrop&#39;s first principle. If one ignores stochastic effects and concentrates on capacity restraint as a generator of a spread of trips on a network, one should consider a different set of models. For a start, capacity restraint models have to make use of functions relating flow to the cost (time) of travel on a link. These models usually attempt, with different degrees of success, to approximate to the equilibrium conditions as formally enunciated by Wardrop(1952):</p>
<p class="section">Under equilibrium conditions traffic arranges itself in congested networks in such a way that no individual trip maker can reduce his path costs by switching routes. If all trip makers perceive costs in the same way (no stochastic effects): Under equilibrium conditions traffic arranges itself in congested networks such that all used routes between an O-D pair have equal and minimum costs while all unused routes have greater or equal cost.</p>
<p class="section">This is usually referred to as Wardrop&#39;s first principle, or simply Wardrop&#39;s equilibrium. It is easy to see that if these conditions did not hold, at least some drivers would be able to reduce their costs by switching to other routes. This problem is equivalent to the following nonlinear mathematical optimization program,</p>
<p class="section">
$$\nonumber Minimize\ Z\ =\ \sum\limits_{a} \int_0^{x_a} t_a(x_a)dx$$

$$\nonumber Subject\ to\ \sum\limits_{k} f_k^{rs}\ =\ q_{rs}\ \: \ \forall r,s  $$

$$\nonumber x_a = \sum\limits_{r}\sum\limits_{s}\sum\limits_{k} \delta_{a,k}^{rs} f_k^{rs}\ \:\ \forall a  $$

$$\nonumber f_k^{rs}\ \geqslant 0\ \:\ \forall k,r,s $$

$$\nonumber x_a\ \geqslant 0\ \:\ a\epsilon A$$
</p>
<p>$k$ is the path,$x_a$ equilibrium flows in link a, $t_a$ travel time on link a, $f_k^{rs}$ flow on path k connecting O-D pair r-s, $q_{rs}$ trip rate between r and s. </p>
<p class="section">The equations above are simply flow conservation equations and non negativity constraints, respectively. These constraints naturally hold the point that minimizes the objective function. These equations state user equilibrium principle. The path connecting O-D pair can be divided into two categories : those carrying the flow and those not carrying the flow on which the travel time is greater than (or equal to)the minimum O-D travel time. If the flow pattern satisfies these equations no motorist can better off by unilaterally changing routes. All other routes have either equal or heavy travel times. The user equilibrium criteria is thus met for every O-D pair. The UE problem is convex because the link travel time functions are monotonically increasing function, and the link travel time a particular link is independent of the flow and other links of the networks. To solve such convex problem Frank Wolfe algorithm is useful.</p>
<p class="section">The Bureau of Public Roads (BPR) developed a link congestion function  as given below</p>
<p>$T = T_0\{ 1 + \alpha {(\dfrac{V}{C})}^\beta \}$</p>
<p>$\alpha$ = Multiplication coefficient (standard value = 0.25, range (0,1))</p>
<p>$\beta$ = Exponential coefficient (standard value = 4, range is positive real number)</p>
<br>
<span class="title">Heuristic Equilibrium Techniques</span>
<p>
 	<ul class="test">
 		<li>Capacity Restraint</li>
 		<li>Incremental Assignment</li>
	 </ul>
</p>
<p>Following are the algorithms for solving these assignment techniques</p>
<span class="title1">Capacity Restraint</span>
<p>
 	<ul class="nostyle">
 		<li><strong>Step 0</strong>: Initialization,$t_a^0\ =t_a(0).$ Obtain $\{x_a^0\}$ by performing all or nothing assignment. Set $n=1$.</li>
 		<li><strong>Step 1</strong>: Update: Set $\eta_a^n\ =\ t_a(x_a^{n-1}),\forall a$.</li>
 		<li><strong>Step 2</strong>: Set $t_a^n\ =\ 0.75t_a^{n-1}\ +\ 0.25\eta_a^n,\  \forall a$. </li>
 		<li><strong>Step 3</strong>: Perform all or nothing assignment based on $\{t_a^n\}$ which yields $\{x_a^n\}$. </li>
 		<li><strong>Step 4</strong>: If $n = N$, go to step 5. Otherwise,set $n = n + 1$ and go to step 1.</li>
 		<li><strong>Step 5</strong>: Set $x_a^*\ =\ 0.25\sum\limits_{i=0}^3\ \forall a$ and stop. $\{x_a^*\}$ are link flows at equilibrium. </li>
 		
	 </ul>
</p>
<span class="title1">Incremental Assignment</span>
<p>
 	<ul class="nostyle">
 		<li><strong>Step 0</strong>: Divide each origin-destination entry into $N$ equal portions $(q_{rs}^n =\dfrac {q_{rs}}{N})$. Set $n=1$ and $x_a^0\ =\ 0,\ \forall a$.</li>
 		<li><strong>Step 1</strong>: Set $t_a^n = t_a(x_a^{n-1}),\ \forall a$.</li>
 		<li><strong>Step 2</strong>: Flow $\{w_a^n\}$ is obtained from all or nothing assignment based on $\{t_a^n\}$ and using trip rates $q_{rs}^n$ for each O-D pair.</li>
 		<li><strong>Step 3</strong>: Set $x_a^n= x_a^{n-1} + w_a^n$. </li>
 		<li><strong>Step 4</strong>: If $n=N$, stop otherwise set $n=n+1$ and go to step 1.</li>
 		
	 </ul>
</p>
<br>
<span class="title1">The Convex Combination Method</span>
<p>
 	<ul class="nostyle">
 		<li><strong>Step 0</strong>: Initialization, $t_a^0=t_a(0)$. Obtain $\{x_a^0\}$ by performing all or nothing assignment. Set $n=1$.</li>
 		<li><strong>Step 1</strong>: Set $t_a^n=t_a(x_a^{n-1}),\ \forall a$.</li>
 		<li><strong>Step 2</strong>: Perform all or nothing based on $\{t_a^n\}$ which yields auxiliary flows $\{y_a^n\}$</li>
 		<li><strong>Step 3</strong>: Line search. Solve<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$min_{\begin{subarray}{rl} {0 \le \alpha \le 1}\cr\end{subarray}} \sum \limits_{a} \int_a^{x_a^n + \alpha (y_a^n - x_a^n)}t_a(\omega)d\omega $.</li>
 		<li><strong>Step 4</strong>: Set $x_a^n + \alpha (y_a^n - x_a^n)\ \forall a$. </li>
 		<li><strong>Step 5</strong>: If the convergence criteria is met stop the solution otherwise set $n = n + 1$ and go to step 1. </li>
	 </ul>
</p>
<p> In this lab you can perform three types of user equilibrium experiments depending on the convergence criteria.</p>
 	<ul class="test">
 	<li>Convergence criteria as $\alpha$ will be used to optimize the maximum optimum move size.</li>
 	<li>Convergence criteria as <strong>Time </strong><br>Let $u_{rs}^n$ = minimum path travel time between OD pair r-s at $n^{th}$ iteration.<br><p>$\sum\limits_{rs} \dfrac{(| u_{rs}^n - u_{rs}^{n-1}|)}{u_{rs}^n}\le \kappa$ </p></li>
 	<li>Convergence criteria as <strong>Flow</strong><br><p>$ \sqrt {\sum\limits_{a} \dfrac{{( x_a^{n+1} - x_a^n)}^2}{\sum\limits_{a} x_a^n}} \le \kappa $</p>
 	</li>
 	</ul>

<br>
<span class="title">Example</span>
<p>To demonstrate how the most common assignment works, an example network is considered. This network has two nodes having two paths as links.</p>
<p><img style="vertical-align: middle; display: block; margin-left: auto; margin-right: auto;" title="Figure 1 Diagram" src ="img/net.jpg" ></p>
<p>Lets take a case where travel time functions for both the links is given by: </p>
<p>$t_1=10+3x_1$</p>
<p>$t_2=15+2x_2$</p>
<p>and total flows from 1 to 2. </p>
<p>$q_{12}=12$</p>
<p>Substituting the travel time in formulation of user equilibrium yield to </p>
<p>$min \colon Z( x ) = \int_0^{x_1}(10+3x_1)dx_1+\int_0^{x_2}(15+2x_2)dx_2 $</p>
<p>$10 x_1+(\dfrac{3 x_1^2}{2})+15 x_2+(\dfrac{2 x_2^2}{2})$</p>
<p>$st \colon   x_1 + x_2 = 12$</p>
<p>Substituting, $x_2 = 12 - x_1$ in the above formulation will yield the unconstrained formulation as below :</p>
<p>$10x_1+(\dfrac{3x_1^2}{2})+15(12-x_1)+{(12-x_1)}^2$</p>
<p>Differentiate the above equation w.r.t $x_1$ and equate to zero, and solving for $x_1$ and then $x_2$ leads to the solution $x_1^*=5.8,x_2^*=6.2,Z(x^*)=239.0$</p>






</div>
<?php
  include_once("footer.php");
  getFooter(2);
?> 