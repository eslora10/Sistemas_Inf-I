--Creamos la tabla countries  y la llenamos con los paises presentes en moviecountries
DROP TABLE IF EXISTS countries;
DROP SEQUENCE IF EXISTS countryid_seq;
CREATE SEQUENCE countryid_seq;
CREATE TABLE countries (
countryid integer NOT NULL DEFAULT nextval('countryid_seq'::regclass),
countryname character varying(32) NOT NULL,
CONSTRAINT country_pkey PRIMARY KEY (COUNTRYID)
);
INSERT INTO countries(countryname) SELECT DISTINCT country FROM imdb_moviecountries;

--Creamos la tabla genres y la llenamos con los generos presentes en moviegenres
DROP TABLE IF EXISTS genres;
DROP SEQUENCE IF EXISTS genreid_seq;
CREATE SEQUENCE genreid_seq;
CREATE TABLE genres (
genreid integer NOT NULL DEFAULT nextval('genreid_seq'::regclass),
genrename character varying(32) NOT NULL,
CONSTRAINT genre_pkey PRIMARY KEY (genreid)
);
INSERT INTO genres(genrename) SELECT DISTINCT genre FROM imdb_moviegenres;

--Creamos la tabla languages y la llenamos con los idiomas presentes en movielanguages
DROP TABLE IF EXISTS languages;
DROP SEQUENCE IF EXISTS languageid_seq;
CREATE SEQUENCE languageid_seq;
CREATE TABLE languages (
languageid integer NOT NULL DEFAULT nextval('languageid_seq'::regclass),
languagename character varying(32) NOT NULL,
CONSTRAINT language_pkey PRIMARY KEY (languageid)
);
INSERT INTO languages(languagename) SELECT DISTINCT language FROM imdb_movielanguages;

