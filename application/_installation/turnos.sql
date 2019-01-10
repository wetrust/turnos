CREATE DATABASE  IF NOT EXISTS `turnos` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `turnos`;
-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: turnos
-- ------------------------------------------------------
-- Server version	5.7.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `comentario_id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario_fecha` date NOT NULL,
  `comentario_text` longtext COLLATE utf8_unicode_ci,
  `comentario_profesional` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `departamento_id` int(11) NOT NULL,
  PRIMARY KEY (`comentario_id`),
  UNIQUE KEY `comentario_id_UNIQUE` (`comentario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (4,'2018-10-01','Turno nocturno hecho a Dc. JR. Ferrada',NULL,2),(5,'2018-10-18','Cuatro ( 4 ) primeras horas de posta 4 x 4',NULL,2),(6,'2018-12-05','Cambalache x turno completo noviembre 24',NULL,2),(7,'2018-12-22','Turno completo a Macarena',NULL,2),(8,'2018-10-16','Turno nocturno hecho a Dc. JR. Ferrada',NULL,2),(9,'2018-11-11','JR. Ferrada devuelve noche de turno, hecho en Octubre 30',NULL,2),(10,'2018-11-08','',NULL,2),(11,'2018-11-06','',NULL,2),(12,'2018-11-12','Cambalache con W. Krause de 24 horas por día anterior',NULL,2),(13,'2018-12-14','',NULL,2),(14,'2018-11-05','Dc. Nicolas Baeza devuelve 12 hrs Dia',NULL,2),(15,'2018-11-09','',NULL,2),(16,'2018-11-24','Cambalache con Douglas Graf x Turno completo de XII 05',NULL,2),(17,'2018-12-12','Cambalache Día x Día devuelta el Día 19 de Diciembre',NULL,2),(18,'2018-12-19','Cambalache Día x Día devuelta el Día 12 de Diciembre',NULL,2),(19,'2018-11-18','Cubrimos turno completo, (Dia y Nocne) a Dc. Sergio Romero',NULL,2),(20,'2018-12-02','comentario',NULL,6),(21,'2018-12-27','Día devolución de antigua deuda',NULL,2),(22,'2018-12-30','Turno completo a Fdo. Abarzua',NULL,2),(23,'2018-12-24','Noche al Viejo Pascuero',NULL,2),(24,'2019-01-02','',NULL,2),(25,'2019-01-28','De 08  a  13 hrs Dr. Walter Krause',NULL,2),(26,'2019-01-29','Cambalache a Fdo. A.',NULL,2);
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_turno`
--

DROP TABLE IF EXISTS `default_turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_turno` (
  `default_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_profesional` int(11) NOT NULL,
  `default_fecha` date NOT NULL,
  `turno_departamento` int(11) NOT NULL,
  PRIMARY KEY (`default_id`),
  UNIQUE KEY `default_id_UNIQUE` (`default_id`),
  KEY `fk_default_turno_profesional_idx` (`turno_profesional`),
  KEY `fk_default_turno_departamento_idx` (`turno_departamento`),
  CONSTRAINT `fk_default_turno_departamento` FOREIGN KEY (`turno_departamento`) REFERENCES `departamentos` (`departamento_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_default_turno_profesional` FOREIGN KEY (`turno_profesional`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_turno`
--

LOCK TABLES `default_turno` WRITE;
/*!40000 ALTER TABLE `default_turno` DISABLE KEYS */;
INSERT INTO `default_turno` VALUES (1,47,'2019-01-02',2),(2,50,'2019-01-01',2),(3,53,'2019-01-03',2),(5,40,'2019-01-05',2),(6,51,'2019-01-04',2),(7,39,'2019-01-06',2),(8,50,'2019-01-07',2),(9,43,'2019-01-08',2),(10,56,'2019-01-09',2),(11,54,'2019-01-10',2),(12,36,'2019-01-11',2),(13,41,'2019-01-12',2),(14,42,'2019-01-13',2),(15,44,'2019-01-14',2),(16,45,'2019-01-15',2),(17,52,'2019-01-17',2),(18,50,'2019-01-16',2),(20,38,'2019-01-18',2),(22,51,'2019-01-19',2),(23,40,'2019-01-20',2),(24,50,'2019-01-31',2),(25,41,'2019-01-30',2),(26,44,'2019-01-29',2),(27,38,'2019-01-24',2),(28,54,'2019-01-25',2),(29,36,'2019-01-26',2),(30,38,'2019-01-27',2),(32,43,'2019-01-23',2),(33,39,'2019-01-21',2),(34,50,'2019-01-22',2),(35,47,'2019-02-01',2),(36,48,'2019-02-02',2),(37,51,'2019-02-03',2),(38,40,'2019-02-04',2),(39,39,'2019-02-05',2),(40,50,'2019-02-06',2),(41,43,'2019-02-07',2),(42,56,'2019-02-08',2),(43,54,'2019-02-09',2),(44,36,'2019-02-10',2),(45,41,'2019-02-11',2),(46,42,'2019-02-12',2),(47,44,'2019-02-13',2),(48,45,'2019-02-14',2),(49,50,'2019-02-15',2),(50,52,'2019-02-16',2),(51,44,'2019-01-28',2),(52,44,'2019-02-28',2),(53,42,'2019-02-27',2),(54,38,'2019-02-23',2),(55,54,'2019-02-24',2),(56,36,'2019-02-25',2),(57,38,'2019-02-26',2),(58,43,'2019-02-22',2),(59,50,'2019-02-21',2),(60,38,'2019-02-17',2),(61,51,'2019-02-18',2),(62,40,'2019-02-19',2),(63,39,'2019-02-20',2),(64,41,'2019-03-01',2),(65,50,'2019-03-02',2),(66,47,'2019-03-03',2),(67,49,'2019-03-04',2),(68,51,'2019-03-05',2),(69,51,'2019-03-20',2),(70,40,'2019-03-06',2),(71,39,'2019-03-07',2),(72,50,'2019-03-08',2),(73,43,'2019-03-09',2),(74,56,'2019-03-10',2),(75,54,'2019-03-11',2),(76,36,'2019-03-12',2),(77,41,'2019-03-13',2),(78,42,'2019-03-14',2),(79,44,'2019-03-15',2),(80,45,'2019-03-16',2),(81,50,'2019-03-17',2),(82,52,'2019-03-18',2),(83,38,'2019-03-19',2),(84,45,'2019-03-31',2),(85,44,'2019-03-30',2),(86,50,'2019-03-23',2),(87,43,'2019-03-24',2),(88,42,'2019-03-29',2),(89,38,'2019-03-28',2),(90,36,'2019-03-27',2),(91,54,'2019-03-26',2),(92,38,'2019-03-25',2),(93,40,'2019-03-21',2),(94,38,'2019-03-22',2),(95,41,'2018-12-31',2),(96,50,'2019-04-01',2),(97,50,'2019-04-01',2),(98,47,'2019-04-02',2),(99,53,'2019-04-03',2),(100,51,'2019-04-04',2),(101,40,'2019-04-05',2),(102,39,'2019-04-06',2),(103,39,'2019-04-06',2),(104,50,'2019-04-07',2),(105,51,'2019-04-19',2),(106,41,'2019-04-30',2),(107,38,'2019-04-18',2),(108,52,'2019-04-17',2),(109,50,'2019-04-16',2),(110,45,'2019-04-15',2),(111,40,'2019-12-01',2),(112,40,'2019-12-16',2),(113,40,'2019-12-31',2),(114,51,'2019-12-15',2),(115,51,'2019-12-30',2),(116,51,'2019-11-30',2),(117,51,'2019-11-15',2),(118,51,'2019-10-01',2),(119,51,'2019-10-16',2),(120,51,'2019-10-31',2),(121,40,'2019-09-17',2),(122,51,'2019-09-16',2),(123,51,'2019-09-01',2),(124,51,'2019-08-02',2),(125,51,'2019-08-02',2),(126,51,'2019-08-02',2),(127,51,'2019-08-17',2),(128,51,'2019-07-03',2),(129,51,'2019-07-18',2),(130,51,'2019-06-18',2),(131,51,'2019-06-03',2),(132,51,'2019-05-04',2),(133,51,'2019-05-19',2),(134,40,'2019-05-05',2),(135,40,'2019-06-04',2),(138,40,'2019-10-17',2),(139,40,'2019-08-18',2),(140,40,'2019-10-02',2);
/*!40000 ALTER TABLE `default_turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `departamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `departamento_name` varchar(100) NOT NULL,
  `departamento_jefe` int(11) NOT NULL,
  PRIMARY KEY (`departamento_id`),
  UNIQUE KEY `departamento_id_UNIQUE` (`departamento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (2,'Gineco Obstetricia',55),(6,'Medicina',43),(7,'Anestesia',58),(8,'Cirugia',54),(9,'Pediatria',36),(10,'UCI',36),(11,'Pabellón',49),(12,'Neonatologia',44);
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turnos`
--

DROP TABLE IF EXISTS `turnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turnos` (
  `turno_id` int(10) NOT NULL AUTO_INCREMENT,
  `turno_profesional` int(11) NOT NULL,
  `turno_fechain` date NOT NULL,
  `turno_turno` int(11) NOT NULL,
  `turno_departamento` int(11) NOT NULL,
  PRIMARY KEY (`turno_id`),
  UNIQUE KEY `turno_id_UNIQUE` (`turno_id`)
) ENGINE=InnoDB AUTO_INCREMENT=476 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turnos`
--

LOCK TABLES `turnos` WRITE;
/*!40000 ALTER TABLE `turnos` DISABLE KEYS */;
INSERT INTO `turnos` VALUES (3,50,'2018-11-02',0,2),(4,50,'2018-11-02',1,2),(5,47,'2018-11-03',0,2),(6,47,'2018-11-03',1,2),(7,48,'2018-11-04',0,2),(8,48,'2018-11-04',1,2),(9,50,'2018-11-05',0,2),(10,36,'2018-11-05',1,2),(11,40,'2018-11-06',0,2),(12,40,'2018-11-06',1,2),(13,38,'2018-11-07',0,2),(14,36,'2018-11-07',1,2),(15,50,'2018-11-08',0,2),(16,50,'2018-11-08',1,2),(17,43,'2018-11-09',0,2),(18,43,'2018-11-09',1,2),(19,38,'2018-11-10',0,2),(20,38,'2018-11-10',1,2),(21,36,'2018-11-11',0,2),(22,37,'2018-11-11',1,2),(23,36,'2018-11-12',1,2),(24,39,'2018-11-13',0,2),(25,41,'2018-11-13',1,2),(26,39,'2018-11-14',0,2),(27,50,'2018-11-14',1,2),(28,41,'2018-11-15',0,2),(29,45,'2018-11-16',0,2),(30,45,'2018-11-16',1,2),(31,50,'2018-11-17',0,2),(32,50,'2018-11-17',1,2),(33,36,'2018-11-18',0,2),(34,41,'2018-11-18',1,2),(35,51,'2018-11-19',0,2),(36,51,'2018-11-19',1,2),(37,39,'2018-11-20',0,2),(38,38,'2018-11-20',1,2),(39,40,'2018-11-21',0,2),(40,40,'2018-11-21',1,2),(41,39,'2018-11-22',0,2),(42,39,'2018-11-23',0,2),(43,50,'2018-11-23',1,2),(44,36,'2018-11-24',0,2),(45,36,'2018-11-24',1,2),(46,39,'2018-11-25',0,2),(47,38,'2018-11-25',1,2),(48,38,'2018-11-27',0,2),(49,54,'2018-11-27',1,2),(50,38,'2018-11-28',0,2),(51,42,'2018-11-28',1,2),(52,42,'2018-11-29',0,2),(53,41,'2018-11-29',1,2),(54,42,'2018-11-30',0,2),(55,36,'2018-11-30',1,2),(56,42,'2018-11-22',1,2),(57,36,'2018-12-01',0,2),(58,36,'2018-12-01',1,2),(59,50,'2018-12-02',0,2),(60,50,'2018-12-02',1,2),(61,47,'2018-12-03',0,2),(62,47,'2018-12-03',1,2),(63,38,'2018-12-04',1,2),(64,38,'2018-12-04',0,2),(65,49,'2018-12-04',1,2),(66,43,'2018-12-05',0,2),(67,43,'2018-12-05',1,2),(68,40,'2018-12-06',0,2),(69,40,'2018-12-06',1,2),(70,39,'2018-12-07',0,2),(71,39,'2018-12-07',1,2),(72,50,'2018-12-08',0,2),(73,50,'2018-12-08',1,2),(74,43,'2018-12-09',0,2),(75,43,'2018-12-09',1,2),(76,38,'2018-12-10',0,2),(77,38,'2018-12-10',1,2),(78,38,'2018-12-12',0,2),(79,41,'2018-12-12',1,2),(80,50,'2018-12-13',0,2),(81,41,'2018-12-13',1,2),(82,42,'2018-12-14',0,2),(83,42,'2018-12-14',1,2),(84,37,'2018-12-15',0,2),(85,37,'2018-12-15',1,2),(86,36,'2018-12-16',0,2),(87,36,'2018-12-16',1,2),(88,50,'2018-12-17',0,2),(89,50,'2018-12-17',1,2),(90,52,'2018-12-18',0,2),(91,52,'2018-12-18',1,2),(92,54,'2018-12-19',0,2),(93,38,'2018-12-19',1,2),(94,51,'2018-12-20',0,2),(95,51,'2018-12-20',1,2),(96,40,'2018-12-21',0,2),(97,42,'2018-12-21',1,2),(98,36,'2018-12-22',0,2),(99,36,'2018-12-22',1,2),(100,50,'2018-12-23',0,2),(101,41,'2018-12-23',1,2),(102,43,'2018-12-24',0,2),(103,36,'2018-12-24',1,2),(104,38,'2018-12-25',0,2),(105,38,'2018-12-25',1,2),(106,54,'2018-12-27',0,2),(107,36,'2018-12-27',1,2),(108,51,'2018-12-28',0,2),(109,55,'2018-12-28',1,2),(110,42,'2018-12-29',0,2),(111,42,'2018-12-29',1,2),(112,36,'2018-12-30',0,2),(113,36,'2018-12-30',1,2),(114,41,'2018-12-31',0,2),(115,41,'2018-12-31',1,2),(116,36,'2018-10-01',1,2),(117,38,'2018-10-01',0,2),(118,38,'2018-10-02',0,2),(119,41,'2018-10-02',1,2),(120,50,'2018-10-03',0,2),(121,43,'2018-10-03',1,2),(122,47,'2018-10-04',0,2),(123,47,'2018-10-04',1,2),(124,38,'2018-10-05',0,2),(125,38,'2018-10-05',1,2),(126,40,'2018-10-06',0,2),(127,36,'2018-10-06',1,2),(128,36,'2018-10-07',0,2),(130,40,'2018-10-07',1,2),(131,39,'2018-10-08',0,2),(132,39,'2018-10-08',1,2),(133,50,'2018-10-09',0,2),(134,50,'2018-10-09',1,2),(135,43,'2018-10-10',0,2),(136,43,'2018-10-10',1,2),(137,38,'2018-10-11',0,2),(138,38,'2018-10-11',1,2),(139,41,'2018-10-13',0,2),(140,41,'2018-10-13',1,2),(141,36,'2018-10-14',0,2),(142,36,'2018-10-14',1,2),(143,39,'2018-10-15',0,2),(144,42,'2018-10-15',1,2),(145,36,'2018-10-16',1,2),(146,41,'2018-10-16',0,2),(147,45,'2018-10-17',0,2),(148,45,'2018-10-17',1,2),(149,40,'2018-10-18',0,2),(150,42,'2018-10-18',1,2),(151,38,'2018-10-19',0,2),(152,38,'2018-10-19',1,2),(153,36,'2018-10-20',0,2),(154,36,'2018-10-20',1,2),(155,51,'2018-10-21',0,2),(156,51,'2018-10-21',1,2),(157,39,'2018-10-22',0,2),(158,40,'2018-10-22',1,2),(159,39,'2018-10-23',0,2),(160,39,'2018-10-23',1,2),(161,43,'2018-10-24',0,2),(162,50,'2018-10-24',1,2),(163,43,'2018-10-25',0,2),(164,50,'2018-10-25',1,2),(165,39,'2018-10-26',0,2),(166,41,'2018-10-26',1,2),(167,36,'2018-10-27',0,2),(168,50,'2018-10-27',1,2),(169,36,'2018-10-28',1,2),(170,42,'2018-10-30',0,2),(171,36,'2018-10-30',1,2),(172,38,'2018-10-29',0,2),(173,50,'2018-10-29',1,2),(174,42,'2018-10-30',0,2),(175,44,'2018-10-31',0,2),(176,37,'2018-10-31',1,2),(184,54,'2018-11-12',0,2),(185,54,'2018-11-15',1,2),(186,54,'2018-11-26',0,2),(187,36,'2018-11-26',1,2),(188,54,'2018-12-11',0,2),(189,36,'2018-12-11',1,2),(190,54,'2018-12-26',0,2),(191,54,'2018-12-26',1,2),(192,54,'2018-10-12',0,2),(193,42,'2018-10-12',1,2),(194,54,'2018-10-28',0,2),(195,54,'2018-10-28',1,2),(196,39,'2018-11-13',0,2),(197,41,'2018-11-01',0,2),(198,41,'2018-11-01',1,2),(199,50,'2019-01-01',0,2),(200,50,'2019-01-01',1,2),(201,36,'2019-01-02',0,2),(202,36,'2019-01-02',1,2),(203,50,'2019-01-03',0,2),(204,50,'2019-01-03',1,2),(205,55,'2019-01-04',0,2),(206,36,'2019-01-04',1,2),(207,36,'2019-01-05',0,2),(208,41,'2019-01-05',1,2),(209,38,'2019-01-06',0,2),(210,38,'2019-01-06',1,2),(211,50,'2019-01-07',0,2),(212,50,'2019-01-07',1,2),(213,43,'2019-01-08',0,2),(214,43,'2019-01-08',1,2),(215,56,'2019-01-09',0,2),(216,56,'2019-01-09',1,2),(217,54,'2019-01-10',0,2),(218,54,'2019-01-10',1,2),(219,41,'2019-01-11',0,2),(220,36,'2019-01-11',1,2),(221,50,'2019-01-22',0,2),(222,50,'2019-01-22',1,2),(223,50,'2019-01-31',0,2),(224,36,'2019-01-31',1,2),(225,52,'2019-01-17',0,2),(226,52,'2019-01-17',1,2),(227,40,'2019-01-12',0,2),(228,40,'2019-01-12',1,2),(229,51,'2019-01-13',1,2),(230,51,'2019-01-13',0,2),(231,44,'2019-01-14',0,2),(232,37,'2019-01-14',1,2),(233,50,'2019-01-15',0,2),(234,36,'2019-01-15',1,2),(235,50,'2019-01-16',0,2),(236,50,'2019-01-16',1,2),(237,38,'2019-01-18',0,2),(238,38,'2019-01-18',1,2),(239,36,'2019-01-19',0,2),(240,36,'2019-01-19',1,2),(241,40,'2019-01-20',0,2),(242,42,'2019-01-20',1,2),(243,55,'2019-01-21',0,2),(244,36,'2019-01-21',1,2),(245,43,'2019-01-23',0,2),(246,43,'2019-01-23',1,2),(247,38,'2019-01-24',0,2),(248,38,'2019-01-24',1,2),(249,54,'2019-01-25',0,2),(250,54,'2019-01-25',1,2),(251,36,'2019-01-26',0,2),(252,36,'2019-01-26',1,2),(253,38,'2019-01-27',0,2),(254,42,'2019-01-27',1,2),(255,42,'2019-01-28',0,2),(256,42,'2019-01-28',1,2),(257,50,'2019-01-29',0,2),(258,37,'2019-01-29',1,2),(259,41,'2019-01-30',0,2),(260,41,'2019-01-30',1,2),(261,36,'2018-01-01',0,2),(262,47,'2019-02-01',0,2),(263,47,'2019-02-01',1,2),(264,48,'2019-02-02',0,2),(265,48,'2019-02-02',1,2),(266,36,'2019-02-03',0,2),(267,36,'2019-02-03',1,2),(268,40,'2019-02-04',0,2),(269,40,'2019-02-04',1,2),(270,38,'2019-02-05',0,2),(271,38,'2019-02-05',1,2),(272,50,'2019-02-06',0,2),(273,50,'2019-02-06',1,2),(274,43,'2019-02-07',0,2),(275,43,'2019-02-07',1,2),(276,56,'2019-02-08',0,2),(277,56,'2019-02-08',1,2),(278,54,'2019-02-09',0,2),(279,54,'2019-02-09',1,2),(280,36,'2019-02-10',0,2),(281,36,'2019-02-10',1,2),(282,41,'2019-02-11',0,2),(283,41,'2019-02-11',1,2),(284,38,'2019-02-12',0,2),(285,38,'2019-02-12',1,2),(286,44,'2019-02-13',0,2),(287,37,'2019-02-13',1,2),(288,36,'2019-02-14',0,2),(289,36,'2019-02-14',1,2),(290,50,'2019-02-15',0,2),(291,50,'2019-02-15',1,2),(292,52,'2019-02-16',0,2),(293,52,'2019-02-16',1,2),(294,38,'2019-02-17',0,2),(295,38,'2019-02-17',1,2),(296,51,'2019-02-18',0,2),(297,51,'2019-02-18',1,2),(298,40,'2019-02-19',0,2),(299,40,'2019-02-19',1,2),(300,44,'2019-02-28',0,2),(301,37,'2019-02-28',1,2),(302,54,'2019-02-27',0,2),(303,54,'2019-02-27',1,2),(304,38,'2019-02-26',0,2),(305,38,'2019-02-26',1,2),(306,36,'2019-02-25',0,2),(307,36,'2019-02-25',1,2),(308,54,'2019-02-24',0,2),(309,54,'2019-02-24',1,2),(310,38,'2019-02-23',0,2),(311,38,'2019-02-23',1,2),(312,43,'2019-02-22',0,2),(313,43,'2019-02-22',1,2),(314,50,'2019-02-21',0,2),(315,50,'2019-02-21',1,2),(316,38,'2019-02-20',0,2),(317,38,'2019-02-20',1,2),(318,38,'2019-03-19',0,2),(319,38,'2019-03-19',1,2),(320,38,'2019-03-22',0,2),(321,38,'2019-03-22',1,2),(322,38,'2019-03-25',0,2),(323,38,'2019-03-25',1,2),(324,38,'2019-03-28',0,2),(325,38,'2019-03-28',1,2),(326,45,'2019-03-31',0,2),(327,45,'2019-03-31',1,2),(328,45,'2019-03-16',0,2),(329,45,'2019-03-16',1,2),(330,41,'2019-03-01',0,2),(331,41,'2019-03-01',1,2),(332,44,'2019-03-30',0,2),(333,37,'2019-03-30',1,2),(334,42,'2019-03-29',0,2),(335,42,'2019-03-29',1,2),(336,36,'2019-03-27',0,2),(337,36,'2019-03-27',1,2),(338,54,'2019-03-26',0,2),(339,54,'2019-03-26',1,2),(340,43,'2019-03-24',0,2),(341,43,'2019-03-24',1,2),(342,50,'2019-03-23',0,2),(343,50,'2019-03-23',1,2),(344,40,'2019-03-21',0,2),(345,40,'2019-03-21',1,2),(346,51,'2019-03-20',0,2),(347,51,'2019-03-20',1,2),(348,52,'2019-03-18',0,2),(349,52,'2019-03-18',1,2),(350,50,'2019-03-17',0,2),(351,50,'2019-03-17',1,2),(352,44,'2019-03-15',0,2),(353,37,'2019-03-15',1,2),(354,42,'2019-03-14',0,2),(355,42,'2019-03-14',1,2),(356,41,'2019-03-13',0,2),(357,41,'2019-03-13',1,2),(358,36,'2019-03-12',0,2),(359,36,'2019-03-12',1,2),(360,54,'2019-03-11',0,2),(361,54,'2019-03-11',1,2),(362,56,'2019-03-10',0,2),(363,56,'2019-03-10',1,2),(364,43,'2019-03-09',0,2),(365,43,'2019-03-09',1,2),(366,50,'2019-03-08',0,2),(367,50,'2019-03-08',1,2),(368,39,'2019-03-07',0,2),(369,39,'2019-03-07',1,2),(370,40,'2019-03-06',0,2),(371,40,'2019-03-06',1,2),(372,36,'2019-03-05',0,2),(373,36,'2019-03-05',1,2),(374,49,'2019-03-04',0,2),(375,49,'2019-03-04',1,2),(376,47,'2019-03-03',0,2),(377,47,'2019-03-03',1,2),(378,50,'2019-03-02',0,2),(379,50,'2019-03-02',1,2),(380,37,'2018-12-18',0,4),(381,37,'2018-12-04',0,4),(382,37,'2018-12-04',1,4),(383,45,'2018-12-02',0,6),(384,45,'2018-12-02',1,6),(385,45,'2018-12-09',0,6),(386,45,'2018-12-09',1,6),(387,37,'2018-12-08',0,4),(388,37,'2018-12-08',1,4),(389,59,'2018-12-12',0,9),(390,59,'2018-12-12',1,9),(391,58,'2018-12-03',0,7),(392,58,'2018-12-03',1,7),(393,51,'2018-12-28',0,2),(394,37,'2018-12-30',0,2),(395,37,'2018-12-30',1,2),(396,53,'2019-01-03',0,2),(397,53,'2019-01-03',1,2),(398,50,'2019-04-01',0,2),(399,50,'2019-04-01',1,2),(400,47,'2019-04-02',0,2),(401,47,'2019-04-02',1,2),(402,53,'2019-04-03',0,2),(403,53,'2019-04-03',1,2),(404,36,'2019-04-04',0,2),(405,36,'2019-04-04',1,2),(406,40,'2019-04-05',0,2),(407,40,'2019-04-05',1,2),(408,39,'2019-04-06',0,2),(409,39,'2019-04-06',1,2),(410,50,'2019-04-07',0,2),(411,50,'2019-04-07',1,2),(412,51,'2019-04-19',0,2),(413,51,'2019-04-19',1,2),(414,41,'2019-04-30',0,2),(415,41,'2019-04-30',1,2),(416,38,'2019-04-18',0,2),(417,38,'2019-04-18',1,2),(418,52,'2019-04-17',0,2),(419,52,'2019-04-17',1,2),(420,50,'2019-04-16',0,2),(421,50,'2019-04-16',1,2),(422,45,'2019-04-15',0,2),(423,45,'2019-04-15',1,2),(424,40,'2019-12-01',0,2),(425,40,'2019-12-01',1,2),(426,40,'2019-12-16',0,2),(427,40,'2019-12-16',1,2),(428,40,'2019-12-31',0,2),(429,40,'2019-12-31',1,2),(430,51,'2019-12-15',0,2),(431,51,'2019-12-15',1,2),(432,51,'2019-12-30',0,2),(433,51,'2019-12-30',1,2),(434,51,'2019-11-15',0,2),(435,51,'2019-11-15',1,2),(436,36,'2019-11-30',0,2),(437,36,'2019-11-30',1,2),(438,36,'2019-10-01',0,2),(439,36,'2019-10-01',1,2),(440,51,'2019-10-16',0,2),(441,51,'2019-10-16',1,2),(442,36,'2019-10-31',0,2),(443,36,'2019-10-31',1,2),(444,40,'2019-09-17',0,2),(445,40,'2019-09-17',1,2),(446,51,'2019-09-16',0,2),(447,51,'2019-09-16',1,2),(448,36,'2019-09-01',0,2),(449,36,'2019-09-01',1,2),(450,51,'2019-08-17',0,2),(451,51,'2019-08-17',1,2),(452,36,'2019-08-02',0,2),(453,36,'2019-08-02',1,2),(454,51,'2019-07-18',0,2),(455,51,'2019-07-18',1,2),(456,36,'2019-07-03',0,2),(457,36,'2019-07-03',1,2),(458,36,'2019-06-03',0,2),(459,36,'2019-06-03',1,2),(460,51,'2019-06-18',0,2),(461,51,'2019-06-18',1,2),(462,36,'2019-05-04',0,2),(463,36,'2019-05-04',1,2),(464,51,'2019-05-19',0,2),(465,51,'2019-05-19',1,2),(466,40,'2019-05-05',0,2),(467,40,'2019-05-05',1,2),(468,40,'2019-06-04',0,2),(469,40,'2019-06-04',1,2),(470,40,'2019-10-17',0,2),(471,40,'2019-10-17',1,2),(472,40,'2019-08-18',0,2),(473,40,'2019-08-18',1,2),(474,40,'2019-10-02',0,2),(475,40,'2019-10-02',1,2);
/*!40000 ALTER TABLE `turnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_departamento`
--

DROP TABLE IF EXISTS `user_departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_departamento` (
  `user_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`departamento_id`),
  KEY `fk_user_departamento_departamento_id_idx` (`departamento_id`),
  CONSTRAINT `fk_user_departamento_departamento_id` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`departamento_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_departamento_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_departamento`
--

LOCK TABLES `user_departamento` WRITE;
/*!40000 ALTER TABLE `user_departamento` DISABLE KEYS */;
INSERT INTO `user_departamento` VALUES (36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(45,6),(58,7),(59,9);
/*!40000 ALTER TABLE `user_departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `session_id` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'stores session cookie id to prevent session concurrency',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `user_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s deletion status',
  `user_account_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s account type (basic, premium, etc)',
  `user_has_avatar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if user has a local avatar, 0 if not',
  `user_remember_me_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `user_creation_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the creation of user''s account',
  `user_suspension_timestamp` bigint(20) DEFAULT NULL COMMENT 'Timestamp till the end of a user suspension',
  `user_last_login_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of user''s last login',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attempts',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_provider_type` text COLLATE utf8_unicode_ci,
  `user_rut` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_telefono` int(11) DEFAULT NULL,
  `user_nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (33,NULL,'admincat','$2y$10$lIHG3oqDMMonf8Y5U1zj6.G44Cbmiks.Pu4sOZ1fztA.OoZ4GhtrK','admincat@cat.cl',1,0,6,0,NULL,1541702350,NULL,1547036816,0,NULL,'9ac39aa48e2078b6ab6072612d59c9ffb39c6e8c',NULL,NULL,'DEFAULT','',0,NULL),(35,NULL,'cristopher','$2y$10$0Zoaon0lZlWn3GCs70OCOOHNZLljCxzB0EQq0UxshAEL0DLidZpXC','cristophernic@live.cl',1,0,6,0,NULL,1541954254,NULL,1546646869,0,NULL,'43ff6987d317aafefd79273317bcb2338738565f',NULL,NULL,'DEFAULT','177266280',123456789,NULL),(36,NULL,'lagos','$2y$10$LmFt1xzsulUpBsVmIfbUtulNHyhDrthUcxT.SgI9T9EUi7/QiR9ay','r.lagos@cat.cl',1,0,2,0,NULL,1541955469,NULL,1546987907,0,NULL,'0043f718060dd151bd09d7ca7dbfb36870435041',NULL,NULL,'DEFAULT','65884003',998732725,'Rdo. Lagos'),(37,NULL,'ferrada','$2y$10$VRR.Gx.9mv6UZVNxXZM6auTPPiOPdzL9vDMlhsQZbkv0LtOkcwOci','r.ferrada@cat.cl',1,0,2,0,NULL,1541977784,NULL,1543418265,0,NULL,'968904b5b7c33e810c45a5df65e0fac4ea55dc33',NULL,NULL,'DEFAULT','68270677',994436079,'Rbto. Ferrada'),(38,NULL,'fernandez','$2y$10$E/eiDqage5B.kwY3bOx.GeLuiipO.EsKOctWeOeYreQVqtsiuOf3G','c.fernandez@cat.cl',1,0,2,0,NULL,1542067250,NULL,1546053831,0,NULL,'1bc62b999f997fb1d43878f6eb5ccb146026507b',NULL,NULL,'DEFAULT','',452,'Claudia Fernandez'),(39,NULL,'espinoza','$2y$10$5xDJM66kLn1inAPETACZs.I2TxHOFwXt1P5kA00ujNqVk0Smw40p6','m.espinoza@cat.cl',1,0,2,0,NULL,1542067358,NULL,1544473697,0,NULL,'4d9e00696eab5178989caeaa5cf44738e69fec66',NULL,NULL,'DEFAULT','',452,'Maca Espinoza'),(40,'6e8e2a0957ef9353014956a3caa3edd0','rogazy','$2y$10$0XcTblE9rOQ4v/Mh7T6L4ufqzMeFbRA/stzZ/HK.SoGAaLQSsQlz2','m.rogazy@cat.cl',1,0,2,0,NULL,1542067407,NULL,1544369971,0,NULL,'4f4f82201d77767ee4e7fc9f19bf8947fe11d875',NULL,NULL,'DEFAULT','',452,'Milen Rogazy'),(41,'3cc2daa973a8ad8d83fdc73abf3a0dea','castagnoli','$2y$10$xHbEujlJsfGLOJCobDGuCOyM3.sZoENlDnGTkrO0zctzHkdpRTVPi','n.castagnoli@cat.cl',1,0,2,0,NULL,1542067470,NULL,1546774210,0,NULL,'9af0b9022dd8ef7d2c7efdb1d9e4f48b1a0ba535',NULL,NULL,'DEFAULT','',98470743,'Natalia Castagnoli'),(42,NULL,'ppino','$2y$10$QXcjHn5fAlxIvXEG0KTuReVHMpx7Xg2r55kwo6dIg9v7qviE6FkkO','p.pino@cat.cl',1,0,2,0,NULL,1542067526,NULL,1546853504,0,NULL,'4be04b040bbf9ce61d4f13b685a1cc64214ad539',NULL,NULL,'DEFAULT','',452,'Paola Pino'),(43,NULL,'graf','$2y$10$Fc12Mxp0GhzO9t9X0.sycurDPe9Gqtu9Ln/as4zzl12PyaKHX8ccu','d.graf@cat.cl',1,0,2,0,NULL,1542067681,NULL,1545775758,0,NULL,'57bcd8bade6d4b7de1733dc92a8c03b5e682ec05',NULL,NULL,'DEFAULT','',452,'Douglas Graf'),(44,'7e467f789a962b2e0e6b5f55f1c87ae0','abarzua','$2y$10$vTr7u6sC3URpt355HT4u6emijdV3JgjGn/FHeJYZx0.YWnYcyVKau','f.abarzua@cat.cl',1,0,2,0,NULL,1542067714,NULL,1544789531,0,NULL,'7e8d5febd48dca1a5d5d85616e26c2ce53f7cff8',NULL,NULL,'DEFAULT','',452,'Fdo. Abarzua'),(45,NULL,'borquez','$2y$10$mI0BTtwQKVdORP85MEzPa.NVY01g1vKwZDmySPQJl9xAuvMeDAgFm','i.borquez@cat.cl',1,0,2,0,NULL,1542067755,NULL,1545228493,0,NULL,'b080502d3103e5b3a06f6b4e5d40b6769d5f089d',NULL,NULL,'DEFAULT','',452,'Ivan Borquez'),(46,NULL,'sepulveda','$2y$10$tvq1mtFvCIsXFxNA9eXnju7ZBe/7Z2/4DsuhPjFQ6gcSm2qSgS4dC','jd.sepulveda@cat.cl',1,0,2,0,NULL,1542067793,NULL,1542231170,0,NULL,'ac59d025f97166e4d2dbd38d0d830744150b36bb',NULL,NULL,'DEFAULT','',452,'Jd. Sepúlveda'),(47,NULL,'munos','$2y$10$QI6kCMRMpqZyhu12hnNW.u4OZfRUZgDY6NiMrTymV0w5NU20Wb7N2','j.munoz@cat.cl',1,0,2,0,NULL,1542067850,NULL,1542162868,0,NULL,'bc6620bf57cebfc6b0621f9ca9b7df884c437dc2',NULL,NULL,'DEFAULT','',452,'Juan Muñoz'),(48,NULL,'echeverria','$2y$10$AIy.mWbRIgKPS.w38xoJ.eziGfPehDAw1e/oUZCMp1ILJtpZsaVLq','p.echeverria@cat.cl',1,0,2,0,NULL,1542067882,NULL,1542163046,0,NULL,'0b5e6e56807b75e225fb8a3ede48d5f55d673aca',NULL,NULL,'DEFAULT','',452,'P. Echeverria'),(49,NULL,'sanmartin','$2y$10$rFgRnC9mRwndETEyxQJZpePQrCHN3QQSlD2LAuVobC3YO/wQplxVO','n.sanmartin@cat.cl',1,0,2,0,NULL,1542067914,NULL,1543503852,0,NULL,'99417208317421554a3db7dfdd688021c5b62ff9',NULL,NULL,'DEFAULT','',452,'Nestor San Martín'),(50,'5a3d51ea1f9d5e7dc295f998d4f573a6','baeza','$2y$10$wAFUooF1TpzZy4HUaCu.IuRaX.SLzGz6.XK54sZz/4lK3IAVNtNYW','n.baeza@cat.cl',1,0,2,0,NULL,1542067997,NULL,1546868882,0,NULL,'b68ddca955f2a8d1d1f1b0c66e6b4efebbe8ae30',NULL,NULL,'DEFAULT','',452,'Nicolás Baeza'),(51,NULL,'arriagada','$2y$10$jMw/mYrkCRfuhVcd8GQ1.ezKvXoVhktK9j4PY.XeleZHp/dDPKV8S','r.arriagada@cat.cl',1,0,2,0,NULL,1542068077,NULL,1546568439,0,NULL,'ad262f32a5ba8c7e899ef29c160ac071021b0732',NULL,NULL,'DEFAULT','',452,'Rgo. Arriagada'),(52,NULL,'romero','$2y$10$JGpDakufq71enMcUeo8SNuMuMGg45hkDFQUGlWsSLX3aB2Zkq9rpC','s.romero@cat.cl',1,0,2,0,NULL,1542068122,NULL,1542406622,0,NULL,'63f8894b0660e278b0feebf630b251bacf75ff54',NULL,NULL,'DEFAULT','',452,'Sergio Romero'),(53,NULL,'tpino','$2y$10$1MdsdiQLCrHaymknAJZXf.OLH5K5j0XvRCNWIOCmul8lxcDZNOaOK','t.pino@cat.cl',1,0,2,0,NULL,1542068240,NULL,1542163437,0,NULL,'2ec9b447883ada70e20e82d6c6ad113bfde7dbd1',NULL,NULL,'DEFAULT','',452,'Tulio Pino'),(54,'51d066dfee445481977dc36ddeafd20b','krause','$2y$10$aMRyURemYhPyA3GZaX95hOrnu26osz6ATgms34SxNpqMzSR.ORFUy','w.krause@cat.cl',1,0,2,0,NULL,1542134447,NULL,1545666743,4,1546854112,'f6081c8654221bcbc7784059c9f31d48e42f4697',NULL,NULL,'DEFAULT','',997005545,'Walter Krause'),(55,NULL,'meissner','$2y$10$OlbEaI3/2i2vBPttSfG69OIBY/9ETylNLpA85LDVJE9PPyr3i26pW','a.meissner@cat.cl',1,0,2,0,NULL,1542137624,NULL,1546488690,0,NULL,'900dfddd47f6d7b551c0e2235ca4282cbb9c67f5',NULL,NULL,'DEFAULT','',995195643,'Arturo Meissner'),(56,NULL,'GustavoKiekebusch','$2y$10$tr2rjb24hgyxTFnweKWJGe92CfiBAFCuiJ6asp0Zpp29PdnFHUgGu','g.kiekebusch@cat.cl',1,0,2,0,NULL,1544468481,NULL,1544483721,0,NULL,'a41704ecd67bc91a661a0c600de94415b07d3f0e',NULL,NULL,'DEFAULT','1234',1234,'G. Kiekebusch'),(57,NULL,'PhillipCollyer','$2y$10$PqeiZ8osA8edhGkBHqCwZePYsh9cpqzvaiIsrFJlbO7LJFOparJdS','p.collyer@cat.cl',1,0,2,0,NULL,1544555081,NULL,1544558574,0,NULL,'078d4bc8e68975446e89bb8f4e3f060cc16b4a69',NULL,NULL,'DEFAULT','125855512',99694256,'Phllip Collyer'),(58,NULL,'RomilioBaeza','$2y$10$E8qKqHQlh5I2tS4s18gbwOv/qz93PB6YPEQdVP6917VGRW9T3SXKW','r.baeza@cat.cl',1,0,2,0,NULL,1545226193,NULL,1545346040,0,NULL,'5700eb1c5590a6ed9ab30609669f96c9ce719685',NULL,NULL,'DEFAULT','0007',7,'Romilio Baeza'),(59,NULL,'lilyleon','$2y$10$RDrszRw9zYMOcNo0N9u8oeuN2j5/5qDITSgvjZEjCZMF3R48KoChy','lilyleon@cat.cl',1,0,2,0,NULL,1545256299,NULL,1545257494,0,NULL,'d4ea9f4ce66c7fb54b9f9ff17b3efe03003990de',NULL,NULL,'DEFAULT','007',7,'Lily Leon'),(60,NULL,'turnoscat','$2y$10$ftK4w7aS8LHcoHXhmxeDS.h5Ail3sQKsaGmhM5SfJ7/oc1LjOVSmq','turnoscat@cat.cl',1,0,1,0,NULL,1545934216,NULL,1546987718,0,NULL,'9559c2f43c8e95d795f1c8deb61af740b7b95d3f',NULL,NULL,'DEFAULT','111',111,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-09 11:58:13
