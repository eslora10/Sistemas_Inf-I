<?php
session_start();
if(!isset($_SESSION["saldo"])){
    /*El usuario debe hacer login primero*/
    $_SESSION["from_basket"] = true;
    header("Location: login.php");
} else if($_SESSION["total_basket"] > $_SESSION["saldo"]){
    /*El saldo es insuficiente*/
    header("Location: basket.php?sell=0");
} else {
    $nick = $_SESSION["nick"];
    $catalogo = simplexml_load_file("../XML/catalogo.xml");
    $historial = simplexml_load_file("../usuarios/$nick/historial.xml");
    $today = date("d/m/y");
    $fecha = $historial->xpath("/historial/fecha[date=\"$today\"]")[0];
    if(!$fecha){
        $fecha = $historial->addChild('fecha');
        $fecha->addChild('date', $today);
    }
    foreach ($_SESSION["items"] as $item){
        $pelicula = $fecha->addChild("pelicula");
        $pelicula->addChild("id", $item);
        $precio = $catalogo->xpath("/catalogo/pelicula[id=\"$item\"]/precio")[0];
        $pelicula->addChild("precio", $precio);
    }
    /*Actualizamos el saldo en sesion*/
    $historial->asXML("../usuarios/$nick/historial.xml"); 
    $_SESSION["saldo"] -= $_SESSION["total_basket"];
    /*Cambiamos el saldo en el fichero del usuario*/
    $user_data = file("../usuarios/$nick/datos.dat");
    $user_data[4] = $_SESSION["saldo"];
    /*Actualizamos el fichero*/
    file_put_contents ("../usuarios/$nick/datos.dat", $user_data);
    
    unset($_SESSION["items"]);
    unset($_SESSION["basketNitems"]);
    header("Location: index.php");
}

?>