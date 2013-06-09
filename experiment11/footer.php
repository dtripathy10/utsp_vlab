<?php
/*
	Author:		Debabrata Tripathy
	Mail ID: 	dtriapthy10@gmail.com
	Website: 	http://home.iitb.ac.in/~debabratatripathy/
	Phone No: 	9004499484
*/

/*
	1	-	aim
	2	-	theory
	3	-	procedure
	4 	-   experiment
	5   -   faq
	6	-	selfevaluation

*/

function getFooter($id) {
?>
 <a  href="#" class="scrollup"></a>
<div class="footer">
    <hr/>
    <em>Last updated in <span class="muted"><?php echo date('jS \of F Y h:i:s A');?></span></em>
    <ul>
       <li><a href="../login/contact.php">Contact Us</a></li>
      <li><a href="../login/people.php">People</a><span class="vline"/></li>
      <li><a href="../login/experiments.php">Experiments</a><span class="vline"/></li>
      <li ><a href="../login/index.php">Home</a><span class="vline"/></li>      
    </ul>
  </div>
</div>
  </body>
</html>
	
<?php
}
?>