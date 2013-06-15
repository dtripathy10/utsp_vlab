<!--
    Author:		Debabrata Tripathy, IIT Bombay, Mumbai
    Mail ID:	dtriapthy10@gmail.com
    Website:	http://home.iitb.ac.in/~debabratatripathy/
    Phone No:	9004499484
-->	
<?php
include_once("header.php");
getHeader(2, "Experiments | UTSP VLab");
?>

<div id="body">
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




   <h1 class="designation">List of Experiments</h1>
   <ul class="experiments">
      <li class="t1"><span>
            <a data-toggle="modal" href="#example">Volume, Speed and Delay Study at Intersection</a>
         </span></li>
      <span class="hh"><span>Trip Generation:</span><a href="tripgeneration.php">Overview</a></span>  
      <li ><span><span>Trip Generation:</span><a data-toggle="modal" href="#example">Regression Analysis</a></span></li>
      <li class="t1"><span><span>Trip Generation:</span><a data-toggle="modal" href="#example">Category Analysis</a></span></li>

	  <span class="hh"><span>Trip Distribution:</span><a href="tripdistribution.php">Overview</a></span>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Growth Factor Distribution Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Singly constrained Gravity Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Doubly constrained Gravity Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Calibration of Singly Constrained Gravity Model</a></span></li>
      <li class="t1"><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Calibration of Doubly Constrained Gravity Model</a></span></li>
      <li class="t1"><span><a data-toggle="modal" href="#example">Mode Split</a></span></li>
      
      <span class="hh"><span>Trip Assignment:</span><a href="tripassignment.php">Overview</a></span>
      <li><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">All or Nothing (AON) Assignment</a></span></li>
      <li><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">User Equilibrium Assignment</a></span></li>
      <li class="t1"><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">System Optimal Assignment</a></span></li>
      
   </ul>
</div>
<?php
include_once("footer.php");
getFooter(2);
?>