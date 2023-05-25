<?php 

define('DB_SERVER', 'host.docker.internal');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'test');
define('DB_DATABASE', 'wwwolima_yerbalito');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Check connection
if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}



/*
$host="host.docker.internal";
$user="root";
$password="test";
$db="wwwolima_yerbalito";
$mysqli = new mysqli($host, $user, $password, $db);
if($mysqli->connect_error) {echo "connection failed";}

$mysqli->close(); 
*/
?>