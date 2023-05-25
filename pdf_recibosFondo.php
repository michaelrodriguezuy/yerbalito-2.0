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
$query_Recordset2 = "SELECT fondocampeonato.numero+1 FROM fondocampeonato ORDER BY id_fondo DESC";  //"SELECT numero+1 FROM recibo ORDER BY idrecibo DESC";
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

if (isset($_GET["recordID"]) && isset($_GET["monto"]) && isset($_GET["observaciones"]) && isset($_GET["anio2"])) {
    // asignar w1 y w2 a dos variables
    $phpVar1 = $_GET["recordID"];
    $phpVar2 = $_GET["monto"];
	$phpVar3 = $_GET["observaciones"];
	$phpVar4 = $_GET["anio2"];
 
    // mostrar $phpVar1 y $phpVar2
    //echo "<p>Parameters: " . $phpVar1 . " " . $phpVar2 . "</p>";
} else {
    echo "<p>No se recibieron parametros</p>";
}


$php_cuota_1 = "0";
$php_cuota_2 = "0";

if (isset($_GET["cuota_1"]) && isset($_GET["cuota_2"]) ) {
    // asignar w1 y w2 a dos variables


$php_cuota_1 = $_GET['cuota_1'];
$php_cuota_2 = $_GET['cuota_2'];


 
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
$html .= '<img src="./images/logo_print.jpg"/>'.'<div align="center"><em> FONDO DE CAMPEONATO </em></div>'; 

$html .= '</div>';

$html .= '<body>';
$html .= '<div align="center">'; 
$html .= '<div align="right"><em> Fecha: '.date("d/m/Y", strtotime($_GET['fecha'])).'</em></div>'.'<h3 align="left">Recibo Nº '.$row_Recordset2['fondocampeonato.numero+1'].'</h3>'; 
$html .= '<h2>'.$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'].' - '.$row_Recordset3['nombre_categoria'].'</h2>'; 		  
$html .= '<p><a href="#"></a> Correspondiente a la cuota: </p>';	  
$html .= '<table width="100%" border="1"cellpadding="2" cellspacing="2">';

if ($php_cuota_1==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="cuota_paga[]" value="1" id="cuota_paga_1" > Cuota 1 </label></td>      ';
$html .=' </tr>                                                                                             ';
elseif ($php_cuota_1==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="cuota_paga[]" value="1" id="cuota_paga_1" > Cuota 1 </label></td>      ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="cuota_paga[]" value="1" id="cuota_paga_1" > Cuota 1 </label></td>      ';
$html .=' </tr>                                                                                             ';
endif;

if ($php_cuota_2==1):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                                     ';
$html .='     <input type="checkbox" name="cuota_paga[]" value="2" id="cuota_paga_2" > Cuota 2 </label></td>      ';
$html .=' </tr>                                                                                             ';
elseif ($php_cuota_2==0):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                                     ';
$html .='     <input type="checkbox" name="cuota_paga[]" value="2" id="cuota_paga_2" > Cuota 2 </label></td>      ';
$html .=' </tr>                                                                                             ';
else:
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="cuota_paga[]" value="2" id="cuota_paga_2" > Cuota 2 </label></td>      ';
$html .=' </tr>                                                                                             ';
endif;

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