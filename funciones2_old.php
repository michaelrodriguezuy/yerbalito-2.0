<?php
//ACA LLEGO CADA VEZ QUE ALGUIEN SE LOGUEA AL SISTEMA

function actualizaDeudores() {	

	// Create connection
	$hostname_yerbalito = "localhost";
	$username_yerbalito = "wwwolima";
	$password_yerbalito = "rjW63u0I6n";	
	$database_yerbalito = "wwwolima_yerbalito";
	
	$con = mysql_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or
	die("problemas con el servidor");
	
	mysql_select_db($database_yerbalito) or die
	("problemas con la base");

	/*		
	mysql_query("Update jugador Set observacionesJugador='$nombre' where idjugador='$id'", $con) or die
	(mysql_error());	
	echo "se agrego correctamente";
	*/	
	$hoy=getdate();

	$result7 = mysql_query("SELECT * FROM jugador WHERE jugador.idestado =2 ", $con) or die
	(mysql_error());
			
	
	while( ($row2 = mysql_fetch_array($result7)) ){  
		$jugadorQueDebe = $row2["idjugador"];		 //hasta aca va bien, me da todos los ID de jugadores que estarian al dia



		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
		$result = mysqli_query($link, "SELECT * FROM recibo WHERE recibo.idjugador ='".$jugadorQueDebe."' AND recibo.anio = $hoy[year]");
	    /* determinar el número de filas del resultado */
	    $row_cnt = mysqli_num_rows($result);
	    //printf("El jugador ".$jugadorQueDebe." tiene ".$row_cnt." pagos.");
		
		if ($row_cnt+1 < date("n")) { //si entro aca es porque el jugador no esta al dia			

		//PRUEBA		
			//mysql_query("Update jugador Set observacionesJugador='".$Nmes."'Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor
			
			
			mysql_query("Update jugador Set idestado=1 Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor

			$result9 = mysql_query("SELECT * FROM jugador WHERE jugador.idjugador ='".$jugadorQueDebe."'", $con)or die
						(mysql_error()); //saco su categoria
			while ($row3 =mysql_fetch_array($result9)) {
				$CategoriaQueDebe = $row3["idcategoria"];
				mysql_query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$CategoriaQueDebe."'", $con); // pongo su categoria en deuda
			}
		} elseif ( ($row_cnt+1==date("n")) AND (date("j")>10) ) {
			mysql_query("Update jugador Set idestado=1 Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor
			//PRUEBA		acaaaa buenazzooooooooo
//			mysql_query("Update jugador Set observacionesJugador='".date("j")."'Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor

			$result9 = mysql_query("SELECT * FROM jugador WHERE jugador.idjugador ='".$jugadorQueDebe."'", $con)or die
						(mysql_error()); //saco su categoria
			while ($row3 =mysql_fetch_array($result9)) {
				$CategoriaQueDebe = $row3["idcategoria"];
				mysql_query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$CategoriaQueDebe."'", $con); // pongo su categoria en deuda
			}
		}
				
		$s++;
	}	
}
?>