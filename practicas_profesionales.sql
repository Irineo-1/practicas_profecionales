-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for practicas_profesionales
CREATE DATABASE IF NOT EXISTS `practicas_profesionales` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `practicas_profesionales`;

-- Dumping structure for table practicas_profesionales.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_control` int(11) NOT NULL DEFAULT 0,
  `nombre_completo` varchar(200) NOT NULL DEFAULT '0',
  `password` varchar(200) NOT NULL DEFAULT '0',
  `numero_proceso` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_control` (`numero_control`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table practicas_profesionales.alumnos: ~2 rows (approximately)
INSERT INTO `alumnos` (`id`, `numero_control`, `nombre_completo`, `password`, `numero_proceso`) VALUES
	(9, 123, 'asd', '$2y$10$gvFy6yEFTuUz5Y.hWq.5k.TZ0/K/S/gm0oPLEclsTEnMWY5KEuiZ2', 2),
	(11, 456, 'dtydthgdg', '$2y$10$o8M3k4fm5EOx3o003mAAaOwFvH9xNaEhlQHOyG3iuVd4Ad36aU4bu', 0);

-- Dumping structure for table practicas_profesionales.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_control` int(11) NOT NULL DEFAULT 0,
  `nombre_documento` varchar(150) NOT NULL DEFAULT '0',
  `proceso` varchar(150) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_archivos_alumno` (`numero_control`),
  CONSTRAINT `FK_archivos_alumno` FOREIGN KEY (`numero_control`) REFERENCES `alumnos` (`numero_control`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table practicas_profesionales.documentos: ~0 rows (approximately)
INSERT INTO `documentos` (`id`, `numero_control`, `nombre_documento`, `proceso`) VALUES
	(36, 123, 'd3e91e46_4de9_b429_377c_d6e88252669b.jpeg', 'constancia_termino');

-- Dumping structure for table practicas_profesionales.firmados
CREATE TABLE IF NOT EXISTS `firmados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_control` int(11) NOT NULL DEFAULT 0,
  `firmado` varchar(50) NOT NULL DEFAULT '0',
  `documento` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_control` (`numero_control`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table practicas_profesionales.firmados: ~0 rows (approximately)

-- Dumping structure for table practicas_profesionales.instituciones
CREATE TABLE IF NOT EXISTS `instituciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(100) NOT NULL DEFAULT '0',
  `entidad_federativa` varchar(100) NOT NULL,
  `clave_centro` varchar(100) NOT NULL,
  `tipo_empresa` varchar(100) NOT NULL,
  `tipo_institucion` varchar(100) NOT NULL,
  `giro_empresa` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table practicas_profesionales.instituciones: ~40 rows (approximately)
INSERT INTO `instituciones` (`id`, `nombre_empresa`, `entidad_federativa`, `clave_centro`, `tipo_empresa`, `tipo_institucion`, `giro_empresa`) VALUES
	(1, 'INSTITUTO DE ESTUDIOS UCCEG', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(2, 'CENTRO DE ESTUDIOS ITEP', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(3, 'INIFAP', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(4, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(5, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(6, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(7, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(8, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(9, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(10, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(11, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(12, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(13, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(14, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(15, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(16, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(17, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(18, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(19, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(20, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(21, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(22, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(23, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(24, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(25, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(26, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(27, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(28, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(29, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(30, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(31, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(32, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(33, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(34, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(35, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(36, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(37, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(38, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(39, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(40, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS'),
	(41, 'CECATI No. 145', 'Colima', '06DCT0019Z', 'CBTIS', 'PRIVADA', 'SERVICIOS');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
