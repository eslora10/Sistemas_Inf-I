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
            <form class="divLogin" action="index.php" method="post">

		            <div class="LogInput">
			               <h2>Regístrate</h2>
                </div>
                <div class="LogInput">

                  <h4 class="error"> <?php echo $argv[1] ?> <h4>
    		        <h5>Nombre de usuario: </h5>
                    <input name="nickname" type="text" class="form-control" placeholder="Nombre de usuario">
                </div>
    	          <div class="LogInput">
    	            <h5>e-mail: </h5>
                  <input name="email" type="text" class="form-control" placeholder="e-mail">
                </div>
                <div class="LogInput">
                    <h5>Contraseña: </h5>
                <input name="password" type="password" class="form-control" placeholder="Contraseña">
                </div>
                <div class="LogInput">
                    <h5>Repite contraseña: </h5>
                <input name="password2" type="password" class="form-control" placeholder="Contraseña">
                </div>
                <div class="LogInput">
    	            <h5> Tarjeta de crédito: </h5>
                <input name="credit" type="text" class="form-control" placeholder="Tarjeta de crédito">
                </div>
                <div class="LogInput">
                  <input class="login" type="submit" value="Regístrate">
                </div>
                <div class="LogInput">
                ¿Ya tienes cuenta? <a href="login.html">Identifícate aquí</a>

                </div>
            </form>
        </div>
      </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
