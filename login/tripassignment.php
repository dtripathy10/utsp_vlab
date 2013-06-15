<?php
  include_once("header.php");
   getHeader(2,"Trip Assignment","");
?> 
<div id ="body">
<h1 class="designation">Trip Assignment</h1>
<span class="title">Introduction</span>
<p class="section">The main concern with this last phase of transportation process is trip maker&#39;s choice of path between pair of zones by mode of choice resulting in vehicular flows on the multimodal transportation network. The estimation of inter zonal demand by mode by determining likely paths of each mode between zone i and j along a network and predict the resulting flow q on each link is the main question of interest. Potential capacity problems can be anticipated by estimating the link utilization used to assess the level of service. Various factors contribute while determining available paths between pair of zones like the mode of travel and in case of private transportation modes the driver is left with a large set of possible options of selecting different routes.</p>
<span class="title">Aim of Traffic Assignment Procedure</span>
<p class="section">Estimate traffic volume on links of network.</p>
<p class="section">Estimate inter zonal travel cost.</p>
<p class="section">Analyze travel pattern between each O-D pair.</p>
<p class="section">Identify congested links and design for future by collecting the required traffic data.</p>
<span class="title">Traffic Assignment Experiments</span>
<p class="section"><a href="../experiment10/aim.php">All or Nothing (AON) Assignment</a></p>
<p class="section"><a href="../experiment11/aim.php">User Equilibrium Assignment </a></p>
<p class="section"><a href="../experiment12/aim.php">System Optimal Assignment</a></p>
</div>
 <?php
  include_once("footer.php");
  getFooter(2);
?>   
