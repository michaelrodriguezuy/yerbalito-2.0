<?php 

session_start();

// Verificar si existe una sesión activa
if (!isset($_SESSION["autentica"])) {
    header("Location: login.php"); // Redireccionar a la página de inicio de sesión si no hay sesión
    exit();
}

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugadores = "SELECT * FROM jugador";
$DatosJugadores = mysql_query($query_DatosJugadores, $yerbalito) or die(mysql_error());
$row_DatosJugadores = mysql_fetch_assoc($DatosJugadores);
$totalRows_DatosJugadores = mysql_num_rows($DatosJugadores);

mysql_select_db($database_yerbalito, $yerbalito);

$query_DatosCategoria = "SELECT categoria.idcategoria, categoria.nombre_categoria, categoria.tecnico, categoria.telefono, categoria.idestado, categoria.edad, estado.tipo_estado FROM categoria, estado WHERE (categoria.idestado = estado.idestado AND categoria.idcategoria<>9 AND categoria.idcategoria<>10 AND categoria.idcategoria<>11) ORDER BY categoria.idcategoria";
$DatosCategoria = mysql_query($query_DatosCategoria, $yerbalito) or die(mysql_error());
$row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
$totalRows_DatosCategoria = mysql_num_rows($DatosCategoria);

$sqlJugadoresAbejas = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=1";
$resJugadoresAbejas= mysql_query($sqlJugadoresAbejas) or die (mysql_error());
$filaAbejas = mysql_fetch_array($resJugadoresAbejas);
$sqlJugadoresGrillos = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=2";
$resJugadoresGrillos= mysql_query($sqlJugadoresGrillos) or die (mysql_error());
$filaGrillos = mysql_fetch_array($resJugadoresGrillos);
$sqlJugadoresChatas = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=3";
$resJugadoresChatas= mysql_query($sqlJugadoresChatas) or die (mysql_error());
$filaChatas = mysql_fetch_array($resJugadoresChatas);
$sqlJugadoresChurrinches = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=4";
$resJugadoresChurrinches= mysql_query($sqlJugadoresChurrinches) or die (mysql_error());
$filaChurrinches = mysql_fetch_array($resJugadoresChurrinches);
$sqlJugadoresGorriones = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=5";
$resJugadoresGorriones= mysql_query($sqlJugadoresGorriones) or die (mysql_error());
$filaGorriones = mysql_fetch_array($resJugadoresGorriones);
$sqlJugadoresSemillas = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=6";
$resJugadoresSemillas= mysql_query($sqlJugadoresSemillas) or die (mysql_error());
$filaSemillas = mysql_fetch_array($resJugadoresSemillas);
$sqlJugadoresCebollas = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=7";
$resJugadoresCebollas= mysql_query($sqlJugadoresCebollas) or die (mysql_error());
$filaCebollas = mysql_fetch_array($resJugadoresCebollas);
$sqlJugadoresBabys = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=8";
$resJugadoresBabys= mysql_query($sqlJugadoresBabys) or die (mysql_error());
$filaBabys = mysql_fetch_array($resJugadoresBabys);

$sqlJugadoresSub11 = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=12";
$resJugadoresSub11= mysql_query($sqlJugadoresSub11) or die (mysql_error());
$filaSub11 = mysql_fetch_array($resJugadoresSub11);
$sqlJugadoresSub13 = "SELECT jugador.idcategoria,COUNT(*) as laCategoria FROM jugador WHERE jugador.idcategoria=13";
$resJugadoresSub13= mysql_query($sqlJugadoresSub13) or die (mysql_error());
$filaSub13 = mysql_fetch_array($resJugadoresSub13);

?>
<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Yerbalito</title>
		
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
	      <h1> Listado de categorias: </h1>       
         
	           

<table width="100%" border="0"cellpadding="2" cellspacing="2">
	        <tr class="blue-box">
			    <td>Nombre</td>
			    <td>Tecnico</td>
			    <td>Telefono</td>                
			    <td>Estado</td>
				<td>Cantidad Jugadores</td>
				<td>Edades</td>
                <td>Acciones</td>                
			 </tr>
  
  <?php do { ?>
    <tr>
      <td>	<?php echo $row_DatosCategoria['nombre_categoria']; ?> </td>       
         
      <td> <?php echo $row_DatosCategoria['tecnico']; ?></td>    
      <td><?php echo $row_DatosCategoria['telefono']; ?></td>
                      
      <td> 
	  	<?php if ($row_DatosCategoria['idestado']==5) { ?>
        <span style="background-color:#F00"> <?php echo $row_DatosCategoria['tipo_estado']; ?>         </span>
        <?php 
		}
		else { ?>
			<span style="background-color:#0F0"> <?php echo $row_DatosCategoria['tipo_estado']; ?> </span>
            <?php
		}        ?>
			 </td>          
             
<td> <?php 
				
                if ($row_DatosCategoria['idcategoria']==1) { echo $filaAbejas['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==2) { echo $filaGrillos['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==3) { echo $filaChatas['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==4) { echo $filaChurrinches['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==5) { echo $filaGorriones['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==6) { echo $filaSemillas['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==7) { echo $filaCebollas['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==8) { echo $filaBabys['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==12) { echo $filaSub11['laCategoria']; }
				if ($row_DatosCategoria['idcategoria']==13) { echo $filaSub13['laCategoria']; }
                 
 ?> 
 
</td>

 <td><?php echo $row_DatosCategoria['edad']; ?></td>

      <td>
      
       <?php if($_SESSION["admin"] != 2) {
		?>
	     <a href="modificar_categoria.php?recordID=<?php echo $row_DatosCategoria['idcategoria']; ?>"><img src="img/knobs-icons/Knob Smart.png" width="32" height="32" border="0" title="Modificar categoria"></a>  
         <?php ;} ?>
      
      <a href="pdf.php?recordID=<?php echo $row_DatosCategoria['idcategoria']; ?>"><img src="img/mono-icons/printer32.png" width="32" height="32" border="0" title="Imprimir en PDF lista de jugadores" ></a>
      
      </td>      
    </tr>
    <?php } while ($row_DatosCategoria = mysql_fetch_assoc($DatosCategoria)); ?>
          </table>

	      
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
	<!-- ENDS WRAPPER -->
	Usuario: <?php echo $_SESSION["nombre"]; ?>
	</body>
	
</html>
<?php
mysql_free_result($DatosJugadores);

mysql_free_result($DatosCategoria);
?>
