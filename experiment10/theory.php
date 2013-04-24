
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
  <p class="section">
    The simplest route choice and assignment method is <strong>All-or-nothing</strong> assignment. 
    This method assumes that there are no congestion effects, that all drivers consider the same 
    attributes for route choice and that they perceive and weigh them in the same way. 
    The absence of congestion effects means that link cost are fixed; the assumption that all drivers perceive 
    the same costs means that every driver from <strong>i </strong>to <strong>j </strong>must choose the same route. Therefore, all drivers are 
    assigned to one route between  <strong>i </strong> and <strong>j </strong> and no driver is assigned to other, less attractive, routes. 
    These assumptions are probably reasonable in sparse and uncongested networks where there are few alternative 
    routes and they are very different in cost.
  </p>
  <p>
    The assignment algorithm itself is the procedure that loads the matrix T to the shortest path trees and produces the flows <strong>V<sub>A, B</sub></strong> on links (between nodes A and B). 
    All load algorithms start with an initialization stage, in this case making all <strong>V<sub>A, B</sub></strong> = 0 and then apply
    one of two basic variations: pair-by-pair methods and once -through approaches..
  </p>
<span class="title">Example</span>
<img src="img/net.jpg" class="pull-left x"></img>
<div class="z"><ul class="conclusion" style="list-style-type:none;">
    <li>t1=10 units</li>
    <li>t2=15 units</li>
    <li>t3=5 units</li>
    <li>t4=20 units</li>
    <li>t5=30 units</li>
  </ul>
</div>
<div style="clear:both;"></div>
<pre>
For origin: 1      destination: 2      Flow: 100
Possible path Travel Time Shortest path
1-2 10  1-2


Flow on link 1 = 100 

For origin: 1      destination: 3      Flow: 200
Possible path Travel Time Shortest path
1-3 15  1-3


Flow on link 2 = 200 

For origin: 1      destination: 4      Flow: 500
Possible path Travel Time Shortest path
1-2-4 10 + 20 = 30  1-2-4
1-3-4 15 + 30 = 45  1-3-4
1-2-3-4 10 + 5 + 30 = 45  1-2-3-4


Flow on link 1 = 100 + 500 = 600 Flow on link 4 = 500 

For origin: 2      destination: 3      Flow: 400
Possible path Travel Time Shortest path
2-3 5 2-3


Flow on link 3 = 400 

For origin: 2      destination: 4      Flow: 300
Possible path Travel Time Shortest path
2-4 20  2-4


Flow on link 4 = 500 + 300 = 800 

For origin: 3      destination: 4      Flow: 600
Possible path Travel Time Shortest path
3-4 30  3-4

Flow on link 5 = 600 
</pre>
<span class="title1">Flow pattern based on all or nothing assignment</span>
<img src="img/net1.jpg" class="pull-left x"></img>
</div>
<?php
  include_once("footer.php");
  getFooter(2);
?> 