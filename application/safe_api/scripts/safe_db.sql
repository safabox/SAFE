-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-10-2016 a las 02:18:27
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
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` int(11) NOT NULL,
  `concepto_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `ejercicio` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `habilitado` tinyint(1) NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `resultado` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `legajo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `instituto_id` int(11) NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `legajo`, `usuario_id`, `instituto_id`, `fechaCreacion`, `fechaModificacion`) VALUES
(8, '10', 14, 1, '2016-09-17 01:44:59', '2016-09-17 01:45:00'),
(9, '12', 16, 1, '2016-09-17 02:12:47', '2016-09-17 02:12:47'),
(10, '130', 18, 1, '2016-10-22 21:55:27', '2016-10-22 21:55:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_concepto_estado`
--

CREATE TABLE `alumno_concepto_estado` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `concepto_id` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_estado_curso`
--

CREATE TABLE `alumno_estado_curso` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_estado_tema`
--

CREATE TABLE `alumno_estado_tema` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_ability`
--

CREATE TABLE `cat_ability` (
  `id` int(11) NOT NULL,
  `examinee_id` int(11) NOT NULL,
  `item_bank_id` int(11) NOT NULL,
  `theta` double NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `theta_error` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_examinee`
--

CREATE TABLE `cat_examinee` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_item`
--

CREATE TABLE `cat_item` (
  `id` int(11) NOT NULL,
  `item_bank_id` int(11) NOT NULL,
  `b` double NOT NULL,
  `a` double NOT NULL,
  `c` double NOT NULL,
  `d` double NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_item_bank`
--

CREATE TABLE `cat_item_bank` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_range` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `theta_est_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discret_increment` double NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `expected_theta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_item_result`
--

CREATE TABLE `cat_item_result` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `examinee_id` int(11) NOT NULL,
  `b` double NOT NULL,
  `a` double NOT NULL,
  `c` double NOT NULL,
  `d` double NOT NULL,
  `result` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_past_ability`
--

CREATE TABLE `cat_past_ability` (
  `id` int(11) NOT NULL,
  `ability_id` int(11) NOT NULL,
  `theta` double NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `orden` int(11) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `copete` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_dependencia`
--

CREATE TABLE `concepto_dependencia` (
  `sucesora_id` int(11) NOT NULL,
  `predecesora_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `fechaModificacion` datetime DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `copete` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `titulo`, `descripcion`, `fechaCreacion`, `instituto_id`, `fechaModificacion`, `habilitado`, `copete`) VALUES
(4, 'Matemáticas 1', '<h1>Curso inical de matemáticas</h1> <p>El objetivo del curso...</p>', '2016-08-25 00:43:30', 1, '2016-10-22 21:55:51', 0, NULL),
(5, 'Lengua', 'pepep', '2016-09-17 02:13:55', 1, '2016-10-22 21:56:32', 0, NULL);

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
(4, 8),
(4, 10),
(5, 8),
(5, 10);

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
(4, 6),
(5, 6);

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
(6, NULL, '2016-09-17 02:07:27', 15, 1, '11', '2016-09-17 02:07:27'),
(7, '<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>', '2016-10-21 15:29:35', 17, 1, '1234510', '2016-10-21 15:29:34');

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
  `curso_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `orden` int(11) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `copete` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema_dependencia`
--

