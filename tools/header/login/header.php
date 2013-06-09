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
  8 -  feeback
  9 -  report

*/

function getHeader($id,$title) {
  	?>
<html lang="en">
  <head>
    <meta charset="utf-8">
   <!-- le title -->
    <title><?php echo $title; ?></title>
    <link rel="icon" href="../images/iitb.ico" type="image/x-icon" />
    <!-- le CSS -->
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
   


  <!-- le java script -->
  <script type="text/javascript" src="../scripts/jquery-1.8.3.js"></script>
       <link href="../css/main.css" rel="stylesheet" type="text/css" />
  <?php
  if($id != 4) {

    ?>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
  <?php

  }

  ?>
   <!-- Bootstrap jQuery plugins compiled and minified -->

    <script type="text/javascript" src="../scripts/responsive.js"></script>


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
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
  <?php
      break;
       case 2:
      ?>

  </head>
  <body>
    <div id="top_container">
    <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
  
      <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li class="active"><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>
  </div>
  <?php
      break;
       case 3:
       ?>

       </head>
  <body>
    <!-- <div class="alert alert-block alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Virtual Lab on Urban Transportation Systems Planning (UTSP) is in β version. Please <a href="login.php">Login</a> and perform Experiments.
          </div> -->

    <div id="top_container">
     <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li  class="active"><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
       case 4:
        ?>
    <link href="../css/map.css" rel="stylesheet" type="text/css" /> 
     <!-- Bootstrap jQuery plugins compiled and minified -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript" src="../scripts/map.js"></script>
         </head>
  <body>
     <div id="top_container">
   <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li ><a href="people.php">People</a></li>
              <li class="active"><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
       case 5:
       ?>
 </head>
  <body>

    <div id="top_container">
     <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
       case 6:
       ?>
 </head>
  <body>
    <!-- <div class="alert alert-block alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Virtual Lab on Urban Transportation Systems Planning (UTSP) is in β version. Please <a href="login.php">Login</a> and perform Experiments.
          </div> -->

    <div id="top_container">
    <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li  class="active"><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
       case 7:
       ?>
 </head>
  <body>
    <!-- <div class="alert alert-block alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Virtual Lab on Urban Transportation Systems Planning (UTSP) is in β version. Please <a href="login.php">Login</a> and perform Experiments.
          </div> -->

    <div id="top_container">
     <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li  class="active"><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
       case 8:
       ?>
 </head>
  <body>
    <div id="top_container">
     <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li  class="active"><a href="feedback.php">Feedback</a></li>
              <li><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
       case 9:
       ?>
 </head>
  <body>
    <!-- <div class="alert alert-block alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Virtual Lab on Urban Transportation Systems Planning (UTSP) is in β version. Please <a href="login.php">Login</a> and perform Experiments.
          </div> -->

    <div id="top_container">
     <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
  </div>
 <div id="navbar">
    <div class="row">
        <div class="span6">
          <ul id="menu-bar">
              <li><a href="index.php">Home</a></li>
              <li><a href="experiments.php">Experiments</a></li>
              <li><a href="feedback.php">Feedback</a></li>
              <li   class="active"><a href="report.php">Report</a></li>
          </ul>
      </div>
        <div class="span5 pull-right">
      <ul id="menu-bar1">
              <li><a href="people.php">People</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li ><a href="logout.php">Logout</a></li>
          </ul>
        </div>

     </div>

  </div>
       <?php
      break;
    
  }
}
?>