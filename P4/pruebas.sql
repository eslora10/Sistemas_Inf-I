BEGIN;


DELETE FROM orderdetail where orderid in(SELECT orderid from orders where customerid=3);
DELETE FROM orders where customerid=3;
DELETE FROM customers where customerid =3;

DELETE FROM customers WHERE customerid=2;
COMMIT;

ROLLBACK;

SELECT * FROM CUSTOMERS order by customerid limit 2 ;

SELECT customerid FROM customers where customerid=10

