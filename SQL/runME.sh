createdb -U alumnodb  si1
gunzip -c ../dump_v1.2.sql.gz | psql -U alumnodb si1
cat actualiza.sql | psql -U alumnodb si1
cat setPrice.sql |  psql -U alumnodb si1
cat setOrderAmount.sql | psql -U alumnodb si1
cat updOrders.sql | psql -U alumnodb si1
cat updInventory.sql | psql -U alumnodb si1
cat getTopVentas.sql | psql -U alumnodb si1
