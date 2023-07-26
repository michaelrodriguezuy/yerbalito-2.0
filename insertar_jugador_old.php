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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//' " . ($_POST['fecha'])  . date("Y/m/d ") . " '
//$fechaActual= $_POST['fecha']  . date("Y/m/d ");
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jugador (nombre, apellido, fecha_nacimiento, cedula, imagen, padre, madre, contacto, fecha_ingreso, idcategoria, observacionesJugador, numeroClub, sexo, ciudadania) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['foto'], "text"),
                       GetSQLValueString($_POST['padre'], "text"),
                       GetSQLValueString($_POST['madre'], "text"),
                       GetSQLValueString($_POST['contacto'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
                       GetSQLValueString($_POST['idcategoria'], "int"),
                       GetSQLValueString($_POST['observacionesJugador'], "text"),
					   GetSQLValueString($_POST['numeroClub'], "int"),
                       GetSQLValueString($_POST['sexo'], "text"),
					   GetSQLValueString($_POST['ciudadania'], "text"));

  mysql_select_db($database_yerbalito, $yerbalito);
  $Result1 = mysql_query($insertSQL, $yerbalito) or die(mysql_error());

  $insertGoTo = "listado_jugadores.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosCategoria = "SELECT * FROM categoria";
$DatosCategoria = mysql_query($query_DatosCategoria, $yerbalito) or die(mysql_error());
$row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
$totalRows_DatosCategoria = mysql_num_rows($DatosCategoria);
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
        
        
        <!-- calcuo de edad -->
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
		{ document.forms["form1"]["idcategoria"].value = 1}
		else if (edadCategoria==7)
		{ document.forms["form1"]["idcategoria"].value = 2}
		else if (edadCategoria==8)
		{ document.forms["form1"]["idcategoria"].value = 3}
		else if (edadCategoria==9)
		{ document.forms["form1"]["idcategoria"].value = 4}
		else if (edadCategoria==10)
		{ document.forms["form1"]["idcategoria"].value = 5}
		else if (edadCategoria==11)
		{ document.forms["form1"]["idcategoria"].value = 6}
		else if (edadCategoria==12)
		{ document.forms["form1"]["idcategoria"].value = 7}
		else if (edadCategoria==13)
		{ document.forms["form1"]["idcategoria"].value = 8}
 
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
		
        
        <!-- aca va javascript para subir imagenes-->
      <script>
function subirimagen(nombrecampo)
{
	self.name = 'opener';
	remote = open('gestionimagen.php?campo='+nombrecampo, 'remote', 'width=400,height=150,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes');
 	remote.focus();
	}

</script>
        
	
    	<!-- MAIN -->
	  <div id="main"> Insertar Jugador:
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center">
          
            <tr valign="baseline">
              <td nowrap align="right">Nombre:</td>
              <td><input type="text" name="nombre" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Apellido:</td>
              <td><input type="text" name="apellido" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Cedula:</td>
              <td><input type="text" name="cedula" value="" size="32"> (sin puntos ni guiones)</td>         
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Fecha de nacimiento:</td>
              
              <td><input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="2017/04/17" size="32" onChange="javascript:calcularEdad();">
              <a id="result"> </a>
              <!-- al seleccionar la fecha de nacimiento, coloco automaticamente la categoria que pertenece -->
 
 <!--
 		<input type="button" value="Edad y Categoría" onclick="javascript:calcularEdad();" >
        <a id="result"> </a>
     -->         
              </td>
            </tr>
            
            <tr valign="baseline">
              <td nowrap align="right">Sexo(F/M):</td>
              <td><select name="sexo" size="1">
                <option selected="selected"></option>
                <option>Femenino</option>
                <option>Masculino</option>
          </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Numero de Jugador:</td>
              <td><input type="text" name="numeroClub" value="" size="32"></td>
            </tr>
            
            
            <tr valign="baseline">
              <td nowrap align="right">Foto:</td>
              <td><input type="text" name="foto" value="user.jpg" size="32">
              <input type="button" name="button2" id="button2" value="Subir Imagen" onClick="javascript:subirimagen('foto');"/></td>
            </tr>           
            <tr valign="baseline">
              <td nowrap align="right">Fecha de ingreso:</td>
              <td><input type="date" name="fecha_ingreso" value="2017/04/17" size="32"></td>
            </tr>
            
            <td nowrap align="right">Categoria:</td>
          
          <td> <select name="idcategoria" id="idcategoria">
          <option value=""  <?php if (!(strcmp("", $row_DatosCategoria['nombre_categoria']))) {echo "selected=\"selected\"";} ?>> </option>
            <?php
do {  
?>
            <option value="<?php echo $row_DatosCategoria['idcategoria']?>"<?php if (!(strcmp($row_DatosCategoria['idcategoria'], $row_DatosCategoria['nombre_categoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DatosCategoria['nombre_categoria']?></option>
            <?php
} while ($row_DatosCategoria = mysql_fetch_assoc($DatosCategoria));
  $rows = mysql_num_rows($DatosCategoria);
  if($rows > 0) {
      mysql_data_seek($DatosCategoria, 0);
	  $row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
  }
?>
          </select>
          </td>
            
            <tr valign="baseline">
              <td nowrap align="right">Ciudadania:</td>
              <td><input type="text" name="ciudadania" value="" size="32"></td>
            </tr>
            
            <tr valign="baseline">
              <td nowrap align="right">Padre:</td>
              <td><input type="text" name="padre" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Madre:</td>
              <td><input type="text" name="madre" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Contacto:</td>
              <td><input type="text" name="contacto" value="" size="32"></td>
           </tr>            
        <tr valign="baseline">
              <td nowrap align="right">Observaciones:</td>
              <td><input type="text" name="observacionesJugador" value="" size="100%"></td>
            </tr>
        
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Insertar registro"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
        <p>&nbsp;</p>



      </div>
		<!-- ENDS MAIN -->

  	  <!-- FOOTER -->
<div id="footer">
				<a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion" ></a> <a href="listado_jugadores.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al Panel de control"></a>
				<!-- footer-cols -->				<!-- ENDS footer-cols -->
				
				<!-- Bottom -->
				<div id="bottom">
				<a href="http://yerbalito.olimarteam.com/yerbalito" >Gestion Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.com">olimarteam.com</a></div>
				<!-- ENDS Bottom -->
	  </div>
		<!-- ENDS FOOTER -->
	
	</div>
	<!-- ENDS WRAPPER -->
    
    Usuario: <?php echo $_SESSION["nombre"]; ?>
    </body>
	
</html>
<?php
mysql_free_result($DatosCategoria);
?>
