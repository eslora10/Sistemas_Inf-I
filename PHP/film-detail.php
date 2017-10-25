<!DOCTYPE html>
<html lang="en">
<?php include("includeHead.php") ?>
<body>
  <?php include("includeHeader.php") ?>
        <div class="container-fluid">
            <div class="main-content">
                <div class="film-detail-card">
                    <?php
                    /*Cargamos el catalogo*/
                    $catalogo = simplexml_load_file("../XML/catalogo.xml");
                    /*Obtenemos la pelicula a partir del nombre que viene en GET*/
                    $film = $_REQUEST['film'];
                    $pelicula = $catalogo->xpath("/catalogo/pelicula[id=\"$film\"]")[0];
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
