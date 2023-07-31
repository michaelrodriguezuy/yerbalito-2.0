<?php 


session_start();

// Verificar si existe una sesión activa
if (!isset($_SESSION["autentica"])) {
    header("Location: login.php"); // Redireccionar a la página de inicio de sesión si no hay sesión
    exit();
}
  
 ?> 



<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Yerbalito</title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/style1.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" />
		<!--[if IE 8]>
			<link rel="stylesheet" type="text/css" media="screen" href="/css/ie8-hacks.css" />
		<![endif]-->
		<!-- ENDS CSS -->	
				
		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
		
		<!-- JS -->
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/quicksand.js"></script>
		<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<!--[if IE]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="js/DD_belatedPNG.js"></script>
			<script>
	      		/* EXAMPLE */
	      		//DD_belatedPNG.fix('*');
	    	</script>
		<![endif]-->
		<!-- ENDS JS -->
		
		
		<!-- Nivo slider -->
		<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
		<script src="js/nivo-slider/jquery.nivo.slider.js" type="text/javascript"></script>
		<!-- ENDS Nivo slider -->
		
		<!-- tabs -->
		<link rel="stylesheet" href="css/tabs.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/tabs.js"></script>
  		<!-- ENDS tabs -->
  		
  		<!-- prettyPhoto -->
		<script type="text/javascript" src="js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />
		<!-- ENDS prettyPhoto -->
		
		<!-- superfish -->
		<link rel="stylesheet" media="screen" href="css/superfish.css" /> 
		<link rel="stylesheet" media="screen" href="css/superfish-left.css" /> 
		<script type="text/javascript" src="js/superfish-1.4.8/js/hoverIntent.js"></script>
		<script type="text/javascript" src="js/superfish-1.4.8/js/superfish.js"></script>
		<script type="text/javascript" src="js/superfish-1.4.8/js/supersubs.js"></script>
		<!-- ENDS superfish -->
		
		<!-- poshytip -->
		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-twitter/tip-twitter.css" type="text/css" />
		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
		<script type="text/javascript" src="js/poshytip-1.0/src/jquery.poshytip.min.js"></script>
		<!-- ENDS poshytip -->
		
		<!-- Tweet -->
		<link rel="stylesheet" href="css/jquery.tweet.css" media="all"  type="text/css"/> 
		<script src="js/tweet/jquery.tweet.js" type="text/javascript"></script> 
		<!-- ENDS Tweet -->
		
		<!-- Fancybox -->
		<link rel="stylesheet" href="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<!-- ENDS Fancybox -->
		
		<!-- SKIN -->
		<link rel="stylesheet" href="skins/plastic/style.css" type="text/css" media="screen" />

 <!-- favicon-->
		<link rel="shortcut icon" href="favicon.ico" >

		
	</head>
	
	<body class="">
	
	
	<!-- WRAPPER -->
	<div id="wrapper">
		
		<!-- HEADER -->
	  <div id="header"><!-- Social -->
			<div align="center">
		  <img src="images/logo3.png" alt="yerbalito" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" >        
        </div>
			<!-- ENDS Social -->
			
			<!-- Navigation --><!-- Navigation -->	
			
			<!-- search --><!-- ENDS search -->
			
			<!-- Breadcrumb--><!-- ENDS Breadcrumb-->	

		</div>
		<!-- ENDS HEADER -->
		    
    	<!-- MAIN -->

	  <div id="main"> 
       <div align="center">
	      
      	      <h1 align="center">Reportes: </h1>

			<form name="filtro" action="<?php echo $PHP_SELF;?>" method="POST">

