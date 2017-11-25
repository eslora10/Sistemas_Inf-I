<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("includeHead.php") ?>
<body>
  <?php include("includeHeader.php") ?>
        <div class="container-fluid">
            <div class="main-content">
                <div class="film-detail-card">
                    <?php

                    $film = $_REQUEST['film'];

                    echo "<img class='film-detail-image' src='../media/img/$film.jpg' alt='aaa'>";
                    ?>

                    <div class="film-detail-text">
                        <?php

                        try {
                            $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
                        } catch (PDOException $e) {
                            echo "<h1 class='err-db'>Se ha producido un error interno</h1>";
                            die();
                        }
                        $query = "SELECT * FROM imdb_movies WHERE movieid=$film";

                        foreach ($database->query($query) as $pelicula) {
                    /*CUIDADO AQUI*/            echo "<h2 class=\"film-detail-title\">$pelicula[movietitle]</h2>";
                        }
                        echo "<h5> Géneros:";

                        $query = "SELECT genrename FROM genres Natural JOIN imdb_moviegenres WHERE movieid=$film";

                        foreach ($database->query($query) as $genero){
                    /*CUIDADO AQUI*/           echo "$genero[genrename] ";
                        }
                        echo "</h5>";
                        echo "<h2>PRECIO €</h2>";
                        ?>
                        <div>
                            <a class="login" href="basket-update.php?basket=1&film=<?php echo "$film"; ?>">Comprar</a>
                            <a class="login" href="basket-update.php?film=<?php echo "$film"; ?>">Añadir a la cesta</a>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    <?php include("includeFooter.php") ?>

</body></html>
