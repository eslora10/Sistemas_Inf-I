<?php
    $catalogo = simplexml_load_file("../XML/catalogo.xml");
    $generos = array_unique($catalogo->xpath('/catalogo/pelicula/generos/genero'));
    foreach ($generos as $genero){
        $peliculas_fil = $catalogo->xpath("/catalogo/pelicula[contains(titulo, 'Vengadores')]");
        /*print_r($peliculas_fil);*/
        $peliculas = $catalogo->xpath("/catalogo/pelicula[generos/genero=\"Infantil\"]"); 
        /*print_r($peliculas);*/
        $peliculas = array_intersect($peliculas, $peliculas_fil);
        print_r($peliculas);
        
    }
?>