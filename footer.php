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
    <em>Last updated in <span class="muted"><?php echo date('jS \of F Y h:i:s A');?></span></em>
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
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-XXXXX-Y']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>  </body>
</html>
<?php
}
?>