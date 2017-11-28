CREATE OR REPLACE FUNCTION getTopMonths(integer, integer) RETURNS TABLE( ymf text) AS $$
DECLARE

BEGIN
    RETURN QUERY SELECT YM
    FROM
        (Select YM
            From
            (SELECT TO_CHAR(orderdate, 'YYYY-MM')AS YM, sum(totalamount) AS TAYM FROM orders
            GROUP BY TO_CHAR(orderdate, 'YYYY-MM')
            ORDER BY TO_CHAR(orderdate, 'YYYY-MM')) AS totAmYM
        Where TAYM >$2) as dineroOK
        Union
        Select TO_CHAR(orderdate, 'YYYY-MM') AS YM
        From
            (SELECT orderid, sum(quantity) as Nprod FROM orderdetail
            Group by orderid) as suma
            Natural join
            (Select orderdate From orders) as prod
            WHERE Nprod >$1
    ORDER BY YM DESC;
END;
$$ LANGUAGE 'plpgsql';
