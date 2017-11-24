DROP TABLE IF EXISTS topVentas;
SELECT anno, movietitle, sells, movieid INTO topVentas FROM 
	(SELECT max(sells) as sells, anno FROM 
		(SELECT sum(quantity) AS sells, date_part('year', orderdate) AS anno
			FROM orderdetail, orders, products
			WHERE date_part('year', orderdate)>=2011 AND orderdetail.prod_id=products.prod_id
				AND orderdetail.orderid=orders.orderid
			GROUP BY movieid, anno) AS COUNT_VENTAS
			GROUP BY anno) AS COUNT_VENTAS_ANNO NATURAL JOIN 
	(SELECT sum(quantity) AS sells, date_part('year', orderdate) AS anno, movietitle, products.movieid
		FROM orderdetail, orders, products, imdb_movies
		WHERE date_part('year', orderdate)>=2011 AND orderdetail.prod_id=products.prod_id
			AND orderdetail.orderid=orders.orderid AND products.movieid=imdb_movies.movieid
		GROUP BY movietitle, anno, products.movieid) as count_ventas_movie
	ORDER BY anno;

DROP FUNCTION IF EXISTS getTopVentas(integer);
CREATE OR REPLACE FUNCTION getTopVentas(integer) RETURNS table(año double precision, pelicula character varying, id integer, ventas bigint) AS $$
BEGIN
	--RETURN QUERY SELECT anno, movietitle, movieid, sells FROM topVentas WHERE anno>=$1;
	RETURN QUERY SELECT anno, movietitle, movieid, sells FROM topVentas WHERE anno>=$1;
END;
$$ LANGUAGE 'plpgsql';

--OPCIONALMENTE hemos creado un store procedure que saca 5 peliculas de cada genero para mostrarlas en la ventana index
CREATE OR REPLACE FUNCTION getMoviesByGenre(character varying) RETURNS table(movietitle character varying, movieid integer) AS $$
BEGIN
	RETURN QUERY SELECT imdb_movies.movietitle, imdb_movies.movieid FROM imdb_movies NATURAL JOIN imdb_moviegenres NATURAL JOIN genres WHERE genrename = $1 LIMIT 5;
END;
$$ LANGUAGE 'plpgsql';
select * from getmoviesbygenre('Drama');
SELECT movieid, movietitle FROM imdb_movies NATURAL JOIN imdb_moviegenres NATURAL JOIN genres WHERE genrename='Drama' AND movietitle ILIKE('life%')
