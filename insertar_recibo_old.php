<?php require_once('Connections/yerbalito.php');
      include('seguridad.php');
	  //include('funciones.php');	

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

/*$checkboxes = "'" . implode("','", $_POST['mes_pago']) . "'";
$checkboxes = "'" . implode(',', $_POST['mes_pago']) . "'";
$mes_pago = $_POST['mes_pago'];

if (isset($_REQUEST['check1']))
  {
    $cant++;
  }
*/

if(@$_POST['mes_pago'] !="")
	{
		if(is_array($_POST['mes_pago']))
			{
				while(list($key,$value) = each($_POST['mes_pago']))
					{
/*						$checkbox=mysql_query("INSERT INTO interes (id_usuario, interes) VALUES ('id' , '$value')",$con);*/
						
						if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 							{
  $insertSQL = sprintf("INSERT INTO recibo (idrecibo, numero, mes_pago, monto, fecha_recibo, idjugador, idlibreta, anio, observacionesRecibo) VALUES (%s, %s, $value, %s, %s, %s, %s, %s, %s)",
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









//refresco los datos antes de mostrar el listado de recibos actualizados
$jugadorQuePago = $_POST['idjugador'];
$mysqli = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
    die("No se pudo conectar: " . mysql_error());

//$banderaDeudores =0;
$hoy=getdate();

//		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
		$result = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador ='".$jugadorQuePago."' AND recibo.anio = $hoy[year]"); // traigo los recibos del jugador que pago en este año

	    $row_cnt = mysqli_num_rows($result);
		//PRUEBA	
		//$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt."' Where jugador.idjugador ='".$jugadorQuePago."'");
		
	/*
		if ($row_cnt < date("n")) { //si entro aca es porque el jugador no esta al dia		
		}

$result = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador =' ".$jugadorQuePago."' AND recibo.anio = $hoy[year]"); 
$contadormeses = 0;
if (count($result)>0) {
	$i = 0;
	while (($i <= count($result)) AND ($contadormeses <= date("n"))) {		
		$contadormeses+=1;							
		$i+=1;									
	}
}
*/
//AFINAR, Y PREGUNTAR SI ESTA DENTRO DE LOS 10 PRIMEROS DIAS DE PLAZO PARA ABONAR EL MES

if ($row_cnt>=date("n")) { /*si entro aca es porque esta al dia */
//	$mysqli->query("Update jugador Set observacionesJugador ='".$contadormeses."' Where jugador.idjugador ='".$jugadorQuePago."'");
	$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador ='".$jugadorQuePago."'");		

	$result3 = ("SELECT * FROM jugador WHERE jugador.idjugador ='".$jugadorQuePago."'");// saco los datos del jugador que pago, para saber de que categoria es

	$query_execute = $mysqli->query($result3);
	$query_result = $query_execute->fetch_array();
	$idCategoria = $query_result['idcategoria']; //HASTA ACA VAMOS BIEN

	//PRUEBA	
	//$mysqli->query("Update jugador Set observacionesJugador ='".$idCategoria."' Where jugador.idjugador ='".$jugadorQuePago."'");
	
	$result2 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."'"); //tengo todos los jugadores de esa categoria
	$row_cnt2 = $result2->num_rows;
	
	$result4 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."' AND jugador.idestado=2"); //tengo todos los jugadores de esa categoria que estan al dia
	$row_cnt4 = $result4->num_rows;
		
	if ($row_cnt2==$row_cnt4) { /*si entro aca es porque todos los jugadores de esa categoria estan al dia */
		$mysqli->query("Update categoria Set idestado=6 Where categoria.idcategoria =' ".$idCategoria."'");
	}
	else {
		$mysqli->query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$idCategoria."'"); 
	}		
}
elseif (($row_cnt+1==date("n")) AND (date("j")<=10)) //si es = a 1 mes anterior y no ha llegado al dia 10, esta al dia
{
	$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador ='".$jugadorQuePago."'");		

	$result3 = ("SELECT * FROM jugador WHERE jugador.idjugador ='".$jugadorQuePago."'");// saco los datos del jugador que pago, para saber de que categoria es

	$query_execute = $mysqli->query($result3);
	$query_result = $query_execute->fetch_array();
	$idCategoria = $query_result['idcategoria']; //HASTA ACA VAMOS BIEN

	//PRUEBA	
	//$mysqli->query("Update jugador Set observacionesJugador ='".$idCategoria."' Where jugador.idjugador ='".$jugadorQuePago."'");
	
	$result2 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."'"); //tengo todos los jugadores de esa categoria
	$row_cnt2 = $result2->num_rows;
	
	$result4 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."' AND jugador.idestado=2"); //tengo todos los jugadores de esa categoria que estan al dia
	$row_cnt4 = $result4->num_rows;
		
	if ($row_cnt2==$row_cnt4) { /*si entro aca es porque todos los jugadores de esa categoria estan al dia */
		$mysqli->query("Update categoria Set idestado=6 Where categoria.idcategoria =' ".$idCategoria."'");
	}
	else {
		$mysqli->query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$idCategoria."'"); 
	}		
}
else
{
	$mysqli->query("Update jugador Set idestado=1 Where jugador.idjugador =' ".$jugadorQuePago."'");
}



















  $insertGoTo = "listado_recibos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
							}
						
						
						
						
					} 
			} 
}





mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = "SELECT * FROM jugador ORDER BY apellido";
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador); 
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);

mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosLibreta = "SELECT * FROM libretas";
$DatosLibreta = mysql_query($query_DatosLibreta, $yerbalito) or die(mysql_error());
$row_DatosLibreta = mysql_fetch_assoc($DatosLibreta);
$totalRows_DatosLibreta = mysql_num_rows($DatosLibreta);






