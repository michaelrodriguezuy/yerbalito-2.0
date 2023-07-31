<?php

//include('seguridad.php');
//include('control.php');
//include('session.php');
include('Connections/yerbalito.php');

header('Content-Type: application/json');

//$pdo=new PDO('mysql:host=localhost;dbname=wwwolima_yerbalito;','wwwolima','rjW63u0I6n');
//$SentenciaSQL=$pdo->prepare("SELECT * FROM cumples");

//$SentenciaSQL="SELECT * FROM cumples";

$query = "SELECT jugador.idjugador, jugador.nombre, jugador.apellido, jugador.fecha_nacimiento, jugador.idcategoria, jugador.imagen, categoria.nombre_categoria FROM jugador JOIN categoria ON categoria.idcategoria = jugador.idcategoria WHERE jugador.idcategoria<>10 AND jugador.idcategoria<>9 AND jugador.idcategoria<>11 ORDER BY jugador.idcategoria, jugador.fecha_nacimiento";



mysqli_set_charset($db, "utf8"); //formato de datos utf8

//if(!$result = mysqli_query($db, $SentenciaSQL)) die();
//$result = pg_query($db, $query);
if  (! $result = mysqli_query($db, $query)) {
    echo "Error: " . $query . "<br>" . mysqli_error($db);
    exit();
}


//$cumpleaneros = array(); //creamos un array

/*
while($row = mysqli_fetch_array($result)) 
{ 
    $id=$row['id'];
    $idJug=$row['id_jugador'];
    $title=$row['title'];
    $descripcion=$row['descripcion'];
    $color=$row['color'];
    $textColor=$row['textColor'];
    $start=$row['start'];
    $end=$row['end']; //este no lo uso, esta pensado para eventos que duren mas de un dia o que tengan hora de inicio y fin
    $imagen=$row['imagen'];
    $idCat=$row['id_categoria'];
    
    //en este arreglo debo guardar solamente aquellos niños que cumplan años en el mes actual
    //para eso debo obtener el mes actual y compararlo con el mes de cada cumpleaños
    //si el mes actual es igual al mes del cumpleaños, entonces lo guardo en el arreglo
    //si no, no lo guardo
    //para obtener el mes actual, debo usar la funcion date('m') que me devuelve el mes actual
    //para obtener el mes del cumpleaños, debo usar la funcion date('m',strtotime($start)) que me devuelve el mes del cumpleaños
    
        $cumpleaneros[] = array('id'=> $id, 'id_jugador'=> $idJug, 'title'=> $title, 'descripcion'=> $descripcion, 'color'=> $color,'textColor'=> $textColor, 'start'=> $start, 'end'=> $end, 'imagen'=> $imagen, 'id_categoria'=> $idCat,);
    
    
    //$cumpleaneros[] = array('id'=> $id, 'id_jugador'=> $idJug, 'title'=> $title, 'descripcion'=> $descripcion, 'color'=> //$color,'textColor'=> $textColor, 'start'=> $start, 'end'=> $end, 'imagen'=> $imagen, 'id_categoria'=> $idCat,);
     
}*/

//$rows = pg_fetch_all($result);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$events = array();
foreach ($rows as $row) {
    
    $id = $row['idjugador'];
    $name = $row["nombre"] . " " . $row["apellido"];

    
    $birthday = new datetime($row['fecha_nacimiento']);
    $today = new datetime();
    
    $age1 = $today->diff($birthday)->y;
    $age2 = $age1;

    /* ANDA OK
    echo "Fecha de nacimiento: " . $birthday->format('Y-m-d') . "<br>";
    echo "Hoy: " . $today->format('Y-m-d') . "<br>";
    echo "Edad: " . $age . "<br>";
    */

    $fecha_cumpleanos = $birthday->format('Y-m-d');
    $fecha_actual_str = $today->format('Y-m-d');

    if ($fecha_actual_str<date("Y").substr($fecha_cumpleanos,4)) { 
    //    echo "No ha cumplido años aún";
        $age2=$age1+1;        
    } /*else {
        echo "Ya ha cumplido años ";
    }
    */

    $fecha_cumpleanos_ok = new datetime($fecha_cumpleanos);
    $fecha_cumpleanos_ok->modify("+{$age2} year");

    /*
    $cumpleActual = $fecha_cumpleanos_ok->format('Y-m-d');
    echo "Cumpleaños actual: " . $cumpleActual . "<br>";
    */


    $imagen = $row['imagen'];

    $event= array(
        "id" => $id,
        "title" => $name,
        "start" => $fecha_cumpleanos_ok->format('Y-m-d'),
        "description" => "Edad: $age1 años - Categoria: ". $row['nombre_categoria'],
        "image" => "images/$row[idcategoria]/".$imagen,
    );
    array_push($events, $event);
}

/*
    $cumpleaneros[] = array('nombre'=> $row['nombre'], 'apellido'=> $row['apellido'], 'fecha_nacimiento'=> $row['fecha_nacimiento'], 'id_categoria'=> $row['id_categoria']);
}
*/
//desconectamos la base de datos
//$close = mysqli_close($db)
//or die("Ha sucedido un error inexperado en la desconexion de la base de datos");


//Creamos el JSON
//$clientes['clientes'] = $clientes;

//$json_string = json_encode($cumpleaneros);
//echo $json_string;
echo json_encode($events);

/*
    $resultado= $SentenciaSQL->get_result();
    $data = $resultado->fetch_all(MYSQLI_ASSOC);    
}
echo json_encode($data);
*/

?>