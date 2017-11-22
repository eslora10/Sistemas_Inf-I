CREATE OR REPLACE FUNCTION getTopVentas(integer) RETURNS table(año double precision, pelicula character varying, ventas bigint) AS $$
BEGIN
	RETURN QUERY SELECT anno, movietitle, sells FROM 
	(SELECT max(sells) as sells, anno FROM 
		(SELECT sum(quantity) AS sells, date_part('year', orderdate) AS anno
			FROM orderdetail, orders, products
			WHERE date_part('year', orderdate)>=$1 AND orderdetail.prod_id=products.prod_id
				AND orderdetail.orderid=orders.orderid
			GROUP BY movieid, anno) AS COUNT_VENTAS
			GROUP BY anno) AS COUNT_VENTAS_ANNO NATURAL JOIN 
	(SELECT sum(quantity) AS sells, date_part('year', orderdate) AS anno, movietitle
		FROM orderdetail, orders, products, imdb_movies
		WHERE date_part('year', orderdate)>=$1 AND orderdetail.prod_id=products.prod_id
			AND orderdetail.orderid=orders.orderid AND products.movieid=imdb_movies.movieid
		GROUP BY movietitle, anno, products.movieid) as count_ventas_movie
	ORDER BY anno;
	
END;
$$ LANGUAGE 'plpgsql';
select * FROM getTopVentas(cast(2017 as integer));

