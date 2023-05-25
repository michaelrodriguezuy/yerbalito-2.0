<?php require_once('Connections/yerbalito.php');
      include('seguridad.php');
	  //include('funciones.php');	
mysql_set_charset('utf8');

date_default_timezone_set('America/Montevideo');
date_default_timezone_set($timezone);
$today = date("Y-m-d");

$monto_recibo=0;
$elJugador=0;
$observaciones_recibo="";
$precio_confirmado=0;
$impreso=0;
$anio2=0;

$pago_febrero=0;
$pago_marzo=0;
$pago_abril=0;
$pago_mayo=0;
$pago_junio=0;
$pago_julio=0;
$pago_agosto=0;
$pago_setiembre=0;
$pago_octubre=0;
$pago_noviembre=0;
$pago_diciembre=0;

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

/*$checkboxes = "'" . implode("','", $_POST['mes_pago']) . "'";
$checkboxes = "'" . implode(',', $_POST['mes_pago']) . "'";
$mes_pago = $_POST['mes_pago'];

if (isset($_REQUEST['check1']))
  {
    $cant++;
  }
*/
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

$pagosDelAnioActual="";

$valor="";
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = "SELECT * FROM jugador ORDER BY apellido ASC";
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);

if (isset($_GET['monto'])) {
	$monto_recibo=	$_GET['monto'];
}
else { $monto_recibo=0; }

if (isset($_GET['elJugador'])) {
	$elJugador=	$_GET['elJugador'];
	
	$mysqli8 = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
    die("No se pudo conectar: " . mysql_error());

//$banderaDeudores =0;
$fechaActual=getdate();


//		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
//		$result = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador = 125 AND recibo.anio = $hoy[year]");
		$pagosDelAnioAnterior = mysqli_query($mysqli8, "SELECT * FROM recibo WHERE recibo.idjugador ='".$elJugador."' AND recibo.anio = $fechaActual[year]-1"); // traigo los recibos del jugador que pago el año anterior

		$pagosDelAnioActual = mysqli_query($mysqli8, "SELECT * FROM recibo WHERE recibo.idjugador ='".$elJugador."' AND recibo.anio = $fechaActual[year]"); // traigo los recibos del jugador que pago en este año
//		$debe_anio_anterior=false;

        		
	  	$contadorDeudaAnterior = mysqli_num_rows($pagosDelAnioAnterior);
		
//EL AÑO 2021 SE COBRARON 7 PAGOS (recibos con monto > 0) Aqui hay 5 recibos al menos con monto 0
//EL AÑO 2022 SE COBRARON 9 PAGOS (recibos con monto > 0) Aqui hay 7 recibos al menos con monto 0
		if ( ($contadorDeudaAnterior>0) AND ($contadorDeudaAnterior<12) ) {
			//si entra aca quiere decir que tiene pagos del mes anterior pero no todos.			
	  		 $totalPagos = mysqli_num_rows($pagosDelAnioAnterior);
			 $debe_anio_anterior=1;
		}else {
	  		 $totalPagos = mysqli_num_rows($pagosDelAnioActual);
			  $debe_anio_anterior=2;
  	 		  
		}
   // echo $contadorDeudaAnterior;
}

else { $elJugador=0; }
/*
$ruta='http://www.olimarteam.uy/yerbalito/insertar_recibo.php';
header(sprintf("Location:", $ruta));
}


function sele($var,$val) {
    if($var==$val){
        return "selected";
    }
} 

print ("
<select id=".$elJugador.">
  <option value='".$elJugador."' ".sele($elJugador,$elJugador).">".$elJugador."</option>
</select>
"); */

mysql_select_db($database_yerbalito, $yerbalito);
$query_datosRecibos = "SELECT * FROM recibo WHERE visible=1 ORDER BY idrecibo DESC";
$datosRecibos = mysql_query($query_datosRecibos, $yerbalito) or die(mysql_error());
$row_datosRecibos = mysql_fetch_assoc($datosRecibos);
$totalRows_datosRecibos = mysql_num_rows($datosRecibos);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if (isset($_SESSION['id_usuario'])) {
	$idusuario = $_SESSION['id_usuario'];
}
else
{
	$idusuario =2;
}

$BANDERAWHILERECIBOSAUTOMATICOS=0;