<table align="center">

	<tr valign="baseline">
        
      <td nowrap align="center">          
              
              <select name="categoria" title="Categoria">
          	    <option value="0"></option>
				<option value="1">Abejitas (2014)</option>
				<option value="2">Grillitos (2013)</option>
				<option value="3">Chatitas (2012)</option>
				<option value="4">Churrinches (2011)</option>
                <option value="5">Gorriones(2010)</option>
                <option value="6">Semillas (2009)</option>
                <option value="7">Cebollitas (2008)</option>
                <option value="8">Babys (2007)</option>
                <option value="11">Sub9</option>
                <option value="12">Sub11</option>
                <option value="13">Sub13</option>
			</select>
              
              <!-- le paso la categoria de la que quiero saber la cantidad de meses que tienen pagos sus jugadores -->
               <a href="pdf_cant_meses_pagos.php?recordID=<?php echo $_GET['categoria']; ?>" >   
               
               		<img src="img/mono-icons/printer32.png" width="32" height="32" border="0" title="Imprimir reporte" >
                </a>	  	                                 

              </td>
     </tr>		
                    
            <tr valign="baseline">        
                    <td nowrap align="center"> 

					

    		   <select name="deuda" title="Deudores">
				<option value="0">Jugadores al día</option>
				<option value="1">Jugadores que deben 1 mes</option>
				<option value="2">Jugadores que deben 2 meses</option>
				<option value="3">Jugadores que deben 3 meses o más</option>
			</select>
   	
    	     <input type="submit" name="filtrar" value="Filtrar">
            
            <h1>
            
            </td>
            
            </tr>
           
            
            
             </table>
            <?php

				$meses_deudas = $_POST['deuda'];
				
				if ($meses_deudas==0){
					echo "Listado de jugadores al día: ";	
							?>	<option value="0" selecte> <?php
				}
				elseif ($meses_deudas==1){
				    echo "Listado de jugadores con 1 mes de deuda: ";
							?>	<option value="1" selected> <?php
				}
				elseif ($meses_deudas==2){
					echo "Listado de jugadores con 2 meses de deuda: ";
						?>	<option value="2" selected> <?php
				}
				else{
					echo "Listado de jugadores con 3 meses o más de deuda: ";
							?>	<option value="3" selected> <?php
				}
			?>           
            
            </h1>
		</form>   
	  

 
      
      <table width="100%" border="0"cellpadding="2" cellspacing="2">
	        <tr class="blue-box">
			    <td>Nombre</td>
			    <td>Apellido</td>			                    
                <td>Categoria</td>                

			 </tr>
<?php

/*
if($meses_deudas==1)
{
	*/


	$jugadores="SELECT * FROM jugador WHERE idcategoria<>9 AND idcategoria<>10 AND idestado<>3 ORDER BY idcategoria ASC"; // AND recibo.anio = $hoy[year]");
	mysql_select_db($database_yerbalito, $yerbalito);
	$result_jugadores=mysql_query($jugadores,$yerbalito)or die(mysql_error());

$hoy=getdate();

