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
                            echo "<h2 class=\"film-detail-title\">$pelicula[movietitle]</h2>";
                        }

                        echo "<h5> Géneros:";
                        $query = "SELECT genrename FROM genres Natural JOIN imdb_moviegenres WHERE movieid=$film";

                        foreach ($database->query($query) as $genero){
                            echo "$genero[genrename] ";
                        }
                        echo "</h5><br>";


                        echo "<h3>";
                        echo "<table id='table1'>";

                        $query = "SELECT * FROM products WHERE movieid=$film";
                        foreach ($database->query($query) as $product){
                            echo "<tr>";
                                echo "<td>$product[description] : $product[price] €</td>";
                                echo "<td>";
                                    echo "<a class='comprar' href='basket-update.php?basket=1&film=$product[prod_id]'>Comprar</a>";
                                    echo "<a class='comprar' href='basket-update.php?film=$product[prod_id]'>Añadir a la cesta</a><br>";
                                echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</h3>";

                        ?>

                    </div>
                    </div>
                    </div>
                    </div>
                    <?php include("includeFooter.php") ?>

</body></html>
