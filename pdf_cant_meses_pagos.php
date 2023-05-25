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
if (isset($_GET["categoria"])) {
  $varDato_Recordset1 = $_GET["categoria"];
}

//aca obtengo la categoria para mostrar
mysql_select_db($database_yerbalito, $yerbalito);
$query_Recordset3 = sprintf("SELECT * FROM categoria WHERE categoria.idcategoria=%s", GetSQLValueString($varDato_Recordset1, "int"));
$Recordset3 = mysql_query($query_Recordset3, $yerbalito) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

//aca tengo todos los jugadores de esa categoria	
		$sql="select * from jugador where idcategoria=".$varDato_Recordset1." ORDER BY nombre";
	mysql_select_db($database_yerbalito, $yerbalito);
	$result=mysql_query($sql,$yerbalito);


//contar los meses pagos por jugador en el año 2020
$sql4="select * from recibo WHERE idjugador=".$result['idjugador']." AND anio=2020 ORDER BY mes_pago DESC";
		mysql_select_db($database_yerbalito, $yerbalito);
		$result4=mysql_query($sql4,$yerbalito);	
$row4=mysql_fetch_array($result4);
						
							if ($row4['mes_pago']==1) {
								 echo 'NO TIENE PAGOS EN EL 2020';
                    		}
							elseif ($row4['mes_pago']==2) {
								 echo FEBRERO;
                    		}
                    		elseif ($row4['mes_pago']==3) {
								 echo MARZO;
                    		}
							elseif ($row4['mes_pago']==4) {
								 echo ABRIL;
                    		}
							elseif ($row4['mes_pago']==5) {
								 echo MAYO;
                    		}
							elseif ($row4['mes_pago']==6) {
								 echo JUNIO;
                    		}
							elseif ($row4['mes_pago']==7) {
								 echo JULIO;
                    		}
							elseif ($row4['mes_pago']==8) {
								 echo AGOSTO;
                    		}
							elseif ($row4['mes_pago']==9) {
								 echo SETIEMBRE;
                    		}
							elseif ($row4['mes_pago']==10) {
								 echo OCTUBRE;
                    		}
							elseif ($row4['mes_pago']==11) {
								 echo ANUAL;
                    		}
							elseif ($row4['mes_pago']==12) {
								 echo ANUAL;
                    		}


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

if (isset($_GET["categoria"]) ) {
    // asignar w1 y w2 a dos variables
    $phpVar1 = $_GET["categoria"];
  
 
    // mostrar $phpVar1 y $phpVar2
    //echo "<p>Parameters: " . $phpVar1 . " " . $phpVar2 . "</p>";
} else {
    echo "<p>No se recibieron parametros</p>";
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
$html .= '<img src="./images/logo_print.jpg"/>'; 

$html .= '</div>';

$html .= '<body>';
$html .= '<div align="center">'; 
$html .= '<div align="right"><em> Fecha: '.date("d/m/Y", strtotime($_GET['fecha_recibo'])).'</em></div>'.'<h3 align="left">Categoria: '.$row_Recordset3['nombre_categoria'].'</h3>'; 
$html .= '<h2>'.$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'].'</h2>'; 		  
$html .= '<p><a href="#"></a> Correspondiente al mes de: </p>';	  
$html .= '<table width="100%" border="1"cellpadding="2" cellspacing="2">';
$html .='<tr>																								';
$html .='   <td bgcolor="#666666"><label>                                                                   ';
$html .='     <input  type="checkbox" name="mes_pago[]" value="1" id="mes_pago_0"> Enero </label></td>       ';
$html .=' </tr>    
                                                                                         ';
if ($php_febrero==1): 
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#00FF00"><label>                                                                   ';
$html .='     <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1"> Febrero </label></td>   ';
$html .=' </tr>                                                                                             ';
elseif ($php_febrero==0): 
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#FFFFFF"><label>                                                                   ';
$html .='     <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1"> Febrero </label></td>   ';
$html .=' </tr>                                                                                             ';
else: //si entra aca es porque ya se pagó (2)
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                   ';
$html .='     <input  type="checkbox" name="mes_pago[]" value="2" id="mes_pago_1"> Febrero </label></td>   ';
$html .=' </tr>                                                                                             ';
endif;

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

if ($phpVar4==2019):
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
	endif;
elseif ($phpVar4==2020):
$html .=' <tr>                                                                                              ';
$html .='   <td bgcolor="#666666"><label>                                                                                     ';
$html .='     <input type="checkbox" name="mes_pago[]" value="11" id="mes_pago_10" >Noviembre </label></td> ';
$html .=' </tr> 																							';
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