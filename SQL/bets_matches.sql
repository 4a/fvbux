-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2013 at 02:51 AM
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
-- Table structure for table `bets_matches`
--

CREATE TABLE IF NOT EXISTS `bets_matches` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Input 1` varchar(100) NOT NULL,
  `Input 2` varchar(100) NOT NULL,
  `Mod` varchar(16) NOT NULL,
  `IP` int(11) NOT NULL,
  `status` enum('open','locked','closed') NOT NULL,
  `winner` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `bets_matches`
--

INSERT INTO `bets_matches` (`ID`, `Input 1`, `Input 2`, `Mod`, `IP`, `status`, `winner`) VALUES
(1, 'daygo', 'maygo', 'joe', 0, 'open', ''),
(22, 'sgs', 'pj', 'foray', 2130706433, 'open', ''),
(23, 'ss', '', 'foray', 2130706433, 'open', ''),
(24, 'sss', '', 'foray', 2130706433, 'open', ''),
(25, 'daigo', 'jwong', 'joe', 2130706433, 'open', '');
