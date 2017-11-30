createdb -U alumnodb  si1p4
gunzip -c ./dump_v1.1-P4.sql.gz | psql -U alumnodb si1p4
