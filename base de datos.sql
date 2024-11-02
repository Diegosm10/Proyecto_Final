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


-- Volcando estructura de base de datos para prueba
CREATE DATABASE IF NOT EXISTS `prueba` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `prueba`;

-- Volcando estructura para tabla prueba.alumnos
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

-- Volcando datos para la tabla prueba.alumnos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.asistencias
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `materia_id` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `asistencia` enum('presente','ausente') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `materia_id` (`materia_id`),
  CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_asistencias_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla prueba.asistencias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.calificaciones
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

-- Volcando datos para la tabla prueba.calificaciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.instituciones
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

-- Volcando datos para la tabla prueba.instituciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.materias
CREATE TABLE IF NOT EXISTS `materias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla prueba.materias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.materias_institucion
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

-- Volcando datos para la tabla prueba.materias_institucion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.materias_profesor
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

-- Volcando datos para la tabla prueba.materias_profesor: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.profesores
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

-- Volcando datos para la tabla prueba.profesores: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.ram
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

-- Volcando datos para la tabla prueba.ram: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.usuarios
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

-- Volcando datos para la tabla prueba.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `fecha_creacion`, `condicion`) VALUES
	(1, 'Diego', 'Segovia Muñiz', 'diego666.segovia777@gmail.com', '$2y$10$al6CM0quxBWA4a5j9qj7LuOY9Uajv4T/1Fi0WGP2IAG9xrC5B27o6', '2024-09-26 23:12:11', 'admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
