<?php
//include('seguridad.php');

//iniciamos la sesión o la retomamos
/*
_DISABLED = 0
_NONE = 1
_ACTIVE = 2
	
	
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	elseif(session_status() === PHP_SESSION_NONE) session_start();
*/

   include("control.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['usuario']);
      $mypassword = mysqli_real_escape_string($db,md5($_POST['clave'])); 
      
	  //mysqli
      $sql = $db-> query("SELECT * FROM usuario WHERE usuario ='" .$myusername."' and password = '". $mypassword."' ");
	  	  

	//lo uso para debugear
	/*
	  if (!$sql) {
		print_r(mysqli_error($db));
	  }
      */

      if($sql->num_rows == 1) { 
        
		$obj = $sql -> fetch_object(); //me trae el objeto de la consulta
		$_SESSION['login_user'] = $obj->nombre; //nombre de usuario
		$_SESSION['admin'] = $obj->admin; //es un numero que me indica el nivel de permisos
		
		header("location: panel.php");			
		
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Yerbalito </title>

    <!-- CSS -->

    <link rel="stylesheet" href="./css/loginSignupStyles.css">

    <!-- 
		<link rel="stylesheet" href="css/style1.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" />

		<link rel="stylesheet" href="css/styled-elements.css" type="text/css" media="screen" />
 -->

    <!-- GOOGLE FONTS 
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
		-->

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

        <form action="" method="post" id="form">

            <div class="form-header">
                <h2>Yerbalito</h2>
                <p class="rounded">Login</p>
            </div>

            <label>Usuario</label>
            <input type="text" name="usuario" id="usuario">

            <label>Contraseña</label>
            <input type="password" name="clave" id="clave">

            <button type="submit" value="Entrar"> Ingresar </button>

        </form>
    </div>

    <footer class="ingresarA">
        <a href="http://olimarteam.uy/yerbalito/">Yerbalito</a> es un sitio de <a target="_blank"
            href="http:/olimarteam.uy">olimarteam.uy</a>
    </footer>

</body>

</html>