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
        $msg_email = "";
    } else {
        $msg_email = "email obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password"])){
        $password = $_REQUEST["password"];
        $msg_password = "";
    } else {
        $msg_password = "email obligatorio";
        $err = 1;
    }
        /*Aqui deberiamos comprobar que el email y la contraseña coinciden*/
        $sql = "SELECT email, username FROM customers WHERE email='$email'";
        foreach ($db->query($sql) as $row) {
          if($email != $row['email']){
            $err=1;
            $msg_email = "El usuario no existe";
          }
          /*caso ok*/
          $_SESSION['nick']=$row['username'];

        }
        $sql = "SELECT password FROM customers WHERE email='$email'";
        foreach ($db->query($sql) as $row) {
          if($password != $row['password']){
            $err=1;
            $msg_password = "La contaseña no es correcta";
          }
        }
    if($err != 1){
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['saldo'] = $saldo;
        setcookie("email", $email, time() + 60*60);
        header("Location: index.php");
    }
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
                    <h5>Nombre de usuario: </h5>
                    <input type="text" name="email" class="form-control" placeholder="Nombre de usuario" value="<?php if(isset($_COOKIE["email"])) echo $_COOKIE["email"];?>" required>
                    <?php echo "<h6 class=\"error\">$msg_email</h6>" ?>
                </div>
                <div class="LogInput">
                    <h5>Contraseña: </h5>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <?php echo "<h6 class=\"error\">$msg_password</h6>" ?>
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
