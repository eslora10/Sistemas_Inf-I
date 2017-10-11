<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UAM PLAY</title><!-- Bootstrap -->
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"><!-- Font Awesome -->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"><!-- User -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>



<!-- len username-->
        <script type="text/javascript">
        $(document).ready(function() {
           $('#send').click(function(){
            if($("#nick").val().length < 8) {
            $(".errorNick").show();
            return false;
        }
           });
        });
        </script>
       <!-- len username-->

       <!--complexify para el meter de la password-->


        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">

    </head>
    <body>
      <header>
            <!-- cambio orden-->
            <div class="divHeaderButton">
                <a class="headerButton" href="login.html">Identifícate</a>
                <a class="headerButton" href="register.html">Regístrate</a>

            </div>
            <!---->
            <div>
                <a href="index.html"><h1 class="main-header">UAM Play</h1></a>
            </div>
            <div class="input-group">
                <input type="text" class="form-control">
                <a class="input-group-btn" href="index.html">Buscar</a>
            </div>

        </header>
		<div class="container-fluid">
      <nav class="navMenu">
          <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">Géneros <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                  <li><a href="index.html">Acción</a></li>
                  <li><a href="index.html"></a></li>
                  <li><a href="index.html">Comedia</a></li>
                  <li><a href="index.html">Drama</a></li>
                  <li><a href="index.html">Animación</a></li>
                  <li><a href="index.html">Infantil</a></li>
              </ul>
          </div>
      </nav>
      <div class="main-content">
            <form class="divLogin" action="../PHP/check-register.php" METHOD=post>

		            <div class="LogInput">
			               <h2>Regístrate</h2>
                </div>

                <div class="LogInput">
    		        <h5>Nombre de usuario: </h5>
                    <input type="text" name="nick" class="form-control" placeholder="Nombre de usuario" required>
                    <?php echo "<h6 class=\"error\">$msg_nick</h6>" ?>
                    <div id='errorNick' class="errorNick" ><!-- display:block-->
                      El nick debe tener 8 caractere minimo
                    </div>
                </div>
    	          <div class="LogInput">
    	            <h5>e-mail: </h5>
                    <input type="text" name="email" class="form-control" placeholder="e-mail" required>
                    <?php echo "<h6 class=\"error\">$msg_email</h6>" ?>
                </div>
                <div class="LogInput">
                    <h5>Contraseña: </h5>
<<<<<<< HEAD:PHP/register.php
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <?php echo "<h6 class=\"error\">$msg_password</h6>" ?>
                </div>
                <div class="LogInput">
                    <h5>Repita contraseña: </h5>
                    <input type="password" name="password_rep" class="form-control" placeholder="Repita contraseña" required>
                    <?php echo "<h6 class=\"error\">$msg_password_rep</h6>" ?>
=======
                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                <meter value="0" id="PassValue" max="100"></meter>
>>>>>>> 24a8a49d6cc242b81e7f500edc290959508bf30e:HTML/register.html
                </div>
                <div class="LogInput">
    	            <h5> Tarjeta de crédito </h5>
                    <input type="text" name="ccard" class="form-control" placeholder="Tarjeta de crédito" required>
                    <?php echo "<h6 class=\"error\">$msg_card</h6>" ?>
                </div>
                <div class="LogInput">
<<<<<<< HEAD:PHP/register.php
                  <input type="Submit" class="login" value="Registrate">
=======
                    <input type="submit" id='send' value='Registrate'>
>>>>>>> 24a8a49d6cc242b81e7f500edc290959508bf30e:HTML/register.html
                </div>
                <div class="LogInput">
                ¿Ya tienes cuenta? <a href="login.html">Identifícate aquí</a>

                </div>
            </form>
        </div>
      </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
