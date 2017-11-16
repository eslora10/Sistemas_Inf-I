DROP function getTopMonths(INTEGER);
CREATE OR REPLACE FUNCTION getTopMonths(integer) RETURNS TABLE( ymf text) AS $$
DECLARE

BEGIN
	RETURN QUERY SELECT YM 
	FROM
		(SELECT TO_CHAR(orderdate, 'YYYY-MM') AS YM, sum(totalamount) AS TAYM FROM orders
		GROUP BY TO_CHAR(orderdate, 'YYYY-MM')
		ORDER BY TO_CHAR(orderdate, 'YYYY-MM')) AS totAmYM 
		NATURAL JOIN
		--products!!!!!!!!
		(SELECT TO_CHAR(orderdate, 'YYYY-MM') AS YM, sum(totalamount) AS TAYM FROM orders
		GROUP BY TO_CHAR(orderdate, 'YYYY-MM')
		ORDER BY TO_CHAR(orderdate, 'YYYY-MM')) AS totAmYM
	WHERE TAYM > $1
	ORDER BY YM DESC;
	
END;
$$ LANGUAGE 'plpgsql';

select getTopMonths(1);
