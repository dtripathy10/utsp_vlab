
 <?php
  include_once("header.php");
  getHeader(2,"Experiments | UTSP VLab");
?>
	<div id="body">
    <h1 class="designation">List of Experiments</h1>
    <ul class="experiments">
      <li class="t1"><span><a href="../experiment1/aim.php">Volume, Speed and Delay Study at Intersection</a></span></li>

	  <span class="hh"><span>Trip Generation:</span><a href="tripgeneration.php">Overview</a></span>
      <li ><span><span>Trip Generation:</span><a href="../experiment2/aim.php">Regression Analysis</a></span></li>
      <li class="t1"><span><span>Trip Generation:</span><a href="../experiment3/aim.php">Category Analysis</a></span></li>

	  <span class="hh"><span>Trip Distribution:</span><a href="tripdistribution.php">Overview</a></span>
      <li><span><span>Trip Distribution:</span><a href="../experiment4/aim.php">Growth Factor Distribution Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a href="../experiment5/aim.php">Singly constrained Gravity Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a href="../experiment6/aim.php">Doubly constrained Gravity Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a href="../experiment7/aim.php">Calibration of Singly Constrained Gravity Model</a></span></li>
      <li class="t1"><span><span>Trip Distribution:</span><a href="../experiment8/aim.php">Calibration of Doubly Constrained Gravity Model</a></span></li>
      <li class="t1"><span><a href="../experiment9/aim.php">Mode Split</a></span></li>
      <span class="hh"><span>Trip Assignment:</span><a href="tripassignment.php">Overview</a></span>
      <li><span><span>Trip Assignment:</span><a href="../experiment10/aim.php">All or Nothing (AON) Assignment</a></span></li>
      <li><span><span>Trip Assignment:</span><a href="../experiment11/aim.php">User Equilibrium Assignment</a></span></li>
      <li class="t1"><span><span>Trip Assignment:</span><a href="../experiment12/aim.php">System Optimal Assignment</a></span></li>
    </ul>
  </div>
<?php
  include_once("footer.php");
  getFooter(2);
?>