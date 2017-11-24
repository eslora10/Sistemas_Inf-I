DROP FUNCTION IF EXISTS updOrders() CASCADE;
CREATE FUNCTION updOrders() RETURNS TRIGGER AS $$
DECLARE 
	orderid_upd integer;
	quantity integer;
	price numeric;
	netamount_upd numeric;
	old_order record;
BEGIN 

	IF(TG_OP = 'UPDATE') THEN 
		orderid_upd := NEW.orderid;
		price := NEW.price;
		--Sumaremos o restaremos el precio en funcion de como cambian las unidades
		netamount_upd := (NEW.quantity - OLD.quantity)*price;

	ELSIF (TG_OP = 'DELETE') THEN 
		--Necesitamos saber cuantas unidades borramos y su precio
		orderid_upd := OLD.orderid;
		price := OLD.price;
		--Tenemos que restar el precio de todos los productos borrados
		netamount_upd := -OLD.quantity*price;
		SELECT netamount INTO old_order FROM orders WHERE orderid=orderid_upd;
		--Si el precio resulta ser 0 borramos el registro, si no lo modificamos
		IF ((old_order.netamount + netamount_upd) = 0) THEN 
			DELETE FROM orders WHERE orderid=orderid_upd;
			RETURN NEW;
		END IF;
	ELSE 
		--Caso insert cuando el carro ya existe
		orderid_upd := NEW.orderid;
		price := NEW.price;
		netamount_upd := NEW.quantity*price;	
		
        END IF;
	--Recalculamos los precios

	--Obtenemos las tasas para calcular el precio
	SELECT tax INTO old_order FROM orders WHERE orderid=orderid_upd;
	UPDATE orders SET
	netamount = netamount + netamount_upd,
	totalamount = totalamount + netamount_upd+netamount_upd*old_order.tax/100
	WHERE orderid=orderid_upd;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS t_updOrders ON orderdetail;
CREATE TRIGGER t_updOrders AFTER UPDATE OR DELETE OR INSERT ON orderdetail
	FOR EACH ROW EXECUTE PROCEDURE updOrders();