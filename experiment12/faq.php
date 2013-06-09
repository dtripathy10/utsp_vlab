
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<?php
  include_once("header.php");
  getHeader(5,"System Optimal Assignment","Trip Assignment");
?> 
	<div id="body">
    <h1 class="designation">FAQs</h1>
    <ul class="questions">
      <li>Is System optimization a realistic model? If not, why we use it to model flow in a network?
        <span class="answers">System optimization is not a realistic model but it is very useful to transport planners and engineers, trying to manage the traffic to minimise travel costs and therefore achieve an optimum social equilibrium.</span></li>
      <li>Can User equilibrium and system optimal produce identical results?<span class="answers">
      When congestion effects are ignored (i.e. travel time is independent of flow) , User equilibrium and system optimal have same optimization function and hence produce identical results.</span></li> 
    </ul>
  </div>
<?php
  include_once("footer.php");
  getFooter(5);
?>  	