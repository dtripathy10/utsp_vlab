<?php 
  if(!isset($redirect)) {
      $redirect ="";
  }
?>


<!DOCTYPE html>
<!--
	Author:		Debabrata Tripathy, IIT Bombay, Mumbai
	Mail ID:	dtriapthy10@gmail.com
	Website:	http://home.iitb.ac.in/~debabratatripathy/
	Phone No:	9004499484
-->	
<html>
  <head>
    <!-- le title -->
  	<title>Sign In | UTSP VLab</title>
    <link rel="icon" href="images/iitb.ico" type="image/x-icon" />
    <!-- le CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <style>
      .error {
        font-size: 12px;
        color: #DC143C;
        font-weight: bold;
      }
    </style>

	<!-- le java script -->
  <script type="text/javascript" src="scripts/jquery-1.8.3.js"></script>
  <script type="text/javascript" src="scripts/responsive.js"></script>
   <!-- Bootstrap jQuery plugins compiled and minified -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body>
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
            <li><a href="experiments.php">Experiments</a></li>
            <li><a href="people.php">People</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">      
          <li class="active"><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
          </ul>
        </div>

     </div>
     
	</div>
 
	<div id="body">
    <h1 class="designation">Sign In</h1>
    <div class="row">
    <div class="left1 span4">
	<form class="form-signin" action="login_process.php" method="post">
        <div class="control-group">
                            <label class="control-label" for="inputEmail"><strong>Username</strong></label>
                            <div class="controls">
                                <input type="text" class="input-xlarge input-block-level" placeholder="username" name="username">
                            </div>
                      </div>
                      <div class="control-group">
                            <label class="control-label" for="inputEmail"><strong>Password</strong></label>
                            <div class="controls">
                                 <input type="password" class="input-xlarge input-block-level" placeholder="Password" name="password">
                            </div>
                            <label class="control-label" for="inputEmail"><span class="error"><?php echo $redirect;?></span></label>
                      </div>
        
       
        <button class="btn btn-success" type="submit">Sign in</button>
        <a style="margin-left:10px;font-size:14px;"href="password_reset.php">forgot password?</a>
      </form></div>
    <div class="right1 span4"><span style="display:block;"><strong>No Account Yet?</strong></span>
                        <a href="signup.php">Sign up</a>  today.</div></div>
                   
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