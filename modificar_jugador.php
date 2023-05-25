<?php require_once('Connections/yerbalito.php'); 

 include('seguridad.php'); 

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE jugador SET nombre=%s, apellido=%s, fecha_nacimiento=%s, cedula=%s, imagen=%s, padre=%s, madre=%s, contacto=%s, fecha_ingreso=%s, idcategoria=%s, idestado=%s, observacionesJugador=%s, numeroClub=%s, sexo=%s, ciudadania=%s WHERE idjugador=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['imagen'], "text"),
                       GetSQLValueString($_POST['padre'], "text"),
                       GetSQLValueString($_POST['madre'], "text"),
                       GetSQLValueString($_POST['contacto'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
                       GetSQLValueString($_POST['idcategoria'], "int"),
                       GetSQLValueString($_POST['idestado'], "int"),
                       GetSQLValueString($_POST['observacionesJugador'], "text"),
					   
					   GetSQLValueString($_POST['numeroClub'], "text"),
				       GetSQLValueString($_POST['sexo'], "text"),
					   GetSQLValueString($_POST['ciudadania'], "text"),
				
                       GetSQLValueString($_POST['idjugador'], "int"));

  mysql_select_db($database_yerbalito, $yerbalito);
  $Result1 = mysql_query($updateSQL, $yerbalito) or die(mysql_error());

  $updateGoTo = "listado_jugadores.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varDato_DatosJugador = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosJugador = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = sprintf("SELECT * FROM jugador WHERE jugador.idjugador = %s", GetSQLValueString($varDato_DatosJugador, "int"));
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosCategoria = sprintf("SELECT nombre_categoria FROM categoria WHERE categoria.idcategoria ='{$row_DatosJugador['idcategoria']}'");
$DatosCategoria = mysql_query($query_DatosCategoria, $yerbalito) or die(mysql_error());
$row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
$totalRows_DatosCategoria = mysql_num_rows($DatosCategoria);

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosEstado = sprintf("SELECT tipo_estado FROM estado WHERE estado.idestado ='{$row_DatosJugador['idestado']}'");
$DatosEstado = mysql_query($query_DatosEstado, $yerbalito) or die(mysql_error());
$row_DatosEstado = mysql_fetch_assoc($DatosEstado);
$totalRows_DatosEstado = mysql_num_rows($DatosEstado);

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
/**
 * Funcion que devuelve true o false dependiendo de si la fecha es correcta.
 * Tiene que recibir el dia, mes y año
 */
function isValidDate(day,month,year)
{
    var dteDate;
 
    // En javascript, el mes empieza en la posicion 0 y termina en la 11 
    //   siendo 0 el mes de enero
    // Por esta razon, tenemos que restar 1 al mes
    month=month-1;
    // Establecemos un objeto Data con los valore recibidos
    // Los parametros son: año, mes, dia, hora, minuto y segundos
    // getDate(); devuelve el dia como un entero entre 1 y 31
    // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
    //   martes, miercoles ...
    // getHours(); Devuelve la hora
    // getMinutes(); Devuelve los minutos
    // getMonth(); devuelve el mes como un numero de 0 a 11
    // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
    //   de enero de 1970 hasta el momento definido en el objeto date
    // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
    // getYear(); devuelve el año
    // getFullYear(); devuelve el año
    dteDate=new Date(year,month,day);
 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}
 
/**
 * Funcion para validar una fecha
 * Tiene que recibir:
 *  La fecha en formato ingles yyyy-mm-dd
 * Devuelve:
 *  true-Fecha correcta
 *  false-Fecha Incorrecta
 */
function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}
 
/**
 * Esta función calcula la edad de una persona y los meses
 * La fecha la tiene que tener el formato yyyy-mm-dd que es
 * metodo que por defecto lo devuelve el <input type="date">
 */
function calcularEdad()
{
    var fecha=document.getElementById("fecha_nacimiento").value;
    
        // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];
 
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth()+1;
        var ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < mes )
        {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }
        if (edad > 1900)
        {
            edad -= 1900;
        }
 
        // calculamos los meses
        var meses=0;
        if(ahora_mes>mes)
            meses=ahora_mes-mes;
        if(ahora_mes<mes)
            meses=12-(mes-ahora_mes);
        if(ahora_mes==mes && dia>ahora_dia)
            meses=11;
 
        // calculamos los dias
        var dias=0;
        if(ahora_dia>dia)
            dias=ahora_dia-dia;
        if(ahora_dia<dia)
        {
            ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
            dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
        }

