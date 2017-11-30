DROP INDEX IF EXISTS i_orderdate;

Explain 
SELECT count(*)
FROM
	(SELECT DISTINCT customerid FROM  orders where totalAmount >=100  
						 --AND TO_CHAR(orderdate, 'YYYY-MM')='2014-04' GROUP BY customerid) AS sub
						 AND orderdate>='2014-04-01' AND orderdate<='2014-04-30' GROUP BY customerid) AS sub;
CREATE INDEX i_orderdate ON orders(orderdate);

Explain 
SELECT count(*)
FROM
	(SELECT DISTINCT customerid FROM  orders where totalAmount >=100  
						 --AND TO_CHAR(orderdate, 'YYYY-MM')='2014-04' GROUP BY customerid) AS sub
						 AND orderdate>='2014-04-01' AND orderdate<='2014-04-30' GROUP BY customerid) AS sub;