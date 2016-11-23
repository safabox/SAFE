-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-11-2016 a las 16:52:51
-- Versión del servidor: 5.5.44-MariaDB-cll-lve
-- Versión de PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `safaboxc_safe_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concepto_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `ejercicio` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `resultado` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `habilitado` tinyint(1) NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8DF2BD066C2330BD` (`concepto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `instituto_id` int(11) NOT NULL,
  `legajo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alumn_leg_uk` (`legajo`,`instituto_id`),
  KEY `IDX_1435D52DDB38439E` (`usuario_id`),
  KEY `IDX_1435D52D6C6EF28` (`instituto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_concepto_estado`
--

CREATE TABLE IF NOT EXISTS `alumno_concepto_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `concepto_id` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB0ABD9FC28E5EE` (`alumno_id`),
  KEY `IDX_FB0ABD96C2330BD` (`concepto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_estado_curso`
--

CREATE TABLE IF NOT EXISTS `alumno_estado_curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DDAE0B0CFC28E5EE` (`alumno_id`),
  KEY `IDX_DDAE0B0C87CB4A1F` (`curso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_estado_tema`
--

CREATE TABLE IF NOT EXISTS `alumno_estado_tema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_431606A6FC28E5EE` (`alumno_id`),
  KEY `IDX_431606A6A64A8A17` (`tema_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_ability`
--

CREATE TABLE IF NOT EXISTS `cat_ability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `examinee_id` int(11) NOT NULL,
  `item_bank_id` int(11) NOT NULL,
  `theta` double NOT NULL,
  `theta_error` double NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_157E6C6A4796EA45` (`examinee_id`),
  KEY `IDX_157E6C6A1A95DD15` (`item_bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_examinee`
--

CREATE TABLE IF NOT EXISTS `cat_examinee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_item`
--

CREATE TABLE IF NOT EXISTS `cat_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_bank_id` int(11) NOT NULL,
  `b` double NOT NULL,
  `a` double NOT NULL,
  `c` double NOT NULL,
  `d` double NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_228D2AF1A95DD15` (`item_bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_item_bank`
--

CREATE TABLE IF NOT EXISTS `cat_item_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_range` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `theta_est_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expected_theta` double NOT NULL,
  `discret_increment` double NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_item_result`
--

CREATE TABLE IF NOT EXISTS `cat_item_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `examinee_id` int(11) NOT NULL,
  `b` double NOT NULL,
  `a` double NOT NULL,
  `c` double NOT NULL,
  `d` double NOT NULL,
  `result` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5FF4947D126F525E` (`item_id`),
  KEY `IDX_5FF4947D4796EA45` (`examinee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_past_ability`
--

CREATE TABLE IF NOT EXISTS `cat_past_ability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ability_id` int(11) NOT NULL,
  `theta` double NOT NULL,
  `created` datetime NOT NULL,
  `theta_error` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB4A86578016D8B2` (`ability_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__category`
--

CREATE TABLE IF NOT EXISTS `classification__category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `context` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_43629B36727ACA70` (`parent_id`),
  KEY `IDX_43629B36E25D857E` (`context`),
  KEY `IDX_43629B36EA9FDD75` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__collection`
--

CREATE TABLE IF NOT EXISTS `classification__collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_collection` (`slug`(15),`context`),
  KEY `IDX_CC_CONTEX` (`context`),
  KEY `IDX_CC_MEDIA` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__context`
--

CREATE TABLE IF NOT EXISTS `classification__context` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classification__tag`
--

CREATE TABLE IF NOT EXISTS `classification__tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_collection` (`slug`(15),`context`),
  KEY `IDX_CA57A1C7E25D857E` (`context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE IF NOT EXISTS `concepto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copete` longtext COLLATE utf8mb4_unicode_ci,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `orden` int(11) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `mostrarResultado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_648388D0A64A8A17` (`tema_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_dependencia`
--

CREATE TABLE IF NOT EXISTS `concepto_dependencia` (
  `sucesora_id` int(11) NOT NULL,
  `predecesora_id` int(11) NOT NULL,
  PRIMARY KEY (`sucesora_id`,`predecesora_id`),
  KEY `IDX_11AE31AA5C6890AE` (`sucesora_id`),
  KEY `IDX_11AE31AAC60169B7` (`predecesora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituto_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copete` longtext COLLATE utf8mb4_unicode_ci,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CA3B40EC6C6EF28` (`instituto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_alumno`
--

CREATE TABLE IF NOT EXISTS `curso_alumno` (
  `curso_id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  PRIMARY KEY (`curso_id`,`alumno_id`),
  KEY `IDX_E95F735487CB4A1F` (`curso_id`),
  KEY `IDX_E95F7354FC28E5EE` (`alumno_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_docente`
--

CREATE TABLE IF NOT EXISTS `curso_docente` (
  `curso_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  PRIMARY KEY (`curso_id`,`docente_id`),
  KEY `IDX_D4BB6C9A87CB4A1F` (`curso_id`),
  KEY `IDX_D4BB6C9A94E27525` (`docente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `instituto_id` int(11) DEFAULT NULL,
  `legajo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curriculum` longtext COLLATE utf8mb4_unicode_ci,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doc_leg_uk` (`legajo`,`instituto_id`),
  KEY `IDX_FD9FCFA4DB38439E` (`usuario_id`),
  KEY `IDX_FD9FCFA46C6EF28` (`instituto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituto`
--

CREATE TABLE IF NOT EXISTS `instituto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2A805CCE832CBC66` (`razonSocial`(50))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `instituto`
--

INSERT INTO `instituto` (`id`, `razonSocial`, `descripcion`) VALUES
(1, 'Razón social por defecto', 'Ingrese aquí la descripción del instituto, historia, datos de contacto.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media__gallery`
--

CREATE TABLE IF NOT EXISTS `media__gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media__gallery_media`
--

CREATE TABLE IF NOT EXISTS `media__gallery_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_80D4C5414E7AF8F` (`gallery_id`),
  KEY `IDX_80D4C541EA9FDD75` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media__media`
--

CREATE TABLE IF NOT EXISTS `media__media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5C6DD74E12469DE2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copete` longtext COLLATE utf8mb4_unicode_ci,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `orden` int(11) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_61E3A53887CB4A1F` (`curso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema_dependencia`
--

CREATE TABLE IF NOT EXISTS `tema_dependencia` (
  `sucesora_id` int(11) NOT NULL,
  `predecesora_id` int(11) NOT NULL,
  PRIMARY KEY (`sucesora_id`,`predecesora_id`),
  KEY `IDX_894FC7535C6890AE` (`sucesora_id`),
  KEY `IDX_894FC753C60169B7` (`predecesora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_54DF918920332D99` (`codigo`),
  UNIQUE KEY `UNIQ_54DF9189A02A2F00` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `codigo`, `descripcion`) VALUES
(1, 'DNI', 'Documento nacional de identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento_id` int(11) NOT NULL,
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
  `genero` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nacionalidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_documento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_uk` (`nombre`,`apellido`),
  UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`(150)),
  UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`(150)),
  UNIQUE KEY `user_doc_uk` (`tipo_documento_id`,`numero_documento`(50)),
  KEY `IDX_2265B05DF6939175` (`tipo_documento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `tipo_documento_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `nombre`, `apellido`, `genero`, `nacionalidad`, `numero_documento`, `avatar`) VALUES
(1, 1, 'admin', 'admin', 'admin@safe.com', 'admin@safe.com', 1, '6lsk4s3xzukgos4wc8kkooc4g0gg0kw', 'fAz1MnIWmBmMm+MttEEuq6oABXfyFXsvMup1TMA6EokWvk7ARq3plY6gZDK6x25vVDmiWUkkSZEysf7sf8AdDA==', '2016-11-20 08:19:42', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'admin_nombre', 'admin_apellido', NULL, NULL, '20555777', NULL);

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
  ADD CONSTRAINT `FK_CC_CATE2` FOREIGN KEY (`context`) REFERENCES `classification__context` (`id`),
  ADD CONSTRAINT `FK_CC_CATE3` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `classification__collection`
--
ALTER TABLE `classification__collection`
  ADD CONSTRAINT `FK_CC_CATE4` FOREIGN KEY (`context`) REFERENCES `classification__context` (`id`),
  ADD CONSTRAINT `FK_CC_CATE5` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`) ON DELETE SET NULL;

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