//lo uso para buscar los meses pagos del jugador seleccionado y ponerlos readonly
$row_cnt;

function devuelveMesesPagos() 
{
	$elJugador=$_POST['idjugador'];

	
  	$hostname_yerbalito = "localhost";
	$username_yerbalito = "wwwolima";
	$password_yerbalito = "rjW63u0I6n";	
	$database_yerbalito = "wwwolima_yerbalito";
	
	$con4 = mysql_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito) or
	die("problemas con el servidor");
	
	mysql_select_db($database_yerbalito) or die
	("problemas con la base");

//$banderaDeudores =0;
	$hoy2=getdate();

// traigo los recibos del jugador que pago en este año
$link6 = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
		$result9 = mysqli_query($link6, "SELECT * FROM recibo WHERE recibo.idjugador ='".$elJugador."' AND recibo.anio = $hoy2[year]");
	    /* determinar el número de filas del resultado */
	    $row_cnt9 = mysqli_num_rows($result9);





//PRUEBA	 hasta aca llegaaaaa
//mysql_query("Update jugador Set observacionesJugador='".$row_cnt9."' Where jugador.idjugador ='".$elJugador."'", $con4); 


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


<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>

<!--
<script src="jquery-3.2.1.min.js"></script>

 javascript que recibe el dato del boton y se lo manda a una funcion php-->
 
<script type="text/javascript">


/*
$(document).ready(function(){
		$('#btnguardar').click(function(){
			var miVariable = document.getElementById('idjugador').options.selectedIndex;
			$.ajax({
				type:"POST",
				url:"funciones.php",
				data:miVariable,
				success:function(r){
					if(r==1){
						alert("agregado con exito");
					}else{
						alert("Fallo el server");
					}
				}
			});

			return false;
		});
	});
*/



/*	ESTE VA
function revisaMesesPagos()
{
//	var idJugadorQuePago2 = document.getElementById('idjugadorQuePago').options.selectedIndex;
//	window.location.href = window.location.href + '?idJugadorQuePago3=' + idJugadorQuePago2;

	var miVariable = document.getElementById('idjugador').options.selectedIndex;
	
	window.location = setTimeout("'funciones.php?idjugador'= + miVariable",10000);

	
	
//x=1234;
//	location.href = pagina;
//	window.location = "funciones.php?jugadorQuePago=" + miVariable;
//document.getElementById('idjugador').src = "../funciones.php?miVariable="+miVariable;
//document.getElementById("idjugadorQuePago").href = "funciones.php?valordex="+miVariable;

//document.getElementById("idjugadorQuePago").href = "funciones.php?valordex="+encodeURIComponent(miVariable);
}
*/

//var checkboxes =  document.getElementsByTagName("mes_pago")
//var checkboxes = document.getElementById("form1").checkbox
var checkboxes = document.getElementsByName("mes_pago[]");
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


//HAY QUE ESTUDIARLO UN POCO MAS
function devuelveLibreta()
{
	var numeroRecibo = document.getElementsByName("numero");
	document.getElementsByName("idlibreta").value = 200 * cont;
}

function devuelveMesesPagos()
{
	//le paso a php el jugador que necesito que me arroje los meses pagos
	var elJugador=document.getElementById("idjugador").value;

	//PHP me da los meses que pago ese jugador
	<?php echo devuelveMesesPagos(); ?>;
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
              <td nowrap align="right">Jugador:</td>
              <td><select id="idjugador" name="idjugador"> 
          <option value=""  <?php if (!(strcmp("", $row_DatosJugador['nombre']))) {echo "selected=\"selected\"";} ?>> </option>
            <?php
do {  
?>
            <option value="<?php echo $row_DatosJugador['idjugador']?>"<?php if (!(strcmp($row_DatosJugador['idjugador'], $row_DatosJugador['nombre']))) {echo "selected=\"selected\"";} ?> onChange="javascript:devuelveMesesPagos();"><?php echo $row_DatosJugador['apellido']?> <?php echo $row_DatosJugador['nombre']?> </option>
            <?php
} while ($row_DatosJugador = mysql_fetch_assoc($DatosJugador));
  $rows = mysql_num_rows($DatosJugador);
  if($rows > 0) {
      mysql_data_seek($DatosJugador, 0);
	  $row_DatosJugador = mysql_fetch_assoc($DatosJugador);
  }
?>
          </select>
          </td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Numero de recibo:</td>
              <td><input type="text" name="numero" value="" size="32">  </td>
            </tr>                  
            <tr valign="baseline">
              <td nowrap align="right">Mes de pago:</td>
              <td align="left">     
              <table width="100">
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              
<?php    //al principio cuando muestro el form aca no voy a entrar porque vale 0, aca deberia entrar cuando selecciono un jugador, ahi cargaria los meses pagos, y chequea el que corresponda
?> 
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              
                <tr>                
                 <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" disabled onClick="javascript:contar();">
                    Enero</label></td>
                </tr>
              
                <?php if($_SESSION["admin"] == 1) {	?>                
               
					<tr>
                  <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" disabled onClick="javascript:contar();">
                    Febrero</label></td>
                </tr>
				<?php ;
	  } else { ?>
		  					<tr>
                  <td><label>
                    <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1"  onClick="javascript:contar();">
                    Febrero</label></td>
                </tr>
<?php	  }
               ?>   
                
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
              <td><input type="text" name="anio" value="2018" size="32"></td>
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
              <td><input type="submit" value="Insertar registro" > 
              </td>
              
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form >
        
       
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
