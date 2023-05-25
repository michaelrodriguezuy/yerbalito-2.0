<?php require_once('Connections/yerbalito.php');

	 include('seguridad.php'); 

	 include('funciones.php');

//     revisaMesesPagos($_POST['idjugador']);

mysql_set_charset('utf8');



if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  if (PHP_VERSION < 6) {

    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  }



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

}

?>



<?php



mysql_select_db($database_yerbalito, $yerbalito);

$query_DatosFondo = "SELECT *, jugador.idjugador, jugador.nombre FROM fondocampeonato, jugador WHERE fondocampeonato.idjugador = jugador.idjugador ORDER BY fondocampeonato.id_fondo DESC";

$DatosFondo = mysql_query($query_DatosFondo, $yerbalito) or die(mysql_error());

$row_DatosFondo = mysql_fetch_assoc($DatosFondo);

$totalRows_DatosFondo = mysql_num_rows($DatosFondo);

?>

<!DOCTYPE  html>

<html>

	<head>

		<meta charset="utf-8">

		<title>Gestion Yerbalito</title>

		

        <!-- Bootstrap -->

		<link href="css/bootstrap.min.css" rel="stylesheet">

    

        

		<!-- CSS -->

		<link rel="stylesheet" href="css/style1.css" type="text/css" media="screen" />

		<link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" />

		<!--[if IE 8]>

			<link rel="stylesheet" type="text/css" media="screen" href="/css/ie8-hacks.css" />

		<![endif]-->

		<!-- ENDS CSS -->	

				

		<!-- GOOGLE FONTS -->

		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

		

		<!-- JS -->

		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>

		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>

		<script type="text/javascript" src="js/easing.js"></script>

		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>

		<script type="text/javascript" src="js/quicksand.js"></script>

		<script type="text/javascript" src="js/jquery.cycle.all.js"></script>

		<script type="text/javascript" src="js/custom.js"></script>

		<!--[if IE]>

			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

		<![endif]-->

		

		<!--[if IE 6]>

			<script type="text/javascript" src="js/DD_belatedPNG.js"></script>

			<script>

	      		/* EXAMPLE */

	      		//DD_belatedPNG.fix('*');

	    	</script>

		<![endif]-->

		<!-- ENDS JS -->

		

		

		<!-- Nivo slider -->

		<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />

		<script src="js/nivo-slider/jquery.nivo.slider.js" type="text/javascript"></script>

		<!-- ENDS Nivo slider -->

		

		<!-- tabs -->

		<link rel="stylesheet" href="css/tabs.css" type="text/css" media="screen" />

		<script type="text/javascript" src="js/tabs.js"></script>

  		<!-- ENDS tabs -->

  		

  		<!-- prettyPhoto -->

		<script type="text/javascript" src="js/prettyPhoto/js/jquery.prettyPhoto.js"></script>

		<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />

		<!-- ENDS prettyPhoto -->

		

		<!-- superfish -->

		<link rel="stylesheet" media="screen" href="css/superfish.css" /> 

		<link rel="stylesheet" media="screen" href="css/superfish-left.css" /> 

		<script type="text/javascript" src="js/superfish-1.4.8/js/hoverIntent.js"></script>

		<script type="text/javascript" src="js/superfish-1.4.8/js/superfish.js"></script>

		<script type="text/javascript" src="js/superfish-1.4.8/js/supersubs.js"></script>

		<!-- ENDS superfish -->

		

		<!-- poshytip -->

		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-twitter/tip-twitter.css" type="text/css" />

		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />

		<script type="text/javascript" src="js/poshytip-1.0/src/jquery.poshytip.min.js"></script>

		<!-- ENDS poshytip -->

		

		<!-- Tweet -->

		<link rel="stylesheet" href="css/jquery.tweet.css" media="all"  type="text/css"/> 

		<script src="js/tweet/jquery.tweet.js" type="text/javascript"></script> 

		<!-- ENDS Tweet -->

		

		<!-- Fancybox -->

		<link rel="stylesheet" href="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

		<script type="text/javascript" src="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

		<!-- ENDS Fancybox -->

		

		<!-- SKIN -->

		<link rel="stylesheet" href="skins/plastic/style.css" type="text/css" media="screen" />



 <!-- favicon-->

		<link rel="shortcut icon" href="favicon.ico" >



	</head>

	

	<body class="">

	

	

	<!-- WRAPPER -->

	<div id="wrapper">

		

		<!-- HEADER -->

		<div id="header"><!-- Social -->

			<div align="center">

		  <img src="images/logo3.png" alt="yerbalito" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" >        

        </div>

			<!-- ENDS Social -->

			

			<!-- Navigation --><!-- Navigation -->	

			

			<!-- search --><!-- ENDS search -->

			

			<!-- Breadcrumb--><!-- ENDS Breadcrumb-->	



		</div>

		<!-- ENDS HEADER -->

		



    

    	<!-- MAIN -->

	  <div id="main">   



      

	    <div align="center">

	      <h1> 

          <form name="filtro" action="<?php echo $PHP_SELF;?>" method="POST">

          

          <a href="panel.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al Panel de control"></a> 

          

		  <?php if($_SESSION["admin"] != 2) {

		?>

          <a href="insertar_fondo.php"><img src="img/knobs-icons/Knob Add.png" width="32" height="32" longdesc="img/knobs-icons/Knob Add.png" title="Insertar fondo"></a>

          <? ;} ?>

          		            	

            <input name="fondoDELjugador" type="text" title="Nombre del jugador">

            

			<input type="submit" name="filtrar" value="Buscar nombre del jugador">

				 Listado de recibos:

		</form>           

          

          

          </h1>       

         

	           



