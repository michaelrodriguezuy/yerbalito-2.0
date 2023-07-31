
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Yerbalito </title>

    <!-- CSS -->

    <link rel="stylesheet" href="./css/loginSignupStyles.css">

 
    <!-- favicon-->
    <link rel="shortcut icon" href="favicon.ico">



</head>

<body>

    <header class="container">
        <nav>
            <img src="assets/logo3.png" alt="yerbalito" class="header" longdesc="assets/logo3.png" hspace="0"
                vspace="0">
        </nav>
    </header>

    <div class="container">

        <form action="login_process.php" method="post" id="form">

            <div class="form-header">
                <h2>Yerbalito</h2>
                <p class="rounded">Login</p>
            </div>

            <label for="usuario">Nombre de usuario:</label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" required>

            <input type="submit" value="Ingresar">

        </form>
    </div>

    <footer class="ingresarA">
        <a href="http://yerbalito.uy/">Yerbalito</a> es un sitio de <a target="_blank"
            href="http:/olimarteam.uy">olimarteam.uy</a>
    </footer>

</body>

</html>