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
      <header>
            <!-- cambio orden-->
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
                        <li><a href="index.php">Terror</a></li>
                        <li><a href="index.php">Comedia</a></li>
                        <li><a href="index.php">Drama</a></li>
                        <li><a href="index.php">Animación</a></li>
                        <li><a href="index.php">Infantil</a></li>
                    </ul>
                </div>
            </nav>
            <div class="main-content">


                <div class="row-content">
                  <h1 class="tittleRow">Estrenos</h1>

                  <!--<span><a href="film-detail.html" class="film-card"><span><img class="film-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'><br><div class="info-card">Los vengadores</div></span>
                  </a></span>-->
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
            </div>
        </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
