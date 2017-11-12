CREATE VIEW order_numyears AS
(SELECT orderid, date_part('year', age(orderdate)) as coef FROM orders);

CREATE VIEW calculated_price AS
(SELECT products.prod_id, orderid, products.price, coef, products.price/1.02^coef AS rel_price 
FROM products JOIN orderdetail NATURAL JOIN order_numyears
ON products.prod_id=orderdetail.prod_id);

UPDATE orderdetail SET price=rel_price*quantity FROM calculated_price
WHERE orderdetail.prod_id=calculated_price.prod_id AND orderdetail.orderid=calculated_price.orderid
