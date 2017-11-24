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
                <?php
                /*Conexion con la base de datos*/
                try {
                    $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
                } catch (PDOException $e) {
                    echo "<h1 class='err-db'>Se ha producido un error interno</h1>";
                    die();
                }
                /*Llamamos al prodecimiento almacenado getTopventas*/
                $year = date('Y')-2; /*Los ultimos tres años*/
                $query = "SELECT * FROM getTopVentas(cast($year as integer))";
                /*Creamos un div para poner las pelis mas vendidas*/
                echo "<div class=\"row-content\">";
                echo "<h1 class=\"tittleRow\">Pel&iacute;culas m&aacute;s vendidas</h1>";
                foreach ($database->query($query) as $pelicula){
                    echo "<span>";
                    echo "<a href=\"film-detail.php?film=".$pelicula['id']."\" class=\"film-card\">";
                    echo "<span>";
                    echo "<img class=\"film-image\" src=\"../media/img/".$pelicula['id'].".jpg\" alt='".$pelicula['pelicula']."'><br>";
                    echo $pelicula['pelicula'];
                    echo "</span>";
                    echo "</a>";
                    echo "</span>";                    
                }
                echo "</div>";
                /*Cargamos el catalogo*/
                $catalogo = simplexml_load_file("../XML/catalogo.xml");
                if(isset($_REQUEST['genre']) && strcmp($_REQUEST['genre'], "All")){
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
                            echo "<a href=\"film-detail.php?film=$pelicula->id\" class=\"film-card\">";
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
              
            </div>


        </div>
        <?php include("includeFooter.php") ?>


</body></html>
