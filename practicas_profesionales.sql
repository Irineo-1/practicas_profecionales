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
  `numero_control` varchar(50) NOT NULL DEFAULT '0',
  `nombre_completo` varchar(200) NOT NULL DEFAULT '0',
  `especialidad` varchar(200) NOT NULL DEFAULT '0',
  `turno` varchar(40) NOT NULL DEFAULT '0',
  `numero_proceso` int(11) NOT NULL DEFAULT 0,
  `institucion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_control` (`numero_control`)
) ENGINE=InnoDB AUTO_INCREMENT=439 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table practicas_profesionales.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_control` varchar(100) NOT NULL DEFAULT '0',
  `nombre_documento` varchar(150) NOT NULL DEFAULT '0',
  `proceso` varchar(150) NOT NULL DEFAULT '0',
  `estatus` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `FK1_documents_user` (`numero_control`),
  CONSTRAINT `FK1_documents_user` FOREIGN KEY (`numero_control`) REFERENCES `alumnos` (`numero_control`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table practicas_profesionales.instituciones
CREATE TABLE IF NOT EXISTS `instituciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(100) NOT NULL DEFAULT '0',
  `nombre_titular` varchar(200) DEFAULT '',
  `puesto_titular` varchar(100) DEFAULT '',
  `RFC` varchar(100) DEFAULT '',
  `direccion` varchar(200) DEFAULT '',
  `telefono` varchar(50) DEFAULT '',
  `correo` varchar(100) DEFAULT '',
  `nombre_testigo` varchar(100) DEFAULT '',
  `puesto_testigo` varchar(100) DEFAULT '',
  `entidad_federativa` varchar(100) NOT NULL DEFAULT '',
  `clave_centro` varchar(100) NOT NULL DEFAULT '',
  `tipo_institucion` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table practicas_profesionales.maestros
CREATE TABLE IF NOT EXISTS `maestros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(200) NOT NULL DEFAULT '',
  `puesto` varchar(70) DEFAULT '',
  `turno` varchar(40) DEFAULT '',
  `password` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
