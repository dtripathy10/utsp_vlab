
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<?php
  include_once("header.php");
  getHeader(5,"Mode Split");
?> 
 
	<div id="body">
    <h1 class="designation">FAQs</h1>
    <ul class="questions">
      <li>What is a Mode Choice Model?<span class="answers">Mode choice models model the travelers' choice of which mode of transport to take, eg car, public transport or whatever. They take as input variables about each possible mode of transport that the traveler has available for the trip and gives the proportion of travelers which would use each mode of transport. (eg 70% by car and 30% by public transport).</span></li>
      <li>What Input data should be considered?<span class="answers">The modeller must decide which variables are relevant to the decision making process but the most common variables for urban and interurban travel are: in-vehicle time, walk time, wait time, cost and how many interchanges are involved. This data can be 'skimmed' from the highway and public transport networks for each origin-destination pair to form matrices which are called skims because they are obtained from the paths by skimming along the paths accumulating the data. The networks can therefore be skimmed for in-vehicle time, walk time, fare, etc and each skim put into the mode choice model. In this case the mode choice model will split an input trip matrix into a trip matrix which uses each mode of transport, e.g. car and public transport.</span></li>
      <li> What is Utility/Disutility Function in mode choice?<span class="answers">A mathematical function that expresses the advantages/disadvantages of a particular transportation mode.</span></li>
    </ul>
  </div>
 <?php
  include_once("footer.php");
  getFooter(5);
?>  