-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2013 at 03:43 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `bets_money`
--

CREATE TABLE IF NOT EXISTS `bets_money` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `match` int(255) NOT NULL,
  `username 1` varchar(16) NOT NULL,
  `username 2` varchar(16) NOT NULL,
  `value` int(255) NOT NULL,
  `odds` float(10,3) NOT NULL DEFAULT '1.000',
  `IP` int(11) NOT NULL,
  `status` enum('open','locked','closed') NOT NULL,
  `private` tinyint(1) NOT NULL,
  `user1choice` varchar(255) NOT NULL,
  `winner` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `bets_money`
--

INSERT INTO `bets_money` (`ID`, `match`, `username 1`, `username 2`, `value`, `odds`, `IP`, `status`, `private`, `user1choice`, `winner`) VALUES
(1, 0, '', '', 1, 1.500, 0, 'open', 0, '', ''),
(2, 1, 'foray', '4a4a', 500, 1.000, 2130706433, 'locked', 0, '', ''),
(6, 1, 'foray', '', 500, 1.000, 2130706433, 'open', 0, '', ''),
(9, 1, 'joe', '', 21, 1.000, 2130706433, 'open', 1, 'daygo', ''),
(10, 1, '4a4a', '', 1009, 1.000, 2130706433, 'open', 0, 'maygo', ''),
(11, 25, '4a4a', '', 8, 1.000, 2130706433, 'open', 0, 'jwong', ''),
(12, 25, '4a4a', '', 6, 1.000, 2130706433, 'open', 1, 'daigo', ''),
(13, 1, '4a4a', '', 500, 1.000, 2130706433, 'open', 0, 'daygo', '');
