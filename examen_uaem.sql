-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2021 a las 04:53:53
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL primary key auto_increment,
  `passw` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ape_paterno` varchar(50) NOT NULL,
  `ape_materno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `passw`, `correo`, `nombre`, `ape_paterno`, `ape_materno`) VALUES
(1, '1234', 'asaed_colin@outlook.com', 'Uriel', 'Rojas', 'Colin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL primary key auto_increment,
  `nom_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nom_categoria`) VALUES
(1, 'MIXTOS'),
(2, 'MATEMATICAS'),
(3, 'COMPUTACION'),
(4, 'HISTORIA COMBINADA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario`
--

CREATE TABLE `cuestionario` (
  `id_cuestionario` int(11) NOT NULL primary key auto_increment,
  `nom_cuestionario` varchar(100) NOT NULL,
  `fec_elaboracion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuestionario`
--

INSERT INTO `cuestionario` (`id_cuestionario`, `nom_cuestionario`, `fec_elaboracion`, `id_categoria`) VALUES
(1, '1 Parcial 2021A Historia', '2021-04-22 03:32:46', 4),
(2, '1 Parcial Matematicas', '2021-04-22 03:32:46', 2),
(3, '1 Parcial Ciencias Computaciones', '2021-04-22 03:33:54', 3),
(4, '1 Parcial Computacion historia', '2021-04-22 03:33:54', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuest_pregunta`
--

CREATE TABLE `cuest_pregunta` (
  `id_cuest_pregunta` int(11) NOT NULL primary key auto_increment,
  `id_cuestionario` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuest_pregunta`
--

INSERT INTO `cuest_pregunta` (`id_cuest_pregunta`, `id_cuestionario`, `id_pregunta`) VALUES
(1, 1, 19),
(2, 1, 20),
(3, 1, 16),
(4, 1, 17),
(5, 1, 18),
(6, 2, 1),
(7, 2, 6),
(8, 2, 8),
(9, 2, 3),
(10, 2, 2),
(11, 4, 10),
(12, 4, 19),
(13, 4, 12),
(14, 4, 16),
(15, 4, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insertar_persona_cuestionario`
--

CREATE TABLE `insertar_persona_cuestionario` (
  `id_ins_per_cuest` int(11) NOT NULL primary key auto_increment,
  `id_persona` int(11) NOT NULL,
  `id_cuestionario` int(11) NOT NULL,
  `fec_inscrip` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cal_cuestionario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `insertar_persona_cuestionario`
--

INSERT INTO `insertar_persona_cuestionario` (`id_ins_per_cuest`, `id_persona`, `id_cuestionario`, `fec_inscrip`, `cal_cuestionario`) VALUES
(1, 1, 1, '2021-04-22 03:44:47', 8),
(2, 2, 1, '2021-04-22 03:44:47', 10),
(3, 3, 1, '2021-04-22 03:45:21', 6),
(4, 6, 1, '2021-04-22 03:45:21', 10),
(5, 4, 2, '2021-04-22 03:46:24', 10),
(6, 1, 2, '2021-04-22 03:46:24', 8),
(7, 2, 2, '2021-04-22 03:46:57', 6),
(8, 3, 2, '2021-04-22 03:46:57', 4),
(9, 5, 2, '2021-04-22 03:47:43', 8),
(10, 1, 4, '2021-04-22 03:47:43', 10),
(11, 2, 4, '2021-04-22 03:48:00', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL primary key auto_increment,
  `nom_persona` varchar(50) NOT NULL,
  `app_persona` varchar(50) NOT NULL,
  `apm_persona` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `passw` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nom_persona`, `app_persona`, `apm_persona`, `correo`, `passw`) VALUES
(1, 'Uriel Asaed', 'Rojas', 'Colin', 'asaed_colin@outlook.com', '1234'),
(2, 'Vania Andrea', 'Ruiz', 'Bautista', 'vania_ruiz@poutlook.com', '1234'),
(3, 'Miguel', 'Samano', 'Sanchez', 'miguel_sam@outlook.com', '1234'),
(4, 'Luis ', 'Alvarez', 'Prez', 'luis_alva@outlook.com', '124'),
(5, 'Angel', 'Martinez', 'Cruz', 'angel_all@outlook.com', '12345'),
(6, 'Mario Alberto', 'Ibarra', 'Rojas', 'mario_12@outlook.com', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL primary key auto_increment,
  `pregunta` varchar(1000) NOT NULL,
  `respA` varchar(1000) NOT NULL,
  `respB` varchar(1000) NOT NULL,
  `respC` varchar(1000) NOT NULL,
  `respD` varchar(1000) NOT NULL,
  `respE` varchar(1000) NOT NULL,
  `respCorrecta` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `pregunta`, `respA`, `respB`, `respC`, `respD`, `respE`, `respCorrecta`) VALUES
(1, 'Adivina cuántos años tengo sabiendo que la tercera parte de ellos menos 1 es igual a la sexta parte', '6', '9', '5', '4', '3', 'A'),
(2, '¿A cuánto equivale pi?\r\n', '3.141890', '3.141592', '3.141790', '3.156789', '3.178976', 'B'),
(3, 'Juan tiene 20 años menos que su padre y este tiene el triple de los años de su hijo. ¿Qué edad tienen cada uno?\r\n', '15 Juan, 35 el padre', '20 Juan, 40 el Padre', '30 Juan, 60 el padre', '10 Juan, 30 el Padre', '9 Juan, 29 el padre', 'D'),
(4, 'En una panadería con 80 kg son capaces de hacer 120 kg de pan. ¿Cuántos kg de harina serán necesarios para hacer 99 kg de pan?', 'Si quieres hacer 99 panes necesitas 66 kg de harina', 'Si quieres hacer 99 panes necesitas 70 kg de harina', 'Si quieres hacer 99 panes necesitas 65 kg de harina', 'Si quieres hacer 99 panes necesitas 56 kg de harina', 'Si quieres hacer 99 panes necesitas 76 kg de harina', 'A'),
(5, '¿Cuánto es la cuarta parte de la tercera parte?', '1/11', '3/4', 'Un Doceavo', '4/6', '12/12', 'C'),
(6, 'Seis obreros enlosan 1200 metros cuadrados de suelo en cuatro días. ¿Cuántos metros cuadrados enlosarán doce obreros en cinco días?\r\n', 'Si trabajan 12 obreros, dias haran 3500 metros cuadrados', 'Si trabajan 12 obreros, dias haran 4000 metros cuadrados', 'Si trabajan 12 obreros, dias haran 3800 metros cuadrados', 'Si trabajan 12 obreros, dias haran 3090 metros cuadrados', 'Si trabajan 12 obreros, dias haran 3000 metros cuadrados', 'E'),
(7, 'Si 8 litros de aceite valen 60 euros. ¿Cuántos litros compraré con 15 euros?', 'Con 15 euros comprare 2 litros de aceite', 'Con 15 euros comprare 2.5 litros de aceite', 'Con 15 euros comprare 1.5 litros de aceite', 'Con 15 euros comprare 3 litros de aceite', 'Con 15 euros comprare 1 litro de aceite', 'A'),
(8, '¿Cuánto habrá que rebajar un producto para que valga lo mismo que valía antes de que incrementase un 25% su precio?\r\n', 'Un 25%', 'Un 19%', 'Un 20%', 'Un 18%', 'Un 30%', 'C'),
(9, 'El monstruo del lago Ness mide 80 metros más la mitad de lo que mide, ¿cuánto mide el monstruo del lago Ness?\r\n', '200', '190', '170', '180', '160', 'E'),
(10, '1. ¿Que es la computación?', 'Es el estudio de los fundamentos teóricos de la información que procesan las computadoras, y las distintas implementaciones en forma de sistemas comp. ', 'Es un vocablo inspirado en el francés “informatique” que se encarga de procesar la Información. ', '\r\nEs aquella que tiene relación con el tratamiento de la Información y sus usos; es más cercana a las Personas y Computadoras\r\n', 'Es el estudio de las Computadoras creadas por Bill Gates en los 80', 'La maquina', 'A'),
(11, '¿Que son los sistemas computacionales?', 'Proviene del Ingles \\\"Informatique\\\" y es la teoría básica de la Informática. ', 'Es la Teoría Básica de la Computacion ', 'Es un conjunto de elementos orientados al tratamiento y administración de datos e información, organizados y listos para su uso posterior ', 'Denota conteo y se refiere a la sección Harware de la computadora. ', '', 'C'),
(12, 'Cuál es la diferencia entre un bit y un Byte.', 'En que uno corresponde a la unidad mínima de Memoria y el otro es un conjunto de 6 a 8 bits ', 'La diferencia es de 1024 Mb de almacenamiento. ', 'La diferencia es que uno es de datos y otro es conjunto de datos. ', 'En que uno corresponde a la unidadmaxima de Memoria y el otro es un conjunto de 6 a 8 bytes ', 'En que uno corresponde a la unidadmaxima de Memoria y el otro es un conjunto de 6 a 16 bytes ', 'A'),
(13, 'Son nombres de lenguajes de programación orientado a objetos.', 'Actionscript, C++, .NET, Simula, PowerBuilder, Maya, entre otros. ', 'Actionscript, COBOL, C++, .NET, PHP, Simula, PowerBuilder, Maya, entre otros. ', 'HTML, XML, VML, Java, PHP, C++, Fortran, Cobol, Lisp, entre otros ', 'Visual Basic, Visual C++, Visual DialogScript, Visual Foxpro, Ensamblador, Borland c, Turbo C. entre otros', ' Java, C++, Smalltalk, Python, Object Pascal, Visual .net, Visual Basic, Delphi, Perl, entre otros. ', 'E'),
(14, 'Son los tipos de variables que se manejan en Programación.', 'De Actionscript, COBOL, C#, .NET, PHP, Simula, PowerBuilder, Maya, entre otros. ', 'Cadena, Boleano, Carácter, Numeros, Entero, Cadena, Boleano, Carácter, Numeros, Entero, entre otros. ', 'Tipo Java, C++, Smalltalk, Python, Object Pascal, Visual .net, Visual Basic, Delphi, Perl, entre otros.', 'String, Boolean, Char, Integer, int, Double, Float, etc', 'Actionscript, COBOL, C#, .NET,Integer, int, Double, Float, etc', 'D'),
(15, ' Que significa JDK.', 'Java Distance kilobye ', 'Java Development Kit ', 'Distrit Java Kit ', ' Kilobyte Java Development', 'Java Enterprise kit ', 'B'),
(16, 'El Renacimiento fue un movimiento cultural y artístico que se desarrolló en Europa a lo largo de varios siglos. En un sentido amplio, se considera que abarca…', 'Los últimos siglos de la Edad Media\r\n', 'Los primeros siglos de la Edad Moderna\r\n', 'Ambas son correctas', '', '', 'C'),
(17, 'El término Renacimiento fue acuñado por…', 'Leonardo da Vinci\r\n', 'Giorgio Vasari\r\n', 'William Shakespeare', 'Miguel Angel', 'Rafael', 'B'),
(18, 'Dicho artista procedía de la tierra que es la cuna del Renacimiento. Hablamos de…', 'Alemania', 'Francia\r\n', 'Grecia\r\n', 'Italia', 'España', 'D'),
(19, 'La arquitectura renacentista afrontó grandes desafíos como la construcción de la cúpula más grande del mundo, en la catedral de…', 'San Pedro', 'Vaticano', 'Venecia\r\n', 'Florencia\r\n', 'Constantinopla', 'D'),
(20, 'La ciudad de Florencia fue la gran urbe del Renacimiento. En ella se crearon algunas de las mayores maravillas de la historia del arte, como el David de...\r\n\r\n    ', 'Miguel Ángel\r\n    ', 'Leonardo\r\n    ', 'Donatello', 'Rafael', 'Tizano', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id` int(11) NOT NULL primary key auto_increment,
  `pass` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ape_paterno` varchar(50) NOT NULL,
  `ape_materno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_per_cuest`
--

CREATE TABLE `respuestas_per_cuest` (
  `id_respu_per_cuest` int(11) NOT NULL primary key auto_increment,
  `id_ins_per_cuest` int(11) NOT NULL,
  `id_cuest_pregunta` int(11) NOT NULL,
  `respuesta` varchar(10) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `respuestas_per_cuest`
--

INSERT INTO `respuestas_per_cuest` (`id_respu_per_cuest`, `id_ins_per_cuest`, `id_cuest_pregunta`, `respuesta`, `valor`) VALUES
(1, 1, 1, 'A', 0),
(2, 1, 2, 'A', 2),
(3, 1, 3, 'B', 2),
(4, 1, 4, 'B', 2),
(5, 1, 5, 'D', 2),
(6, 2, 1, 'D', 2),
(7, 2, 2, 'A', 2),
(8, 2, 3, 'C', 2),
(9, 2, 4, 'B', 2),
(10, 2, 5, 'D', 2),
(11, 3, 1, 'D', 2),
(12, 3, 2, 'A', 2),
(13, 3, 3, 'C', 2),
(14, 3, 4, 'A', 0),
(15, 3, 5, 'A', 0),
(16, 4, 1, 'D', 2),
(17, 4, 2, 'A', 2),
(18, 4, 3, 'C', 2),
(19, 4, 4, 'B', 2),
(20, 4, 5, 'D', 2),
(21, 5, 6, 'A', 2),
(22, 5, 7, 'E', 2),
(23, 5, 8, 'C', 2),
(24, 5, 9, 'D', 2),
(25, 5, 10, 'B', 2),
(26, 6, 6, 'B', 0),
(27, 6, 7, 'E', 2),
(28, 6, 8, 'C', 2),
(29, 6, 9, 'D', 0),
(30, 6, 10, 'B', 2),
(31, 7, 6, 'A', 2),
(32, 7, 7, 'A', 0),
(33, 7, 8, 'C', 2),
(34, 7, 9, 'D', 0),
(35, 7, 10, 'A', 0),
(36, 8, 6, 'C', 0),
(37, 8, 7, 'E', 2),
(38, 8, 8, 'C', 2),
(39, 8, 9, 'B', 0),
(40, 8, 10, 'E', 0),
(41, 9, 6, 'A', 2),
(42, 9, 7, 'E', 2),
(43, 9, 8, 'C', 2),
(44, 9, 9, 'A', 0),
(45, 9, 10, 'B', 2),
(46, 10, 11, 'A', 2),
(47, 10, 12, 'D', 2),
(48, 10, 13, 'A', 2),
(49, 10, 14, 'C', 2),
(50, 10, 15, 'D', 2),
(51, 11, 11, 'A', 2),
(52, 11, 12, 'D', 2),
(53, 11, 13, 'A', 2),
(54, 11, 14, 'C', 2),
(55, 11, 15, 'D', 2);

--
-- Índices para tablas volcadas
--



--
-- Indices de la tabla `cuest_pregunta`
--
ALTER TABLE `cuest_pregunta`
  ADD KEY `id_cuestionario` (`id_cuestionario`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `insertar_persona_cuestionario`
--
ALTER TABLE `insertar_persona_cuestionario`
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_cuestionario_insertar` (`id_cuestionario`);



--
-- Indices de la tabla `respuestas_per_cuest`
--
ALTER TABLE `respuestas_per_cuest`
  ADD KEY `id_ins_per_cuest` (`id_ins_per_cuest`),
  ADD KEY `id_cuest_pregunta` (`id_cuest_pregunta`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  ADD CONSTRAINT `id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cuest_pregunta`
--
ALTER TABLE `cuest_pregunta`
  ADD CONSTRAINT `id_cuestionario` FOREIGN KEY (`id_cuestionario`) REFERENCES `cuestionario` (`id_cuestionario`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `insertar_persona_cuestionario`
--
ALTER TABLE `insertar_persona_cuestionario`
  ADD CONSTRAINT `id_cuestionario_insertar` FOREIGN KEY (`id_cuestionario`) REFERENCES `cuestionario` (`id_cuestionario`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `respuestas_per_cuest`
--
ALTER TABLE `respuestas_per_cuest`
  ADD CONSTRAINT `id_cuest_pregunta` FOREIGN KEY (`id_cuest_pregunta`) REFERENCES `cuest_pregunta` (`id_cuest_pregunta`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_ins_per_cuest` FOREIGN KEY (`id_ins_per_cuest`) REFERENCES `insertar_persona_cuestionario` (`id_ins_per_cuest`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
