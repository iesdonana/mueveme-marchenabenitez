------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       BIGSERIAL   PRIMARY KEY
  , nombre   VARCHAR(32) NOT NULL UNIQUE
  , password VARCHAR(60) NOT NULL
)
