<?php

session_start();

try {
    $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
} catch (PDOException $e){
    die();
}

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
        /*Comprobamos si hay un usuario con login hecho*/
        if(isset($_SESSION['userid'])){
            /*Este usuario no tiene un carrito, se lo creamos*/
            /*ponemos las tasas de Espana 21*/
            $customerid = $_SESSION['userid'];
            $query = "INSERT INTO orders(orderdate, customerid, netamount, tax, totalamount) VALUES (current_date, $customerid, 0, 21, 0)";
            $database->query($query);
            /*Obtenemos el orderid recientemente asignado al carro creado*/
            $query = "SELECT orderid FROM orders WHERE customerid=$customerid AND status IS NULL";
            foreach($database->query($query) as $order){
                $_SESSION['orderid'] = $order['orderid'];
            }
        }
    }

    /*Necesitamos el precio del producto*/
    $query = "SELECT price FROM products WHERE prod_id=".$_REQUEST["film"];
    foreach($database->query($query) as $prod)
        $price = $prod['price'];
    /*Metemos el id de la peli en el array y las unidades a modo de diccionario*/
    /*Si ya existia la peli, aumentamos el uno el numero de unidades*/
    if(array_key_exists($_REQUEST["film"], $_SESSION["items"])){
        $_SESSION["items"][$_REQUEST["film"]]++;
        if(isset($_SESSION['userid'])){
            /*Si hay un usuario con login, actualizamos el carrito en db*/
            $query = "UPDATE orderdetail SET quantity=quantity+1 WHERE orderid=".$_SESSION['orderid']." AND prod_id=".$_REQUEST['film'];
            $database->query($query);
        }
    }
    /*En caso contrario añadimos la peli y ponemos las unidades a 1*/
    else {
        $_SESSION["items"][$_REQUEST["film"]] = 1;
        if(isset($_SESSION['userid'])){
            /*Si hay un usuario con login, actualizamos el carrito en db*/
            $query = "INSERT INTO orderdetail(orderid, prod_id, price, quantity) VALUES (".$_SESSION['orderid'].",".$_REQUEST['film'].",$price, 1)";
            $database->query($query);
        }
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
        if(isset($_SESSION['userid'])){
            /*Si hay un usuario registrado, actualizamos la informacion en la base de datos*/
            $query = "UPDATE orderdetail SET quantity=quantity-1 WHERE orderid=".$_SESSION['orderid']." AND prod_id=".$_REQUEST["xfilm"];
            $database->query($query);
        }
        /*Si las unidades de la pelicula llegan a 0 la borramos del array
        para que no aparezca en la tabla del carrito*/
        if(!$_SESSION["items"][$_REQUEST["xfilm"]])
            unset($_SESSION["items"][$_REQUEST["xfilm"]]);
        $_SESSION["basketNitems"]--;
        /*La base de datos ya hace esta comprobacion en el trigger*/

    }
    header("Location: basket.php");
}

?>
