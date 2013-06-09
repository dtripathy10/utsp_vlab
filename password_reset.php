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
 <script language="javascript">
function chk1()
{
	
	if (document.reset.inputcredential.value == "")
	{
		alert("Please insert your email or username!!!");
		document.reset.inputcredential.focus();
		return false ;
	}
	document.reset.action="password_resetmail.php";
}
</script>
	<div id="body">
    <h1 class="designation">Password Reset</h1>
    <div class="row">
    <div class="left1 span4">
    <form class="form-signin" method="post" name="reset">
        <div class="control-group">
                            <label class="control-label" for="inputUserName"><strong>Username or Email</strong></label>
                            <div class="controls">
                                <input type="text" class="input-xlarge input-block-level" placeholder="Email address" name="inputcredential">
                            </div>
                      </div>
        
        <button class="button" type="submit" OnClick="return chk1()">Send</button>
      </form></div>
    <div class="right1 span4"><span style="display:block;"><strong>No Account Yet?</strong></span>
                        <a href="signup.php">Sign up</a>  today.</div></div>
                   
  </div>
<?php
include_once("footer.php");
getFooter(7);
?>