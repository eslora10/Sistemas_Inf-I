<?php
  $catalogo = simplexml_load_file("../XML/catalogo.xml");
  foreach ($catalogo->children() as $pelicula){
    echo "a: $pelicula->titulo\n";
    $gen = $pelicula->xpath('generos')[0];
    foreach ($gen->children() as $gn)
        echo "$gn\n";
    echo "b: $pelicula->poster\n";
    echo "c: $pelicula->precio\n";

  }
 ?>
