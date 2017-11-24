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
                            echo "<h>No hay articulos</h3>";
                        } else {
                            $catalogo = simplexml_load_file("../XML/catalogo.xml");
                            echo "<table class=\"center\">";
                            echo "<tr>";
                            echo "<th>Imagen</th>";
                            echo "<th colspan=\"2\">Película</th>";
                            echo "<th>Unidades</th>";
                            echo "<th>Precio</th>";
                            echo "</tr>";
                            foreach (array_keys($_SESSION["items"]) as $id){
                                $uds = $_SESSION["items"][$id];
                                $pelicula = $catalogo->xpath("/catalogo/pelicula[id=\"$id\"]")[0];
                                $_SESSION["total_basket"]+= $pelicula->precio * $uds;
                                echo "<tr>";
                                echo "<td><a href=\"film-detail.php?film=$pelicula->id\"><img class=\"mini-image\" src=\"$pelicula->poster\" alt='$pelicula->titulo'></a></td>";
                                echo "<td>$pelicula->titulo</td>";
                                echo "<td><a href=\"basket-update.php?xfilm=$pelicula->id\"><i class=\"fa fa-times\"></i></a></td>";
                                echo "<td>$uds</td>";
                                echo "<td>". $pelicula->precio * $uds. "€</td>";
                                echo "</tr>";
                            }

                            echo "</table>";

                            echo "<h3 class=\"basket-total\"> Total:". $_SESSION["total_basket"]. " € </h3>";
                            echo "<a class=\"login\" href=\"basket-check.php\">Confirmar</a>";
                        }
                        ?>
                        </div>
                    </div>
            </div>
        </div>
        
        <?php include("includeFooter.php") ?>


</body></html>
