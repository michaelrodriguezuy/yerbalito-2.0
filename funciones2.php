<?php

//ACA LLEGO CADA VEZ QUE ALGUIEN SE LOGUEA AL SISTEMA



//EN EL AÑO 2021, ESTA FUNCION LO QUE HACE ES PONER A DEUDORES QUE DEBEN MESES EN EL 2021 SOLAMENTE
// AL DIA 11 DEL MES SIGUIENTE SIN PAGAR EL MES ANTERIOR, CAMBIA A DEUDOR.

function actualizaDeudores() {		//esta funcion busca jugadores que figuren habilitados pero si paso el dia 10 del mes siguiente y no han pago, los cambia a deudores
	
	// Create connection
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


	$hoy=getdate();

//ACA TENGO TODOS LOS JUGADORES AL DIA
	
	$result7 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idestado =2 ");
	

	while($row2 = mysqli_fetch_array($result7)) {  

		$jugadorQueDebe = $row2["idjugador"];		 //hasta aca va bien, me da todos los ID de jugadores que estarian al dia
		
		
				//ACA TENGO TODOS LOS RECIBOS DE ESTE AÑO DEL JUGADOR QUE ESTA AL DIA						 
				 $result = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador ='".$jugadorQueDebe."' AND recibo.anio = $hoy[year]");

		// determinar el número de filas del resultado 
				$row_cnt = mysqli_num_rows($result);
		
	   
				$mesesPagos = $row_cnt; //LE SUMO ENERO Y DICIEMBRE, PARA FINALES DEL 2020 DEBO SUMAR 3, YA QUE NOVIEMBRE TAMPOCO SE COBRA
										//LE SUMO ENERO Y FEBRERO, PARA FINALES DEL 2021 DEBO SUMAR 3, YA QUE DICIEMBRE TAMPOCO SE COBRA
		//echo $mesesPagos;
		
				if ( $mesesPagos+2 == date("n") and (date("j")>10) ) { //si entro aca es porque el jugador no esta al dia			
					mysqli_query("Update jugador Set idestado=1 Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor			
					
							$result9 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idjugador ='".$jugadorQueDebe."'");

					while ($row3 =mysqli_fetch_array($result9)) {
						$CategoriaQueDebe = $row3["idcategoria"];
						mysqli_query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$CategoriaQueDebe."'", $con); // pongo su categoria en deuda
					}
				}
								
			
		$mesesPagos=0;
		//$s++;			
			
	} //cierro el while
} //cierro la funcion



//pasa jugadores al Dia
function actualizaDeudores2() {		 //esta funcion busca jugadores que figuren inhabilitados y si corresponde los habilita, por ejemplo, los nuevos ingresos.

	
	// Create connection
	$hostname_yerbalito = "localhost";
	$username_yerbalito = "wwwolima";
	$password_yerbalito = "rjW63u0I6n";	
	$database_yerbalito = "wwwolima_yerbalito";
	
	$con = mysql_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or
	die("problemas con el servidor");
	
	mysql_select_db($database_yerbalito) or die
	("problemas con la base");

	
	$hoy=getdate();

//ACA TENGO TODOS LOS JUGADORES que deben
	$result7 = mysql_query("SELECT * FROM jugador WHERE jugador.idestado =1 ", $con) or die
		     	(mysql_error());
	

	while($row2 = mysql_fetch_array($result7)) {  

		

		$jugadorQueDebe = $row2["idjugador"];		 //hasta aca va bien, me da todos los ID de jugadores que no estan al dia
		
		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
		
		
			
				//ACA TENGO TODOS LOS RECIBOS DE ESTE AÑO DEL JUGADOR QUE ESTA AL DIA		
  		 $result = mysqli_query($link, "SELECT * FROM recibo WHERE recibo.idjugador ='".$jugadorQueDebe."' AND recibo.anio = $hoy[year]");
	    
		/* determinar el número de filas del resultado */
		$row_cnt = mysqli_num_rows($result);
		
	    //printf("El jugador ".$jugadorQueDebe." tiene ".$row_cnt." pagos.");
		$mesesPagos = $row_cnt; //LE SUMO ENERO Y DICIEMBRE, PARA FINALES DEL 2020 DEBO SUMAR 3, YA QUE NOVIEMBRE TAMPOCO SE COBRA
		
		if ( ($mesesPagos+1 > date("n")) or ($mesesPagos+1==date("n"))) { //si entro aca es porque el jugador no esta al dia			
			mysql_query("Update jugador Set idestado=2 Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor			
			
					
		}
				
		elseif (($mesesPagos+2==date("n") and (date("j")<10))) {
						mysql_query("Update jugador Set idestado=2 Where jugador.idjugador ='".$jugadorQueDebe."'", $con); //cambio su estado a deudor			
					
		}
			
		$mesesPagos=0;	
		$s++;			
			
	} //cierro el while
} //cierro la funcion

?>