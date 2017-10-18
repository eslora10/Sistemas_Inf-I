<!DOCTYPE html>
<html lang="es">
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
        <link rel="stylesheet" type="text/css" href="../CSS/style.css?<?php echo time(); ?>">


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
          <!--
          <form class="input-group" action="index.php" method="get">
              <input type="text" class="form-control" placeholder="Busqueda">
              <input class="input-group-btn" type="submit" value="Buscar">
              
              
          </form>
-->

        </header>
        <div class="container-fluid">
            <div class="main-content">
                <?php
                /*Cargamos el catalogo*/
                $catalogo = simplexml_load_file("../XML/catalogo.xml");
                if(isset($_REQUEST['genre']) && strcmp($_REQUEST['genre'], "Todos")){
                    /*el usuario hace una busqueda*/
                    $generos = array($_REQUEST['genre']);
                } else {
                    /*Seleccionamos todos los generos posibles*/
                    $generos = array_unique($catalogo->xpath('/catalogo/pelicula/generos/genero'));
                }
                /*Por cada genero, hacemos un row*/
                foreach ($generos as $genero){
                    /*Por cada pelicula, creamos una tarjeta*/  
                    $peliculas = $catalogo->xpath("/catalogo/pelicula[generos/genero=\"$genero\"]");                        
                    if (isset($_REQUEST['search']) && strcmp($_REQUEST['search'], "")){
                        /*Seleccionamos solo las peliculas que coincidan con la busqueda*/
                        $search = $_REQUEST['search'];
                        $peliculas = $catalogo->xpath("/catalogo/pelicula[contains(titulo, '$search') and generos/genero=\"$genero\"]");
                        /*translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')*/
                    }
                    if(count($peliculas) >0 ){
                        echo "<div class=\"row-content\">";
                        echo "<h1 class=\"tittleRow\">$genero</h1>";
                        foreach ($peliculas as $pelicula){
                            echo "<span>";
                            echo "<a href=\"film-detail.php?film=$pelicula->titulo\" class=\"film-card\">";
                            echo "<span>";
                            echo "<img class=\"film-image\" src=\"$pelicula->poster\" alt='$pelicula->titulo'><br>";
                            echo "$pelicula->titulo";                            
                            echo "</span>";
                            echo "</a>";
                            echo "</span>";
                        }
                    echo "</div>";
                    }
                    

                }
                

              ?>
              <!--


                <div class="row-content">
                  <h1 class="tittleRow">Estrenos</h1>
            -->

                  <!--<span><a href="film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br><div class="info-card">Los vengadores</div></span>
                  </a></span>-->
                <!--
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                </div>


                <div class="row-content">
                  <h1 class="tittleRow">Estrenos</h1>

                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                </div>

                <div class="row-content">
                  <h1 class="tittleRow">Estrenos</h1>

                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                  <span><a href="../HTML/film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br>Los vengadores</span>
                  </a></span>
                </div>
-->
            </div>

         
        </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
