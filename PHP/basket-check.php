<?php
session_start();
try {
    $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
} catch(PDOException $e){
    header("Location: basket.php?sell=0");
}
if(!isset($_SESSION["saldo"])){
    /*El usuario debe hacer login primero*/
    $_SESSION["from_basket"] = true;
    header("Location: login.php");
} 
/*Conseguimos el totalamount para comprobar si el usuario tiene saldo suficiente*/
$query = "SELECT totalamount FROM orders WHERE orderid=".$_SESSION['orderid'];
foreach($database->query($query) as $totalamount)
    $total = $totalamount['totalamount'];
if($total > $_SESSION["saldo"]){
    /*El saldo es insuficiente*/
    header("Location: basket.php?sell=0");
} else {
    $userid = $_SESSION["userid"];
    $_SESSION["saldo"] -= $_SESSION["total_basket"];
    /*Cambiamos el saldo en base de datos*/
    /*Cambiamos el estado del pedido a "Paid"*/
    $query = "UPDATE orders SET status='Paid' WHERE customerid=$userid";
    $database->query($query);
    /*Actualizamos el saldo en sesion*/
    $query = "UPDATE customers SET income=income-".$_SESSION["total_basket"]." WHERE customerid=$userid";
    $database->query($query);
    
    unset($_SESSION["items"]);
    unset($_SESSION["basketNitems"]);
    header("Location: index.php");
}

?>