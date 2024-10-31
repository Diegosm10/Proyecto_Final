-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sistemita_web_asistencias
CREATE DATABASE IF NOT EXISTS `sistemita_web_asistencias` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistemita_web_asistencias`;

-- Volcando estructura para tabla sistemita_web_asistencias.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `apellido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `dni` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.alumnos: ~3 rows (aproximadamente)
INSERT INTO `alumnos` (`id`, `apellido`, `nombre`, `dni`, `email`, `fecha_nacimiento`) VALUES
	(7, 'Romero', 'Victor', '44556667', 'vicrom8@gmail.com', '2000-05-15'),
	(8, 'Lopez', 'Ramiro', '44556662', 'ramilop@gmail.com', '2000-07-15'),
	(10, 'Casanova', 'Federico', '44556321', 'fedecas12@gmail.com', '1998-11-05'),
	(11, 'Imas', 'Leo', '39144712', 'leoimas@gmail.com', '2000-10-17');

-- Volcando estructura para tabla sistemita_web_asistencias.asistencias
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `materia_id` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `asistencia` enum('presente','ausente') COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `materia_id` (`materia_id`),
  CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_asistencias_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.asistencias: ~6 rows (aproximadamente)
INSERT INTO `asistencias` (`id`, `alumno_id`, `materia_id`, `fecha`, `asistencia`) VALUES
	(2, 7, 4, '2024-10-28 00:00:00', 'ausente'),
	(3, 8, 4, '2024-10-28 00:00:00', 'presente'),
	(4, 10, 4, '2024-10-28 00:00:00', 'presente'),
	(5, 7, 4, '2024-10-25 00:00:00', 'presente'),
	(6, 8, 4, '2024-10-25 00:00:00', 'presente'),
	(7, 10, 4, '2024-10-25 00:00:00', 'presente');

-- Volcando estructura para tabla sistemita_web_asistencias.calificaciones
CREATE TABLE IF NOT EXISTS `calificaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `materia_id` int NOT NULL,
  `nota_1` int DEFAULT NULL,
  `nota_2` int DEFAULT NULL,
  `nota_3` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `materia_id` (`materia_id`),
  CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_calificaciones_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.calificaciones: ~4 rows (aproximadamente)
INSERT INTO `calificaciones` (`id`, `alumno_id`, `materia_id`, `nota_1`, `nota_2`, `nota_3`) VALUES
	(5, 7, 4, 8, 8, 9),
	(6, 8, 4, 6, 6, 6),
	(7, 10, 4, 9, 9, 10),
	(9, 11, 7, 8, 8, 8);

-- Volcando estructura para tabla sistemita_web_asistencias.instituciones
CREATE TABLE IF NOT EXISTS `instituciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cue` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `telefono` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cue` (`cue`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.instituciones: ~2 rows (aproximadamente)
INSERT INTO `instituciones` (`id`, `cue`, `nombre`, `direccion`, `telefono`, `email`) VALUES
	(1, 15478869, 'Sedes Sapientiae', 'Santa Fe 54', '3446502269', 'sedesonline@gmail.com'),
	(2, 12453682, 'UADER', 'Urquiza 2238', '3446411022', 'uader@gmail.com');

-- Volcando estructura para tabla sistemita_web_asistencias.materias
CREATE TABLE IF NOT EXISTS `materias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.materias: ~8 rows (aproximadamente)
INSERT INTO `materias` (`id`, `nombre`) VALUES
	(7, 'Base de datos'),
	(6, 'Legislación informática '),
	(5, 'Lógica'),
	(8, 'Matemática discreta'),
	(2, 'Programación 1'),
	(1, 'Programación 2'),
	(3, 'Programación 3'),
	(4, 'Redes informáticas');

-- Volcando estructura para tabla sistemita_web_asistencias.materias_institucion
CREATE TABLE IF NOT EXISTS `materias_institucion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institucion_id` int NOT NULL,
  `materias_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `materias_fkid1` (`institucion_id`),
  KEY `materias_id` (`materias_id`),
  CONSTRAINT `materias_fkid1` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `materias_fkid2` FOREIGN KEY (`materias_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.materias_institucion: ~9 rows (aproximadamente)
INSERT INTO `materias_institucion` (`id`, `institucion_id`, `materias_id`) VALUES
	(1, 1, 7),
	(2, 1, 6),
	(3, 1, 5),
	(4, 1, 2),
	(5, 1, 1),
	(6, 1, 3),
	(7, 2, 8),
	(8, 2, 4),
	(9, 2, 6);

-- Volcando estructura para tabla sistemita_web_asistencias.materias_profesor
CREATE TABLE IF NOT EXISTS `materias_profesor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profesor_id` int NOT NULL,
  `materias_id` int NOT NULL,
  `institucion_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profesor_id` (`profesor_id`),
  KEY `materias_profesor_ibfk_1` (`materias_id`),
  KEY `FK_materias_profesor_instituciones` (`institucion_id`),
  CONSTRAINT `FK_materias_profesor_instituciones` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_materias_profesor_materias` FOREIGN KEY (`materias_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_materias_profesor_profesores` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.materias_profesor: ~1 rows (aproximadamente)
INSERT INTO `materias_profesor` (`id`, `profesor_id`, `materias_id`, `institucion_id`) VALUES
	(3, 2, 4, 2);

-- Volcando estructura para tabla sistemita_web_asistencias.profesores
CREATE TABLE IF NOT EXISTS `profesores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `apellido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `dni` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `legajo` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `legajo` (`legajo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.profesores: ~1 rows (aproximadamente)
INSERT INTO `profesores` (`id`, `apellido`, `nombre`, `dni`, `email`, `fecha_nacimiento`, `legajo`) VALUES
	(2, 'Gonzalez', 'Pepito', '33247763', 'pepgon12@gmail.com', '1979-12-12', '12121212');

-- Volcando estructura para tabla sistemita_web_asistencias.ram
CREATE TABLE IF NOT EXISTS `ram` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nota_regular` int NOT NULL,
  `nota_promocion` int NOT NULL,
  `asistencia_regular` int NOT NULL,
  `asistencia_promocion` int NOT NULL,
  `institucion_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__instituciones` (`institucion_id`),
  CONSTRAINT `FK__instituciones` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.ram: ~2 rows (aproximadamente)
INSERT INTO `ram` (`id`, `nota_regular`, `nota_promocion`, `asistencia_regular`, `asistencia_promocion`, `institucion_id`) VALUES
	(1, 6, 7, 70, 70, 1),
	(2, 6, 7, 70, 70, 2);

-- Volcando estructura para tabla sistemita_web_asistencias.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `condicion` enum('admin','profesor') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sistemita_web_asistencias.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `fecha_creacion`, `condicion`) VALUES
	(1, 'Diego', 'Segovia Muñiz', 'diego666.segovia777@gmail.com', '$2y$10$al6CM0quxBWA4a5j9qj7LuOY9Uajv4T/1Fi0WGP2IAG9xrC5B27o6', '2024-09-26 23:12:11', 'admin'),
	(3, 'Pepito', 'Gonzalez', 'pepgon12@gmail.com', '$2y$10$imoo8HycKz3szj9gaHWOdOwTVcFf4m8BFDXDs6ClsigcW3xPQawbO', '2024-10-31 21:48:17', 'profesor');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
