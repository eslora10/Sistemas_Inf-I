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

                try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb" );
                /*** use the database connection ***/
                }
                catch(PDOException $e){
                echo $e->getMessage();
                }


                $sql = "SELECT * FROM customers where username='shad'";

                foreach ($db->query($sql) as $row)
                {
                  echo '<h1>';
                  print $row['username'] . '<br />';
                  echo '</h1>';
                }



                ?>

              </div>


          </div>
          <?php include("includeFooter.php") ?>


  </body></html>
