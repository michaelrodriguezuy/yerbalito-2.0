<?php require_once('Connections/yerbalito.php'); 
 	include('seguridad.php');  
date_default_timezone_set('America/Montevideo');
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
$query_DatosJugador = sprintf("SELECT jugador.idjugador, jugador.nombre, jugador.apellido, jugador.idcategoria, jugador.idestado, categoria.nombre_categoria, estado.tipo_estado FROM jugador, categoria, estado WHERE (jugador.idcategoria = %s) AND (jugador.idcategoria = categoria.idcategoria) AND (jugador.idestado = estado.idestado) ORDER BY categoria.idcategoria, jugador.nombre", GetSQLValueString($varDato_DatosCategoria, "int"));
$DatosJugador = mysql_query($query_DatosJugador, $yerbalito) or die(mysql_error());
$row_DatosJugador = mysql_fetch_assoc($DatosJugador);
$totalRows_DatosJugador = mysql_num_rows($DatosJugador);
$categoria = $row_DatosJugador['nombre_categoria'];
 ob_start(); $html.='
 <html>
	<div id="header" align="center">	
				<img src="images/logo.png" alt="yerbalito" width="100" height="100" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" >        
	</div>
    <body>
	    <div align="center">
		      <h1><a href="#"></a> Lista de jugadores de la categoria'; echo $row_DatosJugador['nombre_categoria'];
		$html.='</h1>  
<table width="100%" border="0"cellpadding="2" cellspacing="2">
	        <tr class="blue-box">
			    <td bgcolor="#66CCFF">NOMBRE</td>
			    <td bgcolor="#66CCFF">APELLIDO</td>   
			    <td bgcolor="#66CCFF">ESTADO</td>
			 </tr>  ';
	 do { 
	 $html.='<tr>
      <td>';
		echo $row_DatosJugador['nombre']; $html.='</td>    
      <td>';
	 echo $row_DatosJugador['apellido']; $html.='</td>                         
      <td> ';
	 if ($row_DatosJugador['idestado']==1) { 
	 	$html.='<span style="background-color:#F00">';
		 echo $row_DatosJugador['tipo_estado']; $html.='</span>';    
	 }
	 elseif ($row_DatosJugador['idestado']==2) {
		 $html.='<span style="background-color:#0F0">';
			 echo $row_DatosJugador['tipo_estado']; $html.='</span>';
	 	}
		else { 
		$html.='<span style="background-color:#FF9">';	 echo $row_DatosJugador['tipo_estado']; $html.='</span>';
		}        
		$html.='</td>        
    </tr>';
     } 
	 while ($row_DatosJugador = mysql_fetch_assoc($DatosJugador)); 
	$html.=' 
	</table>	      
		</div>	   
        <footer>
        	<div align="center">
				<em> 
                	<small> <br> <br> date("d-m-Y H:i:s")
					</small> 
                 </em>
				<br> www.olimarteam.uy
            </div>
        </footer>
	</body>
</html>      ';
require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html(ob_get_clean());
$dompdf->render();
$pdf = $dompdf->output();
$filename = $categoria.'_'.date("d-m-Y H:i:s").'.pdf';
file_put_contents($filename, $pdf);
$dompdf->stream($filename);