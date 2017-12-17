<?php
session_start();
try {
    $database = new PDO("pgsql:dbname=si1p4 host=localhost", "alumnodb", "alumnodb");
    $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){

}
echo "<h1>BORRA CLIENTE MAL <br/></h1>";
if(!isset($_REQUEST["customerid"])){
    /*mostrar formulario*/
    echo '<form action="borraClienteMal.php">';
    echo '<input type=numeric name="customerid">';
    echo '<input type=submit value="Delete User">';
    echo '<input type="checkbox" name="usePdo">Usar pdo<br>';
    echo '<input type="checkbox" name="commit">Commit<br>';
    echo '</form>';
} else {
    /*Inicializamos la Transaccion*/
    $query1="DELETE FROM orderdetail where orderid in(SELECT orderid from orders where
            customerid=".$_REQUEST["customerid"].")";
    $query2="DELETE FROM orders where customerid=".$_REQUEST["customerid"];
    $query3="DELETE FROM customers where customerid=".$_REQUEST["customerid"];

    $usePdo = isset($_REQUEST['usePdo']) ? true : false;
    $commit = isset($_REQUEST['commit']) ? true : false;


    if($usePdo){
        try{
            echo "<h1>Transaccion usando PDO <br/></h1>";
            $database->beginTransaction();

            /*query1*/
                /*imprimimos antes ejecutar el borrado*/
                echo '<h4>QUERY 1:</h4>';
                echo '<h4>ANTES DE BORRAR</h4>';

                echo '<table border=1><tr><th>orderid</th></tr>';
                $tabla = "SELECT orderid FROM orderdetail where orderid in(SELECT orderid from orders where
                        customerid=".$_REQUEST["customerid"].")";
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['orderid'].'</td></tr>';
                echo '</table>';
            $database->exec($query1);
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR</h4>';

                echo '<table border=1><tr><th>orderid</th></tr>';
                $tabla ="SELECT orderid FROM orderdetail where orderid in(SELECT orderid from orders where
                        customerid=".$_REQUEST["customerid"].")";

                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['orderid'].'</td></tr>';
                echo '</table>';

            if($commit){
                $database->commit();
                echo '<h2>Se ha realizado un commit</h2>';
                $database->beginTransaction();
            }



            /*query3 CAMBIANDO EL ORDEN FALLARA*/
                /*imprimimos antes ejecutar el borrado*/
                echo '<h4>QUERY 3:</h4>';
                echo '<h4>ANTES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in customers</th></tr>';
                $tabla = "SELECT customerid FROM customers where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';
            $database->exec($query3);
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in customers</th></tr>';
                $tabla = "SELECT customerid FROM customers where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';


            /*query2*/
                /*imprimimos antes ejecutar el borrado*/
                echo '<h4>QUERY 2:</h4>';
                echo '<h4>ANTES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in orders</th></tr>';
                $tabla = "SELECT customerid FROM orders where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';
            $database->exec($query2);
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in orders</th></tr>';
                $tabla = "SELECT customerid FROM orders where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';


            $database->commit();
            echo "<h2>cliente borrado con exito</h2>";
        }catch(PDOException $e){
            echo $e->getMessage();
            $database->rollBack();
            echo "<h2>fallo al borrar el cliente</h2>";

            if($commit){
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR TABLA ORDERDETAIL</h4>';

                echo '<table border=1><tr><th>orderid</th></tr>';
                $tabla =$tabla = "SELECT orderid FROM orderdetail where orderid in(SELECT orderid from orders where
                        customerid=".$_REQUEST["customerid"].")";
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['orderid'].'</td></tr>';
                echo '</table>';

                echo '<table border=1><tr><th>customerid in customers</th></tr>';
                $tabla = "SELECT customerid FROM customers where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';

                echo '<table border=1><tr><th>customerid in orders</th></tr>';
                $tabla = "SELECT customerid FROM orders where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';

            }

        }
    }else{
        try{
            echo "<h1>Transaccion usando exec <br/></h1>";
            $database->exec("BEGIN;");


            /*query1*/
                /*imprimimos antes ejecutar el borrado*/
                echo '<h4>QUERY 1:</h4>';
                echo '<h4>ANTES DE BORRAR</h4>';

                echo '<table border=1><tr><th>orderid</th></tr>';
                $tabla = "SELECT orderid FROM orderdetail where orderid in(SELECT orderid from orders where
                        customerid=".$_REQUEST["customerid"].")";
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['orderid'].'</td></tr>';
                echo '</table>';
            $database->exec($query1);
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR</h4>';

                echo '<table border=1><tr><th>orderid</th></tr>';
                $tabla =
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['orderid'].'</td></tr>';
                echo '</table>';

            /*query3 CAMBIANDO EL ORDEN FALLARA*/
                /*imprimimos antes ejecutar el borrado*/
                echo '<h4>QUERY 3:</h4>';
                echo '<h4>ANTES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in customers</th></tr>';
                $tabla = "SELECT customerid FROM customers where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';
            $database->exec($query3);
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in customers</th></tr>';
                $tabla = "SELECT customerid FROM customers where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';


            /*query2*/
                /*imprimimos antes ejecutar el borrado*/
                echo '<h4>QUERY 2:</h4>';
                echo '<h4>ANTES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in orders</th></tr>';
                $tabla = "SELECT customerid FROM orders where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';
            $database->exec($query2);
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR</h4>';

                echo '<table border=1><tr><th>customerid in orders</th></tr>';
                $tabla = "SELECT customerid FROM orders where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';



            $database->exec("COMMIT;");
            echo "<h2>cliente borrado con exito</h2>";
        }catch(PDOException $e){
            $database->exec("ROLLBACK;");

            if($commit){
                /*imprimimos tras ejecutar el borrado*/
                echo '<h4>DESPUES DE BORRAR TABLA ORDERDETAIL</h4>';

                echo '<table border=1><tr><th>orderid</th></tr>';
                $tabla =$tabla = "SELECT orderid FROM orderdetail where orderid in(SELECT orderid from orders where
                        customerid=".$_REQUEST["customerid"].")";
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['orderid'].'</td></tr>';
                echo '</table>';

                echo '<table border=1><tr><th>customerid in customers</th></tr>';
                $tabla = "SELECT customerid FROM customers where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';

                echo '<table border=1><tr><th>customerid in orders</th></tr>';
                $tabla = "SELECT customerid FROM orders where customerid=".$_REQUEST["customerid"];
                $linea=$database->query($tabla)->fetch();
                echo '<tr><td>'.$linea['customerid'].'</td></tr>';
                echo '</table>';

            }

            echo "<h2>fallo al borrar el cliente</h2>";
        }
    }
}

?>
