<?php
if (isset($_REQUEST["f_sent"])){
    /*El formulario ha sido enviado, hacemos las comprobaciones pertinentes*/

    $err = 0;
    if(isset($_REQUEST["nick"])){
        $nick = $_REQUEST["nick"];
        $msg_nick = "";
    } else {
        $msg_nick = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password"])){
        $password = $_REQUEST["password"];
        $msg_password = "";
    } else {
        $msg_password = "Campo obligatorio";
        $err = 1;
    }
    if(!is_dir("../usuarios/$nick")){
        $msg_nick = "No existe ningun usuario con ese nombre";
        $err = 1 ;
    } else {
        /*Aqui deberiamos comprobar que el nick y la contraseña coinciden*/
        $fdata = fopen("../usuarios/$nick/datos.dat", "r");
        $fnick = fgets($fdata);
        $c_password = fgets($fdata);
        $email = fgets($fdata);
        $ccard = fgets($fdata);
        $saldo = fgets($fdata);
        $pass = md5("$password");
        if (strcmp($c_password, "$pass\n")) {
            $err = 1;
            $msg_password = "La contaseña no es correcta";
        }
    }
    if($err != 1){
        session_start();
        $_SESSION['nick'] = $nick;
        $_SESSION['saldo'] = $saldo;
        setcookie("nick", $nick, time() + 60*60);
        if(isset($_SESSION["from_basket"]))
             header("Location: basket.php");
        else 
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
                    <input type="text" name="nick" class="form-control" placeholder="Nombre de usuario" value="<?php if(isset($_COOKIE["nick"])) echo $_COOKIE["nick"];?>" required>
                    <?php echo "<h6 class=\"error\">$msg_nick</h6>" ?>
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
