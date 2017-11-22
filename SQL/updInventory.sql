--DROP FUNCTION IF EXISTS updateInventory();

CREATE OR REPLACE FUNCTION updateInventory() 
RETURNS TRIGGER AS $$
DECLARE
	res record;
	comp integer;
BEGIN
FOR res in (select prod_id, sum(quantity) as sum
		from orderdetail Natural Join orders 
		where NEW.orderid =orderdetail.orderid 
		group by prod_id)

LOOP
	UPDATE inventory SET
--	comp stock - res.sum
	
	sales= sales + res.sum,
	stock= stock - res.sum
	Where prod_id = res.prod_id;

--	IF comp<=0 THEN
--	INSERT into alertas VALUES(res.prod_id, "producto agotado");
--	END IF;

END LOOP;

RETURN NEW; 
END;
$$LANGUAGE 'plpgsql';

DROP TRIGGER IF EXISTS t_updateInventory ON orders;
CREATE TRIGGER t_updateInventory AFTER UPDATE ON orders
FOR EACH ROW 
WHEN (OLD.status IS DISTINCT FROM NEW.status)
EXECUTE PROCEDURE updateInventory();



--SELECT * from inventory where prod_id in(select prod_id as sum
--		from orderdetail Natural Join orders 
--		where 1 =orderdetail.orderid 
--		group by prod_id);
--UPDATE orders SET status = 2 WHERE orderid = 1;

--UPDATE orderdetail SET quantity=1 where prod_id=1014;

--UPDATE inventory SET stock = 2 where prod_id=1014

