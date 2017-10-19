
<?php
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
    if($err == 1){
        include("login.php");
    } else {
        session_start();
        $_SESSION['nick'] = $nick;
        $_SESSION['saldo'] = $saldo;
        setcookie("nick", $nick, time() + 60);
        include("index.php");
    }


?>
