<?php
session_start();
$nick=$_SESSION["nick"];
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
                          <h2>Historial</h2>

                      <?php
                      /*Conexion con la base de datos*/
                      try {
                          $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
                      } catch (PDOException $e) {
                          echo "<h1 class='err-db'>Se ha producido un error interno</h1>";
                          die();
                      }


                      echo "<table class=\"center\">";
                      echo "<tr>";
                      echo "<th >Fecha </th>";
                      echo "</tr>";

                      /*Conseguimos los pedidos del usuario*/
                      $query = "SELECT * FROM orders where status IS NOT NULL and customerid in (SELECT customerid FROM customers WHERE email=$_SESSION[email])";
                      foreach($database->query($query) as $order){
                          echo "<tr >"; /* ponemos la clase desplegable aqui para que la funcion .next de JQUERY  funcione ; necesita un sibbling*/
                          echo "<td>$order[orderdate] <a class=\"desplegar\"><i class='fa fa-caret-square-o-down' aria-hidden='true'></i></a></td>";
                          echo "</tr>";

                         #dentro del tr generamos la tabla nueva
                          echo "<tr class=\"prueba\">";
                          echo "<td >";
                          echo "<table class='minicenter'>";
                          echo "<tr>";
                          echo "<th >Titulo </th>";
                          echo "<th >Unidades </th>";
                          echo "<th >Precio </th>";
                          echo "</tr>";
                          $queryContent="SELECT * FROM (Select prod_id, quantity FROM orderdetail WHERE orderid = $order[orderid]) as uno NATURAL JOIN(SELECT prod_id, movieid, price, description, movietitle FROM products NATURAL JOIN imdb_movies WHERE prod_id in (SELECT prod_id FROM orderdetail WHERE orderid = $order[orderid])) as dos";

                          foreach ($database->query($queryContent) as $Content) {

                            $titulo = $catalogo->xpath("/catalogo/pelicula[id=\"$p->id\"]/titulo")[0];

                            echo "<tr>";
                            echo "<td >$Content[movietitle]</td>";
                            echo "<td >$Content[quantity]</td>";
                            echo "<td >$Content[price]</td>";
                            echo "</tr>";
                          }
                          echo "</table>";
                        echo "</td>";
                        echo "</tr>";
                      }
                      echo "</table>";
                      ?>

                  <h3 class="basket-total"> Saldo disponible: <?php echo $_SESSION['saldo']; ?>€ </h3>

                  <form action="historySaldo.php" METHOD=post>
                    <div class="header-form">
                    <h3>Añadir saldo:
                        <input class="add_saldo" type="number" name="add_saldo" required><input class="add_saldo-btn" type="submit" value="Añadir"></h3>
                    </div>

                  </form>
                  </div>


          </div>
        </div>
        </div>
        <?php include("includeFooter.php") ?>

</body></html>
