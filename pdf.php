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
$varDato_DatosCategoria = "0";
if (isset($_GET["recordID"])) {
  $varDato_DatosCategoria = $_GET["recordID"];
}
mysql_select_db($database_yerbalito, $yerbalito);
$query_DatosJugador = sprintf("SELECT jugador.idjugador, jugador.nombre, jugador.apellido, jugador.idcategoria, jugador.idestado, categoria.nombre_categoria, categoria.tecnico, estado.tipo_estado FROM jugador, categoria, estado WHERE (jugador.idcategoria = %s) AND (jugador.idcategoria = categoria.idcategoria) AND (jugador.idestado = estado.idestado) ORDER BY categoria.idcategoria, jugador.nombre", GetSQLValueString($varDato_DatosCategoria, "int"));
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);
$categoria = $row_DatosJugador['nombre_categoria'];

$html = '<html>';
$html .= '<div id="header" align="center">'; 
$html .= '<img src="./images/logo_print.jpg"/>'; 
$html .= '</div>';
$html .= '<body>';
$html .= '<div align="center">';
$html .= '<h1><a href="#"></a> Jugadores de ';
$html .= ' '.$row_DatosJugador["nombre_categoria"].' - '.$row_DatosJugador["tecnico"];
$html .= '</h1>';  
$html .= '<table width="100%" border="0"cellpadding="2" cellspacing="2">';
$html .= '<tr class="blue-box">';
$html .= '<td bgcolor="#66CCFF">NOMBRE</td>';
$html .= '<td bgcolor="#66CCFF">APELLIDO</td>';   
$html .= '<td bgcolor="#66CCFF">ESTADO</td>';
$html .= '</tr>';
do {
$html .= '<tr>';
$html .= '<td>';
$html .= ''.$row_DatosJugador['nombre'].'';
$html .= '</td>';
$html .= '<td>';
$html .= ''.$row_DatosJugador['apellido'].''; 
$html .= '</td>';
$html .= '<td>';
if ($row_DatosJugador['idestado']==1) {
$html .= '<span style="background-color:#F00">';
$html .= ''.$row_DatosJugador["tipo_estado"].'';
$html .= '</span>';
} elseif ($row_DatosJugador["idestado"]==2) {
$html .= '<span style="background-color:#0F0">';
$html .= ''.$row_DatosJugador['tipo_estado'].'';
$html .= '</span>';
} else {
$html .= '<span style="background-color:#FF9">';
$html .= ''.$row_DatosJugador["tipo_estado"].''; 
$html .= '</span>';
};
$html .= '</td>';
$html .= '</tr>';
} while ($row_DatosJugador = mysql_fetch_assoc($DatosJugador)); 
$html .= '</table>';
$html .= '</div>';

$html .= '</body></html>';

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





$pdf = $dompdf->output();
$filename ="./reportes/".$categoria.'_'.date("d-m-Y H:i:s").'.pdf';
file_put_contents($filename, $pdf);
$dompdf->stream($filename);

 #Liberamos 
unset($dompdf);