------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       BIGSERIAL   PRIMARY KEY
  , nombre   VARCHAR(32) NOT NULL UNIQUE
  , password VARCHAR(60) NOT NULL
);

DROP TABLE IF EXISTS categorias CASCADE;

CREATE TABLE categorias
(
    id        BIGSERIAL    PRIMARY KEY
  , categoria VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS noticias CASCADE;

CREATE TABLE noticias
(
    id           BIGSERIAL    PRIMARY KEY
  , titulo       VARCHAR(255) NOT NULL
  , noticia      TEXT         NOT NULL
  , link         VARCHAR(255) NOT NULL UNIQUE
  , usuario_id   BIGINT       NOT NULL REFERENCES usuarios(id)
  , categoria_id BIGINT       NOT NULL REFERENCES categorias(id)
  , created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
    id         BIGSERIAL PRIMARY KEY
  , comentario TEXT      NOT NULL
  , usuario_id BIGINT    NOT NULL REFERENCES usuarios(id)
  , noticia_id BIGINT    NOT NULL REFERENCES noticias(id)
  , created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS votos CASCADE;

CREATE TABLE votos
(
    usuario_id    BIGINT REFERENCES usuarios(id)
  , comentario_id BIGINT REFERENCES comentarios(id)
  , voto      BOOL   NOT NULL
  , PRIMARY KEY(usuario_id, comentario_id)
);

DROP TABLE IF EXISTS movimientos CASCADE;

CREATE TABLE movimientos
(
    usuario_id BIGINT REFERENCES usuarios(id)
  , noticia_id BIGINT REFERENCES noticias(id)
  , PRIMARY KEY(usuario_id, noticia_id)
);