//selecciono la categoria que corresponda, segun el año
		 //si estamos en enero o febrero, veo cuando cumple el niño
		var edadCategoria=edad;
		if (((12 - meses) + ahora_mes) <= 12) 
		{edadCategoria = edad + 1} //le sumo un año para contarlo en la categoria sig			
				
		//selecciono la categoria correspondiente a esa edad
		if (edadCategoria<=6)
		{ document.forms["form2"]["idcategoria"].value = 1}
		else if (edadCategoria==7)
		{ document.forms["form2"]["idcategoria"].value = 2}
		else if (edadCategoria==8)
		{ document.forms["form2"]["idcategoria"].value = 3}
		else if (edadCategoria==9)
		{ document.forms["form2"]["idcategoria"].value = 4}
		else if (edadCategoria==10)
		{ document.forms["form2"]["idcategoria"].value = 5}
		else if (edadCategoria==11)
		{ document.forms["form2"]["idcategoria"].value = 6}
		else if (edadCategoria==12)
		{ document.forms["form2"]["idcategoria"].value = 7}
		else if (edadCategoria==13)
		{ document.forms["form2"]["idcategoria"].value = 8}
 
 //no muestro la variable dias

        document.getElementById("result").innerHTML=edad+" años y "+meses+" meses";
//		document.getElementById("result").innerHTML="Tienes "+ano+" años y "+mes+" meses";
		
    }	
	
</script>
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
	  <div id="main"> Modificar Jugador:
        
        <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Id del jugador:</td>
          <td><?php echo $row_DatosJugador['idjugador']; ?></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Nombre:</td>
          <td><input type="text" name="nombre" value="<?php echo htmlentities($row_DatosJugador['nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Apellido:</td>
          <td><input type="text" name="apellido" value="<?php echo htmlentities($row_DatosJugador['apellido'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Cedula:</td>
          <td><input type="text" name="cedula" value="<?php echo htmlentities($row_DatosJugador['cedula'], ENT_COMPAT, 'utf-8'); ?>" size="32">(sin puntos ni guiones)</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Fecha de nacimiento:</td>
          <td><input type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo htmlentities($row_DatosJugador['fecha_nacimiento'], ENT_COMPAT, 'utf-8'); ?>" size="32">
           <!-- al seleccionar la fecha de nacimiento, coloco automaticamente la categoria que pertenece -->
 
 		<input type="button" value="Edad y Categoría" onclick="javascript:calcularEdad();" >
        <a id="result"> </a>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Sexo(F/M):</td>
          <td><input type="text" name="sexo" value="<?php echo htmlentities($row_DatosJugador['sexo'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Numero de Jugador:</td>
          <td><input type="text" name="numeroClub" value="<?php echo htmlentities($row_DatosJugador['numeroClub'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap align="right">Imagen:</td>
          <td><input type="text" name="imagen" value="<?php echo htmlentities($row_DatosJugador['imagen'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Fecha de ingreso:</td>
          <td><input type="text" name="fecha_ingreso" value="<?php echo htmlentities($row_DatosJugador['fecha_ingreso'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Idcategoria:</td>
          <td><input type="text" name="idcategoria" value="<?php echo htmlentities($row_DatosJugador['idcategoria'], ENT_COMPAT, 'utf-8'); ?>" size="32" > <?php echo $row_DatosCategoria['nombre_categoria'];?> </td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Idestado:</td>
          <td><input type="text" name="idestado" value="<?php echo htmlentities($row_DatosJugador['idestado'], ENT_COMPAT, 'utf-8'); ?>" size="32"> <?php echo $row_DatosEstado['tipo_estado'];?></td>
        </tr>
            
        
         <tr valign="baseline">
          <td nowrap align="right">Ciudadania:</td>
          <td><input type="text" name="ciudadania" value="<?php echo htmlentities($row_DatosJugador['ciudadania'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Padre:</td>
          <td><input type="text" name="padre" value="<?php echo htmlentities($row_DatosJugador['padre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Madre:</td>
          <td><input type="text" name="madre" value="<?php echo htmlentities($row_DatosJugador['madre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Contacto:</td>
          <td><input type="text" name="contacto" value="<?php echo htmlentities($row_DatosJugador['contacto'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        
        
        <tr valign="baseline">
          <td nowrap align="right">Observaciones:</td>
          <td><input type="text" name="observacionesJugador" value="<?php echo htmlentities($row_DatosJugador['observacionesJugador'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Actualizar registro"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form2">
      <input type="hidden" name="idjugador" value="<?php echo $row_DatosJugador['idjugador']; ?>">
    </form>
    <p>&nbsp;</p>
        
        
      </div>
		<!-- ENDS MAIN -->

	  <!-- FOOTER -->
	<div id="footer">				
	  <!-- footer-cols -->				<!-- ENDS footer-cols -->				
	  <!-- Bottom -->
      <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion"></a> <a href="listado_jugadores.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al listado de Jugadores"></a> 
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
mysql_free_result($DatosJugador);
?>
