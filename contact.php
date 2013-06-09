<!--
    Author:		Debabrata Tripathy, IIT Bombay, Mumbai
    Mail ID:	dtriapthy10@gmail.com
    Website:	http://home.iitb.ac.in/~debabratatripathy/
    Phone No:	9004499484
-->	
<?php
include_once("header.php");
getHeader(4, "Contact Us | UTSP VLab");
?>

<div id="contact">
   <div class="zoom">
      <a class="zoom_plus" href="#"></a>
      <a class="zoom_minus" href="#"></a>   
   </div><!-- zoom -->
   <div class="inner">
      <div class="img">
         <div id="map_canvas"></div>        
      </div>
      <div>
         <!-- <h2>Transportation Systems Engineering Lab<br/> IIT Bomaby<br/> Powai, Mumbai, India</h2> -->
      </div>
   </div><!-- inner -->

</div>
<div id="body">
   <br/>
   <div class="note1 pull-right">*If you have any questions or comments, please don’t hesitate to contact us in whatever way is most convenient for you</div><div style="clear: both;"></div>
   <h1 class="addr">Address</h1>
   <p class="information1"><a href="http://www.civil.iitb.ac.in/~tse/">Transportation Systems Engineering</a><br/>
      <a href="http://www.civil.iitb.ac.in/">Dept. of Civil Engineering</a><br/>
      <a href="http://www.iitb.ac.in/">Indian Institute of Technology, Bombay</a><br/>
      Powai, Mumbai 400076, India <br/>
      Mail:<a href="mailto:gpatil@iitb.ac.in"> gpatil@iitb.ac.in</a> </p>
   <div style="clear: both;"></div>
   <br/>
   <div class="row">
      <div class="span2">
         <h1 >Contact Us</h1>
      </div>
      <div class="span8 pull-left">
         <form >
            <div class="control-group">
               <label class="control-label" for="inputEmail">Name<span class="text-error">*</span></label>
               <div class="controls">
                  <input class="input-xlarge" style="height: 30px;" type="text" placeholder="Name">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label" for="inputEmail">Email<span class="text-error">*</span></label>
               <div class="controls">
                  <input class="input-xlarge" style="height: 30px;" type="text" placeholder="Email*">
               </div>
            </div>

            <div class="control-group">
               <label class="control-label" for="inputEmail">Title<span class="text-error">*</span></label>
               <div class="controls">
                  <input class="input-xlarge span6" style="height: 30px;" type="text" placeholder="Title*">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label" for="inputEmail">Messages<span class="text-error">*</span></label>
               <div class="controls">
                  <textarea ows="6"></textarea>
               </div>
            </div>
            <div class="control-group">
                <button class="pull-right" type="button" style="margin-right:40px;">Send</button>
               <span class="pull-left text-error">* required fields</span>

            </div>
         </form>      

      </div>
   </div>

</div>
<?php
include_once("footer.php");
getFooter(4);
?>



