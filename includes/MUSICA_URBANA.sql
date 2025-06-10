-- Crear la base de datos
DROP DATABASE IF EXISTS MUSICA_URBANA;
CREATE DATABASE MUSICA_URBANA;
USE MUSICA_URBANA;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS USUARIOS (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NOMBRE_USUARIO VARCHAR(50) NOT NULL,
    CONTRASENA VARCHAR(255) NOT NULL,
    ROL ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario',
    EMAIL VARCHAR(100) NOT NULL,
    FECHA_REGISTRO TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Artistas
CREATE TABLE IF NOT EXISTS ARTISTA (
    CODARTISTA INT PRIMARY KEY AUTO_INCREMENT,
    NOMBRE VARCHAR(255) NOT NULL,
    BIOGRAFIA TEXT,
    FECHA_NACIMIENTO VARCHAR(255),
    PAIS_ORIGEN VARCHAR(100),
    IMAGEN varchar(255)
);

-- Tabla de Álbumes
CREATE TABLE IF NOT EXISTS ALBUM (
    CODALBUM INT PRIMARY KEY AUTO_INCREMENT,
    NOMBRE VARCHAR(255) NOT NULL,
    FECHA_LANZAMIENTO DATE,
    CODARTISTA INT,
    CARATULA VARCHAR(255),
    FOREIGN KEY (CODARTISTA) REFERENCES ARTISTA(CODARTISTA)
);

-- Tabla de Canciones
CREATE TABLE IF NOT EXISTS CANCION (
    CODCANCION INT PRIMARY KEY AUTO_INCREMENT,
    NOMBRE VARCHAR(255) NOT NULL,
    DURACION TIME,
    AUDIO VARCHAR(255),
    CODALBUM INT,
    IMAGEN VARCHAR(255),
    FOREIGN KEY (CODALBUM) REFERENCES ALBUM(CODALBUM)
);

-- Tabla de Comentarios
CREATE TABLE IF NOT EXISTS COMENTARIOS (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_USUARIO INT NOT NULL,
    ID_ALBUM INT NOT NULL,
    COMENTARIO TEXT NOT NULL,
    FECHA_COMENTARIO TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS(ID),
    FOREIGN KEY (ID_ALBUM) REFERENCES ALBUM(CODALBUM)
);

ALTER TABLE COMENTARIOS ADD COLUMN LIKES INT DEFAULT 0;
ALTER TABLE COMENTARIOS ADD COLUMN DISLIKES INT DEFAULT 0;

SET SQL_SAFE_UPDATES = 0;

-- Insertar artista
INSERT INTO ARTISTA (CODARTISTA, NOMBRE, BIOGRAFIA, FECHA_NACIMIENTO, PAIS_ORIGEN) VALUES
(1, 'Bad Bunny', 'Benito Antonio Martínez Ocasio, conocido como Bad Bunny, es un cantante, compositor y productor puertorriqueño de reguetón y trap latino. Nació el 10 de marzo de 1994 en Vega Baja, Puerto Rico. Saltó a la fama en 2016 con su sencillo "Soy Peor" y desde entonces ha dominado la escena musical con álbumes como "X 100pre", "YHLQMDLG" y "Un Verano Sin Ti", este último ganador de un Grammy. Es conocido por su estilo único, fusionando reguetón con otros géneros como rock, salsa y música electrónica.', '1994-03-10', 'Puerto Rico'),
(2, 'Anuel AA', 'Emmanuel Gazmey Santiago, conocido como Anuel AA, es un cantante y compositor puertorriqueño de reguetón y trap latino. Nació el 27 de noviembre de 1992 en Carolina, Puerto Rico. Comenzó su carrera en 2010, pero alcanzó la fama internacional en 2016 con su álbum "Real Hasta la Muerte". Es reconocido por su estilo crudo y letras explícitas, así como por colaboraciones con artistas como Karol G, Ozuna y Daddy Yankee.', '1992-11-27', 'Puerto Rico'),
(3, 'Duki', 'Mauro Ezequiel Lombardo Quiroga, conocido como Duki, es un cantante y compositor argentino de trap y rap. Nació el 24 de junio de 1996 en Almagro, Buenos Aires. Saltó a la fama en 2016 tras ganar una competencia de freestyle llamada "El Quinto Escalón". Es uno de los pioneros del trap en Argentina y ha lanzado éxitos como "She Don’t Give a FO", "Goteo" y "Hablamos Mañana".', '1996-06-24', 'Argentina'),
(4, 'Eladio Carrión', 'Eladio Carrión es un cantante y compositor puertorriqueño de trap y reguetón. Nació el 14 de noviembre de 1994 en Kansas, Estados Unidos, pero creció en Puerto Rico. Es conocido por su habilidad lírica y su estilo único que combina trap con reguetón. Ha lanzado álbumes como "Sauce Boyz" y "SEN2 KBRN", y colaborado con artistas como Bad Bunny, J Balvin y Myke Towers.', '1994-11-14', 'Puerto Rico'),
(5, 'Raúl Clyde', 'Raúl Pérez Marqués, conocido artísticamente como Raúl Clyde, es un cantante y compositor español de reguetón. Nació el 1 de enero de 1997 en Valencia, España. Es uno de los representantes más destacados del reguetón en España, conocido por temas como "La Botella" y "Bailando". Su estilo fusiona reguetón con influencias del pop y el R&B.', '1997-01-01', 'España'),
(6, 'Mora', 'Mora es un cantante y compositor puertorriqueño de reguetón y trap. Nació el 10 de febrero de 1995 en San Juan, Puerto Rico. Es conocido por su habilidad para producir y componer, trabajando con artistas como Bad Bunny, J Balvin y Sech. Ha lanzado álbumes como "Primer Día de Clases" y "Microdosis".', '1995-02-10', 'Puerto Rico'),
(7, 'Quevedo', 'Pedro Luis Domínguez Quevedo, conocido como Quevedo, es un cantante y compositor español de reguetón y trap. Nació el 7 de diciembre de 2001 en Las Palmas de Gran Canaria, España. Saltó a la fama en 2021 con su colaboración "Cayó la Noche" y ha ganado reconocimiento internacional por su estilo fresco y letras introspectivas.', '2001-12-07', 'España'),
(8, 'Tainy', 'Marco Masís, conocido como Tainy, es un productor y compositor puertorriqueño de reguetón y trap. Nació el 9 de agosto de 1989 en San Juan, Puerto Rico. Es uno de los productores más influyentes del género, habiendo trabajado con artistas como Bad Bunny, J Balvin y Ozuna. Es conocido por su álbum debut "NEON16 Tapes: The Kids That Grew Up on Reggaeton".', '1989-08-09', 'Puerto Rico'),
(9, 'Saiko', 'Miguel Cantos Gómez, conocido como Saiko, es un cantante y compositor español de rap y trap. Nació el 18 de marzo de 2001 en Granada, España. Es uno de los artistas más jóvenes y prometedores del trap español, conocido por temas como "Antes de Morirme" y "Cicatrices".', '2001-03-18', 'España'),
(10, 'Rauw Alejandro', 'Raúl Alejandro Ocasio Ruiz, conocido como Rauw Alejandro, es un cantante y compositor puertorriqueño de reguetón y R&B. Nació el 10 de enero de 1993 en San Juan, Puerto Rico. Es conocido por su estilo innovador y álbumes como "Afrodisíaco" y "Vice Versa". Ha colaborado con artistas como Rosalía, Anuel AA y J Balvin.', '1993-01-10', 'Puerto Rico'),
(11, 'Jhayco', 'Jesús Manuel Nieves Cortés, conocido como Jhayco o Jhay Cortez, es un cantante, compositor y productor puertorriqueño de reguetón y trap latino. Nació el 9 de abril de 1993 en Río Piedras, Puerto Rico. Comenzó su carrera como compositor a los 15 años y ha trabajado con artistas como Bad Bunny, J Balvin y Karol G. Es conocido por álbumes como "Famouz" y "Timelezz", y por éxitos como "No Me Conoce" y "Dákiti".', '1993-04-09', 'Puerto Rico'),
(12, 'Ozuna', 'Juan Carlos Ozuna Rosado, conocido como Ozuna, es un cantante y compositor puertorriqueño de reguetón y trap. Nació el 13 de marzo de 1992 en San Juan, Puerto Rico. Es uno de los artistas más influyentes del género, con álbumes como "Odisea" y "Nibiru". Ha colaborado con artistas como Daddy Yankee, Cardi B y Romeo Santos.', '1992-03-13', 'Puerto Rico'),
(13, 'J Balvin', 'José Álvaro Osorio Balvín, conocido como J Balvin, es un cantante y compositor colombiano de reguetón y pop. Nació el 7 de mayo de 1985 en Medellín, Colombia. Es uno de los artistas más reconocidos a nivel mundial, con éxitos como "Mi Gente", "Ginza" y "Rojo". Ha ganado múltiples premios, incluyendo varios Latin Grammy.', '1985-05-07', 'Colombia'),
(14, 'Karol G', 'Carolina Giraldo Navarro, conocida como Karol G, es una cantante y compositora colombiana de reguetón y pop. Nació el 14 de febrero de 1991 en Medellín, Colombia. Es una de las artistas femeninas más influyentes del género, con álbumes como "Ocean" y "KG0516". Ha colaborado con artistas como Nicki Minaj, Anuel AA y J Balvin.', '1991-02-14', 'Colombia'),
(15, 'Feid', 'Salomón Villada Hoyos, conocido como Feid, es un cantante y compositor colombiano de reguetón y música urbana. Nació el 19 de agosto de 1992 en Medellín, Colombia. Es conocido por su estilo único y álbumes como "19" y "FERXXO (VOL 1: M.O.R)". Ha trabajado con artistas como J Balvin, Maluma y Sech.', '1992-08-19', 'Colombia');

-- Insertar álbumes
INSERT INTO ALBUM (CODALBUM, NOMBRE, FECHA_LANZAMIENTO, CODARTISTA, CARATULA) VALUES
(1, 'Real Hasta La Muerte', '2018-07-17', 2, '/assets/img/album/real_hasta_la_muerte.jpg'),
(2, 'Ferxxocalipsis', '2021-10-29', 15, '/assets/img/album/ferxxocalipsis.jpg'),
(4, 'X 100PRE', '2018-12-24', 1, '/assets/img/album/x_100pre.jpg'),
(5, 'YHLQMDLG', '2020-02-29', 1, '/assets/img/album/yhlqmdlg.jpg'),
(6, 'EL ÚLTIMO TOUR DEL MUNDO', '2020-11-27', 1, '/assets/img/album/el_ultimo_tour_del_mundo.jpg'),
(7, 'Un Verano Sin Ti', '2022-05-06', 1, '/assets/img/album/un_verano_sin_ti.jpg'),
(8, 'Nadie sabe lo que va a pasar mañana', '2023-10-13', 1, '/assets/img/album/nadie_sabe_lo_que_va_a_pasar_manana.jpg'),
(9, 'DeBÍ TiRAR MáS FOToS', '2025-01-05', 1, '/assets/img/album/debi_tirar_mas_fotos.jpg'),
(10, 'Emmanuel', '2020-05-29', 2, '/assets/img/album/emmanuel.jpg'),
(11, 'Las Leyendas Nunca Mueren', '2021-11-05', 2, '/assets/img/album/las_leyendas_nunca_mueren.jpg'),
(12, 'Los Dioses', '2021-01-22', 2, '/assets/img/album/los_dioses.jpg'),
(13, 'LLNM2', '2022-11-18', 2, '/assets/img/album/llnm2.jpg'),
(14, 'Destino 2014', '2024-12-15', 5, '/assets/img/album/destino_2014.jpg'),
(15, 'Buenas Noches', '2024-11-22', 7, '/assets/img/album/buenas_noches.jpg'),
(16, 'Le Clique: Vida Rockstar (X)', '2024-09-06', 11, '/assets/img/album/le_clique_vida_rockstar_x.jpg'),
(17, 'Mañana Será Bonito', '2023-02-24', 14, '/assets/img/album/manana_sera_bonito.jpg'),
(18, '3MEN2 KBRN', '2023-03-10', 4, '/assets/img/album/3men2_kbrn.jpg'),
(20, 'Microdosis', '2023-07-14', 6, '/assets/img/album/microdosis.jpg'),
(21, 'Ozutochi', '2023-08-11', 12, '/assets/img/album/ozutochi.jpg'),
(22, 'Saturno', '2023-09-15', 10, '/assets/img/album/saturno.jpg'),
(28, 'Feliz Cumpleaños Ferxxo', '2023-03-17', 15, '/assets/img/album/feliz_cumpleanos_ferxxo.jpg'),
(29, 'Sakura', '2024-01-12', 9, '/assets/img/album/sakura.jpg'),
(30, 'Saliendo del Planeta', '2024-01-12', 9, '/assets/img/album/saliendo_del_planeta.jpg');
