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
                            <?php
                            if(isset($_REQUEST["sell"]) && $_REQUEST["sell"] == 0){
                                $saldo = $_SESSION["saldo"];
                                echo "<h3>Saldo insuficiente: $saldo €</h3>";
                            }
                            ?>
                            <h2>Carrito</h2>


                        <?php
                        $_SESSION["total_basket"] = 0;
                        if(!isset($_SESSION["basketNitems"]) || !$_SESSION["basketNitems"]){
                            echo "<h3>No hay articulos</h3>";
                        } else {
                            try {
                                $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
                            } catch (PDOException $e){
                                echo "<h3>No hay articulos</h3>";
                                die();
                            }
                            echo "<table class=\"center\">";
                            echo "<tr>";
                            echo "<th>Imagen</th>";
                            echo "<th colspan=\"2\">Película</th>";
                            echo "<th>Unidades</th>";
                            echo "<th>Edici&oacute;n</th>";
                            echo "<th>Precio</th>";
                            echo "</tr>";
                            foreach (array_keys($_SESSION["items"]) as $id){
                                $uds = $_SESSION["items"][$id];
                                $query = "SELECT movieid, price, description, movietitle FROM products NATURAL JOIN imdb_movies WHERE prod_id=$id";
                                foreach($database->query($query) as $pelicula){
                                    $_SESSION["total_basket"]+= $pelicula['price'] * $uds;
                                    echo "<tr>";
                                    echo "<td><a href=\"film-detail.php?film=".$pelicula['movieid']."\"><img class=\"mini-image\" src=\"".$pelicula['movieid'].".jpg\" alt='".$pelicula['movieid']."'></a></td>";
                                    echo "<td>".$pelicula['movietitle']."</td>";
                                    echo "<td><a href=\"basket-update.php?xfilm=".$pelicula['movieid']."\"><i class=\"fa fa-times\"></i></a></td>";
                                    echo "<td>$uds</td>";
                                    echo "<td>".$pelicula['description']."</td>";
                                    echo "<td>". $pelicula['price'] * $uds. "€</td>";
                                    echo "</tr>";
                                }
                            }

                            echo "</table>";

                            echo "<h3 class=\"basket-total\"> Total (sin tasas): ". $_SESSION["total_basket"]. " € </h3>";
                            echo "<a class=\"login\" href=\"basket-check.php\">Confirmar</a>";
                        }
                        ?>
                        </div>
                    </div>
            </div>
        </div>
        
        <?php include("includeFooter.php") ?>


</body></html>
