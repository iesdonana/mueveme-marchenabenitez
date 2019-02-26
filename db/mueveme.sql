------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id           BIGSERIAL    PRIMARY KEY
  , nombre       VARCHAR(32)  NOT NULL UNIQUE
  , password     VARCHAR(60)  NOT NULL
  , created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
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
    id            BIGSERIAL PRIMARY KEY
  , comentario    TEXT      NOT NULL
  , usuario_id    BIGINT    NOT NULL REFERENCES usuarios(id)
  , noticia_id    BIGINT    NOT NULL REFERENCES noticias(id)
  , comentario_id BIGINT    REFERENCES comentarios(id)
  , created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS votos CASCADE;

CREATE TABLE votos
(
    usuario_id    BIGINT REFERENCES usuarios(id)
  , comentario_id BIGINT REFERENCES comentarios(id)
  , voto          BOOL   NOT NULL
  , PRIMARY KEY(usuario_id, comentario_id)
);

DROP TABLE IF EXISTS movimientos CASCADE;

CREATE TABLE movimientos
(
    usuario_id BIGINT REFERENCES usuarios(id)
  , noticia_id BIGINT REFERENCES noticias(id)
  , PRIMARY KEY(usuario_id, noticia_id)
);

----- INSERT-----

INSERT INTO usuarios (nombre, password)
VALUES ('benitez', crypt('benitez', gen_salt('bf', 10)))
     , ('marchena', crypt('marchena', gen_salt('bf', 10)))
     , ('pepe', crypt('pepe', gen_salt('bf', 10)))
     , ('juan', crypt('juan', gen_salt('bf', 10)));

INSERT INTO categorias (categoria)
VALUES ('Ciencia')
     , ('Deportes')
     , ('Política')
     , ('Cultura')
     , ('Tecnología')
     , ('Actualidad');

INSERT INTO noticias (titulo, noticia, link, usuario_id, categoria_id)
VALUES ('El Ayuntamiento de Madrid dejará de estar intervenido por Hacienda', 'El ejecutivo madrileño cierra 2018 cumpliendo con la regla de gasto, así que por primera vez en siete años deja de estar subordinado a un Plan Económico Financiero (PEF). El Ayuntamiento de Madrid ha estado sometido a un PEF, al que tiene que dar el visto bueno Hacienda, desde 2011,después de que en 2010 cerrara con un déficit de 754 millones de euros. Este año el ejecutivo madrileño cierra 2018 cumpliendo la regla de gasto, reduciendo deuda y con más de 1.000 millones de superávit. Cumple, así, los objetivos recogidos en el Plan Económico Fina', 'https://cadenaser.com/emisora/2019/01/31/radio_madrid/1548955669_690556.html', 1, 6)
     , ('El 90% de los teléfonos en España son Android', 'La agencia Kantar ha publicado los datos de cuota de mercado referentes al último trimestre de 2018 en los que se pone de manifiesto, una vez más, que Android es el aplastante ganador dentro del mundo de la telefonía móvil tanto a nivel europeo como español.', 'https://eloutput.com/noticias/moviles/telefonos-android-espana-cuota-2018/', 2, 5)
     , ('Científicos rusos logran resucitar a dos gusanos que llevaban miles de años congelados', 'Dos antiguos nematodos se mueven y comen de nuevo por primera vez desde la era del Pleistoceno en un descubrimiento científico calificado de sorprendente por los expertos. Los nematodos, procedentes de dos zonas diferentes de Siberia, volvieron a la vida en placas de Petri, según afirma un reciente estudio científico.', 'https://www.ancient-origins.es/noticias-ciencia-espacio/cient%C3%ADficos-rusos-logran-resucitar-dos-gusanos-que-llevaban-miles-a%C3%B1os-congelados-004840', 3, 1)
     , ('Así es la cárcel de Ushuaia, la prisión del fin del mundo', 'Hubo un tiempo en que en Argentina se enviaba a los delincuentes más peligrosos a cumplir condena al fin del mundo. De la cárcel de Ushuaia, la ciudad más austral del planeta, muchos lograban escapar, pero el frío y el aislamiento hacían de esa breve libertad la mayor de las prisiones.', 'https://www.20minutos.es/noticia/3548401/0/carcel-ushuaia-fin-del-mundo/', 4, 4);

INSERT INTO comentarios (comentario, usuario_id, noticia_id, comentario_id)
VALUES ('Los Iphones son mejores', 3, 2, null)
     , ('No entiendes de moviles', 4, 2, 1)
     , ('bla', 3, 2, 2)
     , ('blabla', 2, 2, null)
     , ('blablabla', 3, 2, 4)
     , ('Estos rusos hacen lo imposible', 2, 3, null)
     , ('Y los chinos', 1, 3, 6)
     , ('Claro que si', 3, 2, 1)
     , ('Claro que no', 2, 2, 8);

INSERT INTO votos (usuario_id, comentario_id, voto)
VALUES (4, 1, false)
     , (1, 3, true)
     , (2, 4, true)
     , (3, 2, false);

INSERT INTO movimientos (usuario_id, noticia_id)
VALUES (1, 3)
     , (2, 1)
     , (3, 4)
     , (4, 2);
