<!DOCTYPE html>
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
 <!-- =============================================== -->
	<div id="body">
    <h1 class="designation">Theory</h1>
    <span class="title">About the experiment</span>
    <p class="section">A travel time study determines the average time required and also the amount of delay caused on a given route. Delay is the extra time spent by drivers against their expectation. Data obtained from travel time and delay studies give a good indication of the level of service on the study section. These data aids the traffic engineer in identifying locations like presence of intersections, which may require special attention in order to improve the overall flow of traffic on the route.</p>



    <p >There can be different forms of delay depending on location:
        <ul class="test1">
          <li><span class="hmm">Stoped time delay</span> It is the delay during which the vehicles is at rest</li>
           <li><span class="hmm"> Approach delay</span> It is due to deceleration to and acceleration from a stop to stopped time delay.</li>
            <li><span class="hmm">Time-in-queue delay</span> It is the time between a vehicle joining the end of the queue at a signalized or stop-controlled intersection and the tie it crosses the intersection (stop line).</li>
             <li><span class="hmm">Control delay (or fixed delay)</span>It is the delay caused by controlled device such as signals, includes both approach delay and time-in-queue delay.</li>
              <li><span class="hmm">Operational delay</span>It is the delay caused due to impedance of other traffic.</li>
        </ul>
    </p>


    <p >There are several methods to conduct travel time and delay studies, namely:
        <ul class="test">
          <li>Floating car technique (requires test vehicle)</li>
           <li>Average speed technique (requires test vehicle)</li>
            <li>Moving vehicle technique (requires test vehicle)</li>
             <li>License plate observations.</li>
              <li>Interview.</li>
               <li><strong>ITS</strong> advanced technologies</li>
        </ul>
    </p>
<p class="section">In this experiment we will be using the <strong>Licence-plate approach</strong> for calculating the travel time and delay is one of the most common methods.</p>


    <p class="title">License-plate approach </p>
    <p>The License-plate approach requires following set up and procedure to be followed :
        <ul class="test">
          <li>The License-plate method requires the observers to be positioned at the beginning and end of the test section.</li>
           <li>Each observer records the last three or four digits of the license plate of each car that passes, together with the time at which the car passes.</li>
            <li>The reduction of the data is accomplished in the office by matching the times of arrival at the beginning and end of the test section for each license plate recorded.</li>
             <li>The difference between these times is the travelling time of each vehicle.</li>
              <li>The delay is calculated by deducting free flow travel time from the observed travel time (usually taken as the minimum travel time recorded)</li>
               <li>Thus average travelling time and average delay time on the test section is calculated by dividing the respective times by number of matched license plates.</li>
               <li>It has been suggested that a sample size of 50 matched license plates will give reasonable accurate results.</li>
        </ul>
    </p>
    <span> Thus,<ul class="conclusion">
        <li><strong>Travel time</strong> = Time recorded at the end of section<strong> - </strong>Time recorded at the begining of the section</li>
        <li><strong>Average travel time</strong> = (Sum of all travel time)<strong>/</strong>(Number of matched license plates)</li>
        <li><strong>Delay time</strong> = Observed travel time <strong>- </strong>Free flow travel time</li>
        <li><strong>Average delay time</strong> = (Sum of all delay time)<strong>/</strong>(Number of matched license plates)</li>
      </ul></span>


  </div>
	<!-- =============================================== -->
 <?php
  include_once("footer.php");
  getFooter(2);
?>   