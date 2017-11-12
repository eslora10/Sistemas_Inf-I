DROP TABLE IF EXISTS countries;
DROP SEQUENCE IF EXISTS countryid_seq;
CREATE SEQUENCE countryid_seq;
CREATE TABLE countries (
countryid integer NOT NULL DEFAULT nextval('countryid_seq'::regclass),
countryname character varying(32) NOT NULL,
CONSTRAINT country_pkey PRIMARY KEY (COUNTRYID)
);
INSERT INTO countries(countryname) SELECT DISTINCT country FROM imdb_moviecountries;

DROP TABLE IF EXISTS genres;
DROP SEQUENCE IF EXISTS genreid_seq;
CREATE SEQUENCE genreid_seq;
CREATE TABLE genres (
genreid integer NOT NULL DEFAULT nextval('genreid_seq'::regclass),
genrename character varying(32) NOT NULL,
CONSTRAINT genre_pkey PRIMARY KEY (genreid)
);
INSERT INTO genres(genrename) SELECT DISTINCT genre FROM imdb_moviegenres;

DROP TABLE IF EXISTS languages;
DROP SEQUENCE IF EXISTS languageid_seq;
CREATE SEQUENCE languageid_seq;
CREATE TABLE languages (
languageid integer NOT NULL DEFAULT nextval('languageid_seq'::regclass),
languagename character varying(32) NOT NULL,
CONSTRAINT language_pkey PRIMARY KEY (languageid)
);
INSERT INTO languages(languagename) SELECT DISTINCT language FROM imdb_movielanguages;

ALTER TABLE imdb_actormovies DROP CONSTRAINT imdb_actormovies_pkey;
ALTER TABLE imdb_actormovies ADD CONSTRAINT imdb_actormovies_pkey PRIMARY KEY (actorid, movieid);
ALTER TABLE imdb_actormovies ADD CONSTRAINT imdb_actormovies_movieid_fkey FOREIGN KEY (movieid)
      REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_actormovies ADD CONSTRAINT imdb_actormovies_actorid_fkey FOREIGN KEY (actorid)
      REFERENCES public.imdb_actors (actorid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;

CREATE TABLE aux (
movieid integer NOT NULL,
countryid integer NOT NULL
);
INSERT INTO aux(movieid, countryid) SELECT movieid, countryid FROM countries, imdb_moviecountries 
WHERE countryname=country;
DROP TABLE imdb_moviecountries;
ALTER TABLE aux RENAME TO imdb_moviecountries;
ALTER TABLE imDdb_moviecountries ADD CONSTRAINT imdb_moviecountries_pkey PRIMARY KEY (movieid, countryid);
ALTER TABLE imdb_moviecountries ADD CONSTRAINT imdb_moviecountries_movieid_fkey FOREIGN KEY (movieid)
      REFERENCES public.imdb_movies (movieid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE imdb_moviecountries ADD CONSTRAINT imdb_moviecountries_countryid_fkey FOREIGN KEY (countryid)
      REFERENCES public.countries (countryid) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION;

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

