<?php
session_start();
    $nick=$_SESSION['nick'];
    /*Actualizamos el saldo en sesion*/
    $_SESSION["saldo"] += $_REQUEST["add_saldo"];
    /*Cambiamos el saldo en el fichero del usuario*/
    $user_data = file("../usuarios/$nick/datos.dat");
    $user_data[4] = $_SESSION["saldo"];
    /*Actualizamos el fichero*/
    file_put_contents ("../usuarios/$nick/datos.dat", $user_data);

    header("Location: history.php");

?>
