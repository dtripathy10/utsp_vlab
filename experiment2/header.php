<?php
/*
	Author:		Debabrata Tripathy
	Mail ID: 	dtriapthy10@gmail.com
	Website: 	http://home.iitb.ac.in/~debabratatripathy/
	Phone No: 	9004499484
*/

/*
	1	-	 aim
	2	-	 theory
	3	-	 procedure
	4 -  experiment
	5 -  faq
	6	-	 selfevaluation

*/

function getHeader($id) {
?>
			<!DOCTYPE html>
			<html>
  				<head>
    				<!-- le title -->
  					<title>Trip Generation | UTSP VLab</title>
    				<link rel="icon" href="../images/iitb.ico" type="image/x-icon" />
    				<!-- le CSS -->
        			<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    				<link href="../css/main.css" rel="stylesheet" type="text/css" />
					<!-- le java script -->
  					<script type="text/javascript" src="../scripts/jquery-1.8.3.js"></script>
  					<script type="text/javascript" src="../scripts/responsive.js"></script>
   					<!-- Bootstrap jQuery plugins compiled and minified -->
    				<script src="../bootstrap/js/bootstrap.min.js"></script>
				</head>
	<?php
	switch($id) {
		case 1:
			?>
			 <body>
        <div id="top_container">
          <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
          <h1 class="title_header"><a href="aim.php">Regression Analysis</a><span class="caption">Trip Generation</span></h1>
        </div>
         <div id="navbar">
  				<div class="row">
        			<div class="span8">
          				<ul id="menu-bar">
              				<li class="active"><a href="aim.php">Aim</a></li>
      						<li ><a href="theory.php">Theory</a></li>
        					<li><a href="procedure.php">Procedure</a></li>
        					<li><a href="experiment.php">Experiment</a></li>
        					<li><a href="faq.php">Faq</a></li>
        					<li><a href="selfevaluation.php">Self Evaluation</a></li>
          				</ul>
      				</div>
        			<div class="span4 pull-right">
      					<ul id="menu-bar1">
              				<li ><a href="../login/index.php">Home</a></li>
              				<li><a href="../login/experiments.php">Experiments</a></li>
              				<li ><a href="../login/logout.php">Logout</a></li>
          				</ul>
        			</div>

     			</div>
 			</div>
			<?php
			break;
		case 2:
			?>
      <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
   MathJax.Hub.Config({ TeX: { equationNumbers: {autoNumber: "all"} } });
  </script>
  <script type="text/javascript" src="../mathjax-MathJax-24a378e/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <link href="css/theory.css" rel="stylesheet" type="text/css" />
			 <body>
  				 <div id="top_container">
          <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
          <h1 class="title_header"><a href="aim.php">Regression Analysis</a><span class="caption">Trip Generation</span></h1>
        </div>
         <div id="navbar">
  				<div class="row">
        			<div class="span8">
          				<ul id="menu-bar">
              				<li><a href="aim.php">Aim</a></li>
      						<li  class="active"><a href="theory.php">Theory</a></li>
        					<li><a href="procedure.php">Procedure</a></li>
        					<li><a href="experiment.php">Experiment</a></li>
        					<li><a href="faq.php">Faq</a></li>
        					<li><a href="selfevaluation.php">Self Evaluation</a></li>
          				</ul>
      				</div>
        			<div class="span4 pull-right">
      					<ul id="menu-bar1">
              				<li ><a href="../login/index.php">Home</a></li>
              				<li><a href="../login/experiments.php">Experiments</a></li>
              				<li ><a href="../login/logout.php">Logout</a></li>
          				</ul>
        			</div>

     			</div>
 			</div>
			<?php
			break;
		case 3:
			?>

			 <body>
  				 <div id="top_container">
          <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
          <h1 class="title_header"><a href="aim.php">Regression Analysis</a><span class="caption">Trip Generation</span></h1>
        </div>
         <div id="navbar">
  				<div class="row">
        			<div class="span8">
          				<ul id="menu-bar">
              				<li><a href="aim.php">Aim</a></li>
      						<li ><a href="theory.php">Theory</a></li>
        					<li class="active"><a href="procedure.php">Procedure</a></li>
        					<li><a href="experiment.php">Experiment</a></li>
        					<li><a href="faq.php">Faq</a></li>
        					<li><a href="selfevaluation.php">Self Evaluation</a></li>
          				</ul>
      				</div>
        			<div class="span4 pull-right">
      					<ul id="menu-bar1">
              				<li ><a href="../login/index.php">Home</a></li>
              				<li><a href="../login/experiments.php">Experiments</a></li>
              				<li ><a href="../login/logout.php">Logout</a></li>
          				</ul>
        			</div>

     			</div>
 			</div>
			<?php
			break;
		case 4:
			?>
			 <body>
  				 <div id="top_container">
          <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
          <h1 class="title_header"><a href="aim.php">Regression Analysis</a><span class="caption">Trip Generation</span></h1>
        </div>
         <div id="navbar">
  				<div class="row">
        			<div class="span8">
          				<ul id="menu-bar">
              				<li><a href="aim.php">Aim</a></li>
      						<li ><a href="theory.php">Theory</a></li>
        					<li><a href="procedure.php">Procedure</a></li>
        					<li class="active"><a href="experiment.php">Experiment</a></li>
        					<li><a href="faq.php">Faq</a></li>
        					<li><a href="selfevaluation.php">Self Evaluation</a></li>
          				</ul>
      				</div>
        			<div class="span4 pull-right">
      					<ul id="menu-bar1">
              				<li ><a href="../login/index.php">Home</a></li>
              				<li><a href="../login/experiments.php">Experiments</a></li>
              				<li ><a href="../login/logout.php">Logout</a></li>
          				</ul>
        			</div>

     			</div>
 			</div>
			<?php
			break;
		case 5:
			?>
			 <body>
  				 <div id="top_container">
          <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
          <h1 class="title_header"><a href="aim.php">Regression Analysis</a><span class="caption">Trip Generation</span></h1>
        </div>
         <div id="navbar">
  				<div class="row">
        			<div class="span8">
          				<ul id="menu-bar">
              				<li><a href="aim.php">Aim</a></li>
      						<li ><a href="theory.php">Theory</a></li>
        					<li><a href="procedure.php">Procedure</a></li>
        					<li><a href="experiment.php">Experiment</a></li>
        					<li class="active"><a href="faq.php">Faq</a></li>
        					<li><a href="selfevaluation.php">Self Evaluation</a></li>
          				</ul>
      				</div>
        			<div class="span4 pull-right">
      					<ul id="menu-bar1">
              				<li ><a href="../login/index.php">Home</a></li>
              				<li><a href="../login/experiments.php">Experiments</a></li>
              				<li ><a href="../login/logout.php">Logout</a></li>
          				</ul>
        			</div>

     			</div>
 			</div>
			<?php
			break;
			case 6:
			?>
			 <body>
  				 <div id="top_container">
          <div id="header">
           <a href="http://www.iitb.ac.in/"><img class="logo" src="../images/iitb.png"/></a>
          <h1 class="title_header"><a href="aim.php">Regression Analysis</a><span class="caption">Trip Generation</span></h1>
        </div>
         <div id="navbar">
  				<div class="row">
        			<div class="span8">
          				<ul id="menu-bar">
              				<li><a href="aim.php">Aim</a></li>
      						<li ><a href="theory.php">Theory</a></li>
        					<li><a href="procedure.php">Procedure</a></li>
        					<li><a href="experiment.php">Experiment</a></li>
        					<li><a href="faq.php">Faq</a></li>
        					<li class="active"><a href="selfevaluation.php">Self Evaluation</a></li>
          				</ul>
      				</div>
        			<div class="span4 pull-right">
      					<ul id="menu-bar1">
              				<li ><a href="../login/index.php">Home</a></li>
              				<li><a href="../login/experiments.php">Experiments</a></li>
              				<li ><a href="../login/logout.php">Logout</a></li>
          				</ul>
        			</div>

     			</div>
 			</div>
			<?php
			break;
	}

}
?>