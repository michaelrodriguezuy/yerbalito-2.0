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

/*$checkboxes = "'" . implode("','", $_POST['mes_pago']) . "'";*/
//$checkboxes = "'" . implode(',', $_POST['mes_pago']) . "'";
$mes_pago = $_POST['mes_pago'];

if (isset($_REQUEST['check1']))
  {
    $cant++;
  }


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO recibo (idrecibo, numero, mes_pago, monto, fecha_recibo, idjugador, idlibreta, anio, observacionesRecibo) VALUES (%s, %s, $mes_pago, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idrecibo'], "int"),
                       GetSQLValueString($_POST['numero'], "int"),
                       /*GetSQLValueString($_POST['mes_pago'], "int"),*/
                       GetSQLValueString($_POST['monto'], "double"),
                       GetSQLValueString($_POST['fecha_recibo'], "date"),
                       GetSQLValueString($_POST['idjugador'], "int"),
                       GetSQLValueString($_POST['idlibreta'], "int"),
                       GetSQLValueString($_POST['anio'], "int"),
                       GetSQLValueString($_POST['observacionesRecibo'], "text"));

  mysql_select_db($database_yerbalito, $yerbalito);
  $Result1 = mysql_query($insertSQL, $yerbalito) or die(mysql_error());

  $insertGoTo = "listado_recibos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = "SELECT * FROM jugador";
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosLibreta = "SELECT * FROM libretas";
$DatosLibreta = mysql_query($query_DatosLibreta, $yerbalito) or die(mysql_error());
$row_DatosLibreta = mysql_fetch_assoc($DatosLibreta);
$totalRows_DatosLibreta = mysql_num_rows($DatosLibreta);




/* recorro los meses que pagó el jugador, si tiene todos los meses pagos, este inclusive,
cambio su estado a 2, luego recorro el estado de todos los jugadores de esa categoria, si todos estan en 2, cambio la categoria a 6 */

$hoy=getdate();

function revisaMesesPagos() 
{ 
$idJugadorPago = $row_DatosJugador['idjugador'];
/*
mysql_select_db($database_yerbalito, $yerbalito);
$result= $mysql_query("SELECT * FROM jugador WHERE idjugador= $idJugadorPago", $yerbalito);
/* me da todos los datos del jugador que pagó. 
de aca cambio el estado, si esta al dia, */

$mysqli = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or die("No se pudo conectar: " . mysql_error());
	
/* traigo todos los recibos del jugador que acaba de pagar, de este año*/
$result = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador = $idJugadorPago AND recibo.anio = $hoy[year]");

/*reviso todos los meses que pago
echo str_replace(',', '<br />', $checkboxes);

CON ESTE CODIGO REEMPLAZO LAS COMAS POR UN ENTER, Y ASI OBTENGO EL MES PAGO
*/
$mesespagos = $result["mes_pago"];
$arrayMeses = array();

if (strlen($mesespagos)>0) {
/*$arrayMeses = str_split($mesespagos, 2); GUARDA DE A 2 STRING EN EL ARRAY*/ 

	if (substr_count($mesespagos, ',')==0)
	{ /*si entro aca es porque pagó 1 mes solo*/
		if (($mesespagos==1) AND ($hoy[mon]==1)) { /* si es enero, y estamos en enero, esta al dia*/
		$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador= $idJugadorPago");			
		}
	}else 
	{/*si entro aca es porque pagó mas de 1 mes*/
		$arrayMeses = explode(",", $mesespagos); /* USA EL SEPARADOR COMA Y GUARDA EN EL   
		ARRAY LO QUE ESTA ANTES Y DESPUES */
		$contadormeses = 1;
		$i = 0;
		while (($i <= count($arrayMeses)) AND ($contadormeses <= $hoy[mon]))
		{	
			if ($array[$i]==$contadormeses)
			{							
				$contadormeses+=1;							
			}	
			$i+=1;									
		}
		if ($contadormeses>$hoy[month])
		{ /*si entro aca es porque esta al dia*/
			$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador=$idJugadorPago");	
		}
	}
	
  }

$categoria = $result["idcategoria"];

}
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



<!-- javascript que recibe el dato del boton y se lo manda a una funcion php-->

<script type="text/javascript">

function revisaMesesPagos()
{
	alert(<?php revisaMesesPagos(); ?>);
}


//var checkboxes =  document.getElementsByTagName("mes_pago")
//var checkboxes = document.getElementById("form1").checkbox
var checkboxes = document.getElementsByName("mes_pago");
//var checkboxes = form1.checkbox;

