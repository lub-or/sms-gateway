-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úte 28. led 2014, 01:06
-- Verze serveru: 5.5.20-log
-- Verze PHP: 5.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `smstools`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `sms_queue`
--

CREATE TABLE IF NOT EXISTS `sms_queue` (
  `id_sms_queue` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(128) DEFAULT NULL,
  `number` varchar(12) NOT NULL,
  `text` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `report` tinyint(1) NOT NULL DEFAULT '0',
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sms_queue`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=805 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;