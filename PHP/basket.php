<?php session_start();?>
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
        <link rel="stylesheet" type="text/css" href="../CSS/style.css?<?php echo time(); ?>">


    </head>
    <body>
      <header>
            <div class="divHeaderButton">
                <?php
                    if(isset($_SESSION['nick'])) {
                        echo "<nav>";
                        echo "<div class=\"dropdown\">";
                        echo "<button class=\"btn dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\">";
                        echo $_SESSION['nick'];
                        echo "<span class=\"caret\"></span></button>";
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
                <h6>Articulos en el <a class="header-link" href="basket.php">carro</a>: 
                    <?php                     
                    if(isset($_SESSION["basketNitems"])){
                        echo $_SESSION["basketNitems"];
                    } else {
                        echo "0";
                    }
                    ?>
                </h6>

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

        </header>
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
                        <!--
                        <tr>"
                            <td><img class="mini-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'></td>
                            <td>Los vengadores</td>
                            <td>10€</td>
                        </tr>
                        <tr>
                            <td><img class="mini-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'></td>
                            <td>Los vengadores</td>
                            <td>10€</td>
                        </tr>
                        <tr>
                            <td><img class="mini-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'></td>
                            <td>Los vengadores</td>
                            <td>10€</td>
                        </tr>
                        <tr>
                            <td><img class="mini-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'></td>
                            <td>Los vengadores</td>
                            <td>10€</td>
                        </tr>
                        <tr>
                            <td><img class="mini-image" src="../media/img/TheAvengers2012Poster.jpg" alt='Avengers'></td>
                            <td>Los vengadores</td>
                            <td>10€</td>
                        </tr>

                    </table> -->
                    <h3 class="basket-total"> Total: <?php echo $total; ?>€ </h3>
                    <a class="login" href="index-logged.html">Confirmar</a>
                        </div>
                    </div>
            </div>
        </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
