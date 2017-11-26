<?php
session_start();
try {
    $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
} catch(PDOException $e){
    header("Location: basket.php");
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
    /*Cambiamos el saldo en base de datos*/
    /*Cambiamos el estado del pedido a "Paid"*/
    $query = "UPDATE orders SET status='Paid' WHERE customerid=$userid";
    $database->query($query);
    /*Y ahora comprobramos que realmente se ha cambiado, porque el trigger de update inventory puede haber
    suspendido la compra si el stock no es suficiente*/
    $query = "SELECT status FROM orders WHERE orderid=".$_SESSION['orderid'];
    foreach($database->query($query) as $status){
        if(strcmp($status['status'], 'Paid')){
             header("Location: basket.php?sell=1");
             die();
<<<<<<< HEAD
         }
     }
=======
        }
    }
>>>>>>> 5966405dbb26a035b31c7745ce23a2af1a862c07
    /*Actualizamos el saldo en sesion*/
    $_SESSION["saldo"] -= $_SESSION["total_basket"];
    $query = "UPDATE customers SET income=income-".$_SESSION["total_basket"]." WHERE customerid=$userid";
    $database->query($query);

    unset($_SESSION["items"]);
    unset($_SESSION["basketNitems"]);
    header("Location: index.php");
}

?>