<table width="100%" border="0"cellpadding="2" cellspacing="2">

	        <tr class="blue-box">

			    <td>Numero de recibo</td>

			  <!--  <td>Libreta</td> -->

				<td>Fecha recibo</td>                

			    <td>Jugador</td>   			    

                <td>Año</td>            

              
				<td>Cuota paga</td>
    

			    <td>Monto ($)</td>



			    

   			    <td>Usuario</td>

            	<td>Acciones</td>      

			 </tr>

  

  

  <?php

//recibo los criterios y construyo la consulta

if($_POST['fondoDELjugador'])

{

	$variable = $_POST['fondoDELjugador'];

	$sql2="select * from jugador where nombre LIKE '%$variable%'";

	mysql_select_db($database_yerbalito, $yerbalito);

	$result2=mysql_query($sql2,$yerbalito); 

	if($result2 && mysql_num_rows($result2)>0) //si hay jugadores con ese nombre, busco si tienen recibos

	{		

		while($row2=mysql_fetch_array($result2))

		{

			$sql="select * from fondocampeonato WHERE idjugador=".$row2['idjugador']." ORDER BY id_fondo DESC"; 

			mysql_select_db($database_yerbalito, $yerbalito);

			$result=mysql_query($sql,$yerbalito); //tengo todos los recibos de ese jugador		


			

			if($result && mysql_num_rows($result)>0)

			{  

			  do { 

				while($row=mysql_fetch_array($result))

				{ 	

					$sql3="select * from jugador WHERE idjugador=".$row['idjugador'];

					mysql_select_db($database_yerbalito, $yerbalito);

					$result3=mysql_query($sql3,$yerbalito);			

					while($row3=mysql_fetch_array($result3))

						{ 



							$sql8="select * from usuario WHERE id_usuario=".$row['idusuario'];

							mysql_select_db($database_yerbalito, $yerbalito);

							$result8=mysql_query($sql8,$yerbalito);

							while($row8=mysql_fetch_array($result8)) {

							?>        

				    	<tr>      

		    		  		<td><?php echo $row['numero']; ?></td>                

						    <td><?php echo $row['fecha']; ?></td>    

					        <td><?php echo $row3['nombre']; ?> <?php echo $row3['apellido']; ?></td>           



					        <td><?php echo $row['anio']; ?></td>

								<td><?php echo $row['cuota_paga']; ?></td>
                      
					        <td><?php echo $row['monto']; ?></td>                


				            <td><?php echo $row8['nombre']; ?></td>

				      		<td> 

                             <?php }  ?>                     

						    </td>

		        		</tr>

          

			    <?php }

				} 

				} while ($row= mysql_fetch_assoc($result)); 

 			}

		}	

	}

}		





