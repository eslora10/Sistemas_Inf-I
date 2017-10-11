<?php
    $err = 0;
    if(isset($_REQUEST["nick"])){
        $nick = $_REQUEST["nick"];
        $msg_nick = "";
    } else {
        $msg_nick = "Campo obligatorio";
        $err = 1;         
    }
    if(isset($_REQUEST["email"])){
        $email = $_REQUEST["email"];
        $msg_email = "";
    }else {
        $msg_email = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password"])){
        $password = $_REQUEST["password"];
        $msg_password = "";
    } else {
        $msg_password = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["password_rep"])){
        $password_rep = $_REQUEST["password_rep"];
        $msg_password_rep = "";
    } else {
        $msg_password_rep = "Campo obligatorio";
        $err = 1;
    }
    if(isset($_REQUEST["ccard"])){
        $ccard = $_REQUEST["ccard"];
        $msg_card = "";
    } else {
        $msg_card = "Campo obligatorio";
        $err = 1;
    }
    if(strcmp($password, $password_rep)){
        $msg_password_rep = "Las contraseñas no coinciden";
        $err = 1;
    }
    if(is_dir("../usuarios/$nick")){
        $msg_nick = "Ya hay un usuario registrado con ese nombre";
        $err = 1 ;
    }
    if($err == 1){
        /*Aqui deberiamos volver a generar el formulario con 
         los errores correspondientes*/            
        include("register.php");
    } else {
        /*Se crea un nuevo usuario*/
        mkdir("../usuarios/$nick");

        $fdata = fopen("../usuarios/$nick/datos.dat", "w");
        $c_pass = md5($password);
        $saldo = rand(0, 100);
        fwrite($fdata, "$nick\n$c_pass\n$ccard\n$saldo");
        setcookie("nick", $nick, time() + 60);
        
        /*include("index.php");*/
    }
?>