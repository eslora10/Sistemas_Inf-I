<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <?php include("includeHead.php") ?>
    <body>
      <?php include("includeHeader.php") ?>
    <body>
        <div class="container-fluid">
          <div class="main-content">
                  <div class="margin-top5em">
                      <div class="center">
                          <h2>Historial</h2>

                      <?php
                      $total = 0;
                      $historial = simplexml_load_file("../XML/hitorial.xml");
                      echo "<table class=\"center\">";
                      echo "<tr>";
                      echo "<th colspan=\"2\">Fecha </th>";
                      echo "</tr>";
                      foreach ($historial->Fecha as $day){
                        echo "<tr>";
                        echo "<td>$day</td>";
                        echo "<td>DESPLEGAR</td>";
                        echo "</tr>";


                        #dentro del tr generamos la tabla nueva
                        echo "<tr>";
                          echo "<table >";
                          echo "<tr>";
                          echo "<th>$day->date </th>";
                          echo "<th>DESPLEGAR</th>";
                          echo "</tr>";
                        echo "<tr>";
                        foreach ($day->peli as $p) {

                          echo "<tr>";
                          echo "<td>$p->titulo</td>";
                          echo "<td>$p->precio</td>";
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
