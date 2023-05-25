<?php

$jugadorQuePago = $_POST['idjugador'];

require_once('Connections/yerbalito.php');
include('seguridad.php');

$mysqli = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
    die("No se pudo conectar: " . mysql_error());

//$banderaDeudores =0;
$hoy=getdate();


/*
$deudoresAnioPasado = mysqli_query($link, "SELECT * FROM recibo WHERE recibo.idjugador ='".$jugadorQuePago."' AND recibo.anio = $hoy[year]-1");
		$mesesDelAnioAnterior = mysqli_num_rows($deudoresAnioPasado);
		if ($mesesDelAnioAnterior > 0) {			
			/*
			if ($mesesDelAnioAnterior == 12) {
				//debe pagar el mes $mesesDelAnioAnterior+1	
				mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQueDebe, '12', $hoy[year], 'ENERO FREE', '0', '1')");
			} 
			
			if ($mesesDelAnioAnterior==11)  {
				//echo $mesesDelAnioAnterior;
					//le agrego diciembre 2019 y enero, y sigo de largo, debe pagar fEBRERO 2020					
						mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '12', '0', '2020-01-01', $jugadorQuePago, '12', $hoy[year]-1, 'DICIEMBRE FREE', '0', '1')");
						
						mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQuePago, '12', $hoy[year], 'ENERO FREE', '0', '1')");
			}			
		}
		else { //jugador que ingresa este año, deberia tambien ingresar los meses anterior a los que se inscribe, pensando en que puede ingresar mas adelante en el año
			mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`, `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQuePago, '12', $hoy[year], 'ENERO FREE', '0', '1')");
		}
	*/	
		
		

//		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
		$result = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador ='".$jugadorQuePago."' AND recibo.anio = $hoy[year]"); // traigo los recibos del jugador que pago en este año

	    $row_cnt = mysqli_num_rows($result);
		//PRUEBA	
		//$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt."' Where jugador.idjugador ='".$jugadorQuePago."'");
		
	/*
		if ($row_cnt < date("n")) { //si entro aca es porque el jugador no esta al dia		
		}

$result = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador =' ".$jugadorQuePago."' AND recibo.anio = $hoy[year]"); 
$contadormeses = 0;
if (count($result)>0) {
	$i = 0;
	while (($i <= count($result)) AND ($contadormeses <= date("n"))) {		
		$contadormeses+=1;							
		$i+=1;									
	}
}
*/
//AFINAR, Y PREGUNTAR SI ESTA DENTRO DE LOS 10 PRIMEROS DIAS DE PLAZO PARA ABONAR EL MES

if ($row_cnt>=date("n")) { /*si entro aca es porque esta al dia */
//	$mysqli->query("Update jugador Set observacionesJugador ='".$contadormeses."' Where jugador.idjugador ='".$jugadorQuePago."'");
	$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador ='".$jugadorQuePago."'");		

	$result3 = ("SELECT * FROM jugador WHERE jugador.idjugador ='".$jugadorQuePago."'");// saco los datos del jugador que pago, para saber de que categoria es

	$query_execute = $mysqli->query($result3);
	$query_result = $query_execute->fetch_array();
	$idCategoria = $query_result['idcategoria']; //HASTA ACA VAMOS BIEN

	//PRUEBA	
	//$mysqli->query("Update jugador Set observacionesJugador ='".$idCategoria."' Where jugador.idjugador ='".$jugadorQuePago."'");
	
	$result2 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."'"); //tengo todos los jugadores de esa categoria
	$row_cnt2 = $result2->num_rows;
	
	$result4 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."' AND jugador.idestado=2"); //tengo todos los jugadores de esa categoria que estan al dia
	$row_cnt4 = $result4->num_rows;
		
	if ($row_cnt2==$row_cnt4) { /*si entro aca es porque todos los jugadores de esa categoria estan al dia */
		$mysqli->query("Update categoria Set idestado=6 Where categoria.idcategoria =' ".$idCategoria."'");
	}
	else {
		$mysqli->query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$idCategoria."'"); 
	}		
}
else
{
	$mysqli->query("Update jugador Set idestado=1 Where jugador.idjugador =' ".$jugadorQuePago."'");
}




?>