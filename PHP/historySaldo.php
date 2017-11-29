<?php
session_start();
    $nick=$_SESSION['nick'];
    /*Actualizamos el saldo en sesion*/

    if ( $_REQUEST["add_saldo"]<0) {
        header("Location: history.php?saldoNeg=1");
        die();
    }
    $_SESSION["saldo"] += $_REQUEST["add_saldo"];

    try {
        $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
    } catch (PDOException $e) {
        echo "<h1 class='err-db'>Se ha producido un error interno</h1>";
        die();
    }
    $query="UPDATE customers SET income = $_SESSION[saldo]";
    $database->query($query);
    /*Cambiamos el saldo en el fichero del usuario*/
    $user_data = file("../usuarios/$nick/datos.dat");
    $user_data[4] = $_SESSION["saldo"];
    /*Actualizamos el fichero*/
    file_put_contents ("../usuarios/$nick/datos.dat", $user_data);

    header("Location: history.php");

?>
