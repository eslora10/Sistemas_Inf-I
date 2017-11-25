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
        $_SESSION["basketNitems"] = 0;
        /*Creamos el array de pelis*/
        $_SESSION["items"] = array();
        /*Comprobamos si hay un usuario con login hecho*/
        if(isset($_SESION['userid'])){
            $customerid = $_SESION['userid'];
            /*Vemos si el usuario ya tiene un carrito*/
            /*IMAGEN TITULO UNIDADES PRECIO*/
            $query = "SELECT prod_id, quantity FROM orders NATURAL JOIN orderdetail NATURAL JOIN products NATURAL JOIN imdb_movies WHERE status IS NULL AND CUSTOMERID=$customerid";
            $products = $database->query($query);
            if($products->rowCount()>0){
                foreach($products as $product){
                    $prod_id = $product->['prod_id'];
                    $quantity = $product->['quantity'];
                    $_SESSION["items"]["$prod_id"] = $quantity;
                    $_SESSION["basketNitems"] += $quantity;                    
                }
            /*Actualizamos la fecha del carro a la actual*/
            $query = "UPDATE orders SET orderdate='2017-10-29' WHERE customerid=$customerid AND status IS NULL";    
            $database->query($query);
            } else {
                /*En caso contrario creamos el carrito*/
                /*ponemos las tasas de Espana 21*/
                $query = "INSERT INTO orders(orderdate, customerid, netamount, tax, totalamount) VALUES (current_date, $customerid, 0, 21, 0)";
                $database->query($query);
                
            }

            
        }

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