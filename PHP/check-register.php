<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UAM PLAY</title>
        <!-- Bootstrap -->
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
        </script><script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">


    </head>
    <body>
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
        if(isset($_REQUEST["password"])){
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
            
            /*Deberiamos generar el codigo html de la ventana index y
            ponerle el usuario creado*/
        }
        


    ?>
    </body>
</html>