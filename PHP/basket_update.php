<?php

session_start();

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
$_SESSION["items"][] = $_REQUEST["film"];
print_r($_SESSION);
header("Location: index.php");

?>