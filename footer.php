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
function getFooter($id) {
?>
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
<?php
}
?>