ALTER TABLE customers ADD COLUMN promo numeric;

CREATE OR REPLACE function promo_cart() RETURNS TRIGGER AS $$
DECLARE
	net numeric;
	price_promo numeric;
	no_promo record;
	p_price numeric;
BEGIN
	net := 0;
	FOR no_promo IN SELECT * FROM 
			orderdetail NATURAL JOIN orders
			WHERE customerid=NEW.customerid AND status IS NULL
	LOOP
		SELECT INTO p_price price from products WHERE prod_id=no_promo.prod_id;
		price_promo := p_price - p_price*NEW.promo/100;
		net := net + price_promo;
		UPDATE  orderdetail SET price=price_promo WHERE prod_id=no_promo.prod_id;
		PERFORM pg_sleep(5);	
		UPDATE orders SET netamount=(SELECT sum(price) FROM orderdetail NATURAL JOIN orders WHERE orderid=no_promo.orderid
		GROUP BY orderid), totalamount=netamount+netamount*tax/100 WHERE orderid=no_promo.orderid;
	END LOOP;
		

	RETURN NEW;
END;
$$ language plpgsql;

DROP TRIGGER IF EXISTS t_promo_cart ON customers;
CREATE TRIGGER t_promo_cart AFTER UPDATE ON customers
FOR EACH ROW
WHEN (OLD.promo IS DISTINCT FROM NEW.promo)
	EXECUTE PROCEDURE promo_cart();

	
UPDATE orders SET status=NULL WHERE customerid=1 OR customerid=2 OR customerid=3 OR customerid=4;
UPDATE customers set promo=10 where customerid=1;
