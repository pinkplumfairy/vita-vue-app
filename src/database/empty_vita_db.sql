-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.7.19 - MySQL Community Server (GPL)
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Struktur von Tabelle vita_morskov_de.knowledge_level
CREATE TABLE IF NOT EXISTS `knowledge_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `text` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `text` (`text`),
  CONSTRAINT `knowledge_text` FOREIGN KEY (`text`) REFERENCES `text_translations` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.language
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` char(2) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.skills
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `level` (`level`),
  KEY `type` (`type`),
  CONSTRAINT `skill_level` FOREIGN KEY (`level`) REFERENCES `knowledge_level` (`name`),
  CONSTRAINT `skill_translation` FOREIGN KEY (`name`) REFERENCES `text_translations` (`name`),
  CONSTRAINT `skill_type` FOREIGN KEY (`type`) REFERENCES `skill_type` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.skill_type
CREATE TABLE IF NOT EXISTS `skill_type` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `text` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `vita_type` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `text` (`text`),
  KEY `sktype_vitype` (`vita_type`),
  CONSTRAINT `sktype_translation` FOREIGN KEY (`text`) REFERENCES `text_translations` (`name`),
  CONSTRAINT `sktype_vitype` FOREIGN KEY (`vita_type`) REFERENCES `vita_type` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.system
CREATE TABLE IF NOT EXISTS `system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `versionnumber` int(11) DEFAULT NULL,
  `text` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sys_translations` (`text`),
  CONSTRAINT `sys_translations` FOREIGN KEY (`text`) REFERENCES `text_translations` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.text_translations
CREATE TABLE IF NOT EXISTS `text_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(1000) COLLATE latin1_general_ci NOT NULL,
  `language` char(2) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`language`),
  KEY `language` (`language`),
  CONSTRAINT `translation_language` FOREIGN KEY (`language`) REFERENCES `language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.vita_elements
CREATE TABLE IF NOT EXISTS `vita_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `vita_value_translation` (`value`),
  CONSTRAINT `vita_name_translation` FOREIGN KEY (`name`) REFERENCES `text_translations` (`name`),
  CONSTRAINT `vita_type_fk` FOREIGN KEY (`type`) REFERENCES `vita_type` (`name`),
  CONSTRAINT `vita_value_translation` FOREIGN KEY (`value`) REFERENCES `text_translations` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle vita_morskov_de.vita_type
CREATE TABLE IF NOT EXISTS `vita_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `text` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `animatable` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `text` (`text`),
  CONSTRAINT `vitatype_translation` FOREIGN KEY (`text`) REFERENCES `text_translations` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
