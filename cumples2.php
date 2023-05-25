<?php

include('seguridad.php');

//require_once('Connections/yerbalito.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

/*
$pdo=new PDO("mysql:dbname=wwwolima_yerbalito;host=localhost","wwwolima","rjW63u0I6n");
$database_yerbalito = "wwwolima_yerbalito";
*/

$hostname_yerbalito = "localhost";
$username_yerbalito = "wwwolima";
$password_yerbalito = "rjW63u0I6n";	
$database_yerbalito = "wwwolima_yerbalito";


$pdo=new PDO("mysql:dbname=wwwolima_yerbalito;host=localhost","wwwolima","rjW63u0I6n");
$pdo->query("SET NAMES 'UTF8' ");
$statement=$pdo->prepare("SELECT nombre, apellido, fecha_nacimiento, idcategoria FROM jugador 
where jugador.idcategoria<>9 AND jugador.idcategoria<>10 AND jugador.idcategoria<>11");
$statement->execute();

if (!$statement){
    echo 'Error al ejecutar la consulta';
}else{
    $arreglo['data'][]= $statement->fetchAll(PDO::FETCH_ASSOC);
}
echo json_encode($arreglo);


/*
	$DatosJugador = mysqli_query($con,"SELECT * FROM jugador where jugador.idcategoria>=1 AND jugador.idcategoria <=8");
$SentenciaSQL=$pdo->prepare("SELECT * FROM jugador where jugador.idcategoria>=1 AND jugador.idcategoria <=8");
$SentenciaSQL->execute();

if (!$statement){
    echo 'Error al ejecutar la consulta';
}else{
    echo 'intentando obtener registros <br>';
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}

while ($array_jugadores = mysqli_fetch_array($DatosJugador))
{
	$nombre = $array_jugadores['jugador.nombre'];	
	$apellido = $array_jugadores['jugador.apellido'];
	$fecha_nacimiento = $array_jugadores['jugador.fecha_nacimiento'];
	$idcategoria = $array_jugadores['jugador.idcategoria'];

	$array_jugadores_final[] = array("nombre" => $nombre,"apellido" => $apellido, "fecha_nacimiento" => $fecha_nacimiento, "idcategoria" => $idcategoria);
}


//echo json_encode($array_jugadores_final);
//$totalRows_DatosJugadores = mysql_num_rows($DatosJugador);			
//echo json_encode($totalRows_DatosJugadores);


$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugadores = mysql_num_rows($DatosJugador);


//traigo todos los jugadores
$jugadoresSQL = mysqli_query("SELECT jugador.idjugador, jugador.nombre, jugador.apellido, jugador.fecha_nacimiento, jugador.idcategoria FROM jugador", $con) or die
		     	(mysql_error());
 con fetchAll consulto todos los registros y los convierto a un arreglo
$resultado= $jugadoresSQL->fetchAll(PDO::FETCH_ASSOC);

$resultado = mysql_fetch_assoc($jugadoresSQL);

por ultimo convierto la consulta a formato json
echo json_encode($row_DatosJugador);
echo json_encode($totalRows_DatosJugadores);
*/

?>