<?php
  include_once("header.php");
   getHeader(2,"Trip Distribution","");
?> 

<script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
 //  MathJax.Hub.Config({ TeX: { equationNumbers: {autoNumber: "all"} } });
</script>
 <script type="text/javascript" src="mathjax-MathJax-24a378e/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<div id ="body">
<div id="example" class="modal hide fade in" style="display: none; ">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3>You have not logged in!!!</h3>
      </div>
      <div class="modal-body">
         <p style="margin:0px;padding: 0px;">please login to perform the experiment.</p>            
      </div>
      <div class="modal-footer">
         <a href="login.php" class="button">Login</a>
         <a href="#" class="button" data-dismiss="modal">Close</a>
      </div>
   </div>
<h1 class="designation">Trip Distribution</h1>
<span class="title">Introduction</span>
 <p class="section">Trip Distribution is the second step in the Sequential Demand Modelling arrangement (FSTP). Its purpose is to analyse and synthesis tip linkages between traffic zones concerned with the estimation of target year trip volume. Underlying principle of trip Distribution can be explained as follows: the zones that are attracting trip are in competition with each other thus depending on the attractiveness of the zones and the intervening factors affecting the choice of the zone will be considered. For example two zones having shopping malls, the trips from trip producing zone will be more attracted to the shopping mall which much closer, thus the attractiveness in this case is determined by the distance factor between the production zone and attraction zone. Other factors that are generally taken into consideration are out of pocket cost, generalised coast, travel time etc.</p>
 <p class="section">Trip Distribution is illustrated better in the form of a matrix. There are two types of Matrix:</p>
<center><b>Example of PA Matrix</b></center>
<table class="table table-bordered table-hover">
<tr><th>&nbsp</th><th colspan="4">Attraction Zones (j)</th><th>sum</th></tr>
<th align="center" rowspan="4" width="35%">Production Zones (i)<th>Zone</td><th>1</th><th>...</th><th>n</th><th>&nbsp;</th></tr>
<tr align="center"><th>1</th><td>t<sub>11</sub></td><td>t<sub>1j</sub></td><td>t<sub>1n</sub></td><td>&Sigma;t<sub>1j</sub></td></tr>
<tr align="center"><th>..</th><td>t<sub>i1</sub></td><td>t<sub>ij</sub></td><td>t<sub>in</sub></td><td>&Sigma;t<sub>ij</sub></td></tr>
<tr align="center"><th>n</th><td>t<sub>n1</sub></td><td>t<sub>nj</sub></td><td>t<sub>nn</sub></td><td>&Sigma;t<sub>nj</sub></td></tr>
<tr align="center"><th>Sum</th><td>&nbsp;</td><td>&Sigma;t<sub>i1</sub></td><td>&Sigma;t<sub>ij</sub></td><td>&Sigma;t<sub>in</sub></td><td>Total</td></tr>
</table>
<p class="section">The cell value in the above table represents trip interchanges between zone I and Zone J, thus it has not directional meaning. Generally the trip production zones are equal to trip attraction zones and the total number of Trips Produced will be equal to total number of Trips Attracted.</p>
<br>
<center><b>Example of OD Matrix</b></center>
<table class="table table-bordered table-hover">
<tr><th>&nbsp</th><th colspan="4">Destination (j)</th><th>sum</th></tr>
<th align="center" rowspan="4" width="35%">Origin (i)<th>Zone</td><th>1</th><th>...</th><th>n</th><th>&nbsp;</th></tr>
<tr align="center"><th>1</th><td>t<sub>11</sub></td><td>t<sub>1j</sub></td><td>t<sub>1n</sub></td><td>O<sub>1</sub></td></tr>
<tr align="center"><th>..</th><td>t<sub>i1</sub></td><td>t<sub>ij</sub></td><td>t<sub>in</sub></td><td>O<sub>i</sub></td></tr>
<tr align="center"><th>n</th><td>t<sub>n1</sub></td><td>t<sub>nj</sub></td><td>t<sub>nn</sub></td><td>O<sub>n</sub></td></tr>
<tr align="center"><th>Sum</th><td>&nbsp;</td><td>D<sub>1</sub></td><td>D<sub>j</sub></td><td>D<sub>n</sub></td><td>T</td></tr>
</table>
<p class="section">The rows and columns represent Origin and Destination zones thus the OD Matrix will be useful for directional traffic assignment.</p>
<p class="section">The PA matrix can be converted into OD Matrix with the help of formula with a given the value of &#955;. the value of &#955; depends on various characteristics, default value is taken as 0.5. General formula for conversion is given below:<br>
$$t_{ij}\ =\ \lambda t_{ij}\ + \ (1-\lambda ) t_{ij}$$
<center><b>Example for conversion of PA to OD Matrix using &#955; = 0.5 is given below</b></center>
<table class="table table-bordered table-hover">
<tr align="center"><th>P/A</th><th>1</th><th>2</th><th>3</th></tr>
<tr align="center"><td>1</td><td>15</td><td>30</td><td>25</td></tr>
<tr align="center"><td>2</td><td>10</td><td>10</td><td>15</td></tr>
<tr align="center"><td>3</td><td>35</td><td>45</td><td>15</td></tr>
</table>
<table class="table table-bordered table-hover">
<tr align="center"><th>O/D</th><th>1</th><th>2</th><th>3</th></tr>
<tr align="center"><td>1</td><td>15</td><td>20</td><td>30</td></tr>
<tr align="center"><td>2</td><td>20</td><td>10</td><td>30</td></tr>
<tr align="center"><td>3</td><td>30</td><td>30</td><td>10</td></tr>
</table>
<span class="title">Trip Distribution Experiments</span>
<p class="section"><a data-toggle="modal" href="#example">Growth Factor Distribution Model</a></p>
<p class="section"><a data-toggle="modal" href="#example">Singly constrained Gravity Model</a></p>
<p class="section"><a data-toggle="modal" href="#example">Doubly constrained Gravity Model</a></p>
<p class="section"><a data-toggle="modal" href="#example">Calibration of Singly Constrained Gravity Model</a></p>
<p class="section"><a data-toggle="modal" href="#example">Calibration of Doubly Constrained Gravity Model</a></p>
</div>
 <?php
  include_once("footer.php");
  getFooter(2);
?>   