else {

	

	// definir o numero de itens por pagina

$cantidad_x_pagina = 10;



// pegar a pagina atual

//$pagina = intval($_GET['pagina']);

	if (isset($_GET['pagina'])) {

		$pagina_actual = $_GET['pagina'];	

	}

	else	{

		$pagina_actual = 1;

	}



$desde = ($pagina_actual-1)* $cantidad_x_pagina;



// puxar produtos do banco

$sql_code = "select * from fondocampeonato ORDER BY id_fondo DESC LIMIT $desde,$cantidad_x_pagina";

// = $mysqli->query($sql_code) or die($mysqli->error);

$resultado = mysql_query($sql_code,$yerbalito);



//$produto = $execute->fetch_assoc();

$num = mysql_num_rows($resultado);



// pega a quantidade total de objetos no banco de dados

$sql_code2 = "select * from fondocampeonato";

$num_total = mysql_query($sql_code2, $yerbalito);

$num_total2 = mysql_num_rows($num_total);



// definir numero de páginas

$num_paginas_total = ceil($num_total2/$cantidad_x_pagina);



	if($num > 0) //si hay recibos entro

		{  

  		do {  //

  			while($row=mysql_fetch_array($resultado))

			{ 	

				$sql3="select * from jugador WHERE idjugador=".$row['idjugador'];

				mysql_select_db($database_yerbalito, $yerbalito);

				$result3=mysql_query($sql3,$yerbalito);	

		

				while($row3=mysql_fetch_array($result3))

					{ 

						$sql8="select * from usuario WHERE id_usuario=".$row['idusuario'];

							mysql_select_db($database_yerbalito, $yerbalito);

							$result8=mysql_query($sql8,$yerbalito);

							while($row8=mysql_fetch_array($result8)) {

						

						?>        

	    			<tr>      

			      		<td><?php echo $row['numero']; ?></td>                

<!--					    <td><?php // echo $row['idlibreta']; ?></td>               -->

					    <td><?php echo $row['fecha']; ?></td>    

                        <td><?php echo $row3['nombre']; ?> <?php echo $row3['apellido']; ?></td>           

			            <td><?php echo $row['anio']; ?></td>                        

				        <td><?php echo $row['cuota_paga']; ?></td>    



				        <td><?php echo $row['monto']; ?></td>                



				        

			            <td><?php echo $row8['nombre']; ?></td>

			      		<td>

                        

                         <?php } if($_SESSION["admin"] != 2) {

		?>

                         <a href="modificar_fondo.php?recordID=<?php echo $row['numero']; ?>"><img src="img/knobs-icons/Knob Smart.png" width="32" height="32" border="0" title=	"Modificar recibo de fondo"></a>  

                         <?php ;}?>      

                         

					    </td>

			        </tr>

          

			    <?php }

			} 

		} while ($row = mysql_fetch_assoc($resultado));

	}

}?>





</table>



	      <nav>

          <?php

		  $anterior=($pagina_actual-1);

		  $siguiente=($pagina_actual+1);

		  ?>

				  <ul class="pagination">

				    

                    <?php

						if (!($pagina_actual<=1)): ?>

                    

                    <li>

				      <a href='<?php echo "listado_fondo.php?pagina=$anterior"?>' aria-label="Anterior">

				        <span aria-hidden="true">&laquo;</span>

				      </a>

				    </li>

				    

                    <?php endif ?>

                    

                    

					

					<?php if($pagina_actual>=1) {

					

					    for($i=1;$i<=$num_paginas_total;$i++){

							echo ($i==$pagina_actual) ? "<li class='active'><a href='listado_fondo.php?pagina=$i'>$i</a></li>":

							"<li> <a href='listado_fondo.php?pagina=$i'>$i</a></li>";

						}

					}				

									

                

					if (!($pagina_actual>=$num_paginas_total)): ?>

                    <li>

                    	<a href=' <?php echo "listado_fondo.php?pagina=$siguiente"?>' aria-label="Siguiente">

				        	<span aria-hidden="true">&raquo;</span>

				      	</a>

				    </li>

                    <?php endif ?>

                    

                    

				  </ul>

				</nav>

                

		</div>	   

        

	  </div>

		<!-- ENDS MAIN -->



  	  <!-- FOOTER -->

	<div id="footer">

    <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion" ></a> <a href="panel.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al Panel de control"></a>				

				<!-- footer-cols -->				<!-- ENDS footer-cols -->				

				<!-- Bottom -->

				<div id="bottom">

				<a href="http://olimarteam.uy/yerbalito/" >Gestión Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.uy">olimarteam.uy</a></div>

				<!-- ENDS Bottom -->

	  </div>

		<!-- ENDS FOOTER -->

	

	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  	<!-- Include all compiled plugins (below), or include individual files as needed -->

  	<script src="js/bootstrap.min.js"></script>

	<!-- ENDS WRAPPER -->

	Usuario: <?php echo $_SESSION["nombre"]; ?>

	</body>

	

</html>

<?php

mysql_free_result($DatosRecibo);





?>

