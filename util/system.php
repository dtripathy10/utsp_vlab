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
?>