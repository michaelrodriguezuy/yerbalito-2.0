<?php

// $hostname_yerbalito = "localhost";
// $database_yerbalito = "wwwolima_yerbalito";
// $username_yerbalito = "wwwolima";
// $password_yerbalito = "rjW63u0I6n";

// $yerbalito = mysql_pconnect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or trigger_error(mysql_error(),E_USER_ERROR); 


$host="host.docker.internal";
	$user="root";
	$password="test";
	$db="wwwolima_yerbalito";

	$mysqli = new mysqli($host, $user, $password, $db);

    try {
        $mysqli->connect_error;
    } catch (\Throwable $th) {
        echo "connection failed";
    }

	//if($mysqli->connect_error) {echo "connection failed";};



?>