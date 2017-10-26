<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <?php include("includeHead.php") ?>
    <body>
      <?php include("includeHeader.php") ?>
        <div class="container-fluid">
            <div class="main-content">
                    <div class="margin-top5em">
                        <div class="center">
                            <h2>Carrito</h2>

                        <?php
                        $total = 0;
                        if(!isset($_SESSION["basketNitems"])){
                            echo "<h>No hay articulos</h3>";
                        } else {
                            $catalogo = simplexml_load_file("../XML/catalogo.xml");
                            echo "<table class=\"center\">";
                            echo "<tr>";
                            echo "<th>Imagen</th>";
                            echo "<th>Película</th>";
                            echo "<th>Precio</th>";
                            echo "</tr>";
                            foreach ($_SESSION["items"] as $id){
                                $pelicula = $catalogo->xpath("/catalogo/pelicula[id=\"$id\"]")[0];
                                $total+= $pelicula->precio;
                                echo "<tr>";
                                echo "<td><img class=\"mini-image\" src=\"$pelicula->poster\" alt='$pelicula->titulo'></td>";
                                echo "<td>$pelicula->titulo</td>";
                                echo "<td>$pelicula->precio €</td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                        }
                        ?>

                    <h3 class="basket-total"> Total: <?php echo $total; ?>€ </h3>
                    <a class="login" href="index-logged.html">Confirmar</a>
                        </div>
                    </div>
            </div>
        </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
