<?php require_once('Connections/yerbalito.php'); ?>
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

$varDato_DatosMascotas = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosMascotas = $_GET["recordID"];
}
mysql_select_db($database_qrmascotas, $qrmascotas);
$query_DatosMascotas = sprintf("SELECT * FROM mascota WHERE mascota.identificacion = %s", GetSQLValueString($varDato_DatosMascotas, "text"));
$DatosMascotas = mysql_query($query_DatosMascotas, $qrmascotas) or die(mysql_error());
$row_DatosMascotas = mysql_fetch_assoc($DatosMascotas);
$totalRows_DatosMascotas = mysql_num_rows($DatosMascotas);

$varDato_DatosUsuarios = "0";
if (isset($_GET["idUsuario"])) {
  $varDato_DatosUsuarios = $_GET["idUsuario"];
}
mysql_select_db($database_qrmascotas, $qrmascotas);
$query_DatosUsuarios = sprintf("SELECT * FROM usuario WHERE usuario.id_usuario = %s", GetSQLValueString($varDato_DatosUsuarios, "int"));
$DatosUsuarios = mysql_query($query_DatosUsuarios, $qrmascotas) or die(mysql_error());
$row_DatosUsuarios = mysql_fetch_assoc($DatosUsuarios);
$totalRows_DatosUsuarios = mysql_num_rows($DatosUsuarios);


?>
<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Mascotas QR</title>
		
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
			<div id="social-holder"></div>
			<!-- ENDS Social -->
			
			<!-- Navigation --><!-- Navigation -->	
			
			<!-- search --><!-- ENDS search -->
			
			<!-- Breadcrumb--><!-- ENDS Breadcrumb-->	

		</div>
		<!-- ENDS HEADER -->
		    
    	<!-- MAIN -->
	  <div id="main"> 
	    <div align="center">
	      <h1> Datos del animal: </h1>
               
               
               
          <table width="100%" border="1">
  <tr>
    <td>Apodo</td>
    <td><?php echo $row_DatosMascotas['apodo']; ?></td>
  </tr>
  <tr>
    <td>Foto</td>
    <td><img src="/qrmascotas.com/images/<?php echo $row_DatosMascotas['foto']; ?>"></td>
  </tr>
  <tr>
    <td>Raza</td>
    <td><?php echo $row_DatosMascotas['raza']; ?></td>
  </tr>
  <tr>
    <td>Color</td>
    <td><?php echo $row_DatosMascotas['color']; ?></td>
  </tr>
  <tr>
    <td>Fecha de nacimiento</td>
    <td><?php echo $row_DatosMascotas['fecha_nacimiento']; ?></td>
  </tr>
  <tr>
    <td scope="row">Observación</td>
    <td><?php echo $row_DatosMascotas['observacion']; ?></td>
  </tr>
</table>

<h1> Datos del dueño: </h1>
          <table width="100%" border="1">
                 <tr>
                   <td>Nombre</td>
                   <td><?php echo $row_DatosUsuarios['nombre']; ?></td>
                 </tr>
                 <tr>
                   <td>Celular</td>
                   <td><?php echo $row_DatosUsuarios['celular']; ?></td>
                 </tr>
                 <tr>
                   <td>Email</td>
                   <td><?php echo $row_DatosUsuarios['email']; ?></td>
                 </tr>
                 <tr>
                   <td>Dirección</td>
                   <td><?php echo $row_DatosUsuarios['direccion']; ?></td>
                 </tr>
                 <tr>
                   <td>Localidad</td>
                   <td><?php echo $row_DatosUsuarios['localidad']; ?></td>
                 </tr>
          </table>
 
	      
		</div>	    
	  </div>
		<!-- ENDS MAIN -->

  	  <!-- FOOTER -->
	<div id="footer">				
				<!-- footer-cols -->				<!-- ENDS footer-cols -->				
				<!-- Bottom -->
				<div id="bottom">
				<a href="#" >Mascotas QR</a> es un sitio de <a href="http://olimarteam.com">olimarteam.com</a></div>
				<!-- ENDS Bottom -->
	  </div>
		<!-- ENDS FOOTER -->
	
	</div>
	<!-- ENDS WRAPPER -->
	
	</body>
	
</html>
<?php
mysql_free_result($DatosMascotas);

mysql_free_result($DatosUsuarios);
?>
