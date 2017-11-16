SELECT prod_id, orderdate, count(quantity) AS ventas 
FROM orderdetail NATURAL JOIN orders 
WHERE date_part('year', orderdate)=2016
GROUP BY prod_id, orderdate
ORDER BY ventas DESC LIMIT 1

select * from orders natural join orderdetail where date_part('year', orderdate)=2011
select * from products where prod_id=498

DROP FUNCTION IF EXISTS getTopVentas(integer);
CREATE OR REPLACE FUNCTION getTopVentas(anno integer) RETURNS table(año integer, pelicula varchar, ventas integer) AS $$

BEGIN
	CREATE VIEW pelis_ventas AS
	(SELECT count(quantity) AS ventas, movieid, date_part('year', orderdate) as año
	FROM orderdetail, orders, products
	WHERE date_part('year', orderdate)>=2011 AND orderdetail.prod_id=products.prod_id
	AND orderdetail.orderid=orders.orderid
	GROUP BY movieid, año);

	RETURN QUERY (SELECT año, movietitle as pelicula, ventas FROM
	(SELECT ventas, movietitle, año FROM pelis_ventas NATURAL JOIN imdb_movies) as movies
	NATURAL JOIN
	(SELECT max(ventas) AS ventas, año FROM  pelis_ventas
	GROUP BY año
	ORDER BY año) as max
	ORDER BY año);

	DROP VIEW pelis_ventas;
END;
$$ LANGUAGE plpgsql;
select * FROM getTopVentas(2011)
Select setOrderAmount();

