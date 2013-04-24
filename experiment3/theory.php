
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
    <p class="section">Trip production modelling technique that is based on the household and its characteristics is known as Category Analysis. This model helps in estimation of household trips in residential generation context; household types are classified according to a set of categories that are highly correlated with trip making. Thus we get trip rates per household for different characteristics. The household is represented into three to four characteristics like household size, car ownership, household income etc. Following example will help you to give a proper idea about Category Analysis Modelling.</p>
    <p class="section">Under equilibrium conditions traffic arranges itself in congested networks in such a way that no individual trip maker can reduce his path costs by switching routes. If all trip makers perceive costs in the same way (no stochastic effects): Under equilibrium conditions traffic arranges itself in congested networks such that all used routes between an O-D pair have equal and minimum costs while all unused routes have greater or equal cost.</p>
    <span class="title">Example</span>
          <table class="table table-bordered table-hover">
            <caption>Car ownership</caption>
                 <tr class="success">
                      <th>HH Size</th><th>0</th><th>1</th><th>2 or 2+</th>
                  </tr>
                  <tr>
                      <td>1</td><td>0.12</td><td>0.94</td><td></td>
                  </tr>
                    <tr>
                <td>2 or 3</td><td >0.60</td><td>1.38</td><td>2.16</td>
                </tr>
<tr>
<td>4</td><td>1.14</td><td>1.74</td><td>2.60</td>
</tr>
<tr>
<td>5</td><td>1.02</td><td>1.69</td><td>2.60</td>
</tr>

          </table>
          <span class="x">Gross classification no. of households is:</span>
          <table class="table table-bordered table-hover">
            <caption>Car ownership</caption>
                 <tr class="success">
                      <th>HH Size</th><th>0</th><th>1</th><th>2 or 2+</th>
                  </tr>
                  <tr>
                      <td>1</td><td>50</td><td>200</td><td></td>
                  </tr>
                    <tr>
                <td>2 or 3</td><td >30</td><td>150</td><td>450</td>
                </tr>
<tr>
<td>4</td><td>20</td><td>100</td><td>600</td>
</tr>
<tr>
<td>5</td><td>5</td><td>50</td><td>300</td>
</tr>

          </table>
          <span class="x">Total number of trips produced in the zone with household size 4andcar ownership 1 is T = 1.74*100 = 174 trips</span>
  </div>
<?php
  include_once("footer.php");
  getFooter(2);
?> 