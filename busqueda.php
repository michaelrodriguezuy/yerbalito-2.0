<?php require_once('Connections/yerbalito.php');
 include('seguridad.php');

mysql_set_charset('utf8');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<form name="filtro" action="<?php echo $PHP_SELF;?>" method="POST">
<select name="estado">
<option value="0"></option>
<option value="1">No habilitado</option>
<option value="2">Habilitado</option>
<option value="3">Exonerado</option>
</select>
<input type="submit" name="filtrar" value="Filtrar">
</form>

<?php
//recibo los criterios y construyo la consulta
if($_POST['estado'])
{
	$estadoJugador = $_POST['estado'];
	$sql="select * from jugador where idestado=".$estadoJugador." ORDER BY idcategoria";
	mysql_select_db($database_yerbalito, $yerbalito);
	$result=mysql_query($sql,$yerbalito);
}
else
	$sql="select * from jugador ORDER BY idcategoria";
	mysql_select_db($database_yerbalito, $yerbalito);
	$result=mysql_query($sql,$yerbalito);
	
if($result && mysql_num_rows($result)>0)
{
	?>
	<table>
	<?php
		while($row=mysql_fetch_array($result))
		{
			
		$sql2="select * from categoria WHERE idcategoria=".$row['idcategoria'];
		mysql_select_db($database_yerbalito, $yerbalito);
		$result2=mysql_query($sql2,$yerbalito);
		
		 		while($row2=mysql_fetch_array($result2))
				{
					?>
					<tr>
					<td><?php echo $row['nombre']." ".$row['apellido']." - ".$row2['nombre_categoria'];?></td>
					<tr>
			      <?php		
				}		
		}
} 
?>
	</table>

</body>
</html>