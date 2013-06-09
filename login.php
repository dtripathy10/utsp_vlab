<!--
    Author:		Debabrata Tripathy, IIT Bombay, Mumbai
    Mail ID:	dtriapthy10@gmail.com
    Website:	http://home.iitb.ac.in/~debabratatripathy/
    Phone No:	9004499484
-->	
<?php
include_once("header.php");
getHeader(5, "Sign In | UTSP VLab");
?>
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
               <label class="control-label" for="inputEmail"><span class="error">

                     <?php 
                     if(isset($redirect)) {
                        echo $redirect; 
                     }
                     ?></span></label>
            </div>


            <button class="button" type="submit">Sign in</button>
            <a style="margin-left:10px;font-size:14px;"href="password_reset.php">forgot password?</a>
         </form></div>
      <div class="right1 span4"><span style="display:block;"><strong>No Account Yet?</strong></span>
         <a href="signup.php">Sign up</a>  today.</div></div>

</div>
<?php
include_once("footer.php");
getFooter(5);
?>