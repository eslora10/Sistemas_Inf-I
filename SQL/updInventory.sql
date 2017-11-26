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
	comp:= (Select stock from inventory where prod_id=res.prod_id) - res.sum;
	UPDATE inventory SET
		sales= sales + res.sum,
		stock= stock - res.sum
	Where prod_id = res.prod_id;

	IF comp<=0 THEN
		INSERT into alertas(prod_id, msg) VALUES(res.prod_id, 'producto agotado');
	END IF;

END LOOP;

RETURN NEW;
END;
$$LANGUAGE 'plpgsql';

DROP TRIGGER IF EXISTS t_updateInventory ON orders;
CREATE TRIGGER t_updateInventory AFTER UPDATE ON orders
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status AND OLD.status IS NULL)
EXECUTE PROCEDURE updateInventory();
