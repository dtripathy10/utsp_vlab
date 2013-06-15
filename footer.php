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
      <a  href="#" class="scrollup"></a>
  <div class="footer">
    <hr/>
    <div>
      <div style="float:left">
   <ul>
      <li><a href="https://www.facebook.com/utspvlab" target="_blank">Facebook</a><span class="vline"/></li>
      <li><a href="https://plus.google.com/100878576331692025483/about" target="_blank">Google+</a></li> 
    </ul>
  </div>
   <div style="float:right">
    <ul>
            <li ><a href="index.php">Home</a><span class="vline"/></li>   
                  <li><a href="experiments.php">Experiment List</a><span class="vline"/></li> 
                        <li><a href="people.php">People</a><span class="vline"/></li>
                               <li><a href="contact.php">Contact Us</a><span class="vline"/></li>
      <li><a href="login.php">Login</a><span class="vline"/></li>
      <li><a href="signup.php">Sign Up</a></li>



  
    </ul>
    </div>
  </div>
</div>
	<?php
include_once("util/system.php");
getgoogleanalytics();
?>
</body>
</html>
<?php
}
?>