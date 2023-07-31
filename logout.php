<?php
session_start();
session_destroy(); // Destruir la sesión
header("Location: index.php"); // Redireccionar al inicio de sesión después de cerrar sesión
exit();
?>