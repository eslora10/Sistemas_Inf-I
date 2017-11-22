delete if exist function getTopMonths(INTEGER);
CREATE OR REPLACE FUNCTION getTopMonths(integer) RETURNS TABLE( ymf text) AS $$
DECLARE

BEGIN
	RETURN QUERY SELECT YM 
	FROM
		(SELECT TO_CHAR(orderdate, 'YYYY-MM') AS YM, sum(totalamount) AS TAYM FROM orders
		GROUP BY TO_CHAR(orderdate, 'YYYY-MM')
		Where TAYM > $1
		ORDER BY TO_CHAR(orderdate, 'YYYY-MM')) AS totAmYM
		--NATURAL JOIN
		Select TO_CHAR(orderdate, 'YYYY-MM')
		From	
			(SELECT orderid, sum(quantity) as Nprod FROM orderdetail
			Group by orderid) as suma
			Natural join
			(Select orderdate From orders) as prod
		WHERE Nprod >$2
		
	WHERE TAYM > $1
	ORDER BY YM DESC;
	
END;
$$ LANGUAGE 'plpgsql';

select getTopMonths(320000, 2);
