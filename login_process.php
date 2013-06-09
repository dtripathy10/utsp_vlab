<?php

include_once("util/system.php");
selectDatabase();
if (isset($_POST['username'], $_POST['password'])) {
   //the page comming from login page and do the normal logic
   $userName = mysql_real_escape_string($_POST['username']); //User Name sent from Form
   $password = mysql_real_escape_string($_POST['password']); // Password sent from Form
   //*********retrieving data from Database**********
   $query = "select * from usermaster where UserName='$userName' and Password='$password'";
   $res = mysql_query($query);
   $rows = mysql_num_rows($res);
   //**********if $userName and $password will match database, The above function will return 1 row
   if ($rows == 1) {
      //***if the userName and password matches then register a session and redrect user to the Successfull.php
      session_start();
      $myrow1 = mysql_fetch_array($res);
      $_SESSION['uid'] = $myrow1["SrNo"];
      $_SESSION['user'] = $myrow1["UserName"];
      $_SESSION['fname'] = $myrow1["FName"];
      $_SESSION['mname'] = $myrow1["MName"];
      $_SESSION['lname'] = $myrow1["LName"];
      $_SESSION['EmlId'] = $myrow1["EmailId"];
      $space = '    ';
      $mname = '   ';
      if (!empty($myrow1["MName"])) {
         $mname = $myrow1["MName"];
      }
      $_SESSION['username'] = $myrow1["FName"] . $space . $mname . $space . $myrow1["LName"];
      if (!is_dir("user/" . $_SESSION['user'])) {
         mkdir("user/" . $_SESSION['user'], 0777);
      }
      header('Location: login/index.php');
   } else {
      $redirect = "The username or password you entered is incorrect.";
      include 'login.php';
   }
} else {
   //first time user enter to login page
   $redirect = "";
   include 'login.php';
}
?>