if(@$_POST['mes_pago'] !="")
{
  if(is_array($_POST['mes_pago']))
  {
    while(list($key,$value) = each($_POST['mes_pago']))
    {
          /* $checkbox=mysql_query("INSERT INTO interes (id_usuario, interes) VALUES ('id' , '$value')",$con);*/
              
    	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 							
      {
        $insertSQL = sprintf("INSERT INTO recibo (idrecibo, numero, mes_pago, monto, fecha_recibo, idjugador, idlibreta, anio, observacionesRecibo, idusuario) VALUES (%s, %s,      $value, %s, %s, $elJugador, 12, %s, %s, $idusuario)",
    /*
    $insertSQL = sprintf("INSERT INTO recibo (idrecibo, numero, mes_pago, monto, fecha_recibo, idjugador, idlibreta, anio, observacionesRecibo) VALUES (2140, 1136, $value, 250,    2019-03-06, $elJugador, 12, 'eliminar', false)",*/
                           GetSQLValueString($_POST['idrecibo'], "int"),
                           GetSQLValueString($_POST['numero'], "int"),
                           /*GetSQLValueString($_POST['mes_pago'], "int"),*/
                           GetSQLValueString($_POST['monto'], "double"),
                           GetSQLValueString($_POST['fecha_recibo'], "date"),
                           /*GetSQLValueString($_POST['idjugador'], "int"),
                           GetSQLValueString($_POST['idlibreta'], "int"),*/
                           GetSQLValueString($_POST['anio'], "int"),
                           GetSQLValueString($_POST['observacionesRecibo'], "text"));
    //				   GetSQLValueString($_POST['idusuario'], "int"));
                
        mysql_select_db($database_yerbalito, $yerbalito);
        $Result1 = mysql_query($insertSQL, $yerbalito) or die(mysql_error());
                
    //refresco los datos antes de mostrar el listado de recibos actualizados
        $jugadorQuePago = $_POST['idjugador']; //NO TIENE VALOR
        $mysqli = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
        die("No se pudo conectar: " . mysql_error());
                
        //$banderaDeudores =0;
        $hoy=getdate();
                
    //		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
    //		$result = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador = 125 AND recibo.anio = $hoy[year]");
                
                
    		$deudoresAnioPasado = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador ='".$elJugador."' AND recibo.anio = $hoy[year]-1");
    		$mesesDelAnioAnterior = mysqli_num_rows($deudoresAnioPasado);
    		if ($mesesDelAnioAnterior > 0) 
        {			
    		/*			
    			if ($mesesDelAnioAnterior == 12) {
    				//debe pagar el mes $mesesDelAnioAnterior+1	
    				mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`,     `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $jugadorQueDebe, '12', $hoy[year], 'ENERO FREE', '0', '1')");
    			} 
    			*/
          
    			if ($mesesDelAnioAnterior>10 AND $mesesDelAnioAnterior<12 AND $BANDERAWHILERECIBOSAUTOMATICOS==0)  //SI HAY 11 RECIBOS DEL AÑO ANTERIOR YA LO HABILITO, PORQUE LE ESTARIA FALTANDO SOLO 1 MES QUE SERIA LO QUE SE COMPENSA
          {         
//              ECHO $mesesDelAnioAnterior, ' - ', $BANDERAWHILERECIBOSAUTOMATICOS;

    					//le agrego diciembre 2021, enero Y FEBRERO 2022, y sigo de largo, debe pagar MARZO 2022					
    						mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`,     `idusuario`) VALUES (NULL, '0', '12', '0', '2022-01-01', $elJugador, '12', $hoy[year]-1, 'DICIEMBRE FREE', '0', '1')");
          
          
    						mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`,     `idusuario`) VALUES (NULL, '0', '1', '0', '2023-01-01', $elJugador, '12', $hoy[year], 'ENERO FREE', '0', '1')");
          
                mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`,     `idusuario`) VALUES (NULL, '0', '2', '0', '2023-01-01', $elJugador, '12', $hoy[year], 'FEBRERO FREE', '0', '1')");
          
                $BANDERAWHILERECIBOSAUTOMATICOS=1;   //LO HAGO PARA HACER RECIBOS 1 SOLA VEZ
    			}			
    		}
    /*		
    else { //jugador que ingresa este año, deberia tambien ingresar los meses anterior a los que se inscribe, pensando en que puede ingresar mas adelante en el año
    
    			mysql_query("INSERT INTO `recibo` (`idrecibo`, `numero`, `mes_pago`, `monto`, `fecha_recibo`, `idjugador`, `idlibreta`, `anio`, `observacionesRecibo`, `visible`,     `idusuario`) VALUES (NULL, '0', '1', '0', '2020-01-01', $elJugador, '12', $hoy[year], 'ENERO FREE', '0', '1')");
    
    		}
    */    
      
    		$result = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador ='".$elJugador."' AND recibo.anio = $hoy[year]"); //AND monto>0"); traigo los recibos del    jugador que pago en este año
    		//PUEDE TENER PAGOS EN 0, CUANDO PAGAN CON TRABAJO O CUANDO SON HERMANOS
      
    	  $row_cnt = mysqli_num_rows($result);
    		//PRUEBA	
    		//$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt."' Where jugador.idjugador ='".$jugadorQuePago."'");
      
    	/*
    		if ($row_cnt < date("n")) { //si entro aca es porque el jugador no esta al dia		
    		}
      
    $result = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador =' ".$jugadorQuePago."' AND recibo.anio = $hoy[year]"); 
    $contadorDeudaAnteriormeses = 0;
    if (count($result)>0) {
    	$i = 0;
    	while (($i <= count($result)) AND ($contadorDeudaAnteriormeses <= date("n"))) {		
    		$contadorDeudaAnteriormeses+=1;							
    		$i+=1;									
    	}
    }
    */
    //AFINAR, Y PREGUNTAR SI ESTA DENTRO DE LOS 10 PRIMEROS DIAS DE PLAZO PARA ABONAR EL MES

        if ($row_cnt>=date("n")) 
        { /*si entro aca es porque esta al dia      n=numero del mes*/ 
        //	$mysqli->query("Update jugador Set observacionesJugador ='".$contadorDeudaAnteriormeses."' Where jugador.idjugador ='".$jugadorQuePago."'");
        	$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador ='".$elJugador."'");		
        	$result3 = ("SELECT * FROM jugador WHERE jugador.idjugador ='".$elJugador."'");// saco los datos del jugador que pago, para saber de que categoria es
        	$query_execute = $mysqli->query($result3);
        	$query_result = $query_execute->fetch_array();
        	$idCategoria = $query_result['idcategoria']; //HASTA ACA VAMOS BIEN
        	//PRUEBA	
        	//$mysqli->query("Update jugador Set observacionesJugador ='".$idCategoria."' Where jugador.idjugador ='".$jugadorQuePago."'");	
        	$result2 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."'"); //tengo todos los jugadores de esa categoria
        	$row_cnt2 = $result2->num_rows;	
        	$result4 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."' AND jugador.idestado=2 OR (jugador.idestado=3)"); //tengo todos los    jugadores    de esa categoria que estan al dia
        	$row_cnt4 = $result4->num_rows;		
        	if ($row_cnt2==$row_cnt4) { /*si entro aca es porque todos los jugadores de esa categoria estan al dia */
        		$mysqli->query("Update categoria Set idestado=6 Where categoria.idcategoria =' ".$idCategoria."'");
        	}
        	else {
        		$mysqli->query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$idCategoria."'"); 
        	}		
        }      
      
        elseif ($row_cnt+1==date("n")) //si es = a 1 mes anterior esta al dia
        {	
        	$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador ='".$elJugador."'");		
        	$result3 = ("SELECT * FROM jugador WHERE jugador.idjugador ='".$elJugador."'");// saco los datos del jugador que pago, para saber de que categoria es
        	$query_execute = $mysqli->query($result3);
        	$query_result = $query_execute->fetch_array();
        	$idCategoria = $query_result['idcategoria']; //HASTA ACA VAMOS BIEN
        	//PRUEBA	
        	//$mysqli->query("Update jugador Set observacionesJugador ='".$idCategoria."' Where jugador.idjugador ='".$jugadorQuePago."'");	
        	$result2 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."'"); //tengo todos los jugadores de esa categoria
        	$row_cnt2 = $result2->num_rows;	
        	$result4 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."' AND (jugador.idestado=2 OR jugador.idestado=3)"); //tengo todos los    jugadores    de esa categoria que estan al dia o estan exonerados
        	$row_cnt4 = $result4->num_rows;		
        		//PRUEBA	
        //$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt2."' Where jugador.idjugador =125");
        //PRUEBA	
        //$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt4."' Where jugador.idjugador =123");
        	if ($row_cnt2==$row_cnt4) { /*si entro aca es porque todos los jugadores de esa categoria estan al dia */
        		$mysqli->query("Update categoria Set idestado=6 Where categoria.idcategoria =' ".$idCategoria."'");
        	}
        	else {
        		$mysqli->query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$idCategoria."'"); 
        	}		
        }
      
        elseif (($row_cnt+2==date("n") AND (date("j")<=10))) //si es = a 2 meses anterior y no ha llegado al dia 10, esta al dia
        {
        	
        	$mysqli->query("Update jugador Set idestado=2 Where jugador.idjugador ='".$elJugador."'");		
        	$result3 = ("SELECT * FROM jugador WHERE jugador.idjugador ='".$elJugador."'");// saco los datos del jugador que pago, para saber de que categoria es
        	$query_execute = $mysqli->query($result3);
        	$query_result = $query_execute->fetch_array();
        	$idCategoria = $query_result['idcategoria']; //HASTA ACA VAMOS BIEN
        	//PRUEBA	
        	//$mysqli->query("Update jugador Set observacionesJugador ='".$idCategoria."' Where jugador.idjugador ='".$jugadorQuePago."'");	
        	$result2 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."'"); //tengo todos los jugadores de esa categoria
        	$row_cnt2 = $result2->num_rows;	
        	$result4 = $mysqli->query("SELECT * FROM jugador WHERE jugador.idcategoria ='".$idCategoria."' AND (jugador.idestado=2 OR jugador.idestado=3)"); //tengo todos los    jugadores    de esa categoria que estan al dia o estan exonerados
        	$row_cnt4 = $result4->num_rows;		
        		//PRUEBA	
        //$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt2."' Where jugador.idjugador =125");
        //PRUEBA	
        //$mysqli->query("Update jugador Set observacionesJugador ='".$row_cnt4."' Where jugador.idjugador =123");
        	if ($row_cnt2==$row_cnt4) { /*si entro aca es porque todos los jugadores de esa categoria estan al dia */
        		$mysqli->query("Update categoria Set idestado=6 Where categoria.idcategoria =' ".$idCategoria."'");
        	}
        	else {
        		$mysqli->query("Update categoria Set idestado=5 Where categoria.idcategoria =' ".$idCategoria."'"); 
        	}		
        }
      
        else /* si entro aca es porque el jugador debe*/
        {
        	$mysqli->query("Update jugador Set idestado=1 Where jugador.idjugador =' ".$elJugador."'");
        }
      
      
        $insertGoTo = "listado_recibos.php";
        if (isset($_SERVER['QUERY_STRING'])) 
        {
          $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
          $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
      
        header(sprintf("Location: %s", $insertGoTo));
    	}				
    } //END WHILE
  } 
}





/*
function devuelveMesesPagos_php() {

//		$jugadorQuePago = $_POST['idjugador'];

$valor=125; //$_POST['valor'];

$mysqli8 = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
    die("No se pudo conectar: " . mysql_error());

//$banderaDeudores =0;
$fechaActual=getdate();

//		$link = mysqli_connect($hostname_yerbalito, $username_yerbalito, $password_yerbalito, $database_yerbalito);
//		$result = mysqli_query($mysqli, "SELECT * FROM recibo WHERE recibo.idjugador = 125 AND recibo.anio = $hoy[year]");
		$pagosDelAnioActual = mysqli_query($mysqli8, "SELECT * FROM recibo WHERE recibo.idjugador ='".$valor."' AND recibo.anio = $fechaActual[year]"); // traigo los recibos del jugador que pago en este año

	    $totalPagos = mysqli_num_rows($pagosDelAnioActual);
}
*/


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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
<!--
<script src="jquery-3.2.1.min.js"></script>

 javascript que recibe el dato del boton y se lo manda a una funcion php-->
</head>
<script type="text/javascript">


var checkboxes = document.getElementsByName("mes_pago[]");
//USO ESTA FUNCION PARA VER LA CANTIDAD DE MESES QUE VA A PAGAR Y PODER CALCULAR EL VALOR TOTAL
var pago_febrero = 0;
var pago_marzo = 0;
var pago_abril = 0;
var pago_mayo = 0;
var pago_junio = 0;
var pago_julio = 0;
var pago_agosto = 0;
var pago_setiembre = 0;
var pago_octubre = 0;
var pago_noviembre = 0;
var pago_diciembre = 0;

function contar() 
{
var cont = 0;
//var checkboxes = document.getElementById("mes_pago"); 
	for (var x=0; x < checkboxes.length; x++) {
	 if (checkboxes[x].checked) {
	  cont = cont + 1;
	 }
	}
	
	if (document.getElementById("anio3").value == 2019) {
		document.getElementById("monto").value = 250 * cont;
	}else {
		document.getElementById("monto").value = 300 * cont;			
	}
}


function contar2020() 
{
var cont = 0;
//var checkboxes = document.getElementById("mes_pago"); 
	for (var x=0; x < checkboxes.length; x++) {
	 if (checkboxes[x].checked) {
	  cont = cont + 1;
	 }
	}
	document.getElementById("monto").value = 300 * cont;			

}




/*NO APLICA AHORA, YA QUE NO HAY MAS LIBRETAS

function devuelveLibreta()
{
	var numeroRecibo = document.getElementsByName("numero");
	document.getElementsByName("idlibreta").value = 250 * cont;
}
*/
var elJugador_js=0;
var monto_recibo_js=0;
var observaciones_recibo_js="";
var anio_recibo_js=0;
		 
function devuelveMesesPagos_js()
{
	//le paso a php el jugador que necesito que me arroje los meses pagos
	elJugador_js= document.getElementById("idjugador").value;
	/*
	var monto_recibo_js= 500;//document.getElementById("monto").value;
	var observaciones_recibo_js="Hola";// document.getElementById("observacionesRecibo").value;
	//window.location.href='insertar_recibo.php?elJugador='+elJugador;
	*/
	window.location.href=	window.location.href + "?elJugador=" + elJugador_js;// + "&monto_recibo=" + monto_recibo_js+ "&observacionesRecibo=" + observaciones_recibo_js;
	
//	location.replace('insertar_recibo.php?elJugador='+elJugador);
	//window.history.pushState('insertar_recibo.php?elJugador='+elJugador);
	
	//document.form1.idjugador.options[document.form1.idjugador.selectedIndex]
	//document.getElementById("idjugador").value = idjugador;
	//history.pushState(null, "", "insertar_recibo.php?elJugador="+elJugador);
	//localStorage.setItem("idjugador",elJugador);
	
	//var indice = document.forml.idjugador.selectedIndex;
	//var valor = document.forml.idjugador.options[indice].value;
	//alert("el id del jugador es:"+ elJugador);

	//PHP me da los meses que pago ese jugador
	<?php //echo devuelveMesesPagos_php() ?>
	

}



function pasa_observaciones_recibo_js()
{	//le paso a php el jugador que necesito que me arroje los meses pagos
observaciones_recibo_js= document.getElementById("observacionesRecibo").value;
window.location.href=window.location.href + "&observaciones_recibo=" + observaciones_recibo_js;	
}

//anio_recibo_js=0;
function pasa_anio_recibo_js()
{	//le paso a php el jugador que necesito que me arroje los meses pagos
anio_recibo_js= document.getElementById("anio3").value;
window.location.href=window.location.href + "&anio2=" + anio_recibo_js;	
}

function pasa_monto_recibo_js()
{	//le paso a php el jugador que necesito que me arroje los meses pagos
monto_recibo_js= document.getElementById("monto").value;
window.location.href=window.location.href + "&monto_recibo=" + monto_recibo_js + "&precio_confirmado=1";
pasar_meses_pagos();
}

function pasar_meses_pagos() 
{
//var checkboxes = document.getElementById("mes_pago"); 
	
	 if (checkboxes[1].checked) {
	  pago_febrero = 1;
	 }
	 if (checkboxes[2].checked) {
		if (pago_febrero == 0){
		  pago_febrero = 2;
		}
	  pago_marzo = 1;
	 }
	 if (checkboxes[3].checked) {
		if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
	  pago_abril = 1;
	 }
	 if (checkboxes[4].checked) {
  	  if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
	  pago_mayo = 1;
	 }
	 if (checkboxes[5].checked) {
 		if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
	  pago_junio = 1;
	 }
	 if (checkboxes[6].checked) {
   	    if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
		if (pago_junio== 0){
		  pago_junio = 2;
		}	 
	  pago_julio = 1;
	 }
	 if (checkboxes[7].checked) {
	    if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
		if (pago_junio== 0){
		  pago_junio = 2;
		}
		if (pago_julio== 0){
		  pago_julio = 2;
		}
	  pago_agosto = 1;
	 }
	 if (checkboxes[8].checked) {
      if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
		if (pago_junio== 0){
		  pago_junio = 2;
		}
		if (pago_julio== 0){
		  pago_julio = 2;
		}
		if (pago_agosto== 0){
		  pago_agosto = 2;
		}
	  pago_setiembre = 1;
	 }
	 if (checkboxes[9].checked) {
	  if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
		if (pago_junio== 0){
		  pago_junio = 2;
		}
		if (pago_julio== 0){
		  pago_julio = 2;
		}
		if (pago_agosto== 0){
		  pago_agosto = 2;
		}
		if (pago_setiembre== 0){
		  pago_setiembre = 2;
		}	
	  pago_octubre = 1;
	 }
	 if (checkboxes[10].checked) {
      if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
		if (pago_junio== 0){
		  pago_junio = 2;
		}
		if (pago_julio== 0){
		  pago_julio = 2;
		}
		if (pago_agosto== 0){
		  pago_agosto = 2;
		}
		if (pago_setiembre== 0){
		  pago_setiembre = 2;
		}
		if (pago_octubre== 0){
		  pago_octubre = 2;
		}	
	  pago_noviembre = 1;
	 }
	 if (checkboxes[11].checked) {
      if (pago_febrero == 0){
		  pago_febrero = 2;
		}
		if (pago_marzo== 0){
		  pago_marzo = 2;
		}
		if (pago_abril == 0){
		  pago_abril = 2;
		}
		if (pago_mayo== 0){
		  pago_mayo = 2;
		}
		if (pago_junio== 0){
		  pago_junio = 2;
		}
		if (pago_julio== 0){
		  pago_julio = 2;
		}
		if (pago_agosto== 0){
		  pago_agosto = 2;
		}
		if (pago_setiembre== 0){
		  pago_setiembre = 2;
		}
		if (pago_octubre== 0){
		  pago_octubre = 2;
		}
		if (pago_noviembre== 0){
		  pago_noviembre = 2;
		}
	  pago_diciembre = 1;
	 }
	 
	 //anio= document.getElementById("anio").value;
	 	 
	 window.location.href=window.location.href + "&monto_recibo=" + monto_recibo_js + "&precio_confirmado=1" + "&anio2=" + document.getElementById("anio3").value + "&pago_marzo=" + pago_marzo + "&pago_abril=" + pago_abril + "&pago_mayo=" + pago_mayo + "&pago_junio=" + pago_junio + "&pago_julio=" + pago_julio + "&pago_agosto=" + pago_agosto + "&pago_setiembre=" + pago_setiembre + "&pago_octubre=" + pago_octubre + "&pago_noviembre=" + pago_noviembre; //+ "&anio=" + anio_recibo_js;
	 	 
}


function refresca()
{ 

elJugador_js= 0;
monto_recibo_js= 0;
observaciones_recibo_js= "";
precio_confirmado=0;
anio_recibo_js=0;

	window.location.href='insertar_recibo.php';
}

</script>
<body class="">
<!-- WRAPPER -->
<div id="wrapper">
  <!-- HEADER -->
  <div id="header">
    <!-- Social -->
    <div align="center"> <img src="images/logo3.png" alt="yerbalito" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" > </div>
    <!-- ENDS Social -->
    <!-- Navigation -->
    <!-- Navigation -->
    <!-- search -->
    <!-- ENDS search -->
    <!-- Breadcrumb-->
    <!-- ENDS Breadcrumb-->
  </div>
  <!-- ENDS HEADER -->
  <!-- aca va javascript para subir imagenes-->
  <!-- MAIN -->
  <div id="main"> Insertar recibo:
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <!--		<form method="post" name="form1" id="form1" action="muestro_meses_pagos.php"> -->
      <table align="center">
      <tr valign="baseline">
        <td nowrap align="right">Numero de recibo:</td>
        <!-- tomo el valor "numero_recibo" del ultimo recibo ingresado, le sumo 1 y lo muestro-->
        <td><input type="text" name="numero" value="<?php echo $row_datosRecibos['numero']+1; ?>" readonly size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Jugador:</td>
        
        <td><?php if(isset($elJugador) && (!$elJugador==0) ) { 
						?>
				          <select id="idjugador" name="idjugador">
                                      
            			<?php do { ?>
			   				    <option value="<?php echo $row_DatosJugador['idjugador']?>" <?php if ($row_DatosJugador['idjugador']==$elJugador) {echo 		
								"selected=\"selected\"";} ?> disabled > <?php echo $row_DatosJugador['apellido']?>, <?php echo $row_DatosJugador['nombre'] ;?></									                                option> <?php } 
			
						while ($row_DatosJugador = mysql_fetch_assoc($DatosJugador));?>
            				<input type="button" value="Cambiar de jugador"  onmouseout="salir_del_hover()" onmouseover="hacer_hover()" onclick="refresca()"/>
				            </select>
            	 <?php } 
   				else  { ?>
    			      <select id="idjugador" name="idjugador" onChange="return devuelveMesesPagos_js();">
			          <option <?php if (!(strcmp("", $row_DatosJugador['idjugador']))) {echo "selected=\"selected\"";} ?>> </option>
		              
					  <?php	do { ?>
					            <option value="<?php echo $row_DatosJugador['idjugador']?>" <?php if (!(strcmp($row_DatosJugador['idjugador'], $row_DatosJugador[				
								'nombre']))) {echo "selected=\"elected\"";} ?> > <?php echo $row_DatosJugador['apellido']?>, <?php echo $row_DatosJugador['nombre'] ;
								?></option>
				           <?php }
						   
				    	while ($row_DatosJugador = mysql_fetch_assoc($DatosJugador));
							$rows = mysql_num_rows($DatosJugador);
					 		if($rows > 0) {
					   			 mysql_data_seek($DatosJugador, 0);
								$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
							} ?>
                            
				       </select>
                <?php } ?>
          <!--         <input name="boton" id="boton" type="submit" value="Consultar pagos del jugador"> --></td>
      </tr>
      
      <tr valign="baseline">
        <td nowrap align="right">Fecha de recibo:</td>
        <td><input type="date" name="fecha_recibo" value="<?php echo $today; ?>" size="32"></td>
      </tr>
      
      <tr valign="baseline">
        <td nowrap align="right">Observaciones:</td>
        
        
        <?php if(isset($_GET['observaciones_recibo']) && (!$_GET['observaciones_recibo']=="") ) { 
			?>        
        <td><input type="text" name="observacionesRecibo" id="observacionesRecibo" value="<?php echo $_GET['observaciones_recibo'];?>" size="32" ></td>
        <?php } 
		  else
		  
		  {?> <td><input type="text" name="observacionesRecibo" id="observacionesRecibo" value="" size="32" onChange="return pasa_observaciones_recibo_js();"></td>
          <?php } ?>
        
        
      </tr>
      
      <tr valign="baseline">
        <td nowrap align="right" style=" font-weight:bold">Año de pago:</td>
        
       <?php if( isset($_GET['anio2']) && (!$_GET['anio2']==0) ) { 
                  	
			// este lo muestro cuando recargo la pagina, para mantener los valores que puse?>      
        <td><input type="text" name="anio" id="anio3" value="<?php echo $_GET['anio2']; ?>" size="32" onChange="return pasa_anio_recibo_js();"></td>     

        <tr valign="baseline">
        <td nowrap align="right">Mes a pagar: </td>
        <td align="left"><table width="100">
          <?php    //al principio cuando muestro el form aca no voy a entrar porque vale 0, aca deberia entrar cuando selecciono un jugador, ahi cargaria los meses pagos, y chequea el que corresponda
			?>
			<tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" <?php echo "disabled";?> onClick="javascript:contar();">
             <strike> Enero </strike> </label></td>
          </tr>
        
          <tr>
            <td ><label>
              <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" <?php echo "disabled";?> onClick="javascript:contar();">
              <strike> Febrero </strike>  </label></td>
          </tr>
          
			<?php
		if ($totalPagos==0){ ?>   
          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
                

  			<tr>
			    <td> <label style=" font-weight:bold">
				    <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" onClick="javascript:contar();">
            Noviembre </label> </td> 
			  </tr> 			
        
        

		<?php		 
		  }
		  if($totalPagos==2){ $pago_marzo=0;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;         
          
        

        if(isset($_GET['pago_marzo']) && ($_GET['pago_marzo']==1) ) { 
			?>
        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" checked  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <?php } 
          else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
           <?php } if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
                   
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php 
    } 
          
           }


		 if($totalPagos==3){ 
       
      if ($debe_anio_anterior==1) { ?>
            
            //SI DEBE DEL AÑO ANTERIOR

            <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike> Mayo </strike> </label></td>
          </tr>
         
          <?php if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>

          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
                   
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>  

        <?PHP } }
        //SINO DEBE DEL AÑO ANTERIOR
        else { $pago_marzo=1;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                           
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>
          <?php if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) )  { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
         
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>




          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
          



    } }
          
          
          
          if($totalPagos==4){ $pago_marzo=1;$pago_abril=1;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
          
                 
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
                   
          <?php if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
            
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>


          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
             
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  
    }
          
          } if($totalPagos==5){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike> Mayo </strike> </label></td>
          </tr>
          
          
          <?php  if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
          
         } if($totalPagos==6){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike> Junio </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
		   
		   
      } if($totalPagos==7){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                            
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
                     
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
		   
       } if($totalPagos==8){$pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
              <strike> Agosto </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  { 	
			?>
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          	
                
           <?php } else { ?>

                   
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
    	      </tr>        
		<?php  }		   
          
       } if($totalPagos==9){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=0;$pago_noviembre=0;?>
                      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
            
				 <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
          
           <?php } else { ?>
                    
                
				<tr>
            <td>
            	<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
              Noviembre </label>
              </td>
          </tr>          
		<?php   }
          
		  
       } if($totalPagos==10){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=0;?>
          
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
 <strike>              Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
           
           
          <?php  if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
              <tr>
				<td><label>
             		 <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
             		 Noviembre </label></td>         
                     </tr>           
          
           <?php } else { ?>
          
                  
          <tr>
				<td>
     			   	<label> <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
                Noviembre </label>
    		    </td>    
                </tr>      
		<?php   }
          
       } if($totalPagos==11){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
         
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
            
            
                            
        <tr>
  			  <td>
				    <label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
            <strike> Noviembre </strike> </label>
		      </td>                         
        </tr>
		            
          
           <?php 
          
       } if($totalPagos==12){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
          
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled  onClick="javascript:contar();">
             <strike>  Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
              <strike> Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled onClick="javascript:contar();">
              <strike> Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled onClick="javascript:contar();">
              <strike> Setiembre </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
               <strike>Octubre </strike></label></td>
          </tr>
          
                  
        <tr>
  			  <td>
				<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
        <strike>Noviembre </strike> </label>
		    </td>                         
            </tr>
		
          
          <?php }//fin del IF ?>
          <tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" disabled onClick="javascript:contar();">
              <strike> Diciembre </strike></label></td>
          </tr>

      <?php } 

		  else		  
		  { //esto lo muestro por primera vez, cuando haya seleccionado el jugador
		    if ($debe_anio_anterior==1) { ?>           
        <td><input type="text" name="anio" required  id="anio3" value="2022" size="32" onChange="return pasa_anio_recibo_js();"></td>
        
        <tr valign="baseline">
        <td nowrap align="right">Mes a pagar: </td>
        <td align="left"><table width="100">
          <?php    //al principio cuando muestro el form aca no voy a entrar porque vale 0, aca deberia entrar cuando selecciono un jugador, ahi cargaria los meses pagos, y chequea el que corresponda
			?>
			<tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" <?php echo "disabled";?> onClick="javascript:contar();">
             <strike> Enero </strike> </label></td>
          </tr>
        
          <tr>
            <td ><label>
              <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" <?php echo "disabled";?> onClick="javascript:contar();">
              <strike> Febrero </strike>  </label></td>
          </tr>
          
			<?php
		if ($totalPagos==0){ //LO USO CUANDO MUESTRO POR PRIMERA VES, NO HE SELECCIONADO UN JUGADOR?>   
          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
                

  			<tr>
			    <td> <label style=" font-weight:bold">
				    <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" onClick="javascript:contar();">
            Noviembre </label> </td> 
			  </tr> 			
        
        

		<?php		 
		  }
		  if($totalPagos==2){ $pago_marzo=0;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;         
          
        

        if(isset($_GET['pago_marzo']) && ($_GET['pago_marzo']==1) ) { 
			?>
        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" checked  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <?php } 
          else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
           <?php } if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
                   
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php 
    } 
          
           }
		 if($totalPagos==3){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                           
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike> Mayo </strike> </label></td>
          </tr>
         
          <?php if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>




          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
          
          } if($totalPagos==4){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
          
                 
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
                   
          <?php if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
            
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>


          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
             
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  
    }
          
          } if($totalPagos==5){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike> Mayo </strike> </label></td>
          </tr>
          
          
          <?php  if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
          
         } if($totalPagos==6){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike> Junio </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
		   
		   
      } if($totalPagos==7){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                            
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
                     
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
		   
       } if($totalPagos==8){$pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
              <strike> Agosto </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  { 	
			?>
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          	
                
           <?php } else { ?>

                   
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
    	      </tr>        
		<?php  }		   
          
       } if($totalPagos==9){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=0;$pago_noviembre=0;?>
                      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
            
				 <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
          
           <?php } else { ?>
                    
                
				<tr>
            <td>
            	<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
              Noviembre </label>
              </td>
          </tr>          
		<?php   }
          
		  
       } if($totalPagos==10){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=0;?>
          
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
 <strike>              Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
           
           
          <?php  if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
              <tr>
				<td><label>
             		 <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
             		 Noviembre </label></td>         
                     </tr>           
          
           <?php } else { ?>
          
                  
          <tr>
				<td>
     			   	<label> <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
                Noviembre </label>
    		    </td>    
                </tr>      
		<?php   }
          
       } if($totalPagos==11){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
         
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
            
            
                            
        <tr>
  			  <td>
				    <label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
            <strike> Noviembre </strike> </label>
		      </td>                         
        </tr>
		            
          
           <?php 
          
       } if($totalPagos==12){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
          
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled  onClick="javascript:contar();">
             <strike>  Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
              <strike> Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled onClick="javascript:contar();">
              <strike> Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled onClick="javascript:contar();">
              <strike> Setiembre </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
               <strike>Octubre </strike></label></td>
          </tr>
          
                  
        <tr>
  			  <td>
				<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
        <strike>Noviembre </strike> </label>
		    </td>                         
            </tr>
		
          
          <?php }//fin del IF ?>
          <tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" disabled onClick="javascript:contar();">
              <strike> Diciembre </strike></label></td>
          </tr>
    <?php } elseif ($debe_anio_anterior==2)
	  			{ ?>

 		        <td><input type="text" name="anio" required  id="anio3" value="2023" size="32" onChange="return pasa_anio_recibo_js();"></td>
             <tr valign="baseline">
        <td nowrap align="right">Mes a pagar: </td>
        <td align="left"><table width="100">
          <?php    //al principio cuando muestro el form aca no voy a entrar porque vale 0, aca deberia entrar cuando selecciono un jugador, ahi cargaria los meses pagos, y chequea el que corresponda
			?>
			<tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" <?php echo "disabled";?> onClick="javascript:contar();">
             <strike> Enero </strike> </label></td>
          </tr>
        
          <tr>
            <td ><label>
              <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" <?php echo "disabled";?> onClick="javascript:contar();">
              <strike> Febrero </strike>  </label></td>
          </tr>
          
			<?php
		
		  
			if($totalPagos==2){ $pago_marzo=0;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;         
          
        

        if(isset($_GET['pago_marzo']) && ($_GET['pago_marzo']==1) ) { 
			?>
        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" checked  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <?php } 
          else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
           <?php } 
           if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
                   
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php 
    } 
          
           } if($totalPagos==3){ $pago_marzo=1;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
          
                 
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      

          
           <?php  if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>




          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
          
          } if($totalPagos==4){ $pago_marzo=1;$pago_abril=1;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
          
                 
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
                   
          <?php if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
            
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>


          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
             
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  
    }
          
          } if($totalPagos==5){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike> Mayo </strike> </label></td>
          </tr>
          
          
          <?php  if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
          
         } if($totalPagos==6){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike> Junio </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
		   
		   
      } if($totalPagos==7){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                            
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
                     
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
		   
       } if($totalPagos==8){$pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
              <strike> Agosto </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  { 	
			?>
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          	
                
           <?php } else { ?>

                   
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
    	      </tr>        
		<?php  }		   
          
       } if($totalPagos==9){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=0;$pago_noviembre=0;?>
                      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
            
				 <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
          
           <?php } else { ?>
                    
                
				<tr>
            <td>
            	<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
              Noviembre </label>
              </td>
          </tr>          
		<?php   }
          
		  
       } if($totalPagos==10){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=0;?>
          
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
 <strike>              Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
           
           
          <?php  if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
              <tr>
				<td><label>
             		 <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
             		 Noviembre </label></td>         
                     </tr>           
          
           <?php } else { ?>
          
                  
          <tr>
				<td>
     			   	<label> <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
                Noviembre </label>
    		    </td>    
                </tr>      
		<?php   }
          
       } if($totalPagos==11){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
         
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
            
            
                            
        <tr>
  			  <td>
				    <label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
            <strike> Noviembre </strike> </label>
		      </td>                         
        </tr>
		            
          
           <?php 
          
       } if($totalPagos>=12){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;
            ?>
                              
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled  onClick="javascript:contar();">
             <strike>  Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
              <strike> Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled onClick="javascript:contar();">
              <strike> Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled onClick="javascript:contar();">
              <strike> Setiembre </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
               <strike>Octubre </strike></label></td>
          </tr>
          
                  
        <tr>
  			  <td>
				<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
        <strike>Noviembre </strike> </label>
		    </td>                         
            </tr>
		
          
          <?php }//fin del IF ?>
          <tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" disabled onClick="javascript:contar();">
              <strike> Diciembre </strike></label></td>
          </tr>
			<?php }
		
			else {  ?>
				 <td><input type="text" name="anio" required  id="anio3" value="" size="32" onChange=""></td>
         <tr valign="baseline">
        <td nowrap align="right">Mes a pagar: </td>
        <td align="left"><table width="100">
          <?php    //al principio cuando muestro el form aca no voy a entrar porque vale 0, aca deberia entrar cuando selecciono un jugador, ahi cargaria los meses pagos, y chequea el que corresponda
			?>
			<tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0" <?php echo "disabled";?> onClick="javascript:contar();">
             <strike> Enero </strike> </label></td>
          </tr>
        
          <tr>
            <td ><label>
              <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1" <?php echo "disabled";?> onClick="javascript:contar();">
              <strike> Febrero </strike>  </label></td>
          </tr>
          
			<?php
		if ($totalPagos==0){ //LO USO CUANDO MUESTRO POR PRIMERA VES, NO HE SELECCIONADO UN JUGADOR?>   
          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
                

  			<tr>
			    <td> <label style=" font-weight:bold">
				    <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" onClick="javascript:contar();">
            Noviembre </label> </td> 
			  </tr> 			
                

		<?php		 
		  }
		  
		if ($totalPagos==1){ 
			  if(isset($_GET['pago_marzo']) && ($_GET['pago_marzo']==1) ) { 
			?>
        
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" checked  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
           <?php } if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>
          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label style=" font-weight:bold">
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else 
           { ?>
                
            
			      	<tr>
                <td><label style=" font-weight:bold">
                  <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
                 Noviembre </label></td>
              </tr>          
		        <?php  
            } 
          
          }	if($totalPagos==2){ $pago_marzo=0;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;         
          ?>
			        
                  
          
        <?php if(isset($_GET['pago_marzo']) && ($_GET['pago_marzo']==1) ) { 
			?>
        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" checked  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2"  onClick="javascript:contar();">
              Marzo </label></td>
          </tr>
           <?php } if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
                   
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php 
    } 
          
           } if($totalPagos==3){ $pago_marzo=1;$pago_abril=0;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
          
                 
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      

          
           <?php  if(isset($_GET['pago_abril']) && ($_GET['pago_abril']==1) ) { 
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" checked onClick="javascript:contar();">
              Abril </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3"  onClick="javascript:contar();">
              Abril </label></td>
          </tr>          
          <?php } if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>




          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
           
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
          
          } if($totalPagos==4){ $pago_marzo=1;$pago_abril=1;$pago_mayo=0;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
          
                 
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
                   
          <?php if(isset($_GET['pago_mayo']) && ($_GET['pago_mayo']==1) )  {
            
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" checked onClick="javascript:contar();">
              Mayo </label></td>
          </tr>
          <?php } else { ?>
                   <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4"  onClick="javascript:contar();">
              Mayo </label></td>
          </tr>


          <?php } if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
             
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  
    }
          
          } if($totalPagos==5){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=0;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike> Abril </strike> </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike> Mayo </strike> </label></td>
          </tr>
          
          
          <?php  if(isset($_GET['pago_junio']) && ($_GET['pago_junio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" checked  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5"  onClick="javascript:contar();">
              Junio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
          
         } if($totalPagos==6){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=0;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                        
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike> Marzo </strike> </label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike> Junio </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_julio']) && ($_GET['pago_julio']==1) )  {
			?>          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" checked  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6"  onClick="javascript:contar();">
              Julio </label></td>
          </tr>
          <?php } if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
          
                 
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          
		<?php  }
		   
		   
      } if($totalPagos==7){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=0;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                            
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_agosto']) && ($_GET['pago_agosto']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" checked  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7"  onClick="javascript:contar();">
              Agosto </label></td>
          </tr>
          <?php } if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>
           <?php } else { ?>
          
                     
				<tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
		<?php  }
		   
       } if($totalPagos==8){$pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=0;$pago_octubre=0;$pago_noviembre=0;?>
                          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
              <strike> Agosto </strike></label></td>
          </tr>
          
          <?php  if(isset($_GET['pago_setiembre']) && ($_GET['pago_setiembre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" checked  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8"  onClick="javascript:contar();">
              Setiembre </label></td>
          </tr>
          <?php } if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  { 	
			?>
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>          	
                
           <?php } else { ?>

                   
	          <tr>
	            <td><label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();">
              Noviembre </label></td>
    	      </tr>        
		<?php  }		   
          
       } if($totalPagos==9){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=0;$pago_noviembre=0;?>
                      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>
          
          
          <?php if(isset($_GET['pago_octubre']) && ($_GET['pago_octubre']==1) )  {
			?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" checked onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
           <?php } else { ?>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9"  onClick="javascript:contar();">
              Octubre </label></td>
          </tr>
          
          <?php } if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
            
				 <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
              Noviembre </label></td>
          </tr>         
          
           <?php } else { ?>
                    
                
				<tr>
            <td>
            	<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
              Noviembre </label>
              </td>
          </tr>          
		<?php   }
          
		  
       } if($totalPagos==10){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=0;?>
          
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
               <strike>Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
 <strike>              Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
           
           
          <?php  if(isset($_GET['pago_noviembre']) && ($_GET['pago_noviembre']==1) )  {
			?>
              <tr>
				<td><label>
             		 <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" checked onClick="javascript:contar();">
             		 Noviembre </label></td>         
                     </tr>           
          
           <?php } else { ?>
          
                  
          <tr>
				<td>
     			   	<label> <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10"  onClick="javascript:contar();"> 
                Noviembre </label>
    		    </td>    
                </tr>      
		<?php   }
          
       } if($totalPagos==11){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
         
             
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled  onClick="javascript:contar();">
               <strike>Marzo </strike></label></td>
          </tr>      
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled onClick="javascript:contar();">
               <strike>Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
               <strike>Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled  onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled  onClick="javascript:contar();">
               <strike>Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled  onClick="javascript:contar();">
               <strike>Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled  onClick="javascript:contar();">
               <strike>Setiembre </strike></label></td>
          </tr>         
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
              <strike> Octubre </strike></label></td>
          </tr>
            
            
                            
        <tr>
  			  <td>
				    <label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
            <strike> Noviembre </strike> </label>
		      </td>                         
        </tr>
		            
          
           <?php 
          
       } if($totalPagos==12){ $pago_marzo=1;$pago_abril=1;$pago_mayo=1;$pago_junio=1;$pago_julio=1;$pago_agosto=1;$pago_setiembre=1;$pago_octubre=1;$pago_noviembre=1;?>
          
          
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" disabled onClick="javascript:contar();">
              <strike> Marzo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" disabled  onClick="javascript:contar();">
             <strike>  Abril </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" disabled onClick="javascript:contar();">
              <strike> Mayo </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" disabled onClick="javascript:contar();">
              <strike> Junio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" disabled onClick="javascript:contar();">
              <strike> Julio </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" disabled onClick="javascript:contar();">
             <strike>  Agosto </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" disabled onClick="javascript:contar();">
              <strike> Setiembre </strike></label></td>
          </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" disabled onClick="javascript:contar();">
               <strike>Octubre </strike></label></td>
          </tr>
          
                  
        <tr>
  			  <td>
				<label><input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" disabled onClick="javascript:contar();"> 
        <strike>Noviembre </strike> </label>
		    </td>                         
            </tr>
		
          
          <?php }//fin del IF ?>
          <tr>
            <td><label>
              <input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" disabled onClick="javascript:contar();">
              <strike> Diciembre </strike></label></td>
          </tr>
			<?php }
	   	  }
	  	 ?>
      
      </tr>  
      
      
          
        </table></td>
      </tr>
           
      
      
      <tr valign="baseline">
        <td nowrap align="right">Monto:</td>        
        <!-- calculo la cantidad de meses marcados *250 y lo pongo en value-->
        <?php if(isset($_GET['monto_recibo']) && (!$_GET['monto_recibo']==0) ) { 
			?>
        		<td><input type="text" name="monto" id="monto" value="<?php echo $_GET['monto_recibo']; ?>" size="32" >
	    	       </td>
    	    	  <td> <input type="button" name="check_monto" id="check_monto" disabled value="Confirmar monto" size="32" >
		          </td>
          
          <?php } 

		  else
		  
			  {?> <td><input type="text" name="monto" id="monto" required value="0" size="32">
		           </td>
		          <td> <input type="button" name="check_monto" id="check_monto" value="Confirmar monto" size="32" onClick="return pasa_monto_recibo_js();">
        		  </td>
         <?php } ?>
          
          
          
          
      </tr>
      
      <tr valign="baseline" hidden="true">
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

              <?php if(isset($_GET['precio_confirmado']) && ($_GET['precio_confirmado']==1) ) { 
			?>              
              
      <tr valign="baseline">
              
              
              
              <!--<td nowrap align="right">&nbsp;</td> aca llamo a una function que cambie el estado del jugador -->
              <td nowrap align="center">          
              
               <a href="pdf_recibos.php?recordID=<?php echo $elJugador; ?>&fecha_recibo= <?php echo $today; ?>&monto_recibo= <?php echo $_GET['monto_recibo']; ?> &observacionesRecibo=<?php echo $_GET['observaciones_recibo']; ?>&anio2= <?php echo $_GET["anio2"]; ?>&pago_marzo= <?php echo $_GET['pago_marzo']; ?>&pago_abril= <?php echo $_GET['pago_abril']; ?>&pago_mayo= <?php echo $_GET['pago_mayo']; ?>&pago_junio= <?php echo $_GET['pago_junio']; ?>&pago_julio= <?php echo $_GET['pago_julio']; ?>&pago_agosto= <?php echo $_GET['pago_agosto']; ?>&pago_setiembre= <?php echo $_GET['pago_setiembre']; ?>&pago_octubre= <?php echo $_GET['pago_octubre']; ?>&pago_noviembre= <?php echo $_GET['pago_noviembre']; ?>"  >  
               
               		<img src="img/mono-icons/printer32.png" width="32" height="32" border="0" title="Imprimir recibo" >
                </a>	  	                                 
  <script> alert("Imprima y guarde el recibo");</script>
              </td>

              <td nowrap align="center">                    
        		     <input id="boton_guardar" align="middle" type="submit" value="Guardar recibo" required style="border-color:#06F" style="font-style:!important" > 
              </td>
              
        </tr>
		<?php }
			  ?> 
      </table>
          <input type="hidden" name="MM_insert" value="form1">
           
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
				<a href="http://olimarteam.uy/yerbalito/" >Gestión Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.uy">olimarteam.uy</a></div>
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
