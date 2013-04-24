
<!--
  Author:   Debabrata Tripathy, IIT Bombay, Mumbai
  Mail ID:  dtriapthy10@gmail.com
  Website:  http://home.iitb.ac.in/~debabratatripathy/
  Phone No: 9004499484
--> 
<?php
  include_once("header.php");
  getHeader(5);
?> 
  <div id="body">
    <h1 class="designation">FAQs</h1>
    <ul class="questions">
      <li>
        What is SSE?<span class="answers">
        SSE stands for the sum of squares due to error (SSE). This statistic measures the total deviation 
        of the response values from the fit to the response values. It is also called the summed square 
        of residuals and is usually labelled as SSE. A value closer to 0 indicates that the model has a 
        smaller random error component, and that the fit will be more useful for prediction.
        </span>
      </li>
      <li>
       What is the criterion for β convergence?<span class="answers">At convergence the β value satisfies the equality between the
      estimated trip distribution matrix and the observed trip distribution matrix.
    </span>
    </li>
   </ul>
  </div>
  <?php
  include_once("footer.php");
  getFooter(5);
?>  