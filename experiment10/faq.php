
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
    <ul class="questions">
      <li>What is link?<span class="answers">An element of a transportation network that connects two nodes.
       A section of roadway or a bus route could be modeled as a link.</span></li>
       <li>What are Nodes?<span class="answers">Nodes are points at which links terminate. 
        Links may terminate at destinations or at intersections with other links.</span></li>
       <li>What are Routes in network?<span class="answers">Pathways through a network. 
        Routes are composed of links and nodes.</span></li>
       <li>What is Trip Assignment Analysis?<span class="answers">The process used to estimate the routes (for each mode) that will be used 
        to travel from origin to destination. This process yields the total number of vehicles or passengers that 
        a particular route can expect to service.</span></li>
       <li>Why this assignment is called All-or-nothing assignment ?<span class="answers">
       In this method the trips from any origin zone to any destination zone are assign to a single, 
       minimum cost, path between them and other path are assign zero flow.</span></li>
       <li>What are the basic assumptions made in All-or-nothing assignment?<span class="answers">
          <div>1-<span class="margin-right:10px;"></span>Travel time is a fixed input, equal to free flow travel time and it does not vary depending on the congestion on a link.</div>
          <div>2-<span class="margin-right:30px;"></span>Unlimited number of vehicles can be assign to a link </div>
       </span></li>
       <li>In which condition All-or-nothing assignment can be used?<span class="answers">
       Though All-or-nothing is unrealistic as only one path between every O-D pair is utilised, this model may be reasonable in sparse and uncongested networks where there arefew alternative routes and they have a large difference in travel cost.
                   This model may also be used to identify the path which the drivers would like to travel in the absence of congestion.</span></li>
    </ul>
  </div>
<?php
  include_once("footer.php");
  getFooter(5);
?>  	