function contar() 
{

var cont = 0;
//var checkboxes = document.getElementById("mes_pago");
 
	
 
	for (var x=0; x < checkboxes.length; x++) {
	 if (checkboxes[x].checked) {
	  cont = cont + 1;
	 }
	}

document.getElementById("monto").value = 200 * cont;		
	
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
   
        
	
   	  <!-- MAIN -->
	  <div id="main"> Insertar recibo:
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center">
            
            <tr valign="baseline">
              <td nowrap align="right">Numero de recibo:</td>
              <td><input type="text" name="numero" value="" size="32">  </td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Mes de pago:</td>
              <td align="left">              
             
              <table width="100">
                <tr>
                
                  <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" onClick="javascript:contar();">
                    Enero</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" onClick="javascript:contar();">
                    Febrero</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" onClick="javascript:contar();">
                    Marzo </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" onClick="javascript:contar();">
                    Abril </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" onClick="javascript:contar();">
                    Mayo </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" onClick="javascript:contar();">
                    Junio </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" onClick="javascript:contar();">
                    Julio </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" onClick="javascript:contar();">
                    Agosto </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" onClick="javascript:contar();">
                    Setiembre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" onClick="javascript:contar();">
                    Octubre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" onClick="javascript:contar();">
                    Noviembre </label></td>
                </tr>
                <tr>
                  <td><label>
                  <!-- en el caso de no usar algun mes, pongo disabled="disabled" -->
                    <input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" onClick="javascript:contar();">
                    Diciembre </label></td>
                </tr>
              </table>
                                                      
              </td>
              
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Año de pago:</td>
              <td><input type="text" name="anio" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Monto:</td>
              <!-- calculo la cantidad de meses marcados *200 y lo pongo en value-->
              <td>
              <input type="text" name="monto" id="monto" value="" size="32">        
				
            </td>
 
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Fecha de recibo:</td>
              <td><input type="date" name="fecha_recibo" value="2017/04/17" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Jugador:</td>
              <td><select name="idjugador">
          <option value=""  <?php if (!(strcmp("", $row_DatosJugador['nombre']))) {echo "selected=\"selected\"";} ?>> </option>
            <?php
do {  
?>
            <option value="<?php echo $row_DatosJugador['idjugador']?>"<?php if (!(strcmp($row_DatosJugador['idjugador'], $row_DatosJugador['nombre']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DatosJugador['nombre']?> <?php echo $row_DatosJugador['apellido']?></option>
            <?php
} while ($row_DatosJugador = mysql_fetch_assoc($DatosJugador));
  $rows = mysql_num_rows($DatosJugador);
  if($rows > 0) {
      mysql_data_seek($DatosJugador, 0);
	  $row_DatosJugador = mysql_fetch_assoc($DatosJugador);
  }
?>
          </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Numeracion de libreta:</td>
              <td><select name="idlibreta">
          <option value=""  <?php if (!(strcmp("", $row_DatosLibreta['numeracion']))) {echo "selected=\"selected\"";} ?>> </option>
            <?php
do {  
?>
            <option value="<?php echo $row_DatosLibreta['idlibreta']?>"<?php if (!(strcmp($row_DatosLibreta['idlibreta'], $row_DatosLibreta['numeracion']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DatosLibreta['numeracion']?></option>
            <?php
} while ($row_DatosLibreta = mysql_fetch_assoc($DatosLibreta));
  $rows = mysql_num_rows($DatosLibreta);
  if($rows > 0) {
      mysql_data_seek($DatosLibreta, 0);
	  $row_DatosLibreta = mysql_fetch_assoc($DatosLibreta);
  }
?>
          </select></td>
            </tr>
<tr valign="baseline">
              <td nowrap align="right">Observaciones:</td>
              <td><input type="text" name="observacionesRecibo" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              
              
              <!--aca llamo a una function que cambie el estado del jugador -->
              <td><input type="submit" value="Insertar registro" onClick="revisaMesesPagos();"></td>
             
            
              
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
        <p>&nbsp;</p>
<p>&nbsp;</p>
      </div>
	  <!-- ENDS MAIN -->

  	  <!-- FOOTER -->
<div id="footer">
			<a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion" ></a> <a href="listado_recibos.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al Panel de control"></a>	
				<!-- footer-cols -->				<!-- ENDS footer-cols -->
				
				<!-- Bottom -->
				<div id="bottom">
				<a href="http://yerbalito.olimarteam.com/yerbalito" >Gestion Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.com">olimarteam.com</a>
                </div>
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

mysql_free_result($DatosLibreta);

mysql_free_result($DatosRecibo);
?>
