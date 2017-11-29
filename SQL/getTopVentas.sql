DROP FUNCTION IF EXISTS getTopVentas(integer);
CREATE OR REPLACE FUNCTION getTopVentas(integer)
RETURNS table(año double precision, pelicula character varying, id integer, ventas bigint) AS $$
BEGIN
    --RETURN QUERY SELECT anno, movietitle, movieid, sells FROM topVentas WHERE anno>=$1;
    RETURN QUERY SELECT anno, movietitle, movieid, sells FROM topVentas WHERE anno>=$1;
END;
$$ LANGUAGE 'plpgsql';

--OPCIONALMENTE hemos creado un store procedure que saca 5 peliculas de cada genero para mostrarlas en la ventana index
CREATE OR REPLACE FUNCTION getMoviesByGenre(character varying)
RETURNS table(movietitle character varying, movieid integer) AS $$
BEGIN
    RETURN QUERY SELECT imdb_movies.movietitle, imdb_movies.movieid FROM imdb_movies NATURAL JOIN imdb_moviegenres NATURAL JOIN genres WHERE genrename = $1 LIMIT 5;
END;
$$ LANGUAGE 'plpgsql';