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

-- Exportiere Daten aus Tabelle vita_morskov_de.knowledge_level: ~4 rows (ungefähr)
/*!40000 ALTER TABLE `knowledge_level` DISABLE KEYS */;
INSERT IGNORE INTO `knowledge_level` (`id`, `name`, `text`) VALUES
	(1, 'twenty_percent', 'basic'),
	(2, 'forty_percent', 'good'),
	(3, 'sixty_percent', 'advanced'),
	(4, 'eighty_percent', 'verygood');
/*!40000 ALTER TABLE `knowledge_level` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle vita_morskov_de.language: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT IGNORE INTO `language` (`id`, `language`) VALUES
	(1, 'DE'),
	(2, 'EN');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle vita_morskov_de.skills: ~25 rows (ungefähr)
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT IGNORE INTO `skills` (`id`, `name`, `level`, `type`) VALUES
	(25, 'vue', 'eighty_percent', 'misc');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle vita_morskov_de.skill_type: ~4 rows (ungefähr)
/*!40000 ALTER TABLE `skill_type` DISABLE KEYS */;
INSERT IGNORE INTO `skill_type` (`id`, `name`, `text`, `vita_type`) VALUES
	(4, 'misc', 'misc_desc', 'itknowledge');
/*!40000 ALTER TABLE `skill_type` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle vita_morskov_de.system: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `system` DISABLE KEYS */;
INSERT IGNORE INTO `system` (`id`, `name`, `versionnumber`, `text`) VALUES
	(1, 'version', 5, NULL),
	(2, 'header', NULL, 'gen_heading'),
	(3, 'menu', NULL, 'gen_menu_head');
/*!40000 ALTER TABLE `system` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle vita_morskov_de.text_translations: ~84 rows (ungefähr)
/*!40000 ALTER TABLE `text_translations` DISABLE KEYS */;
INSERT IGNORE INTO `text_translations` (`id`, `text`, `language`, `name`) VALUES
	(23, 'Vue.js', 'DE', 'vue'),
	(26, 'Sehr gute Kenntnisse', 'DE', 'verygood'),
	(27, 'Fortgeschrittene Kenntnisse', 'DE', 'advanced'),
	(28, 'Gute Kenntnisse', 'DE', 'good'),
	(29, 'Grundkenntnisse', 'DE', 'basic'),
	(70, 'Weiteres', 'DE', 'misc_desc'),
	(86, 'Menü', 'DE', 'gen_menu_head'),
	(87, 'Lebenslauf', 'DE', 'gen_heading');
/*!40000 ALTER TABLE `text_translations` ENABLE KEYS */;


-- Exportiere Daten aus Tabelle vita_morskov_de.vita_type: ~8 rows (ungefähr)
/*!40000 ALTER TABLE `vita_type` DISABLE KEYS */;
INSERT IGNORE INTO `vita_type` (`id`, `name`, `text`, `animatable`) VALUES
	(4, 'itknowledge', 'it_desc', 0);
/*!40000 ALTER TABLE `vita_type` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
