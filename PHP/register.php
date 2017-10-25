<?php
if(isset($_REQUEST["f_sent"])){
    /*El formulario fue enviado, comprobamos que este correcto*/
    
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
    if($err != 1){
        /*Se crea un nuevo usuario*/
        if(mkdir("../usuarios/$nick")){
            $fdata = fopen("../usuarios/$nick/datos.dat", "w");
            $c_pass = md5($password);
            $saldo = rand(0, 100);
            fwrite($fdata, "$nick\n$c_pass\n$email\n$ccard\n$saldo");
            setcookie("nick", $nick, time() + 60*3);
            header("Location: http://localhost/Sistemas_Inf-I/PHP/");
        } else {
            $msg_nick = "Error al crear usuario";
            
      }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UAM PLAY</title><!-- Bootstrap -->
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"><!-- Font Awesome -->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"><!-- User -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


        <!-- NUESTROS SCRIPTS JS/JQ-->
        <script src="../JS/register.js?<?php echo time();?>"></script>


        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">

    </head>
    <body>
            <header>
            <div class="divHeaderButton">
                <?php
                    if(isset($_COOKIE["nick"])) {
                        $nick = $_COOKIE["nick"];
                        echo "<nav>";
                        echo "<div class=\"dropdown\">";
                        echo "<button class=\"btn dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\">$nick <span class=\"caret\"></span></button>";
                        echo "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu2\">";
                        echo "<li><a href=\"../HTML/history.html\">Historico</a></li>";
                        echo "<li><a href=\"../HTML/basket.html\">Carrito</a></li>";
                        echo "<li><a href=\"login.php\">Log out</a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "</nav>";
                    } else {
                        echo "<a class=\"headerButton\" href=\"login.php\">Identifícate</a>";
                        echo "<a class=\"headerButton\" href=\"register.php\">Regístrate</a>";
                    }
                ?>

            </div>
            <div>
                <a href="index.php"><h1 class="main-header">UAM Play</h1></a>
            </div>
          
            <form class="input-group" method="get" action="index.php">
                <input type=submit class="input-group-btn">
                <select class="select-header" name="genre">
                    <option value="Todos" selected>Todos</option>
                    <option value="Accion">Accion</option>
                    <option value="Aventuras">Aventuras</option> 
                    <option value="Thriller">Thriller</option>
                    <option value="Comedia">Comedia</option>
                    <option value="Drama">Drama</option>
                    <option value="Infantil">Infantil</option>
                    <option value="Superheroes">Superheroes</option>
                </select>
                <div class="header-form">
                <input type="text" class="form-control" name="search">
                    </div>
            </form>

        </header>
		<div class="container-fluid">
      <div class="main-content">
            <form class="divLogin" action="register.php" METHOD=post>

		        <div class="LogInput">
			        <h2>Regístrate</h2>
                </div>

                <div class="LogInput">
    		        <h5>Nombre de usuario: </h5>
                    <input type="text" name="nick" id=nick class="form-control" placeholder="Nombre de usuario" required>
                    <?php echo "<h5 class=\"error\">$msg_nick</h5>" ?>

                    <h5 id='errorNick' class="errorHidden" >
                      <!-- campo vacio rellenar con js-->
                    </h5>


                </div>
    	          <div class="LogInput">
    	            <h5>e-mail: </h5>
                    <input type="text" name="email" id=email class="form-control" placeholder="e-mail" required>
                    <?php echo "<h6 class=\"error\">$msg_email</h6>" ?>

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

                    <?php echo "<h5 class=\"error\">$msg_password</h5>" ?>

                    <h5  id='passLen' class="errorHidden" >
                      <!-- campo vacio rellenar con js-->
                    </h5>
                </div>


                <div class="LogInput">
                    <h5>Repita contraseña: </h5>
                    <input type="password" name="password_rep" id="password_rep" class="form-control" placeholder="Repita contraseña" required>
                    <?php echo "<h5 class=\"error\">$msg_password_rep</h5>" ?>

                    <h5  id='password_OK' class="errorHidden" >
                      <!-- campo vacio rellenar con js-->
                    </h5>
                </div>


                <div class="LogInput">
    	            <h5> Tarjeta de crédito </h5>
                    <input type="number" name="ccard" id="ccard" class="form-control" placeholder="Tarjeta de crédito" required>
                    <?php echo "<h5 class=\"error\">$msg_card</h5>" ?>

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
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
