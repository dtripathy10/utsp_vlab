<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!-- le title -->
  	<title>Experiments | UTSP VLab</title>
    <link rel="icon" href="images/iitb.ico" type="image/x-icon" />
    <!-- le CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css" />
      <style>
p.body {
  text-indent: 0px;
        margin-bottom: 0px;
        margin-top: 0px;
      }
</style>
	<!-- le java script -->
  <script type="text/javascript" src="scripts/jquery-1.8.3.js"></script>
  <script type="text/javascript" src="scripts/responsive.js"></script>
   <!-- Bootstrap jQuery plugins compiled and minified -->
    <script src="bootstrap/js/bootstrap.js"></script>
  </head>
  <body>
    <!--  <div class="alert alert-block alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Virtual Lab on Urban Transportation Systems Planning (UTSP) is in β version. Please <a href="login.php">Login</a> and perform Experiments.
          </div> -->
          
  	<div id="top_container">
  	<div id="header">
          <a href="http://www.iitb.ac.in/"><img class="logo" src="images/iitb.png"/></a>
          <a href="http://mhrd.gov.in/"><img class="logo" src="images/logo.png"/></a>
          <a href="http://www.vlab.co.in/"><img class="logo" src="images/vlab.png"/></a>
          <a href="index.php"><img class="logo" src="images/utsp.png"/></a>
      <div  class="brand">
      <h1><a href="index.php">Urban Transportation Systems Planning Lab</a><span class="caption">IIT Bombay</span></h1>
    </div>
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
            <li ><a href="index.php">Home</a></li>
            <li class="active"><a href="experiments.php">Experiments</a></li>
            <li><a href="people.php">People</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">      
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
          </ul>
        </div>

     </div>
     
	</div>
 
	<div id="body">
	<div id="example" class="modal hide fade in" style="display: none; ">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3>You have not logged in!!!</h3>
            </div>
            <div class="modal-body">
              <p class="body">please login to perform the experiment.</p>            
            </div>
            <div class="modal-footer">
              <a href="login.php" class="btn btn-success">Login</a>
              <a href="#" class="btn btn-success" data-dismiss="modal">Close</a>
            </div>
          </div>

	
	
	
    <h1 class="designation">List of Experiments</h1>
    <ul class="experiments">
      <li class="t1"><span>
      <a data-toggle="modal" href="#example">Volume, Speed and Delay Study at Intersection</a>
      </span></li>
      <li ><span><span>Trip Generation:</span><a data-toggle="modal" href="#example">Regression Analysis</a></span></li>
      <li class="t1"><span><span>Trip Generation:</span><a data-toggle="modal" href="#example">Category Analysis</a></span></li>


      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Growth Factor Distribution Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Singly constrained Gravity Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Doubly constrained Gravity Model</a></span></li>
      <li><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Calibration of Singly Constrained Gravity Model</a></span></li>
      <li class="t1"><span><span>Trip Distribution:</span><a data-toggle="modal" href="#example">Calibration of Doubly Constrained Gravity Model</a></span></li>
      <li class="t1"><span><a data-toggle="modal" href="#example">Mode Split</a></span></li>
      <li><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">All or Nothing (AON) Assignment</a></span></li>
      <li><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">User Equilibrium Assignment</a></span></li>
      <li><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">System Optimal Assignment</a></span></li>
      <li class="t1"><span><span>Trip Assignment:</span><a data-toggle="modal" href="#example">Stochastic User Equilibrium</a></span></li>
    </ul>
  </div>
	
  <div class="footer">
    <hr/>
     <em class="text-error">Last updated in 05/2013.</em>
    <ul>
      <li><a href="signup.php">Sign Up</a></li>
        <li><a href="login.php">Login</a><span class="vline"/></li>
       <li><a href="contact.php">Contact Us</a><span class="vline"/></li>
      <li><a href="people.php">People</a><span class="vline"/></li>
      <li><a href="experiments.php">Experiments</a><span class="vline"/></li>
      <li ><a href="index.php">Home</a><span class="vline"/></li>      
    </ul>
  </div>
</div>
  </body>
</html>