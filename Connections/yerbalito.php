<?php

    define('DB_SERVER', 'host.docker.internal');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'test');
    define('DB_DATABASE', 'wwwolima_yerbalito');

    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    mysqli_set_charset($db, 'utf8');
    
    if (!$db) {
        die("Error conexión: " . mysqli_connect_error());
    }


?>


    