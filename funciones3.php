<?php



function ingresoMesEneroParaNuevoJugador()
{
	$hoy=getdate();
	
	$hostname_yerbalito = "localhost";
	$username_yerbalito = "wwwolima";
	$password_yerbalito = "rjW63u0I6n";	
	$database_yerbalito = "wwwolima_yerbalito";
	
	$con = mysql_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or
	die("problemas con el servidor");
	
	mysql_select_db($database_yerbalito) or die
	("problemas con la base");

//RECUPERAR EL ID DEL JUGADOR QUE ACABO DE INGRESAR
$result7 = mysql_query("SELECT * FROM jugador ORDER BY idjugador DESC LIMIT 1", $con) or die //ordeno descendentemente y le digo mostrame solo 1 registro
	(mysql_error());

while( ($row2 = mysql_fetch_array($result7)) ){  
 $idJugadorIngresado=$row2["idjugador"];
}


mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2021-01-01', $idJugadorIngresado, '12', $hoy[year], 'ENERO FREE', '0', '1')"); //, $con) or die
	//(mysql_error());

/*

mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`,               `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQueDebe, '12', $hoy[year], 'ENERO FREE', '0', '1')");

mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQueDebe, '12', $hoy[year], 'ENERO FREE', '0', '1')");

mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $elJugador, '12', $hoy[year], 'ENERO FREE', '0', '1')");
*/

}


function ingresoMesFebreroParaNuevoJugador()
{
	$hoy=getdate();
	
	$hostname_yerbalito = "localhost";
	$username_yerbalito = "wwwolima";
	$password_yerbalito = "rjW63u0I6n";	
	$database_yerbalito = "wwwolima_yerbalito";
	
	$con = mysql_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or
	die("problemas con el servidor");
	
	mysql_select_db($database_yerbalito) or die
	("problemas con la base");

//RECUPERAR EL ID DEL JUGADOR QUE ACABO DE INGRESAR
$result7 = mysql_query("SELECT * FROM jugador ORDER BY idjugador DESC LIMIT 1", $con) or die //ordeno descendentemente y le digo mostrame solo 1 registro
	(mysql_error());

while( ($row2 = mysql_fetch_array($result7)) ){  
 $idJugadorIngresado=$row2["idjugador"];
}


mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '2', '0', '2021-01-01', $idJugadorIngresado, '12', $hoy[year], 'FEBRERO FREE', '0', '1')"); //, $con) or die
	//(mysql_error());

/*

mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`,               `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQueDebe, '12', $hoy[year], 'ENERO FREE', '0', '1')");

mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQueDebe, '12', $hoy[year], 'ENERO FREE', '0', '1')");

mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $elJugador, '12', $hoy[year], 'ENERO FREE', '0', '1')");
*/

}

?>