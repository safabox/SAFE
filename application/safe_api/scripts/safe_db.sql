-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-07-2016 a las 20:50:17
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


set global innodb_file_format = BARRACUDA;
set global innodb_large_prefix = ON;
-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-07-2016 a las 16:56:34
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safe_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legajo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `nombre`, `apellidos`, `legajo`) VALUES
(1, 'Alumno 1', 'Apellido 1', '123412'),
(2, 'Alumno 2', 'Apellido 2', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `fechaCreacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `docente_id`, `nombre`, `descripcion`, `fechaCreacion`) VALUES
(1, 1, 'Matemáticas', 'Esto es una clase de matemáticas', '2016-06-09 00:00:00'),
(2, 2, 'Biología', 'Clase de biología', '2016-06-09 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_alumno`
--

CREATE TABLE `curso_alumno` (
  `curso_id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_alumno`
--

INSERT INTO `curso_alumno` (`curso_id`, `alumno_id`) VALUES
(1, 1),
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `curriculum` text,
  `apellido` varchar(100) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `nombre`, `curriculum`, `apellido`, `fechaModificacion`) VALUES
(1, 'Docente 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sit amet volutpat elit. Morbi ultricies diam sit amet felis varius sodales. Aliquam non nunc commodo dui mollis fermentum quis eget nibh. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus', '', NULL),
(2, 'Docente 2', 'Morbi bibendum tellus tempus, iaculis ligula non, ultrices lorem. Curabitur eu velit non lorem condimentum posuere vitae vestibulum nibh. Praesent eu laoreet massa, non cursus sapien. Mauris lorem ligula, consequat ac augue et, sodales mollis orci. Nunc consectetur blandit augue sollicitudin posuere', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id`, `curso_id`, `titulo`, `descripcion`, `orden`) VALUES
(1, 1, 'Suma y resta', 'Aprender a sumar y restar', 1),
(2, 1, 'Multiplicación', 'Aprender a multiplicar', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema_dependencia`
--

CREATE TABLE `tema_dependencia` (
  `tema_source` int(11) NOT NULL,
  `tema_target` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `nombre`, `apellido`, `avatar`) VALUES
(8, 'admin', 'admin', 'admin@safe.com', 'admin@safe.com', 1, '6lsk4s3xzukgos4wc8kkooc4g0gg0kw', 'fAz1MnIWmBmMm+MttEEuq6oABXfyFXsvMup1TMA6EokWvk7ARq3plY6gZDK6x25vVDmiWUkkSZEysf7sf8AdDA==', '2016-07-14 15:52:18', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'admin_nombre', 'admin_apellido', NULL),
(9, 'pepe', 'pepe', 'pepe@mail.com', 'pepe@mail.com', 0, 'ijizd3jp7e0ogcksc48ggsocwgckoc4', 'r3PB/OGX1u44MLk0uIGRu0Lop6VB/4avUigjscM888sadATC5f7naHUyE6UY+cGxwhA26rQ0T6i1WTpHmxQkmg==', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'pepe_nombre', 'pepe_apellido', 'pepe_avatar'),
(10, 'test1_username', 'test1_username', 'test1@safe.com', 'test1@safe.com', 0, 'n0g2wfgetn48kww48so0wkgwgggcgws', 'waKlY4nWQGByxFYrce0RbU7XIQ8aGB2+19mvfaVD70UFWKxRGgiypz9+lpg9FLAIqYhqoq2Sk27kSMCP6WSpxA==', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'Test1', 'Test1_apellido', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CA3B40EC94E27525` (`docente_id`);

--
-- Indices de la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  ADD PRIMARY KEY (`curso_id`,`alumno_id`),
  ADD KEY `IDX_E95F735487CB4A1F` (`curso_id`),
  ADD KEY `IDX_E95F7354FC28E5EE` (`alumno_id`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_61E3A53887CB4A1F` (`curso_id`);

--
-- Indices de la tabla `tema_dependencia`
--
ALTER TABLE `tema_dependencia`
  ADD PRIMARY KEY (`tema_source`,`tema_target`),
  ADD KEY `IDX_894FC753980ADEF1` (`tema_source`),
  ADD KEY `IDX_894FC75381EF8E7E` (`tema_target`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `user_uk` (`nombre`,`apellido`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `FK_CA3B40EC94E27525` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`);

--
-- Filtros para la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  ADD CONSTRAINT `FK_E95F735487CB4A1F` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E95F7354FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `FK_61E3A53887CB4A1F` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`);

--
-- Filtros para la tabla `tema_dependencia`
--
ALTER TABLE `tema_dependencia`
  ADD CONSTRAINT `FK_894FC75381EF8E7E` FOREIGN KEY (`tema_target`) REFERENCES `tema` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_894FC753980ADEF1` FOREIGN KEY (`tema_source`) REFERENCES `tema` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
