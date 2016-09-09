-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-09-2016 a las 22:05:39
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
  `legajo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `instituto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `legajo`, `usuario_id`, `instituto_id`) VALUES
(1, '123457', 2, 1),
(2, '123452', 3, 1),
(3, '123422', 4, 1),
(4, '123423', 5, 1),
(5, '123424', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__category`
--

CREATE TABLE `classification__category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `context` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__collection`
--

CREATE TABLE `classification__collection` (
  `id` int(11) NOT NULL,
  `context` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__context`
--

CREATE TABLE `classification__context` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__tag`
--

CREATE TABLE `classification__tag` (
  `id` int(11) NOT NULL,
  `context` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `fechaCreacion` datetime DEFAULT NULL,
  `instituto_id` int(11) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `titulo`, `descripcion`, `fechaCreacion`, `instituto_id`, `fechaModificacion`) VALUES
(4, 'Matemáticas 1', '<h1>Curso inical de matemáticas</h1> <p>El objetivo del curso...</p>', '2016-08-25 00:43:30', 1, NULL);

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
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_docente`
--

CREATE TABLE `curso_docente` (
  `curso_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_docente`
--

INSERT INTO `curso_docente` (`curso_id`, `docente_id`) VALUES
(4, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `curriculum` text,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `instituto_id` int(11) DEFAULT NULL,
  `legajo` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `curriculum`, `fechaModificacion`, `usuario_id`, `instituto_id`, `legajo`, `fechaCreacion`) VALUES
(1, '<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>', '2016-08-25 00:39:32', 7, 1, '123457', NULL),
(2, '<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>', '2016-08-25 00:40:40', 8, 1, '123451', NULL),
(3, '<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>', '2016-08-25 00:41:40', 9, 1, '123452', NULL),
(4, '<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>', '2016-08-25 00:41:54', 10, 1, '123454', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituto`
--

CREATE TABLE `instituto` (
  `id` int(11) NOT NULL,
  `razonSocial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `instituto`
--

INSERT INTO `instituto` (`id`, `razonSocial`, `descripcion`) VALUES
(1, 'Razón social por defecto', 'Ingrese aquí la descripción del instituto, historia, datos de contacto.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media__gallery`
--

CREATE TABLE `media__gallery` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media__gallery_media`
--

CREATE TABLE `media__gallery_media` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media__media`
--

CREATE TABLE `media__media` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `enabled` tinyint(1) NOT NULL,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_status` int(11) NOT NULL,
  `provider_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_metadata` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:json)',
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `length` decimal(10,0) DEFAULT NULL,
  `content_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_size` int(11) DEFAULT NULL,
  `copyright` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `context` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdn_is_flushable` tinyint(1) DEFAULT NULL,
  `cdn_flush_identifier` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdn_flush_at` datetime DEFAULT NULL,
  `cdn_status` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `codigo` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `codigo`, `descripcion`) VALUES
(1, 'DNI', 'Documento nacional de identidad');

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
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_documento_id` int(11) NOT NULL,
  `numero_documento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nacionalidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `nombre`, `apellido`, `avatar`, `tipo_documento_id`, `numero_documento`, `genero`, `nacionalidad`) VALUES
(1, 'admin', 'admin', 'admin@safe.com', 'admin@safe.com', 1, '6lsk4s3xzukgos4wc8kkooc4g0gg0kw', 'fAz1MnIWmBmMm+MttEEuq6oABXfyFXsvMup1TMA6EokWvk7ARq3plY6gZDK6x25vVDmiWUkkSZEysf7sf8AdDA==', '2016-09-06 03:16:46', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'admin_nombre', 'admin_apellido', NULL, 1, '20555777', NULL, NULL),
(2, 'chespirito', 'chespirito', 'chespirito@organizacion.org', 'chespirito@organizacion.org', 1, 'pll1f8ota5cgcs0s0koog0gkgsc0s0', 'TGo5inENJH2gE3Qf3YxVFoky0OwPYD86inxtaD+bMoYJzCtNkZ4nPUdHWkiRzIO/5G8lfJSSeAtB0tZYShGeuQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'Roberto', 'Gómez Bolaño', NULL, 1, '30777555', 'Masculino', NULL),
(3, 'alumno1', 'alumno1', 'alumno1@organizacion.org', 'alumno1@organizacion.org', 1, 'm009bk38wtso4wkssg4sc8g404wok4w', 'FkaApz8FAz5iZrESTHBKVLJy8zV8UBQcmJqdDrEXMMuI1kiJgrfrJ9ZXgQPtV/i9V3j1RtvlszMyqC4ahInhlw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'Alumno_1', 'Gómez Bolaño', NULL, 1, '30777551', 'Masculino', NULL),
(4, 'alumno2', 'alumno2', 'alumno2@organizacion.org', 'alumno2@organizacion.org', 1, 'p5lnsdli5344cwgsgssc0c4sc04o4w0', 'F/TIIq7DfD6M1Hk6uLKuS+VmkrWPkAyAkmzZ7blhpfJgjUeG81Mt3oRoCI2r3pftLBzIVekdfGAltIuFBcX8bg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'Alumno_2', 'Gómez Bolaño', NULL, 1, '30777552', 'Masculino', NULL),
(5, 'alumno3', 'alumno3', 'alumno3@organizacion.org', 'alumno3@organizacion.org', 1, 'kialvu6njsgsco8wck4s0ws44wc4w0o', '/DxuzoEyMAb/KjMFiMxvafn6/NW0YlBPjlipqM31S6c+f3MkXU1l7yphBssAgwUqnB5/z9U7cOb8UMX1ISFdwA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'Alumno_3', 'Gómez Bolaño', NULL, 1, '30777553', 'Masculino', NULL),
(6, 'alumno4', 'alumno4', 'alumno4@organizacion.org', 'alumno4@organizacion.org', 1, 'joqg0c4jqeos0k4cs0cwgscwwckk8go', 'dcmdtls7c5JGcy3gpmfwUBewxfKDeg9AXcZRBfLCICR74gEid6N5+kSbwwKKeZmjLeRm9nT8BE5ReerxVcMX4Q==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'Alumno_4', 'Gómez Bolaño', NULL, 1, '30777554', 'Masculino', NULL),
(7, 'jirafales', 'jirafales', 'jirafales@organizacion.org', 'jirafales@organizacion.org', 1, 'b48n6m4nz1ckkwogg800444w0c4wok8', 'E+XHNQ1Whx352vq24UBhrtOqW6/9flDGEbEYYD+pJ+jxdQAN2DPxzh0jpZo2J1oJbukDTAXvJ443sK0XtuDvvQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_DOCENTE";}', 0, NULL, 'Ruben', 'Aguirre', NULL, 1, '20777555', 'Masculino', NULL),
(8, 'docente1', 'docente1', 'docente1@organizacion.org', 'docente1@organizacion.org', 1, 'xg4udz23ztw0kw4oco48gs008gg4g', 'RlNu8+03kQTcjs4hXE4OEqGUn7lONjSmFthvbbuGLOUVqoQXStVwnZ4MKp1ah8mDKat5QiQ7d4cLmzUlmlUKtw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_DOCENTE";}', 0, NULL, 'docente1', 'Aguirre', NULL, 1, '20777551', 'Masculino', NULL),
(9, 'docente2', 'docente2', 'docente2@organizacion.org', 'docente2@organizacion.org', 1, '4acpspaebzwgsc80s08ocswk848ssws', 'YdMcpTwOCIsjxCixlF2tv3pdHt7TrVl9i0dz/Yt5LxJIw5A2iltk6pV6nN1nOSbflyArnYOCRqd/239VBbcSeA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_DOCENTE";}', 0, NULL, 'docente2', 'Aguirre', NULL, 1, '20777552', 'Masculino', NULL),
(10, 'docente4', 'docente4', 'docente4@organizacion.org', 'docente4@organizacion.org', 1, 'kwipnamuxlc80so4sckokw0888g4ook', 'MmIYLc3UZwJB+UAG9/TkZaAyhJs1LeO/XmyZuvryN8PuzVtMcrpH0E0nHhxZOmaY4jQsVUehFvYk+kPzQdaRFw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_DOCENTE";}', 0, NULL, 'docente4', 'Aguirre', NULL, 1, '20777554', 'Masculino', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumn_leg_uk` (`legajo`,`instituto_id`),
  ADD KEY `IDX_1435D52DDB38439E` (`usuario_id`),
  ADD KEY `IDX_1435D52D6C6EF28` (`instituto_id`);

--
-- Indices de la tabla `classification__category`
--
ALTER TABLE `classification__category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_43629B36727ACA70` (`parent_id`),
  ADD KEY `IDX_43629B36E25D857E` (`context`),
  ADD KEY `IDX_43629B36EA9FDD75` (`media_id`);

--
-- Indices de la tabla `classification__collection`
--
ALTER TABLE `classification__collection`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_collection` (`slug`,`context`),
  ADD KEY `IDX_A406B56AE25D857E` (`context`),
  ADD KEY `IDX_A406B56AEA9FDD75` (`media_id`);

--
-- Indices de la tabla `classification__context`
--
ALTER TABLE `classification__context`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `classification__tag`
--
ALTER TABLE `classification__tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_context` (`slug`,`context`),
  ADD KEY `IDX_CA57A1C7E25D857E` (`context`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CA3B40EC6C6EF28` (`instituto_id`);

--
-- Indices de la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  ADD PRIMARY KEY (`curso_id`,`alumno_id`),
  ADD KEY `IDX_E95F735487CB4A1F` (`curso_id`),
  ADD KEY `IDX_E95F7354FC28E5EE` (`alumno_id`);

--
-- Indices de la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  ADD PRIMARY KEY (`curso_id`,`docente_id`),
  ADD KEY `IDX_D4BB6C9A87CB4A1F` (`curso_id`),
  ADD KEY `IDX_D4BB6C9A94E27525` (`docente_id`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doc_leg_uk` (`legajo`,`instituto_id`),
  ADD KEY `IDX_FD9FCFA4DB38439E` (`usuario_id`),
  ADD KEY `IDX_FD9FCFA46C6EF28` (`instituto_id`);

--
-- Indices de la tabla `instituto`
--
ALTER TABLE `instituto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2A805CCE832CBC66` (`razonSocial`);

--
-- Indices de la tabla `media__gallery`
--
ALTER TABLE `media__gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `media__gallery_media`
--
ALTER TABLE `media__gallery_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_80D4C5414E7AF8F` (`gallery_id`),
  ADD KEY `IDX_80D4C541EA9FDD75` (`media_id`);

--
-- Indices de la tabla `media__media`
--
ALTER TABLE `media__media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5C6DD74E12469DE2` (`category_id`);

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
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_54DF918920332D99` (`codigo`),
  ADD UNIQUE KEY `UNIQ_54DF9189A02A2F00` (`descripcion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `user_uk` (`nombre`,`apellido`),
  ADD UNIQUE KEY `user_doc_uk` (`tipo_documento_id`,`numero_documento`),
  ADD KEY `IDX_2265B05DF6939175` (`tipo_documento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `classification__category`
--
ALTER TABLE `classification__category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `classification__collection`
--
ALTER TABLE `classification__collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `classification__tag`
--
ALTER TABLE `classification__tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `instituto`
--
ALTER TABLE `instituto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `media__gallery`
--
ALTER TABLE `media__gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `media__gallery_media`
--
ALTER TABLE `media__gallery_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `media__media`
--
ALTER TABLE `media__media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `FK_1435D52D6C6EF28` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`),
  ADD CONSTRAINT `FK_1435D52DDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `classification__category`
--
ALTER TABLE `classification__category`
  ADD CONSTRAINT `FK_43629B36727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `classification__category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_43629B36E25D857E` FOREIGN KEY (`context`) REFERENCES `classification__context` (`id`),
  ADD CONSTRAINT `FK_43629B36EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `classification__collection`
--
ALTER TABLE `classification__collection`
  ADD CONSTRAINT `FK_A406B56AE25D857E` FOREIGN KEY (`context`) REFERENCES `classification__context` (`id`),
  ADD CONSTRAINT `FK_A406B56AEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `classification__tag`
--
ALTER TABLE `classification__tag`
  ADD CONSTRAINT `FK_CA57A1C7E25D857E` FOREIGN KEY (`context`) REFERENCES `classification__context` (`id`);

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `FK_CA3B40EC6C6EF28` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`);

--
-- Filtros para la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  ADD CONSTRAINT `FK_E95F735487CB4A1F` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E95F7354FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  ADD CONSTRAINT `FK_D4BB6C9A87CB4A1F` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D4BB6C9A94E27525` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `FK_FD9FCFA46C6EF28` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`),
  ADD CONSTRAINT `FK_FD9FCFA4DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `media__gallery_media`
--
ALTER TABLE `media__gallery_media`
  ADD CONSTRAINT `FK_80D4C5414E7AF8F` FOREIGN KEY (`gallery_id`) REFERENCES `media__gallery` (`id`),
  ADD CONSTRAINT `FK_80D4C541EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`);

--
-- Filtros para la tabla `media__media`
--
ALTER TABLE `media__media`
  ADD CONSTRAINT `FK_5C6DD74E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `classification__category` (`id`) ON DELETE SET NULL;

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

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_2265B05DF6939175` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
