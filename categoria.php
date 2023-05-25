<?php require_once('Connections/yerbalito.php'); ?>
<?php include('seguridad.php'); ?> 
<?php
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

$varDato_DatosJugador = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosJugador = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = sprintf("SELECT * FROM jugador WHERE jugador.idjugador = %s", GetSQLValueString($varDato_DatosJugador, "int"));
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$varDato_DatosJugador = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosJugador = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = sprintf("SELECT * FROM jugador, categoria, estado WHERE jugador.idjugador = %s AND categoria.idcategoria = jugador.idcategoria AND estado.idestado = jugador.idestado", GetSQLValueString($varDato_DatosJugador, "int"));
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);
?>
<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Yerbalito</title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
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
		  <img src="images/logo.png" alt="yerbalito" width="200" height="200" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" >        
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
	      <h1> Datos del jugador: </h1>
               
               
               
          <table width="100%" border="1">
  <tr>
    <td>Nombre</td>
    <td> <?php echo $row_DatosJugador['nombre']; ?> </td>
  </tr>
  <tr>
    <td>Apellido</td>
    <td><?php echo $row_DatosJugador['apellido']; ?></td>
  </tr>
  <tr>
    <td>Foto</td>
    <td><img src="/yerbalito.com/images/<?php echo $row_DatosJugador['imagen']; ?>"></td>
  </tr> 
  <tr>
    <td>Categoria</td>
    <td><?php echo $row_DatosJugador['nombre_categoria']; ?></td>
  </tr>
  <tr>
    <td>Fecha de nacimiento</td>
    <td><?php echo $row_DatosJugador['fecha_nacimiento']; ?></td>
  </tr>
  <tr>  
  <tr>
    <td>Fecha de ingreso</td>
    <td><?php echo $row_DatosJugador['fecha_ingreso']; ?></td>
  </tr>
  <tr>
    <td>Cedula</td>
    <td><?php echo $row_DatosJugador['cedula']; ?></td>
  </tr>  
  <tr>
    <td scope="row">Estado</td>
   <td>
     <?php if ($row_DatosJugador['idestado']==1) { ?>
        <span style="background-color:#F00"> <?php echo $row_DatosJugador['tipo_estado']; ?>         </span>
        <?php 
		}
		elseif ($row_DatosJugador['idestado']==2) { ?>
        <span style="background-color:#0F0"> <?php echo $row_DatosJugador['tipo_estado']; ?>        </span>
        <?php
		}
		else { ?>
			<span style="background-color:#FF9"> <?php echo $row_DatosJugador['tipo_estado']; ?> </span>
            <?php
		}        ?>
     </td>

  </tr>
  <tr>
    <td scope="row">Padre</td>
    <td><?php echo $row_DatosJugador['padre']; ?></td>
  </tr>
  <tr>
    <td scope="row">Madre</td>
    <td><?php echo $row_DatosJugador['madre']; ?></td>
  </tr>
  <tr>
    <td scope="row">Contacto</td>
    <td><?php echo $row_DatosJugador['contacto']; ?></td>
  </tr> 
  <tr>
    <td scope="row">Observaciones</td>
    <td><?php echo $row_DatosJugador['observaciones']; ?></td>
  </tr>    
</table>
 <tr align="center"> 
   <td>
  <a href="modificar_jugador.php?recordID=<?php echo $row_DatosJugador['idjugador']; ?>"><img src="img/knobs-icons/Knob Smart.png" width="32" height="32" border="0" title="Modificar jugador"></a>  
      <a href="eliminar_jugador.php?recordID=<?php echo $row_DatosJugador['idjugador']; ?>"><img src="img/knobs-icons/Knob Remove.png" width="32" height="32" onClick="javascript:return asegurar();" title="Eliminar jugador"></a> 
      </td>
   </tr>
	      
          </div>	 
	  </div>
		<!-- ENDS MAIN -->

  	  <!-- FOOTER -->
	<div id="footer">	
    <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion" ></a> <a href="listado_jugadores.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al listado de Jugadores"></a>			
				<!-- footer-cols -->				<!-- ENDS footer-cols -->				
				<!-- Bottom -->
				<div id="bottom">
				<a href="http://olimarteam.uy/yerbalito" >Gestion Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.uy">olimarteam.uy</a></div>
				<!-- ENDS Bottom -->
	  </div>
		<!-- ENDS FOOTER -->
	
	</div>
	<!-- ENDS WRAPPER -->
	
	</body>
	
</html>
<?php
mysql_free_result($DatosJugador);
?>
