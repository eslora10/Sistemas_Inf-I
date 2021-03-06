<?php
session_start();
if(isset($_REQUEST["f_sent"])){
    /*El formulario fue enviado, comprobamos que este correcto*/

        $err = 0;
    if(isset($_REQUEST["nick"])){
        $nick = $_REQUEST["nick"];
    } else {
        $msg_nick = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["email"])){
        $email = $_REQUEST["email"];
    }else {
        $msg_email = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password"])){
        $password = $_REQUEST["password"];
    } else {
        $msg_password = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password_rep"])){
        $password_rep = $_REQUEST["password_rep"];
    } else {
        $msg_password_rep = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["ccard"])){
        $ccard = $_REQUEST["ccard"];
    } else {
        $msg_card = "Campo obligatorio";
        $err = 1;
    }
    if(strcmp($password, $password_rep)){
        $msg_password_rep = "Las contraseñas no coinciden";
        $err = 1;
    }
    if($err != 1){
        /*Se crea un nuevo usuario*/

        $c_pass = md5($password);
        $saldo = rand(0, 100);
        /*conexion con la base de datos*/
        try{
            $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
            $query = "INSERT INTO customers(username, password, email, creditcard, income) VALUES ('$nick', '$c_pass', '$email', '$ccard',  $saldo)";
            $stmt = $database->query($query);
            if($stmt===FALSE){
                $msg_email =  "e-mail ya registrado";
            } else {
                /*inicio de sesion y de cookie*/
                session_start();
                $_SESSION['nick'] = $nick;
                $_SESSION['saldo'] = $saldo;
                $_SESSION['email'] = $email;
                setcookie("email", $email, time() + 60*60);  
                /*Obtenemos el id que la base de datos ha asociado al usuario*/
                $query = "SELECT customerid FROM customers WHERE email='$email'";
                foreach($database->query($query) as $user)
                    $_SESSION['userid'] = $user['customerid'];
                
              /*Vemos si el usuario ya tiene un carrito*/
              /*Comprobamos si ya habia en sesion un carro*/
                if(isset($_SESSION['basketNitems'])){
                    $customerid = $_SESSION['userid'];
                    $query = "INSERT INTO orders(orderdate, customerid, netamount, tax, totalamount) VALUES (current_date, $customerid, 0, 21, 0)";
                    $database->query($query);
                    /*Obtenemos el orderid recientemente asignado al carro creado*/
                    $query = "SELECT orderid FROM orders WHERE customerid=$customerid AND status IS NULL";
                    foreach($database->query($query) as $order){
                        $_SESSION['orderid'] = $order['orderid'];
                    }

                    /*Guardamos la informacion del carro en database*/
                    foreach($_SESSION['items'] as $id => $quantity){
                        $query = "SELECT price FROM products WHERE prod_id=".$id;
                        $price = $database->query($query)->fetch()['price'];
                        $query = "INSERT INTO orderdetail(orderid, prod_id, price, quantity) VALUES (".$_SESSION['orderid'].",".$id.",$price, $quantity)";
                        $database->query($query);
                    }
                } 
                header("Location: index.php");
            }
        } catch (PDOException $e){
            $msg_nick = "Error al crear usuario";
        }

      }
    }

?>

<!DOCTYPE html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <?php include("includeHead.php") ?>
    <body>
      <?php include("includeHeader.php") ?>
		<div class="container-fluid">
      <div class="main-content">
            <form class="divLogin" action="register.php" METHOD=post>

		        <div class="LogInput">
			        <h2>Regístrate</h2>
                </div>

                <div class="LogInput">
    		        <h5>Nombre de usuario: </h5>
                    <input type="text" name="nick" id=nick class="form-control" placeholder="Nombre de usuario" required>
                    <?php if(isset($msg_nick)) echo "<h5 class=\"error\">$msg_nick</h5>"; ?>

                    <h5 id='errorNick' class="errorHidden" >
                      <!-- campo vacio rellenar con js-->
                    </h5>


                </div>
    	          <div class="LogInput">
    	            <h5>e-mail: </h5>
                    <input type="text" name="email" id=email class="form-control" placeholder="e-mail" required>
                    <?php if(isset($msg_email)) echo "<h6 class=\"error\">$msg_email</h6>"; ?>

                    <h5 id='errorEmail' class="errorHidden" >
                        <!-- campo vacio rellenar con js-->
                    </h5>


                </div>
                <div class="LogInput">
                    <h5>Contraseña: </h5>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <div><!--estos div calculan la fortaleza de la password-->
                        <span id="scoreStr"></span>
                        <span id="scoreNum"></span>
                    </div>
                    <meter class=meter value=0.01 low="0.25" high="0.75" id="scoreMeter"></meter>

                    <?php if(isset($msg_password)) echo "<h5 class=\"error\">$msg_password</h5>"; ?>

                    <h5  id='passLen' class="errorHidden" >
                      <!-- campo vacio rellenar con js-->
                    </h5>
                </div>


                <div class="LogInput">
                    <h5>Repita contraseña: </h5>
                    <input type="password" name="password_rep" id="password_rep" class="form-control" placeholder="Repita contraseña" required>
                    <?php if(isset($msg_password_rep)) echo "<h5 class=\"error\">$msg_password_rep</h5>"; ?>

                    <h5  id='password_OK' class="errorHidden" >
                      <!-- campo vacio rellenar con js-->
                    </h5>
                </div>


                <div class="LogInput">
    	            <h5> Tarjeta de crédito </h5>
                    <input type="number" name="ccard" id="ccard" class="form-control" placeholder="Tarjeta de crédito" required>
                    <?php if(isset($msg_card)) echo "<h5 class=\"error\">$msg_card</h5>"; ?>

                    <h5 id='errorCcard' class="errorHidden" ><!-- display:block-->
                      Tarjeta de credito incorrecta.
                    </h5>
                </div>


                <div class="LogInput">
                  <input type="Submit" name="f_sent" id='send' class="login" value="Registrate">
                </div>


                <div class="LogInput">

                ¿Ya tienes cuenta? <a href="login.php">Identifícate aquí</a>
                </div>


            </form>
        </div>
      </div>
      <?php include("includeFooter.php") ?>


</body></html>
