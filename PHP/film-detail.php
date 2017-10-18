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
                <a href="index.php"><h1 class="main-header">UAM Play</h1></a>
            </div>
            <div class="input-group">
                <input type="text" class="form-control">
                <a class="input-group-btn" href="index.php">Buscar</a>
            </div>

        </header>
        <div class="container-fluid">
            <nav class="navMenu">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">Géneros <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li><a href="index.php">Acción</a></li>
                        <li><a href="index.php"></a></li>
                        <li><a href="index.php">Comedia</a></li>
                        <li><a href="index.php">Drama</a></li>
                        <li><a href="index.php">Animación</a></li>
                        <li><a href="index.php">Infantil</a></li>
                    </ul>
                </div>
            </nav>
            <div class="main-content">
                <div class="film-detail-card">
                    <?php
                    /*Cargamos el catalogo*/
                    $catalogo = simplexml_load_file("../XML/catalogo.xml");
                    /*Obtenemos la pelicula a partir del nombre que viene en GET*/
                    $film = $_REQUEST['film'];
                    $pelicula = $catalogo->xpath("/catalogo/pelicula[titulo=\"$film\"]")[0];
                    echo "<img class=\"film-detail-image\" src=\"$pelicula->poster\" alt='$pelicula->titulo'>";
                    ?>
                    
                    <div class="film-detail-text">
                        <?php
                        echo "<h2 class=\"film-detail-title\">$pelicula->titulo</h2>";
                        echo "<h5> Géneros:";
                        foreach ($pelicula->generos->children() as $genero)
                            echo " $genero";
                        echo "</h5>";
                        
                        echo "<h6>$pelicula->sinopsis </h6>";
                        echo "<h2>$pelicula->precio €</h2>";
                        ?>
                        <div>
                            <a class="login" href="login.php">Comprar</a>
                            <a class="login" href="login.php">Añadir a la cesta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
