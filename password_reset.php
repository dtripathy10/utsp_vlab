<!--
    Author:		Debabrata Tripathy, IIT Bombay, Mumbai
    Mail ID:	dtriapthy10@gmail.com
    Website:	http://home.iitb.ac.in/~debabratatripathy/
    Phone No:	9004499484
-->	
<?php
include_once("header.php");
getHeader(7, "Password Reset | UTSP VLab");
?>
 
	<div id="body">
    <h1 class="designation">Password Reset</h1>
    <div class="row">
    <div class="left1 span4"><form class="form-signin">
        <div class="control-group">
                            <label class="control-label" for="inputEmail"><strong>Username</strong></label>
                            <div class="controls">
                                <input type="text" class="input-xlarge input-block-level" placeholder="Email address">
                            </div>
                      </div>
                      <div class="control-group">
                            <label class="control-label" for="inputEmail"><strong>Email</strong></label>
                            <div class="controls">
                                 <input type="password" class="input-xlarge input-block-level" placeholder="Password">
                            </div>
                      </div>
        
        <button class="button" type="submit">Reset</button>
      </form></div>
    <div class="right1 span4"><span style="display:block;"><strong>No Account Yet?</strong></span>
                        <a href="signup.php">Sign up</a>  today.</div></div>
                   
  </div>
<?php
include_once("footer.php");
getFooter(7);
?>