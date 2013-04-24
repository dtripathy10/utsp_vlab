<?php
/*
	Author:		Debabrata Tripathy
	Mail ID: 	dtriapthy10@gmail.com
	Website: 	http://home.iitb.ac.in/~debabratatripathy/
	Phone No: 	9004499484
*/

/*
	1	-	 index
	2	-	 experiments
	3	-	 people
	4 -  contact
	5 -  login
	6	-	 signin
  7 -  password_reset

*/

function getHeader($id,$title) {
  	?>
<html lang="en">
  <head>
    <meta charset="utf-8">
     <!-- le title -->
    <title><?php echo $title; ?></title>
    <link rel="icon" href="images/iitb.ico" type="image/x-icon" />
    <!-- le CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <!-- le java script -->
    <script type="text/javascript" src="scripts/jquery-1.8.3.js"></script>
    <!-- Bootstrap jQuery plugins compiled and minified -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/responsive.js"></script>


<?php
  switch ($id) {
    case 1:
     ?>

         <script>
      $(document).ready(function(){
        $('.carousel').carousel({
          interval: 4000
        });
      });
    </script>
  </head>
  <body>
    <!-- <div class="alert alert-block alert-success">
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
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="experiments.php">Experiments</a></li>
            <li><a href="people.php">People</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">      
          <li ><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
          </ul>
        </div>

     </div>


  </div>

  <?php
      break;
       case 2:
      # code...
      break;
       case 3:
      # code...
      break;
       case 4:
      # code...
      break;
       case 5:
      # code...
      break;
       case 6:
      # code...
      break;
       case 7:
      # code...
      break;
    
  }
}
?>