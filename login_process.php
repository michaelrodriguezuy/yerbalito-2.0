<?php
session_start(); // Iniciar la sesión

// Verificar si se enviaron los datos de inicio de sesión
if (isset($_POST["usuario"]) && isset($_POST["clave"])) {
    include('Connections/yerbalito.php'); // Incluir el archivo de conexión a la base de datos

    $usuario = mysqli_real_escape_string($db, $_POST["usuario"]);
    $clave = md5($_POST["clave"]);

    // Realizar la consulta para verificar las credenciales
    $query = "SELECT id_usuario, nombre, admin FROM usuario WHERE usuario = '$usuario' AND password = '$clave'";
    $resultado = mysqli_query($db, $query);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($db));
    }

    // Verificar si se encontró un usuario con las credenciales ingresadas
    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);

        $_SESSION["autentica"] = "SIP";
        $_SESSION["id_usuario"] = $fila["id_usuario"];
        $_SESSION["nombre"] = $fila["nombre"];
        $_SESSION["admin"] = $fila["admin"];

        header("Location: panel.php"); // Redireccionar a la página principal después de iniciar sesión
        exit();
    } else {
        echo "<p>Usuario o contraseña incorrectos. <a href=\"login.php\">Volver a intentar</a></p>";
    }

    mysqli_close($db); // Cerrar la conexión a la base de datos
} else {
    header("Location: login.php"); // Redireccionar si no se enviaron los datos de inicio de sesión
    exit();
}
?>
