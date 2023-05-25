<?php require_once('Connections/yerbalito.php');
	 include('seguridad.php');

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







$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE recibo SET numero=%s, mes_pago=%s, monto=%s, fecha_recibo=%s, idjugador=%s, idlibreta=%s, anio=%s, observacionesRecibo=%s WHERE idrecibo=%s",
                       GetSQLValueString($_POST['numero'], "int"),
                       GetSQLValueString($_POST['mes_pago'], "text"),
                       GetSQLValueString($_POST['monto'], "double"),
                       GetSQLValueString($_POST['fecha_recibo'], "date"),
                       GetSQLValueString($_POST['idjugador'], "int"),
                       GetSQLValueString($_POST['idlibreta'], "int"),
                       GetSQLValueString($_POST['anio'], "int"),
                       GetSQLValueString($_POST['observacionesRecibo'], "text"),
                       GetSQLValueString($_POST['idrecibo'], "int"));

  mysql_select_db($database_yerbalito, $yerbalito);
  $Result1 = mysql_query($updateSQL, $yerbalito) or die(mysql_error());

  $updateGoTo = "listado_recibos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
/*
$varDato_DatosRecibo = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosRecibo = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosRecibo = sprintf("SELECT *, jugador.nombre, jugador.apellido, libretas.numeracion FROM recibo, jugador, libretas WHERE recibo.idrecibo = %s", GetSQLValueString($varDato_DatosRecibo, "int"));
$DatosRecibo = mysql_query($query_DatosRecibo, $yerbalito) or die(mysql_error());
$row_DatosRecibo = mysql_fetch_assoc($DatosRecibo);
*/
$varDato_DatosRecibo = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosRecibo = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosRecibo = sprintf("SELECT *, jugador.idjugador , jugador.nombre, jugador.apellido, libretas.idlibreta, libretas.numeracion FROM recibo, jugador, libretas WHERE recibo.numero = %s AND recibo.idjugador = jugador.idjugador AND recibo.idlibreta = libretas.idlibreta", GetSQLValueString($varDato_DatosRecibo, "int"));
$DatosRecibo = mysql_query($query_DatosRecibo, $yerbalito) or die(mysql_error());
$row_DatosRecibo = mysql_fetch_assoc($DatosRecibo);
$totalRows_DatosRecibo = mysql_num_rows($DatosRecibo);



//LO USO PARA TRAER TODOS LOS RECIBOS (MESES PAGOS, PORQUE CADA RECIBO ES UN MES PAGO) CON ESE NUMERO DE RECIBO
$mysqli8 = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
die("No se pudo conectar: " . mysql_error());
$result8 = mysqli_query($mysqli8, "SELECT * FROM recibo WHERE recibo.numero ='".$varDato_DatosRecibo."'"); // traigo los recibos del jugador que pago en este año
$row_dd = mysqli_fetch_assoc($result8);
$row_cnt8 = mysqli_num_rows($result8);

$v=array();
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

	<script type="text/javascript">
	
function subirimagen(nombrecampo)
{
	self.name = 'opener';
	remote = open('gestionimagen.php?campo='+nombrecampo, 'remote', 'width=400,height=150,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes');
 	remote.focus();
}

//USO ESTA FUNCION PARA VER LA CANTIDAD DE MESES QUE VA A PAGAR Y PODER CALCULAR EL VALOR TOTAL

function contar() 
{
var checkboxes = document.getElementsByName('mes_pago[]');

var cont = 0;

//var checkboxes = document.getElementById("mes_pago"); 
	for (var x=0; x < checkboxes.length; x++) {
	 if (checkboxes[x].checked) {
	  cont = cont + 1;
	 }
	}
	document.getElementById('monto').value = 250 * cont;
	
}


</script>

	</head>
	

    
	<body class="">
    
    <p>&nbsp;</p>
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
	  <div id="main"> Modificar recibo:
       

   <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table align="center">
        <!--
        <tr valign="baseline">
          <td nowrap align="right">Id del recibo:</td>
          <td><?php echo $row_DatosRecibo['idrecibo']; ?></td>
        </tr>
        -->
        <tr valign="baseline">
          <td nowrap align="right">Numero de recibo:</td>
          <td><input type="text" name="numero" value="<?php echo htmlentities($row_DatosRecibo['numero'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
              <td nowrap align="right">Mes pago:</td>
              <td align="left">              
             
              <table width="100">
              
              
              
                <tr>                
                  <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" checked disabled onClick="javascript:contar();">
                    Enero</label></td>
                </tr>
                
                <?php 
				do{
					$v[]= $row_dd['mes_pago'];
				} while ($row_dd = mysqli_fetch_assoc($result8));				
				?>
                
                <tr>
                  <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" onClick="contar();" <?php    
													
	    			
						foreach( $v as $value ){
 					   		if( $value == 2 ){
					        	echo "checked";
						        break;
			 			    }
						}					
					
					       ?> >
                    Febrero</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 3 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Marzo </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 4 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Abril </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 5 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Mayo </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 6 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Junio </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 7 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Julio </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 8 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Agosto </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 9 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Setiembre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 10 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Octubre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 11 ){
					        	echo "checked";
						        break;
			 			    }
						}						
					
					       ?> onClick="javascript:contar();">
                    Noviembre </label></td>
                </tr>
                <tr>
                  <td><label>
                  <!-- en el caso de no usar algun mes, pongo disabled="disabled" -->
                    <input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" <?php    
					
						foreach( $v as $value ){
 					   		if( $value == 12 ){
					        	echo "checked";
						        break;
			 			    }
						}						
						
					       ?> onClick="javascript:contar();">
                    Diciembre </label></td>
                </tr>
                
                
              </table>
                                                      
              </td>
              
            </tr>
        <tr valign="baseline">
          <td nowrap align="right">Año:</td>
          <td><input type="text" name="anio" value="<?php echo htmlentities($row_DatosRecibo['anio'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Monto:</td>
          <td><input type="text" name="monto" value="<?php echo htmlentities($row_DatosRecibo['monto'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap align="right">Fecha de recibo:</td>
          <td><input type="text" name="fecha_recibo" value="<?php echo htmlentities($row_DatosRecibo['fecha_recibo'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Id del jugador:</td>
          <td><input type="text" name="idjugador" value="<?php echo htmlentities($row_DatosRecibo['idjugador'], ENT_COMPAT, 'utf-8'); ?>" size="32"><?php echo $row_DatosRecibo['nombre']; ?>  <?php echo $row_DatosRecibo['apellido']; ?></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Id de libreta:</td>
          <td><input type="text" name="idlibreta" value="<?php echo htmlentities($row_DatosRecibo['idlibreta'], ENT_COMPAT, 'utf-8'); ?>" size="32"><?php echo $row_DatosRecibo['numeracion']; ?></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Observaciones:</td>
          <td><input type="text" name="observacionesRecibo" value="<?php echo htmlentities($row_DatosRecibo['observacionesRecibo'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Actualizar registro"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="idrecibo" value="<?php echo $row_DatosRecibo['idrecibo']; ?>">
    </form>
       
      </div>
		<!-- ENDS MAIN -->

	  <!-- FOOTER -->
	<div id="footer">	
    			
	  <!-- footer-cols -->				<!-- ENDS footer-cols -->				
	  <!-- Bottom -->
       <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion"></a> <a href="listado_recibos.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al listado de recibos"></a>

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
mysql_free_result($DatosRecibo);

?>
