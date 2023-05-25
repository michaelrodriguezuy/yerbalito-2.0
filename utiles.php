<?php


require_once('Connections/yerbalito.php');
include("control.php");


function mostrarCantidadJugadores() {

echo '<script type="text/JavaScript">

    const cantidad= document.getElementById (".cantidad-finalizadas");
</script>';

$sql="select * from jugador where idcategoria<>10 AND idcategoria<>9 AND idcategoria<>11 ORDER BY idcategoria, nombre";

mysql_select_db($database_yerbalito, $yerbalito);

$result=mysql_query($sql,$yerbalito);   

echo '<script type="text/JavaScript">
    cantidad.innerText = ${mysql_num_rows($result)};
</script>';

}


?>