--Modificamos la tabla moviecountries para que el pais sea una FK a la tabla countries
CREATE TABLE aux (
movieid integer NOT NULL,
countryid integer NOT NULL
);
INSERT INTO aux(movieid, countryid) SELECT movieid, countryid FROM countries, imdb_moviecountries 
WHERE countryname=country;
DROP TABLE IF EXISTS imdb_moviecountries;
ALTER TABLE aux RENAME TO imdb_moviecountries;
ALTER TABLE imdb_moviecountries ADD CONSTRAINT imdb_moviecountries_pkey PRIMARY KEY (movieid, countryid);
ALTER TABLE imdb_moviecountries ADD CONSTRAINT imdb_moviecountries_movieid_fkey FOREIGN KEY (movieid)
      REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_moviecountries ADD CONSTRAINT imdb_moviecountries_countryid_fkey FOREIGN KEY (countryid)
      REFERENCES public.countries (countryid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;

--Modificamos la tabla moviegenres para que el genero sea una FK a la tabla genres
CREATE TABLE aux (
movieid integer NOT NULL,
genreid integer NOT NULL
);
INSERT INTO aux(movieid, genreid) SELECT movieid, genreid FROM genres, imdb_moviegenres 
WHERE genrename=genre;
DROP TABLE IF EXISTS imdb_moviegenres;
ALTER TABLE aux RENAME TO imdb_moviegenres;
ALTER TABLE imdb_moviegenres ADD CONSTRAINT imdb_moviegenres_pkey PRIMARY KEY (movieid, genreid);
ALTER TABLE imdb_moviegenres ADD CONSTRAINT imdb_moviegenres_movieid_fkey FOREIGN KEY (movieid)
      REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_moviegenres ADD CONSTRAINT imdb_moviegenres_genreid_fkey FOREIGN KEY (genreid)
      REFERENCES public.genres (genreid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;

--Modificamos la tabla movielanguages para que el idioma sea una FK a la tabla languages
--Queremos que la PK de la tabla movielanguages sea (movieid, languageid) eliminamos los 
--duplicados quedandonos con los que tienen extrainformation
DELETE FROM imdb_movielanguages WHERE movieid IN
(SELECT movieid FROM (SELECT movieid, language, COUNT(*) as c FROM imdb_movielanguages
group by movieid, language) AS count_lan WHERE C>1) AND extrainformation='';

CREATE TABLE aux (
movieid integer NOT NULL,
languageid integer NOT NULL,
extrainformation character varying(128) --not null esta mal porque es info extra
);
INSERT INTO aux(movieid, languageid, extrainformation) SELECT movieid, languageid, extrainformation FROM languages, imdb_movielanguages
WHERE languagename=language;
DROP TABLE IF EXISTS imdb_movielanguages;
ALTER TABLE aux RENAME TO imdb_movielanguages;
ALTER TABLE imdb_movielanguages ADD CONSTRAINT imdb_movielanguages_pkey PRIMARY KEY (movieid, languageid);
ALTER TABLE imdb_movielanguages ADD CONSTRAINT imdb_movielanguages_movieid_fkey FOREIGN KEY (movieid)
      REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_movielanguages ADD CONSTRAINT imdb_movielanguages_languageid_fkey FOREIGN KEY (languageid)
      REFERENCES public.languages (languageid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;

--CAMBIOS PARA ACTORMOVIES
--Cambiamos la primarykey para que no contenga numparticipation
ALTER TABLE imdb_actormovies DROP CONSTRAINT imdb_actormovies_pkey;
ALTER TABLE imdb_actormovies ADD CONSTRAINT imdb_actormovies_pkey PRIMARY KEY (actorid, movieid);

--Creamos dos foreign keys para actorid y movieid
ALTER TABLE imdb_actormovies ADD CONSTRAINT imdb_actormovies_movieid_fkey FOREIGN KEY (movieid)
      REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_actormovies ADD CONSTRAINT imdb_actormovies_actorid_fkey FOREIGN KEY (actorid)
      REFERENCES public.imdb_actors (actorid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;

--Quitamos el NOT NULL de ascharacter porque hay muchos datos vacios
ALTER TABLE imdb_actormovies ALTER COLUMN ascharacter DROP NOT NULL;

--CAMBIOS PARA LA TABLA ACTORS
--cambiamos gender de male, female a M,F para que sea consistente con la tabla customer
UPDATE imdb_actors SET gender='M' WHERE gender='male';
UPDATE imdb_actors SET gender='F' WHERE gender='female';
ALTER TABLE imdb_actors ALTER gender TYPE character varying(1);

--CAMBIOS PARA LA TABLA DIRECTORMOVIES
--Cambiamos la PK eliminando numpartitipation
ALTER TABLE imdb_directormovies DROP CONSTRAINT imdb_directormovies_pkey;
ALTER TABLE imdb_directormovies ADD CONSTRAINT imdb_directormovies_pkey PRIMARY KEY (directorid, movieid);
--Cambiamos las FK para que se actualicen cuando los elemtos a los que referencian cambien
ALTER TABLE imdb_directormovies DROP CONSTRAINT imdb_directormovies_directorid_fkey;
ALTER TABLE imdb_directormovies ADD CONSTRAINT imdb_directormovies_directorid_fkey FOREIGN KEY (directorid)
    REFERENCES public.imdb_directors (directorid) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_directormovies DROP CONSTRAINT imdb_directormovies_movieid_fkey;
ALTER TABLE imdb_directormovies ADD CONSTRAINT imdb_directormovies_movieid_fkey FOREIGN KEY (movieid)
    REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE NO ACTION;

--CAMBIOS PARA LA TABLA MOVIES
--Quitamos el NOT NULL de movierelease porque hay muchos datos vacios
ALTER TABLE imdb_movies ALTER COLUMN movierelease DROP NOT NULL;

--CAMBIOS PARA LA TABLA ORDERDETAIL
CREATE TABLE sum_quantity(
  orderid integer NOT NULL,
  prod_id integer NOT NULL,
  price numeric, -- price without taxes when the order was paid
  quantity integer NOT NULL,
  CONSTRAINT sum_quantity_pkey PRIMARY KEY (orderid, prod_id),
  CONSTRAINT sum_quantity_orderid_fkey FOREIGN KEY (orderid) 
	REFERENCES public.orders (orderid) MATCH SIMPLE
	ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT sum_quantity_prod_id_fkey FOREIGN KEY (prod_id)
	REFERENCES public.products (prod_id) MATCH SIMPLE 
	ON UPDATE CASCADE ON DELETE NO ACTION
 );

INSERT INTO sum_quantity(orderid, prod_id, price, quantity) 
SELECT orderid, prod_id, price, sum(quantity) AS quantity_2 FROM orderdetail
GROUP BY orderid, prod_id, price;

DROP TABLE orderdetail;
ALTER TABLE sum_quantity RENAME TO orderdetail;

--CAMBIOS PARA LA TABLA ORDERS
--Falta la FK para customerid
ALTER TABLE orders ADD CONSTRAINT orders_customerid_fkey FOREIGN KEY (customerid)
	REFERENCES public.customers(customerid) MATCH SIMPLE
	ON UPDATE CASCADE ON DELETE CASCADE;
SELECT setval('orders_orderid_seq', (SELECT orderid FROM orders ORDER BY orderid DESC LIMIT 1)+1, FALSE);

--CAMBIOS PARA LA TABLA CUSTOMERS
--Eliminacion de duplicados en el username
--Quitamos el NULL de todos los campos que no utiliza nuestra web
ALTER TABLE customers ALTER address1 DROP NOT NULL;
ALTER TABLE customers ALTER firstname DROP NOT NULL;
ALTER TABLE customers ALTER lastname DROP NOT NULL;
ALTER TABLE customers ALTER city DROP NOT NULL;
ALTER TABLE customers ALTER country DROP NOT NULL;
ALTER TABLE customers ALTER region DROP NOT NULL;
ALTER TABLE customers ALTER creditcardtype DROP NOT NULL;
ALTER TABLE customers ALTER creditcardexpiration DROP NOT NULL;
ALTER TABLE customers ALTER income SET NOT NULL;
ALTER TABLE customers ALTER email SET NOT NULL;
ALTER TABLE customers ADD CONSTRAINT customers_unique_username UNIQUE(email);
--Cambio de las contraseñas a md5
UPDATE customers SET password=md5(password);
SELECT setval('customers_customerid_seq', (SELECT customerid FROM customers ORDER BY customerid DESC LIMIT 1)+1, FALSE);

--Creacion de tabla de alertas para el trigger de updInventory
CREATE TABLE alertas(
prod_id integer NOT NULL,
msg varchar NOT NULL,
CONSTRAINT alerta_pkey PRIMARY KEY (prod_id, msg)
);



