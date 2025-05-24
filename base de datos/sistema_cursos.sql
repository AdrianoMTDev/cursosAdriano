-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2025 a las 21:45:01
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_cursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `cupo_maximo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`, `cupo_maximo`) VALUES
(1, 'Curso de PHP', 'Aprende PHP desde cero', '2025-06-01', '2025-06-30', 28),
(2, 'Diseño Gráfico Básico', 'Maneja herramientas como Canva y Photoshop', '2025-06-10', '2025-07-05', 23),
(3, 'Programación en Python', 'Curso práctico para jóvenes programadores', '2025-07-01', '2025-07-31', 38),
(4, 'Robótica para Principiantes', 'Introduce a los niños al mundo de la robótica', '2025-06-15', '2025-07-15', 19),
(5, 'Inglés Conversacional', 'Mejora tu fluidez y comprensión oral', '2025-06-20', '2025-07-20', 34),
(6, 'Creación de Videojuegos', 'Crea tus propios videojuegos con Unity', '2025-07-05', '2025-08-01', 20),
(7, 'Cocina Creativa', 'Aprende a preparar platos divertidos y saludables', '2025-06-10', '2025-06-28', 15),
(8, 'Matemáticas Divertidas', 'Refuerza tus habilidades matemáticas con juegos', '2025-07-01', '2025-07-26', 25),
(9, 'Arte y Pintura', 'Explora técnicas de dibujo y pintura artística', '2025-06-25', '2025-07-25', 30),
(10, 'Canto y Expresión Vocal', 'Taller de técnicas vocales y presentación', '2025-07-03', '2025-07-29', 20),
(11, 'Baile Moderno', 'Taller de baile urbano y coreografías', '2025-06-17', '2025-07-10', 30),
(12, 'Creación de Contenido', 'Curso para jóvenes que quieren ser youtubers', '2025-07-08', '2025-08-02', 19),
(13, 'Educación Financiera Juvenil', 'Aprende a manejar tu dinero desde joven', '2025-06-20', '2025-07-15', 24),
(14, 'Técnicas de Estudio', 'Estrategias para mejorar el rendimiento académico', '2025-07-01', '2025-07-20', 30),
(15, 'Manualidades Recicladas', 'Crea arte y objetos útiles con materiales reciclados', '2025-06-22', '2025-07-12', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id_inscripcion` int(11) NOT NULL,
  `id_inscrito` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id_inscripcion`, `id_inscrito`, `id_curso`, `fecha_inscripcion`) VALUES
(10, 5, 1, '2025-05-23 19:42:43'),
(11, 5, 2, '2025-05-23 19:42:45'),
(12, 5, 3, '2025-05-23 19:42:48'),
(13, 5, 4, '2025-05-23 19:42:51'),
(14, 5, 5, '2025-05-23 19:43:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscritos`
--

CREATE TABLE `inscritos` (
  `id_inscrito` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('Masculino','Femenino','Otro') DEFAULT 'Otro',
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscritos`
--

INSERT INTO `inscritos` (`id_inscrito`, `nombre`, `correo`, `contrasena`, `telefono`, `direccion`, `ciudad`, `pais`, `fecha_nacimiento`, `genero`, `rol`, `fecha_registro`) VALUES
(4, 'Administrador General', 'admin@cursos.com', '$argon2id$v=19$m=65536,t=4,p=1$SkRvaVBOd3BkaTlwNGtnbg$xIXpGhSWcWfnlc+wIg0UMT0so4xUHUgddHrFBUzir6c', '0999999999', 'Oficina Central', 'Quito', 'Ecuador', '1985-01-01', 'Masculino', 'admin', '2025-05-23 19:12:35'),
(5, 'MARICELA DOMINGUEZ LOURDES ROJAS', 'maricela@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$R0VQR3Zjb0E5Mk5qQjlZVQ$clNJa4gf0j2rC3iuHjYRTsWbS/xw5eUmeMFaYSGwZcQ', '0991583838', 'SANGOLQUI', 'QUITO', 'Ecuador', '2000-12-12', 'Femenino', 'usuario', '2025-05-23 19:42:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_inscrito` (`id_inscrito`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD PRIMARY KEY (`id_inscrito`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  MODIFY `id_inscrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`id_inscrito`) REFERENCES `inscritos` (`id_inscrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
