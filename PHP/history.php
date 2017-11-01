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
                      $historial = simplexml_load_file("../usuarios/$nick/historial.xml");
                      echo "<table class=\"center\">";
                      echo "<tr>";
                      echo "<th >Fecha </th>";
                      echo "</tr>";
                      foreach ($historial->fecha as $day){
                        echo "<tr >"; /* ponemos la clase desplegable aqui para que la funcion .next de JQUERY  funcione ; necesita un sibbling*/
                        echo "<td>$day->date <a class=\"desplegar\"><i class='fa fa-caret-square-o-down' aria-hidden='true'></i></a></td>";
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
                          $catalogo = simplexml_load_file("../XML/catalogo.xml");
                          foreach ($day->pelicula as $p) {

                            $titulo = $catalogo->xpath("/catalogo/pelicula[id=\"$p->id\"]/titulo")[0];

                            echo "<tr>";
                            echo "<td >$titulo</td>";
                            echo "<td >$p->uds</td>";
                            echo "<td >$p->precio</td>";
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
