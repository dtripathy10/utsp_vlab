
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
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
   MathJax.Hub.Config({ TeX: { equationNumbers: {autoNumber: "all"} } });
  </script>
<script type="text/javascript" src="../mathjax-MathJax-24a378e/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

	<div id="body">
    <h1 class="designation">FAQs</h1>
    <ul class="questions">
      <li>
        When to use origin constrained and destination constrained model?<span class="answers">
          <div>Origin constrained model can be used when sum of all the trips attracted to all the attraction 
          zones will be equal to the total number of trips produced in a production zone. Mathematically:
          $$\nonumber \sum \limits_{j} T_{ij} = O_{i}$$
          </div>
          <div>Destination constrained model can be used when sum of trips produced for all the trip production 
            zones will be equal to the number of trips attracted to a destination zone.  Mathematically:
             $$\nonumber \sum \limits_{j} T_{ij} = D_{i}$$
          </div>
        </span>
      </li>
      <li> What is Travel Impedance?<span class="answers">
        Travel Impedance is known as generalized cost for travel.  Travel impedance of generalized cost 
        is a function of in-vehicle-travel-time, waiting time, fare, discomfort level, transfer time, 
        walk time etc.</span></li>
   </ul>
  </div>
  <?php
  include_once("footer.php");
  getFooter(5);
?>  