if($result_jugadores && mysql_num_rows($result_jugadores)>0)
{
	while($row=mysql_fetch_array($result_jugadores))

	{
		$mysqli = new mysqli($hostname_yerbalito,$username_yerbalito, $password_yerbalito, $database_yerbalito);
		$query = $mysqli->prepare("SELECT * FROM recibo WHERE idjugador=".$row['idjugador']." AND anio= $hoy[year]"); //cantidad de recibos que tiene el jugador, pagos
		$query->execute();
		$query->store_result();
		$rows = $query->num_rows; //ACA TENGO TODOS LOS RECIBOS PAGOS DE ESE JUGADOR

		$meses_resta=0;
		$fechaingreso = $row['fecha_ingreso'];
		$fechaactual = date("Y-m-d");
		
		//no me reconoce esta funcion
//		$diferencia = $fechaingreso->diff($fechaactual);
//		$meses_resta = ( $diferencia->y * 12 ) + $diferencia->m;
	

		if ($meses_deudas==0) {

			//OJO esta formular varia con el paso de los mes de ENERO y DICIEMBRE
			//ACA ENTRO CUANDO QUIERO JUGADORES AL DIA, QUE DEBEN 1 Ó 2 MESES SOLAMENTE
			
			if ( ((date(m)-1)- $rows) <=0) //el numero 10 es para jugadores que tuvieron todo el año pasado, deberia obtener este numero de la fecha de inscripcion
			{ 
									   				 
				 ?>
 				   <tr>
				    <?php	
							$sql2="SELECT * FROM categoria WHERE idcategoria=".$row['idcategoria'];
							mysql_select_db($database_yerbalito, $yerbalito);
							$result_categoria_jugador=mysql_query($sql2,$yerbalito);
					
						 	while($row2=mysql_fetch_array($result_categoria_jugador))
							{
				 				?>        
								<td>	<?php echo $row['nombre']; ?> </td>       			         
								<td> <?php echo $row['apellido']; ?></td>    						
								<td><?php echo $row2['nombre_categoria']; ?></td>           
								<?php
							}
					?>
                    </tr>
                    <?php					
			
			}
			
		}
		if ($meses_deudas==1) {
			//OJO esta formular varia con el paso de los mes de ENERO y DICIEMBRE
			//ACA ENTRO CUANDO QUIERO JUGADORES AL DIA, QUE DEBEN 1 Ó 2 MESES SOLAMENTE
			
			if ( ((date(m)-1)- $rows) ==1) //el numero 10 es para jugadores que tuvieron todo el año pasado, deberia obtener este numero de la fecha de inscripcion
			{ 			   				 
				 ?>
 				   <tr>
				    <?php	
							$sql2="SELECT * FROM categoria WHERE idcategoria=".$row['idcategoria'];
							mysql_select_db($database_yerbalito, $yerbalito);
							$result_categoria_jugador=mysql_query($sql2,$yerbalito);
					
						 	while($row2=mysql_fetch_array($result_categoria_jugador))
							{
				 				?>        
								<td>	<?php echo $row['nombre']; ?> </td>       			         
								<td> <?php echo $row['apellido']; ?></td>    						
								<td><?php echo $row2['nombre_categoria']; ?></td>           
								<?php
							}
					?>
                    </tr>
                    <?php					
			
			}
			
		}
		if ($meses_deudas==2) {
			//OJO esta formular varia con el paso de los mes de ENERO y DICIEMBRE
			//ACA ENTRO CUANDO QUIERO JUGADORES AL DIA, QUE DEBEN 1 Ó 2 MESES SOLAMENTE
			
			if ( ((date(m)-1)- $rows) ==2) //el numero 10 es para jugadores que tuvieron todo el año pasado, deberia obtener este numero de la fecha de inscripcion
			{ 			   				 
				 ?>
 				   <tr>
				    <?php	
							$sql2="SELECT * FROM categoria WHERE idcategoria=".$row['idcategoria'];
							mysql_select_db($database_yerbalito, $yerbalito);
							$result_categoria_jugador=mysql_query($sql2,$yerbalito);
					
						 	while($row2=mysql_fetch_array($result_categoria_jugador))
							{
				 				?>        
								<td>	<?php echo $row['nombre']; ?> </td>       			         
								<td> <?php echo $row['apellido']; ?></td>    						
								<td><?php echo $row2['nombre_categoria']; ?></td>           
								<?php
							}
					?>
                    </tr>
                    <?php					
			
			}
			
		}
		if ($meses_deudas==3) { //aca entro cuando son jugadores que deben 3 meses o mas

			if ( ((date(m)-1)- $rows) >= 3) 
		{ 			  
			//	echo juanMartin; 				 
				 ?>
 				   <tr>
				    	<?php	
							$sql2="SELECT * FROM categoria WHERE idcategoria=".$row['idcategoria'];
							mysql_select_db($database_yerbalito, $yerbalito);
							$result_categoria_jugador=mysql_query($sql2,$yerbalito);
					
						 	while($row2=mysql_fetch_array($result_categoria_jugador))
							{
				 				?>        
								<td>	<?php echo $row['nombre']; ?> </td>       			         
								<td> <?php echo $row['apellido']; ?></td>    						
								<td><?php echo $row2['nombre_categoria']; ?></td>           
								<?php
							}
						?>
                  </tr>
                 <?php					
			
		}
		}
		
		
		
	} //CIERRE DE WHILE
	$meses_deudas=0;
}
/*
}
elseif ($meses_deudas==2) {	

}
elseif ($meses_deudas==3) {	

}
*/
?>




 		 </table>

	      
		</div>	   
        
	  </div>
		<!-- ENDS MAIN -->

  	  <!-- FOOTER -->
	<div id="footer">
    <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion" ></a> 
    
    
    
     <a href="panel.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al Panel de control"></a>				
				<!-- footer-cols -->				<!-- ENDS footer-cols -->				
				<!-- Bottom --> 
				<div id="bottom">
				<a href="http://olimarteam.uy/yerbalito/" >Gestión Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.uy">olimarteam.uy</a>
                
                
                </div>
				<!-- ENDS Bottom -->
               
	  </div>
		<!-- ENDS FOOTER -->
	</div>
	<!-- ENDS WRAPPER -->
    
    
     
	
	Usuario: <?php echo $_SESSION["nombre"]; ?>
	</body>
	
</html>