CREATE TABLE `tema_dependencia` (
  `sucesora_id` int(11) NOT NULL,
  `predecesora_id` int(11) NOT NULL
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
(1, 'admin', 'admin', 'admin@safe.com', 'admin@safe.com', 1, '6lsk4s3xzukgos4wc8kkooc4g0gg0kw', 'fAz1MnIWmBmMm+MttEEuq6oABXfyFXsvMup1TMA6EokWvk7ARq3plY6gZDK6x25vVDmiWUkkSZEysf7sf8AdDA==', '2016-10-22 21:54:14', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'admin_nombre', 'admin_apellido', NULL, 1, '20555777', NULL, NULL),
(14, 'alumno10', 'alumno10', 'alumno10@asdf.com', 'alumno10@asdf.com', 1, '95k7ar66q0ow8gscgw4wcss0sk4c8gg', 'fAz1MnIWmBmMm+MttEEuq6oABXfyFXsvMup1TMA6EokWvk7ARq3plY6gZDK6x25vVDmiWUkkSZEysf7sf8AdDA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'alumno10', 'apellido10', NULL, 1, '290001111', 'Masculino', NULL),
(15, 'usuario11', 'usuario11', 'usuario11@asd.com', 'usuario11@asd.com', 0, '116kmbor3e1w4os80k4wcso40coogo8', 'fAz1MnIWmBmMm+MttEEuq6oABXfyFXsvMup1TMA6EokWvk7ARq3plY6gZDK6x25vVDmiWUkkSZEysf7sf8AdDA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_DOCENTE";}', 0, NULL, 'Docente11', 'Apellido11', NULL, 1, '30444711', 'Masculino', NULL),
(16, 'usuario12', 'usuario12', 'test@test.com', 'test@test.com', 0, 'm52rvfamzj4koks40kgw4ggokccwc44', 'd2QeGc9fYlVIY7H/1lUEaP3xySPwCTCvXtXFtG+I9+TMtkmaLLgyNays1pS4jBlK9Bhqz6FNOKXQ/Vw/LP89cg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'alumno12', 'apellido12', NULL, 1, '30444712', 'Masculino', NULL),
(17, 'test_docente', 'test_docente', 'jirafales@organizacion.org', 'jirafales@organizacion.org', 1, '8wc3d2cexr0gckswkg44kwgswc40sgs', '5VihoD/YXf1835OZfP+dOTzdqwLfK+NErW2bKKlIPkTg7/+ySY65btyAY0qWY5L7wD8HFMi7HOkgls2liwq5Sw==', '2016-10-21 15:31:20', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_DOCENTE";}', 0, NULL, 'Ruben2', 'Aguirre2', NULL, 1, '22777555', 'Masculino', NULL),
(18, 'toshi', 'toshi', 'toshi@test.com', 'toshi@test.com', 1, '58muqs1u5vs4wwosscg8ooogsgwcg84', 'nE8JhbNgIj71c6hLWcoAkfhkYUjFgCB5WtNj1BBks3NGYY6/AYOD3i96ECEdTccGUAy7e0kN36vh1TyCjkEZWg==', '2016-10-22 21:56:55', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_ALUMNO";}', 0, NULL, 'Toshi', 'Test', NULL, 1, '30888999', 'Masculino', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8DF2BD066C2330BD` (`concepto_id`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumn_leg_uk` (`legajo`,`instituto_id`),
  ADD KEY `IDX_1435D52DDB38439E` (`usuario_id`),
  ADD KEY `IDX_1435D52D6C6EF28` (`instituto_id`);

--
-- Indices de la tabla `alumno_concepto_estado`
--
ALTER TABLE `alumno_concepto_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FB0ABD9FC28E5EE` (`alumno_id`),
  ADD KEY `IDX_FB0ABD96C2330BD` (`concepto_id`);

--
-- Indices de la tabla `alumno_estado_curso`
--
ALTER TABLE `alumno_estado_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DDAE0B0CFC28E5EE` (`alumno_id`),
  ADD KEY `IDX_DDAE0B0C87CB4A1F` (`curso_id`);

--
-- Indices de la tabla `alumno_estado_tema`
--
ALTER TABLE `alumno_estado_tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_431606A6FC28E5EE` (`alumno_id`),
  ADD KEY `IDX_431606A6A64A8A17` (`tema_id`);

--
-- Indices de la tabla `cat_ability`
--
ALTER TABLE `cat_ability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_157E6C6A4796EA45` (`examinee_id`),
  ADD KEY `IDX_157E6C6A1A95DD15` (`item_bank_id`);

--
-- Indices de la tabla `cat_examinee`
--
ALTER TABLE `cat_examinee`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cat_item`
--
ALTER TABLE `cat_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_228D2AF1A95DD15` (`item_bank_id`);

--
-- Indices de la tabla `cat_item_bank`
--
ALTER TABLE `cat_item_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cat_item_result`
--
ALTER TABLE `cat_item_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5FF4947D126F525E` (`item_id`),
  ADD KEY `IDX_5FF4947D4796EA45` (`examinee_id`);

--
-- Indices de la tabla `cat_past_ability`
--
ALTER TABLE `cat_past_ability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FB4A86578016D8B2` (`ability_id`);

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
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_648388D0A64A8A17` (`tema_id`);

--
-- Indices de la tabla `concepto_dependencia`
--
ALTER TABLE `concepto_dependencia`
  ADD PRIMARY KEY (`sucesora_id`,`predecesora_id`),
  ADD KEY `IDX_11AE31AA5C6890AE` (`sucesora_id`),
  ADD KEY `IDX_11AE31AAC60169B7` (`predecesora_id`);

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
  ADD PRIMARY KEY (`sucesora_id`,`predecesora_id`),
  ADD KEY `IDX_894FC7535C6890AE` (`sucesora_id`),
  ADD KEY `IDX_894FC753C60169B7` (`predecesora_id`);

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
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `alumno_concepto_estado`
--
ALTER TABLE `alumno_concepto_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alumno_estado_curso`
--
ALTER TABLE `alumno_estado_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alumno_estado_tema`
--
ALTER TABLE `alumno_estado_tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_ability`
--
ALTER TABLE `cat_ability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_examinee`
--
ALTER TABLE `cat_examinee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_item`
--
ALTER TABLE `cat_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_item_bank`
--
ALTER TABLE `cat_item_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_item_result`
--
ALTER TABLE `cat_item_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_past_ability`
--
ALTER TABLE `cat_past_ability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `FK_8DF2BD066C2330BD` FOREIGN KEY (`concepto_id`) REFERENCES `concepto` (`id`);

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `FK_1435D52D6C6EF28` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`),
  ADD CONSTRAINT `FK_1435D52DDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `alumno_concepto_estado`
--
ALTER TABLE `alumno_concepto_estado`
  ADD CONSTRAINT `FK_FB0ABD96C2330BD` FOREIGN KEY (`concepto_id`) REFERENCES `concepto` (`id`),
  ADD CONSTRAINT `FK_FB0ABD9FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `alumno_estado_curso`
--
ALTER TABLE `alumno_estado_curso`
  ADD CONSTRAINT `FK_DDAE0B0C87CB4A1F` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `FK_DDAE0B0CFC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `alumno_estado_tema`
--
ALTER TABLE `alumno_estado_tema`
  ADD CONSTRAINT `FK_431606A6A64A8A17` FOREIGN KEY (`tema_id`) REFERENCES `tema` (`id`),
  ADD CONSTRAINT `FK_431606A6FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `cat_ability`
--
ALTER TABLE `cat_ability`
  ADD CONSTRAINT `FK_157E6C6A1A95DD15` FOREIGN KEY (`item_bank_id`) REFERENCES `cat_item_bank` (`id`),
  ADD CONSTRAINT `FK_157E6C6A4796EA45` FOREIGN KEY (`examinee_id`) REFERENCES `cat_examinee` (`id`);

--
-- Filtros para la tabla `cat_item`
--
ALTER TABLE `cat_item`
  ADD CONSTRAINT `FK_228D2AF1A95DD15` FOREIGN KEY (`item_bank_id`) REFERENCES `cat_item_bank` (`id`);

--
-- Filtros para la tabla `cat_item_result`
--
ALTER TABLE `cat_item_result`
  ADD CONSTRAINT `FK_5FF4947D126F525E` FOREIGN KEY (`item_id`) REFERENCES `cat_item` (`id`),
  ADD CONSTRAINT `FK_5FF4947D4796EA45` FOREIGN KEY (`examinee_id`) REFERENCES `cat_examinee` (`id`);

--
-- Filtros para la tabla `cat_past_ability`
--
ALTER TABLE `cat_past_ability`
  ADD CONSTRAINT `FK_FB4A86578016D8B2` FOREIGN KEY (`ability_id`) REFERENCES `cat_ability` (`id`);

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
-- Filtros para la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD CONSTRAINT `FK_648388D0A64A8A17` FOREIGN KEY (`tema_id`) REFERENCES `tema` (`id`);

--
-- Filtros para la tabla `concepto_dependencia`
--
ALTER TABLE `concepto_dependencia`
  ADD CONSTRAINT `FK_11AE31AA5C6890AE` FOREIGN KEY (`sucesora_id`) REFERENCES `concepto` (`id`),
  ADD CONSTRAINT `FK_11AE31AAC60169B7` FOREIGN KEY (`predecesora_id`) REFERENCES `concepto` (`id`);

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
  ADD CONSTRAINT `FK_894FC7535C6890AE` FOREIGN KEY (`sucesora_id`) REFERENCES `tema` (`id`),
  ADD CONSTRAINT `FK_894FC753C60169B7` FOREIGN KEY (`predecesora_id`) REFERENCES `tema` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_2265B05DF6939175` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
