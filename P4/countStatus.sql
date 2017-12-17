EXPLAIN
select count(*)
from orders
where status is null;

EXPLAIN
select count(*)
from orders
where status ='Shipped';

DROP INDEX IF EXISTS i_status;
CREATE INDEX i_status ON orders(status);

EXPLAIN
select count(*)
from orders
where status is null;

EXPLAIN
select count(*)
from orders
where status ='Shipped';

ANALYZE orders;

EXPLAIN
select count(*)
from orders
where status is null;

EXPLAIN
select count(*)
from orders
where status ='Shipped';

EXPLAIN
select count(*)
from orders
where status ='Paid';

EXPLAIN
select count(*)
from orders
where status ='Processed';
