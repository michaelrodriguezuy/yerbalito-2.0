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

$varDato_PagosJugador = "0";
if (isset($GET_["recordID"])) {
  $varDato_PagosJugador = $GET_["recordID"];
}

$varDato_PagosJugador = "0";
if (isset($_GET["recordID"])) {
  $varDato_PagosJugador = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_PagosJugador = sprintf("SELECT * FROM recibo WHERE recibo.idjugador = %s AND recibo.anio = DATE('Y')", GetSQLValueString($varDato_PagosJugador, "int"));
$PagosJugador = mysql_query($query_PagosJugador, $yerbalito) or die(mysql_error());
$row_PagosJugador = mysql_fetch_assoc($PagosJugador);
$totalRows_PagosJugador = mysql_num_rows($PagosJugador);

$varDato_datosJugador = "0";
if (isset($_GET["recordID"])) {
  $varDato_datosJugador = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_datosJugador = sprintf("SELECT * FROM jugador WHERE jugador.idjugador = %s", GetSQLValueString($varDato_datosJugador, "int"));
$datosJugador = mysql_query($query_datosJugador, $yerbalito) or die(mysql_error());
$row_datosJugador = mysql_fetch_assoc($datosJugador);
$totalRows_datosJugador = mysql_num_rows($datosJugador);


/*saco la fecha de hoy para buscar solo meses de este año*/
$hoy=getdate();

$mysqli = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
    die("No se pudo conectar: " . mysql_error());
	
$result = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador = $varDato_PagosJugador AND recibo.anio = $hoy[year]");

/*
$result2 = $mysqli->query("SELECT mes_pago FROM recibo WHERE recibo.idjugador = $varDato_PagosJugador AND recibo.anio = $hoy[year]");

$row_cnt_mesesMismoRecibo=0;

$mesespagos = $result['mes_pago'];


$arrayMeses = array(); 
 
 
$arrayMeses = explode(',', $result2);

if (substr_count($result2, ',')>0)
{ 	
	$arrayMeses = explode(',', $result2); 
	$row_cnt_mesesMismoRecibo = count($arrayMeses); /*aca obtengo los meses pagos en un mismo recibo 
} */


$row_cnt = $result->num_rows; /*aca obtengo todos los meses pagos en distintos recibos*/

/*
$row_cnt+=$row_cnt_mesesMismoRecibo;
 $row_mesesMismoRecibo = $arrayMeses->num_rows; */


?>
<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<strong></strong><title>Gestion Yerbalito</title>
		
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
          <h1> Pagos realizados por <?php echo $row_datosJugador['nombre']; ?> <?php echo $row_datosJugador['apellido']; ?></h1>
          
          <table width="100%" border="1">
  <tr>




   <?php
   /*
$result = mysql_query("SELECT mes_pago FROM recibo WHERE recibo.idjugador = 1 AND recibo.anio = 2018");
echo count(mysqli_fetch_array($result));
*/

/*
echo $row_cnt;

*/

echo "Este jugador tiene ".$row_cnt." recibos pagos del año 2020<br />" ;

/*
echo "Este jugador tiene ".$row_cnt_mesesMismoRecibo." meses pagos en un mismo recibo<br />";
echo "Este jugador tiene ".count($arrayMeses)." meses pagos en total<br />"; /*NO ESTA CONTANDO COMAS */






for ($x=0;$x<=$row_cnt;$x++) {
	$fila = $result->fetch_object();
	/*$fila->mes_pago;*/
?>

    <td>    <?php if ($fila->mes_pago==1) { ?>
        <span style="background-color:#0F0">  ENERO </span>
        <?php 
		} ?>

    
    
    
    
  
    
<?php if ($fila->mes_pago==2) { ?>
        <span style="background-color:#0F0">  FEBRERO </span>
        <?php 
		}		
		 ?>
        
   
         
  
     
<?php if ($fila->mes_pago==3) { ?>
        <span style="background-color:#0F0">  MARZO </span>
        <?php 
		}		
		    ?>
   
        
        
<?php if ($fila->mes_pago==4) { ?>
        <span style="background-color:#0F0">  ABRIL </span>
        <?php 
		}		
		?>
    <?php if ($fila->mes_pago==5) { ?>
        <span style="background-color:#0F0">  MAYO </span>
        <?php 
		}		
		     ?>
    <?php if ($fila->mes_pago==6) { ?>
        <span style="background-color:#0F0">  JUNIO </span>
        <?php 
		}		
		   ?>
    <?php if ($fila->mes_pago==7) { ?>
        <span style="background-color:#0F0">  JULIO </span>
        <?php 
		}		
		      ?>
    <?php if ($fila->mes_pago==8) { ?>
        <span style="background-color:#0F0">  AGOSTO </span>
        <?php 
		}		
		      ?>
    <?php if ($fila->mes_pago==9) { ?>
        <span style="background-color:#0F0">  SETIEMBRE </span>
        <?php 
		}		
		    ?>
    <?php if ($fila->mes_pago==10) { ?>
        <span style="background-color:#0F0">  OCTUBRE </span>
        <?php 
		}		
		     ?>
   <?php if ($fila->mes_pago==11) { ?>
        <span style="background-color:#0F0">  NOVIEMBRE </span>
        <?php 
		}		
		      ?>
    <?php if ($fila->mes_pago==12) { ?>
        <span style="background-color:#0F0">  DICIEMBRE </span>
        <?php 
		}		
		    ?></td>
  
<?php    } ?> 
  
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
mysql_free_result($PagosJugador);

mysql_free_result($datosJugador);
$result->close();
$mysqli->close();
?>
