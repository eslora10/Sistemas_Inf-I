DROP FUNCTION IF EXISTS updateInventory()
CREATE FUNCTION updateInventory() RETURNS TRIGGER AS $$
DECLARE
	oID record;

BEGIN

UPDATE inventory SET
stock=stock -1
sales=sales+1
Where invent.prod_id in (select distinct prod_id from orderdetails Natural Join orders where NEW.orderid =orderdetail.orderid)
END;
$$LANGUAGE 'plpgsql'

UPDATE OR CREATE TRIGGER t_updateInventory() AFTER UPDATE status ON orders
FOR EACH ROW EXECUTE PROCEDURE updateInventory();


OLD.