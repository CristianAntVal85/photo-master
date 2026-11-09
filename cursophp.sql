-- Base de datos: cursophp
-- Creado para el proyecto Photo Master
-- Juego de caracteres: utf8 / utf8_spanish_ci

CREATE DATABASE IF NOT EXISTS `cursophp` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `cursophp`;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `categorias`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'categoría I'),
(2, 'categoría II'),
(3, 'categoría III')
ON DUPLICATE KEY UPDATE `nombre`=VALUES(`nombre`);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `imagenes`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `categoria` int(11) NOT NULL DEFAULT 1,
  `numVisualizaciones` int(11) NOT NULL DEFAULT 0,
  `numLikes` int(11) NOT NULL DEFAULT 0,
  `numDownloads` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_imagenes_categorias` (`categoria`),
  CONSTRAINT `fk_imagenes_categorias` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `asociados`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `asociados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
