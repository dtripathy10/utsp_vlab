
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<?php
  include_once("header.php");
  getHeader(5);
?> 
	<div id="body">
    <h1 class="designation">FAQs</h1>
    <ul class="questions1">
        <li>
          <strong class="bold1">Why travel time is generally used as sole measure of link impedance?</strong>
        Travel time is the best representative of travel Impedance due to following facts:
  <ul>
    <li>Flow on a link primarily depends on Travel time associated with link. Lesser the travel time more will be the flow</li>
    <li>Majority of measure of travel Impedance are highly correlated with travel time.</li>
    <li>It can be measured easily as compare to other measures.</li>
  </ul>
    </li>
      <li> <strong class="bold1">what are the assumptions in user equilibrium?</strong>
        <ul>
<li>The user has perfect knowledge of the path cost.</li>
<li>Travel time on a given link is a function of the flow on that link only.</li>
<li>Travel time functions are positive and increasing.</li>
</ul>
</li>
        <li><strong class="bold1">What is the underlying assumption of route choice behaviour that defines
         flow pattern in user equilibrium?</strong>
While Travelling from fixed origin to destination, every driver will try to minimise his own travel time by choosing shortest travel time path. For fixed origin and destination, if travel time on different paths is different, then some of drivers will shift to shortest path. Travel time on links will change with flow change and a stable condition will reach when no driver can better off by unilaterally changing routes.
                  This equilibrium in flow pattern is called User Equilibrium</li>

        <li><strong class="bold1">What in user equilibrium principle?</strong>
        For each O-D pair, at user equilibrium, the travel time on all used is equal and less
         than or equal to travel time that would be experience by a single vehicle on any unused path.</span></li>
        <li><strong class="bold1">What are the major parameters on which link performance function of a link depands?</strong>
        Physical characteristics of roads like width, length, parking restrictions, 
          green signal time determine the exact parameter of performance function of a road.</li>
    </ul>
  </div>
<?php
  include_once("footer.php");
  getFooter(5);
?>  	