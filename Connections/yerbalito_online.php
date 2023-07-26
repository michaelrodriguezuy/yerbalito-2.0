<?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'wwwolima');
    define('DB_PASSWORD', 'rjW63u0I6n');
    define('DB_DATABASE', 'wwwolima_yerbalito');

    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    mysqli_set_charset($db, 'utf8');
    
    if (!$db) {
        die("Error conexión: " . mysqli_connect_error());
    }


?>