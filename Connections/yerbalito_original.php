<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_yerbalito = "localhost";
$database_yerbalito = "wwwolima_yerbalito";
$username_yerbalito = "wwwolima";
$password_yerbalito = "rjW63u0I6n";
$yerbalito = mysql_pconnect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or trigger_error(mysql_error(),E_USER_ERROR); 
?>