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
                      $historial = simplexml_load_file("../XML/historial.xml");
                      echo "<table class=\"center\">";
                      echo "<tr>";
                      echo "<th colspan=\"2\">Fecha </th>";
                      echo "</tr>";
                      foreach ($historial->Fecha as $day){
                        echo "<tr >"; /* ponemos la clase desplegable aqui para que la funcion .next de JQUERY  funcione ; necesita un sibbling*/
                        echo "<td><a class=\"desplegar\">$day->date</a></td>";
                        echo "</tr>";

                        #dentro del tr generamos la tabla nueva
                        echo "<tr class=\"prueba\">";
                        echo "<td colspan=\"2\">";
                          echo "<table class=\"center\">";
                          $catalogo = simplexml_load_file("../XML/catalogo.xml");
                          foreach ($day->pelicula as $p) {

                            $titulo = $catalogo->xpath("/catalogo/pelicula[id=\"$p->id\"]/titulo");

                            echo "<tr>";
                            echo "<td >$titulo</td>";
                            echo "<td >$p->precio</td>";
                            echo "</tr>";
                          }
                          echo "</table>";
                        echo "</td>";
                        echo "</tr>";
                      }
                      echo "</table>";
                      ?>

                      <?php

                     /* echo "<table class=\"center\">";
                      echo "<tr>";
                      echo "<th colspan=\"2\">Fecha </th>";
                      echo "</tr>";
                      echo "<tr>";
                      echo "<td>hola</td>";
                      echo "<td>adios</td>";
                      echo "</tr>";


                      echo "<tr>";
                          echo "<table class=\"center\">";
                          echo "<tr>";
                          echo "<th colspan=\"2\">Fecha </th>";
                          echo "</tr>";
                          echo "<tr>";
                          echo "<td>hola</td>";
                          echo "<td>adios</td>";
                          echo "</tr>";

                          echo "<tr>";
                              echo "<table class=\"center\">";
                              echo "<tr>";
                              echo "<th colspan=\"2\">Fecha </th>";
                              echo "</tr>";
                              echo "<tr>";
                              echo "<td>hola</td>";
                              echo "<td>adios</td>";
                              echo "</tr>";
                              echo "</table>";
                          echo "</tr>";


                          echo "</table>";
                      echo "</tr>";

                      echo "</table>";
*/
                      ?>


                  <h3 class="basket-total"> Total: <?php echo $total; ?>€ </h3>
                  <a class="login" href="index-logged.html">Confirmar</a>
                      </div>
                  </div>
          </div>
        </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


        <script>
        $( ".desplegar" ).closest("tr").nextAll( ".prueba" ).css('background', 'yellow');
        </script>

</body></html>
