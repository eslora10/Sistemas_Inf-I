<?php
session_start();
if(isset($_SESSION['email'])){
    unset($_SESSION['email']);
    unset($_SESSION['saldo']);
    session_destroy();
}
if (isset($_REQUEST["f_sent"])){
    /*El formulario ha sido enviado, hacemos las comprobaciones pertinentes*/


    /*INIT session DB*/
    try {
      $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb" );
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    /*comprobaciones*/
    $err = 0;
    if(isset($_REQUEST["email"])){
        $email = $_REQUEST["email"];
    } else {
        $msg_email = "email obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password"])){
        $password = $_REQUEST["password"];
    } else {
        $msg_password = "password obligatoria";
        $err = 1;
    }
    /*Aqui deberiamos comprobar que el email y la contraseña coinciden*/
    if($err != 1){
        $sql = "SELECT email, username, password, income, customerid FROM customers WHERE email='$email'";
        $res = $db->query($sql);
        foreach ( $res as $rowUser) {
          /*comprobar contraseña*/
          if(strcmp((string)md5($password),(string)$rowUser['password'])!==0){
              $msg_password = "La contraseña es incorrecta";
          }else{
            /*login OK*/
              $nick=$rowUser['username'];
              $_SESSION['nick'] = $nick;
              $_SESSION['saldo'] = $rowUser['income'];
              $_SESSION['userid'] = $rowUser['customerid'];
            $_SESSION['email'] = $email;
              /*Cargamos el carro del usuario*/
              $customerid = $_SESSION['userid'];
              /*Vemos si el usuario ya tiene un carrito*/
            /*IMAGEN TITULO UNIDADES PRECIO*/
            $query = "SELECT orderid, prod_id, quantity FROM orders NATURAL JOIN orderdetail NATURAL JOIN products NATURAL JOIN imdb_movies WHERE status IS NULL AND CUSTOMERID=$customerid";
            $products = $db->query($query);
              /*Comprobamos si ya habia en sesion un carro*/
                if(isset($_SESSION['basketNitems'])){
                /*Si el usuario no tiene carro en db se lo creamos*/
                if($products->rowCount()<=0){
                    $customerid = $_SESSION['userid'];
                    $query = "INSERT INTO orders(orderdate, customerid, netamount, tax, totalamount) VALUES (current_date, $customerid, 0, 21, 0)";
                    $db->query($query);
                    /*Obtenemos el orderid recientemente asignado al carro creado*/
                    $query = "SELECT orderid FROM orders WHERE customerid=$customerid AND status IS NULL";
                    foreach($db->query($query) as $order){
                        $_SESSION['orderid'] = $order['orderid'];
                    }
                } else {
                    $_SESSION['orderid'] = $products->fetch()['orderid'];
                }
                 
                /*Guardamos la informacion del carro en db*/
                foreach($_SESSION['items'] as $id => $quantity){
                    $query = "SELECT price FROM products WHERE prod_id=".$id;
                    $price = $db->query($query)->fetch()['price'];
                    $query = "INSERT INTO orderdetail(orderid, prod_id, price, quantity) VALUES (".$_SESSION['orderid'].",".$id.",$price, $quantity)";
                    $db->query($query);
                }
                    /*destruimos el carro en sesion*/
                unset($_SESSION["items"]);
                unset($_SESSION["basketNitems"]);
            }
              
            $query = "SELECT orderid, prod_id, quantity FROM orders NATURAL JOIN orderdetail NATURAL JOIN products NATURAL JOIN imdb_movies WHERE status IS NULL AND CUSTOMERID=$customerid";
            $products = $db->query($query);
            if($products->rowCount()>0){
                foreach($products as $product){
                    $prod_id = $product['prod_id'];
                    $quantity = $product['quantity'];
                    $_SESSION["items"]["$prod_id"] = $quantity;
                    $_SESSION["basketNitems"] += $quantity;   
                    $_SESSION["orderid"] = $product['orderid'];
                }
            /*Actualizamos la fecha del carro a la actual*/
            $query = "UPDATE orders SET orderdate=current_date WHERE customerid=$customerid AND status IS NULL";   
            
            $db->query($query);
            }
            setcookie("email", $email, time() + 60*60);
            if(isset($_SESSION["from_basket"]))
                header("Location: basket.php");

            else
                header("Location: index.php");
              }
        }
    }
    if(!isset($msg_password))
        $msg_email = "E-mail no registrado";
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include("includeHead.php") ?>
<body>
  <?php include("includeHeader.php") ?>
        <div class="container-fluid">
          <div class="main-content">
            <form class="divLogin" action="login.php" method=post>
                <div class="LogInput">
           <h2>Inicia sesión</h2>
                </div>
                <div class="LogInput">
                    <h5>E-mail: </h5>
                    <input type="text" name="email" class="form-control" placeholder="E-mail" value="<?php if(isset($_COOKIE["email"])) echo $_COOKIE["email"];?>" required>
                    <?php if(isset($msg_email)) echo "<h6 class=\"error\">$msg_email</h6>"; ?>
                </div>
                <div class="LogInput">
                    <h5>Contraseña: </h5>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <?php if(isset($msg_password)) echo "<h6 class=\"error\">$msg_password</h6>"; ?>
                </div>
                <div class="LogInput">
                    <input type="Submit" name="f_sent" class="login" value="Identificate">
                </div>
                <div class="LogInput">
                    ¿No tienes cuenta?, <a href="register.php">Regístrate aquí</a>
                </div>

            </form>
        </div>
      </div>
        <?php include("includeFooter.php") ?>


</body></html>
