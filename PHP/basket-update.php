<?php

session_start();

if(isset($_REQUEST["film"])){
    /*Caso añadir una peli*/
    /*Miramos si hay una sesion iniciada e incrementamos el
    numero de articulos en el carro*/
    if(isset($_SESSION["basketNitems"])){
        $_SESSION["basketNitems"]++;
    }

    else {
        $_SESSION["basketNitems"] = 1;
        /*Creamos el array de pelis*/
        $_SESSION["items"] = array();

    }

    /*Metemos el id de la peli en el array y las unidades a modo de diccionario*/
    /*Si ya existia la peli, aumentamos el uno el numero de unidades*/
    if(array_key_exists($_REQUEST["film"], $_SESSION["items"]))
        $_SESSION["items"][$_REQUEST["film"]]++;
    /*En caso contrario añadimos la peli y ponemos las unidades a 1*/
    else {
        $_SESSION["items"][$_REQUEST["film"]] = 1;
    }
    /*Si el usuario ha seleccionado "Comprar" mostramos la ventana del carro*/
    if(isset($_REQUEST["basket"]))
        header("Location: basket.php");
    /*Si selecciono "Añadir ..." mostramos la ventana de index*/
    else 
        header("Location: index.php");
} else if (isset($_REQUEST["xfilm"])){
    /*Caso borrar una peli*/
    if (array_key_exists($_REQUEST["xfilm"], $_SESSION["items"])) {
        $_SESSION["items"][$_REQUEST["xfilm"]]--;
        /*Si las unidades de la pelicula llegan a 0 la borramos del array 
        para que no aparezca en la tabla del carrito*/
        if(!$_SESSION["items"][$_REQUEST["xfilm"]]) 
            unset($_SESSION["items"][$_REQUEST["xfilm"]]);
        $_SESSION["basketNitems"]--;
        
    }
    header("Location: basket.php");
}

?>