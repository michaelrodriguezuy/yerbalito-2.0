<?php require_once('Connections/yerbalito.php'); 
include('seguridad.php');  
	
date_default_timezone_set('America/Montevideo');
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

$varDato_Recordset1 = "0";
if (isset($_GET["recordID"])) {
  $varDato_Recordset1 = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_Recordset1 = sprintf("SELECT * FROM jugador WHERE jugador.idjugador=%s", GetSQLValueString($varDato_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $yerbalito) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$jugador=$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'];

mysql_select_db($database_yerbalito, $yerbalito);
$query_Recordset2 = "SELECT recibo.numero+1 FROM recibo WHERE visible=1 ORDER BY idrecibo DESC";  //"SELECT numero+1 FROM recibo ORDER BY idrecibo DESC";
$Recordset2 = mysql_query($query_Recordset2, $yerbalito) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);


mysql_select_db($database_yerbalito, $yerbalito);
$query_Recordset3 = "SELECT * FROM categoria WHERE categoria.idcategoria=".$row_Recordset1['idcategoria'];
$Recordset3 = mysql_query($query_Recordset3, $yerbalito) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
/*
$monto_recibido="0";
if(isset($_GET["monto"]))
{
	if($_GET["monto"])
		$monto_recibido=$_GET["monto"];
	else
		echo "He recibido un campo vacio";
}
*/

if (isset($_GET["recordID"]) && isset($_GET["monto_recibo"]) && isset($_GET["observacionesRecibo"]) && isset($_GET["anio2"])) {
    // asignar w1 y w2 a dos variables
    $phpVar1 = $_GET["recordID"];
    $phpVar2 = $_GET["monto_recibo"];
	$phpVar3 = $_GET["observacionesRecibo"];
	$phpVar4 = $_GET["anio2"];
 
    // mostrar $phpVar1 y $phpVar2
    //echo "<p>Parameters: " . $phpVar1 . " " . $phpVar2 . "</p>";
} else {
    echo "<p>No se recibieron parametros</p>";
}


$php_marzo = "0";
$php_abril = "0";
$php_mayo = "0";
$php_junio = "0";
$php_julio = "0";
$php_agosto = "0";
$php_setiembre = "0";
$php_octubre = "0";
$php_noviembre = "0";


if (isset($_GET["pago_marzo"]) && isset($_GET["pago_abril"]) && isset($_GET["pago_mayo"]) && isset($_GET["pago_junio"]) && isset($_GET["pago_julio"]) && isset($_GET["pago_agosto"]) && isset($_GET["pago_setiembre"]) && isset($_GET["pago_octubre"]) && isset($_GET["pago_noviembre"])) {
    // asignar w1 y w2 a dos variables


$php_marzo = $_GET['pago_marzo'];
$php_abril = $_GET['pago_abril'];
$php_mayo = $_GET['pago_mayo'];
$php_junio = $_GET['pago_junio'];
$php_julio = $_GET['pago_julio'];
$php_agosto = $_GET['pago_agosto'];
$php_setiembre = $_GET['pago_setiembre'];
$php_octubre = $_GET['pago_octubre'];
$php_noviembre = $_GET['pago_noviembre'];

 
    // mostrar $phpVar1 y $phpVar2
    //echo "<p>Parameters: " . $phpVar1 . " " . $phpVar2 . "</p>";
}

$html = '<html>';
$html = '<html>';
$html = '<html>';
$html = '<html>';
$html = '<html>';
$html = '<html>';
$html = '<html>';
$html = '<html>';

$html .= '<div id="header" align="left">'; 
$html .= '<img src="./images/logo.jpg"/>'; 

$html .= '</div>';

$html .= '<body>';
$html .= '<div align="center">'; 
$html .= '<div align="right"><em> Fecha: '.date("d/m/Y", strtotime($_GET['fecha_recibo'])).'</em></div>'.'<h3 align="left">Recibo Nº '.$row_Recordset2['recibo.numero+1'].'</h3>'; 
$html .= '<h2>'.$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'].' - '.$row_Recordset3['nombre_categoria'].'</h2>'; 		  
$html .= '<p><a href="#"></a> Correspondiente al mes de: </p>';	  
$html .= '<table width="100%" border="1"cellpadding="2" cellspacing="2">';

$html .='<tr>																								';
$html .='   <td bgcolor="#666666"><label>                                                                   ';
$html .='     <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0"> Enero </label></td>       ';
$html .=' </tr>    
                                                                                         ';
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                   ';
$html .='     <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1"> Febrero </label></td>   ';
$html .=' </tr>                                                                                             ';


if ($php_marzo==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" > Marzo </label></td>      ';
$html .=' </tr>                                                                                             ';
elseif ($php_marzo==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" > Marzo </label></td>      ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="3" id="mes_pago_2" > Marzo </label></td>      ';
$html .=' </tr>                                                                                             ';
endif;

if ($php_abril==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" > Abril </label></td>      ';
$html .=' </tr>                                                                                             ';
elseif ($php_abril==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" > Abril </label></td>      ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="4" id="mes_pago_3" > Abril </label></td>      ';
$html .=' </tr>                                                                                             ';
endif;

if ($php_mayo==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" > Mayo </label></td>       ';
$html .=' </tr>                                                                                             ';
elseif ($php_mayo==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" > Mayo </label></td>       ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="5" id="mes_pago_4" > Mayo </label></td>       ';
$html .=' </tr>                                                                                             ';
endif;

if ($php_junio==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" > Junio </label></td>      ';
$html .=' </tr>                                                                                             ';
elseif ($php_junio==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" > Junio </label></td>      ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="6" id="mes_pago_5" > Junio </label></td>      ';
$html .=' </tr>                                                                                             ';
endif;

if ($php_julio==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" >Julio </label></td>       ';
$html .=' </tr>                                                                                             ';
elseif ($php_julio==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" >Julio </label></td>       ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="7" id="mes_pago_6" >Julio </label></td>       ';
$html .=' </tr>                                                                                             ';
endif;

if ($php_agosto==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" >Agosto </label></td>      ';
$html .=' </tr>                                                                                             ';
elseif ($php_agosto==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" >Agosto </label></td>      ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="8" id="mes_pago_7" >Agosto </label></td>      ';
$html .=' </tr>                                                                                             ';
endif;
	
if ($php_setiembre==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" > Setiembre </label></td>  ';
$html .=' </tr>                                                                                             ';
elseif ($php_setiembre==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" > Setiembre </label></td>  ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="9" id="mes_pago_8" > Setiembre </label></td>  ';
$html .=' </tr>                                                                                             ';
endif;


if ($php_octubre==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" >Octubre </label></td>    ';
$html .=' </tr>                                                                                             ';
elseif ($php_octubre==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" >Octubre </label></td>    ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="10" id="mes_pago_9" >Octubre </label></td>    ';
$html .=' </tr>                                                                                             ';
endif;


if ($php_noviembre==1):
	$html .=' <tr>                                                                                              ';
	$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
	$html .='     <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" >Noviembre </label></td> ';
	$html .=' </tr>';
elseif ($php_noviembre==0):
	$html .=' <tr>                                                                                              ';
	$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
	$html .='     <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" >Noviembre </label></td> ';
	$html .=' </tr> 																							';
else:
	$html .=' <tr>                                                                                              ';
	$html .='   <td bgcolor="#666666"><label>                                                                                     ';
	$html .='     <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" >Noviembre </label></td>    ';
	$html .=' </tr>                                                                                             ';
endif;

$html .=' <tr>';
$html .='   <td bgcolor="#666666"><label>';
$html .='<input  type="checkbox" name="mes_pago[]" value="12" id="mes_pago_11" >Diciembre </label></td>';
$html .='</tr>';

$html .= '</table>';
$html .= '<p><a href="#"></a> Año '.$phpVar4.'</p>';	 
$html .= '</div>';

$html .= '<p> Observaciones: '.$phpVar3.'</p>'; 		  
$html .= '<h2 align="left"><a href="#"></a> Total pago $ '.$phpVar2.'</h2>';

$html .= '</body></html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
';

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();

$dompdf->load_html(utf8_decode($html));//cargamos el html
$dompdf->render();

#Esto es lo que imprime en el PDF el numero de paginas
$canvas = $dompdf->get_canvas();
$footer = $canvas->open_object();
$w = $canvas->get_width();
$h = $canvas->get_height();
#$canvas->page_text($w-60,$h-28,"Página {PAGE_NUM} de {PAGE_COUNT}", Font_Metrics::get_font('helvetica'),6);
$canvas->page_text($w-115,$h-28,'Fecha de emision:'.date("d-m-Y H:i:s"), Font_Metrics::get_font('helvetica'),6);
$canvas->page_text($w/2,$h-28,'www.olimarteam.uy', Font_Metrics::get_font('helvetica'),6);
$canvas->close_object();
$canvas->add_object($footer,"all");

# Enviamos el fichero PDF al navegador.
//$dompdf->stream('FicheroEjemplo.pdf');

# Para grabar en fichero en ruta especifica
$pdf = $dompdf->output();
$filename ="./recibo_de/".$jugador.'_'.date("d-m-Y H:i:s").'.pdf';
file_put_contents($filename, $pdf);
$dompdf->stream($filename);

 #Liberamos 
unset($dompdf);