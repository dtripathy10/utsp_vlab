<?php
define("DB_HOST", "localhost"); // The host you want to connect to.
define("DB_USER", "root"); // The database username.
define("DB_PASS", "123456"); // The database password. 
define("DB_NAME", "db2"); // The database name.
define("USER_ROOT","../user"); //Root folder
define("DOC_FOLDER","../Docs"); //folder containing sample files 
define("EXCELREADER","../phpExcelReader"); //folder containing excel reader API

function getConnection() {
	$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Connecting to MySQL failed");
	return $conn;
}
function selectDatabase() {
	$conn = getConnection();
	mysql_select_db(DB_NAME, $conn) or die("Selecting MySQL database failed");
}
function getgoogleanalytics() {
?>
<script type="text/javascript">

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41670407-1', 'iitb.ac.in');
  ga('send', 'pageview');

</script>



<?php
}
?>