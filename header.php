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

function printNavbar() {
    ?>
    <body>
        <div id="top_container">
            <div id="header">
                <a href="http://www.iitb.ac.in/"><img class="logo" src="images/iitb.png"/></a>
            </div>


            <div id="navbar"> 
            <?php
            }

            function getHeader($id, $title) {
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
                                    $(document).ready(function() {
                                    $('.carousel').carousel({
                                    interval: 4000
                                    });
                                    });
                                </script>
                            </head>
            <?php printNavbar(); ?>
                            <div class="row">
                                <div class="span6">
                                    <ul id="menu-bar">
                                        <li class="active"><a href="index.php">Home</a></li>
                                        <li><a href="experiments.php">Experiment List</a></li>
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
                    ?>
            <?php printNavbar(); ?>
                </head>

                <div class="row">
                    <div class="span6">
                        <ul id="menu-bar">
                            <li><a href="index.php">Home</a></li>
                            <li  class="active"><a href="experiments.php">Experiment List</a></li>
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
        case 3:
            ?>
            <?php printNavbar(); ?>
            </head>

            <div class="row">
                <div class="span6">
                    <ul id="menu-bar">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="experiments.php">Experiment List</a></li>
                        <li  class="active"><a href="people.php">People</a></li>
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
        case 4:
            ?>
            <?php printNavbar(); ?>
            <link href="css/map.css" rel="stylesheet" type="text/css" /> 
            <!-- Bootstrap jQuery plugins compiled and minified -->
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
            <script type="text/javascript" src="scripts/map.js"></script>   
            </head>

            <div class="row">
                <div class="span6">
                    <ul id="menu-bar">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="experiments.php">Experiment List</a></li>
                        <li><a href="people.php">People</a></li>
                        <li class="active"><a href="contact.php">Contact Us</a></li>
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
        case 5:
            ?>
            <?php printNavbar(); ?>
            </head>

            <div class="row">
                <div class="span6">
                    <ul id="menu-bar">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="experiments.php">Experiment List</a></li>
                        <li><a href="people.php">People</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="span5 pull-right">
                    <ul id="menu-bar1">      
                        <li  class="active"><a href="login.php">Login</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    </ul>
                </div>

            </div>


            </div>

            <?php
            break;
        case 6:
            ?>
            <?php printNavbar(); ?>
            </head>

            <div class="row">
                <div class="span6">
                    <ul id="menu-bar">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="experiments.php">Experiment List</a></li>
                        <li><a href="people.php">People</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="span5 pull-right">
                    <ul id="menu-bar1">      
                        <li ><a href="login.php">Login</a></li>
                        <li class="active"><a href="signup.php">Sign Up</a></li>
                    </ul>
                </div>

            </div>


            </div>

            <?php
            break;
        case 7:
            ?>
            <?php printNavbar(); ?>
            </head>

            <div class="row">
                <div class="span6">
                    <ul id="menu-bar">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="experiments.php">Experiment List</a></li>
                        <li><a href="people.php">People</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="span5 pull-right">
                    <ul id="menu-bar1">      
                        <li  class="active"><a href="login.php">Login</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    </ul>
                </div>

            </div>


            </div>

            <?php
            break;
    }
}
?>
