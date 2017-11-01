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

    /*Metemos el id de la peli en el array*/
    if(array_key_exists($_REQUEST["film"], $_SESSION["items"]))
        $_SESSION["items"][$_REQUEST["film"]]++;
    else {
        $_SESSION["items"][$_REQUEST["film"]] = 1;
    }
    if(isset($_REQUEST["basket"]))
        header("Location: basket.php");
    else 
        header("Location: index.php");
} else if (isset($_REQUEST["xfilm"])){
    /*Caso borrar una peli*/
    if (array_key_exists($_REQUEST["xfilm"], $_SESSION["items"])) {
        $_SESSION["items"][$_REQUEST["xfilm"]]--;
        if(!$_SESSION["items"][$_REQUEST["xfilm"]]) 
            unset($_SESSION["items"][$_REQUEST["xfilm"]]);
        $_SESSION["basketNitems"]--;
        
    }
    header("Location: basket.php");
}

?>