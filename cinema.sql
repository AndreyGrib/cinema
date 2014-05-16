-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2014 at 06:11 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cinema`
--
CREATE DATABASE `cinema` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cinema`;

-- --------------------------------------------------------

--
-- Table structure for table `cinema`
--

CREATE TABLE IF NOT EXISTS `cinema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cinema`
--

INSERT INTO `cinema` (`id`, `name`) VALUES
(2, 'Nescafe IMAX'),
(1, 'Времена года');

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE IF NOT EXISTS `hall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cinema` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `capacity` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cinema` (`id_cinema`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`id`, `id_cinema`, `name`, `capacity`) VALUES
(1, 1, '1', 10),
(2, 1, '2', 15),
(3, 2, '1', 20),
(4, 2, '2', 25);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `name`) VALUES
(1, '22 минуты'),
(2, 'Варежка'),
(3, 'Ной'),
(4, 'Сердце льва');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_session` int(10) unsigned NOT NULL,
  `place` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_session` (`id_session`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `id_session`, `place`) VALUES
(1, 1, '1'),
(2, 1, '2,4,6'),
(3, 1, '3,7'),
(4, 1, '8'),
(5, 1, '9'),
(6, 1, '5'),
(7, 2, '1,2,3');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_hall` int(10) unsigned NOT NULL,
  `id_movie` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_hall` (`id_hall`),
  KEY `id_movie` (`id_movie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `id_hall`, `id_movie`, `date`) VALUES
(1, 1, 1, '2014-05-16 16:00:00'),
(2, 3, 1, '2014-05-16 16:00:00'),
(3, 1, 2, '2014-05-16 18:00:00'),
(4, 2, 3, '2014-05-16 20:00:00'),
(5, 3, 4, '2014-05-16 15:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
