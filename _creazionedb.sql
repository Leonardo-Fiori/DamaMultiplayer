DROP DATABASE IF EXISTS dama_online;

SET NAMES latin1;
SET FOREIGN_KEY_CHECKS = 0;

BEGIN;
CREATE DATABASE `dama_online`;
COMMIT;

USE `dama_online`;

-- Creo tabella partite.
-- Qua verranno salvate le istanze.

DROP TABLE IF EXISTS `Partite`;
CREATE TABLE `Partite` (
  `id_match` int(50) AUTO_INCREMENT NOT NULL,
  `id_utente1` int(50) NOT NULL,
  `id_utente2` int(50) NOT NULL,
  `ultimo_turno` int(50) DEFAULT NULL,
  `finito` int(50) DEFAULT NULL,
  `muovi_da` int(50) NOT NULL,
  `muovi_a` int(50) NOT NULL,
  PRIMARY KEY (`id_match`)

  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

-- Creo la tabella utenti.
-- Qua verranno salvati i dati utente.

DROP TABLE IF EXISTS `Utenti`;
CREATE TABLE `Utenti` (
  `id_utente` int(50) AUTO_INCREMENT NOT NULL,
  `nickname` char(50) NOT NULL,
  `pass` char(50) NOT NULL,
  `ora_online` boolean DEFAULT false,
  PRIMARY KEY (`id_utente`,`nickname`)

  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

-- Creo la tabella chat.
-- Qua verranno salvati i post.

DROP TABLE IF EXISTS `Chat`;
CREATE TABLE `Chat` (
  `id_post` int(50) AUTO_INCREMENT NOT NULL,
  `nickname` char(50) NOT NULL,
  `timestmp` timestamp NOT NULL,
  `messaggio` text NOT NULL,
  PRIMARY KEY (`id_post`)

  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

-- Creo la tabella chat locale.
-- Qua verranno salvati i post 
-- scritti tra due avversari durante un match.

DROP TABLE IF EXISTS `Chat_Locale`;
CREATE TABLE `Chat_Locale` (
  `id_post` int(50) AUTO_INCREMENT NOT NULL,
  `nickname` char(50) NOT NULL,
  `timestmp` timestamp NOT NULL,
  `messaggio` text NOT NULL,
  `match_id` int(50) NOT NULL,
  PRIMARY KEY (`id_post`)

  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;