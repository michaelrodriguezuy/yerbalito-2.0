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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuario SET nombre=%s, usuario=%s, password=%s, celular=%s, estado=%s, `admin`=%s WHERE id_usuario=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['celular'], "int"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['admin'], "int"),
                       GetSQLValueString($_POST['id_usuario'], "int"));

  mysql_select_db($database_yerbalito, $yerbalito);
  $Result1 = mysql_query($updateSQL, $yerbalito) or die(mysql_error());

  $updateGoTo = "listado_usuarios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varDato_DatosUsuario = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosUsuario = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosUsuario = sprintf("SELECT * FROM usuario WHERE usuario.id_usuario = %s", GetSQLValueString($varDato_DatosUsuario, "int"));
$DatosUsuario = mysql_query($query_DatosUsuario, $yerbalito) or die(mysql_error());
$row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
$totalRows_DatosUsuario = mysql_num_rows($DatosUsuario);
?>
<?php include('seguridad.php'); ?> 


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
			
            
            
            <div align="center">
		  <img src="images/logo.png" alt="yerbalito" width="200" height="200" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" >        
        </div>
        
			<!-- ENDS Social -->
			
			<!-- Navigation --><!-- Navigation -->	
			
			<!-- search --><!-- ENDS search -->
			
			<!-- Breadcrumb--><!-- ENDS Breadcrumb-->	

		</div>
		<!-- ENDS HEADER -->		
        
      <script>
function subirimagen(nombrecampo)
{
	self.name = 'opener';
	remote = open('gestionimagen.php?campo='+nombrecampo, 'remote', 'width=400,height=150,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes');
 	remote.focus();
	}
</script>        
	
   	  <!-- MAIN -->
	  <div id="main"> 
	    <p>Modificar Usuario: </p>
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center">
            <tr valign="baseline">
              <td nowrap align="right">Id_usuario:</td>
              <td><?php echo $row_DatosUsuario['id_usuario']; ?></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Nombre:</td>
              <td><input type="text" name="nombre" value="<?php echo htmlentities($row_DatosUsuario['nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Usuario:</td>
              <td><input type="text" name="usuario" value="<?php echo htmlentities($row_DatosUsuario['usuario'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Password:</td>
              <td><input type="text" name="password" value="<?php echo htmlentities($row_DatosUsuario['password'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Celular:</td>
              <td><input type="text" name="celular" value="<?php echo htmlentities($row_DatosUsuario['celular'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Estado:</td>
              <td><select name="estado">
		  <option value=""  
                
               <?php if (!(strcmp("", $row_DatosUsuario['estado']))) {echo "selected=\"selected\"";} ?>>          
		  <option value="0" <?php if (!(strcmp(0, $row_DatosUsuario['estado']))) {echo "selected=\"selected\"";} ?>>No activo</option>
		  <option value="1" <?php if (!(strcmp(1, $row_DatosUsuario['estado']))) {echo "selected=\"selected\"";} ?>>Activo</option>
		  <?php
do {  
?>
		  <option value="<?php echo $row_DatosUsuario['estado']?>"<?php if (!(strcmp($row_DatosUsuario['estado'], $row_DatosUsuario['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DatosUsuario['estado']?></option>
		  <?php
} while ($row_DatosUsuario = mysql_fetch_assoc($DatosUsuario));
  $rows = mysql_num_rows($DatosUsuario);
  if($rows > 0) {
      mysql_data_seek($DatosUsuario, 0);
	  $row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
  }
?>
        </select></td>
            </tr>
            
            
             
            
            
            <tr valign="baseline">
              <td nowrap align="right">Admin:</td>
              <td><select name="admin">
		  <option value=""  
                
               <?php if (!(strcmp("", $row_DatosUsuario['admin']))) {echo "selected=\"selected\"";} ?>>          
		  <option value="0" <?php if (!(strcmp(0, $row_DatosUsuario['admin']))) {echo "selected=\"selected\"";} ?>>NO</option>
		  <option value="1" <?php if (!(strcmp(1, $row_DatosUsuario['admin']))) {echo "selected=\"selected\"";} ?>>SI</option>
		  <?php
do {  
?>
		  <option value="<?php echo $row_DatosUsuario['admin']?>"<?php if (!(strcmp($row_DatosUsuario['admin'], $row_DatosUsuario['admin']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DatosUsuario['admin']?></option>
		  <?php
} while ($row_DatosUsuario = mysql_fetch_assoc($DatosUsuario));
  $rows = mysql_num_rows($DatosUsuario);
  if($rows > 0) {
      mysql_data_seek($DatosUsuario, 0);
	  $row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
  }
?>
        </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Actualizar registro"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form1">
          <input type="hidden" name="id_usuario" value="<?php echo $row_DatosUsuario['id_usuario']; ?>">
        </form>
        <p>&nbsp;</p>
<p>&nbsp;</p>
        
        <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion"></a> 


		 <a href="listado_usuarios.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al listado de usuarios"></a>

         
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
mysql_free_result($DatosUsuario);

mysql_free_result($Datosusuarios);
?>
