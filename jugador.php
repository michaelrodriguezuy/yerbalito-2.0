<?php require_once('Connections/yerbalito.php');
   include('session.php'); //esto lo uso para dar la bienvenida y para cerrar sesion

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
    var fecha= "<?php echo $row_DatosJugador['fecha_nacimiento']; ?>";
    
	
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
 
 //no muestro la variable dias
        document.getElementById("result").innerHTML=edad+" años y "+meses+" meses";
//		document.getElementById("result").innerHTML="Tienes "+ano+" años y "+mes+" meses";
		
    }	
	
	function muestraPagos()
	{
		document.getElementById("result2").innerHTML=12+" años y "+1+" meses";
	}
	
  function imprimirpagina()
  {
    window.print();
  }

</script>


	</head>
	
	<body class="">
	
	
	<!-- WRAPPER -->
	<div id="wrapper">
		
		<!-- HEADER -->
	  <div id="header"><!-- Social -->
			<div align="center">
		  <img src="images/logo3.png" alt="yerbalito" class="header" longdesc="images/logo3.png" hspace="0" vspace="0" border="0" >        
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
	      <h1> Datos del Jugador: </h1>
               
               
               
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
    <td>Cedula</td>
    <td><?php echo $row_DatosJugador['cedula']; ?></td>
  </tr> 
  <tr>
    <td>Fecha de nacimiento</td>
    <td><?php echo $row_DatosJugador['fecha_nacimiento']; ?> 
    <input type="button" value="Calcula edad" onclick="javascript:calcularEdad();" >
        <a id="result"> </a> 
        </td>
  </tr>
  <tr>
    <td>Sexo</td>
    <td><?php echo $row_DatosJugador['sexo']; ?></td>
  </tr>
  <tr>
    <td>Número de Jugador</td>
    <td><?php echo $row_DatosJugador['numeroClub']; ?>
        <?php if ($row_DatosJugador['numeroClub']==0) {
           echo " - JUGADOR NO FICHADO";
		}		
		?>
    </td>
  </tr>
  
  <tr>
    <td>Foto</td>
    <td><img src="/yerbalito/images/<?php echo $row_DatosJugador['imagen']; ?>"></td>
  </tr> 
  <tr>
    <td>Fecha de ingreso</td>
    <td><?php echo $row_DatosJugador['fecha_ingreso']; ?></td>
  </tr>
  <tr>
    <td>Categoria</td>
    <td><?php echo $row_DatosJugador['nombre_categoria']; ?></td>
  </tr>
  <tr>
    <td scope="row">Estado/Pagos</td>
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
    <td scope="row">Ciudadania</td>
    <td><?php echo $row_DatosJugador['ciudadania']; ?></td>
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
  
  <tr>
    <td scope="row">Observaciones</td>
    <td><?php echo $row_DatosJugador['observacionesJugador']; ?></td>
  </tr>  
  
    <tr >    
		<td align="center">
    
     <a href="pagos_jugador.php?recordID=<?php echo $row_DatosJugador['idjugador']; ?>" target="_blank" type="text" value=""> VER PAGOS DEL JUGADOR </a>

	    </td>
	 </tr>    
  
</table>
 <tr align="center"> 
   <td>
   
    <?php if($_SESSION["admin"] != 2) {
		?>
      <a href="modificar_jugador.php?recordID=<?php echo $row_DatosJugador['idjugador']; ?>"><img src="img/knobs-icons/Knob Smart.png" width="32" height="32" border="0" title="Modificar jugador"></a>  
      <a href="eliminar_jugador.php?recordID=<?php echo $row_DatosJugador['idjugador']; ?>"><img src="img/knobs-icons/Knob Remove.png" width="32" height="32" onClick="javascript:return asegurar();" title="Eliminar jugador"></a> 
      
      <a href=""><img src="img/knobs-icons/Knob Download.png" width="32" height="32" onclick="imprimirpagina();" title="Imprimir jugador"></a> 


      <?php ;} ?>
      
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
