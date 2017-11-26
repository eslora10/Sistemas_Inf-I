CREATE OR REPLACE FUNCTION setOrderAmount() RETURNS void AS $$
DECLARE
	valores record;
BEGIN
	FOR  valores IN 
		SELECT  orderid,neto, (neto*tax*0.01+neto) as total FROM 
			(SELECT orderid, sum(price *quantity) as neto FROM orderdetail GROUP BY orderid) AS neto 
			NATURAL JOIN orders 
		WHERE netamount IS NULL OR totalamount IS NULL
	LOOP
		UPDATE orders SET netamount=valores.neto, totalamount=valores.total
		WHERE orders.orderid=valores.orderid;
	END LOOP;
END;
$$ LANGUAGE plpgsql;

SELECT setOrderAmount();
