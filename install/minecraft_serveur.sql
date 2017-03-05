-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.2.3-MariaDB-10.2.3+maria~xenial - mariadb.org binary distribution
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour spigot
CREATE DATABASE IF NOT EXISTS `spigot` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `spigot`;

-- Export de la structure de la table spigot. bannissement
CREATE TABLE IF NOT EXISTS `{{TBLPREFIX}}bannissement` (
  `idban` int(11) NOT NULL AUTO_INCREMENT,
  `motif` longtext DEFAULT NULL,
  PRIMARY KEY (`idban`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Export de la structure de la table spigot. levelutilisateur
CREATE TABLE IF NOT EXISTS `{{TBLPREFIX}}levelutilisateur` (
  `lvlmembre` int(11) NOT NULL AUTO_INCREMENT,
  `lvlname` varchar(64) NOT NULL,
  PRIMARY KEY (`lvlmembre`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Export de la structure de la table spigot. session
CREATE TABLE IF NOT EXISTS `{{TBLPREFIX}}session` (
  `idsession` int(11) NOT NULL AUTO_INCREMENT,
  `sessionhash` varchar(255) NOT NULL,
  `expire` timestamp NULL DEFAULT NULL,
  `utilisateurs_iduser` int(11) NOT NULL,
  PRIMARY KEY (`idsession`),
  KEY `fk_session_utilisateurs1_idx` (`utilisateurs_iduser`),
  CONSTRAINT `fk_session_utilisateurs1` FOREIGN KEY (`utilisateurs_iduser`) REFERENCES `{{TBLPREFIX}}utilisateurs` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Export de la structure de la table spigot. utilisateurs
CREATE TABLE IF NOT EXISTS `{{TBLPREFIX}}utilisateurs` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID de l''utilisateur',
  `username` varchar(20) NOT NULL COMMENT 'Nom d el''utilisateur',
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ipuser` int(10) unsigned NOT NULL,
  `bannissement` tinyint(1) NOT NULL DEFAULT 0,
  `levelutilisateur_lvlmembre` int(11) NOT NULL,
  PRIMARY KEY (`iduser`),
  KEY `idx_utilisateurs_iduser` (`iduser`),
  KEY `fk_utilisateurs_levelutilisateur1_idx` (`levelutilisateur_lvlmembre`),
  CONSTRAINT `fk_utilisateurs_levelutilisateur1` FOREIGN KEY (`levelutilisateur_lvlmembre`) REFERENCES `{{TBLPREFIX}}levelutilisateur` (`lvlmembre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Export de la structure de la table spigot. utilisateurs_bannissement
CREATE TABLE IF NOT EXISTS `{{TBLPREFIX}}utilisateurs_bannissement` (
  `utilisateurs_iduser` int(11) NOT NULL,
  `bannissement_idban` int(11) NOT NULL,
  PRIMARY KEY (`utilisateurs_iduser`,`bannissement_idban`),
  KEY `fk_utilisateurs_bannissement_bannissement1_idx` (`bannissement_idban`),
  KEY `fk_utilisateurs_bannissement_utilisateurs1_idx` (`utilisateurs_iduser`),
  CONSTRAINT `fk_utilisateurs_bannissement_bannissement1` FOREIGN KEY (`bannissement_idban`) REFERENCES `{{TBLPREFIX}}bannissement` (`idban`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_utilisateurs_bannissement_utilisateurs1` FOREIGN KEY (`utilisateurs_iduser`) REFERENCES `{{TBLPREFIX}}utilisateurs` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
