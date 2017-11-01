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
    /*Cargamos el catalogo para ver los precios de cada pelicula*/
    $catalogo = simplexml_load_file("../XML/catalogo.xml");
    /*Cargamos el historial en un array que vamos a modificar y posteriormente
    volcar en el fichero*/
    $historial = simplexml_load_file("../usuarios/$nick/historial.xml");
    $today = date("d/m/y");
    $fecha = $historial->xpath("/historial/fecha[date=\"$today\"]")[0];
    /*Comprobamos si el usuario ya ha hecho compras en este mismo dia
    en cuyo caso no crearemos una entrada nueva, si no que modificaremos la
    existente*/
    if(!$fecha){
        $fecha = $historial->addChild('fecha');
        $fecha->addChild('date', $today);
    }
    
    /*Recorremos los id de las peliculas*/
    foreach (array_keys($_SESSION["items"]) as $item){
        $uds = $_SESSION["items"][$item];
        $precio = $catalogo->xpath("/catalogo/pelicula[id=\"$item\"]/precio")[0];
        
        /*Comprobamos si ya existe una pelicula con el id*/
        if($pelicula = $historial->xpath("/historial/fecha/pelicula[id=\"$item\"]")[0]){
            $pelicula->uds+=$uds;
            $pelicula->precio = $precio*$pelicula->uds;
        } else {
            $pelicula = $fecha->addChild("pelicula");
            $pelicula->addChild("id", $item);
            $pelicula->addChild("uds", $uds);
            $pelicula->addChild("precio", $precio*$uds);
        }
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