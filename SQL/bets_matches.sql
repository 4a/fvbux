-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2013 at 05:59 PM
-- Server version: 5.5.28-cll
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cstawr_stream`
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
  `status` enum('open','locked','closed','timeout') NOT NULL,
  `winner` varchar(16) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `bets_matches`
--

INSERT INTO `bets_matches` (`ID`, `Input 1`, `Input 2`, `Mod`, `IP`, `status`, `winner`, `timestamp`) VALUES
(1, 'daygo', 'maygo', 'joe', 0, 'open', '', '0000-00-00 00:00:00'),
(22, 'sgs', 'pj', 'foray', 2130706433, 'open', '', '0000-00-00 00:00:00'),
(25, 'daigo', 'jwong', 'joe', 2130706433, 'open', '', '0000-00-00 00:00:00'),
(27, 'Gootecks', 'Loneliness', '4a4a', 1141223399, 'closed', 'Loneliness', '0000-00-00 00:00:00'),
(28, 'Maya', '4a', '4a4a', 0, 'closed', 'Maya', '0000-00-00 00:00:00'),
(29, 'dwatt21', 'balkanankalkn', 'bobby', 0, 'closed', 'dwatt21', '0000-00-00 00:00:00'),
(30, 'kable', 'balkanankalkn', 'bobby', 0, 'closed', 'balkanankalkn', '0000-00-00 00:00:00'),
(31, 'F Champ', 'Infiltration', 'bobby', 0, 'closed', 'Infiltration', '0000-00-00 00:00:00'),
(32, 'lots of', 'bets', '4a4a', 1141223399, 'closed', 'bets', '0000-00-00 00:00:00'),
(33, 'SirRick', 'Site Layout', 'SirRick', 1286226743, 'open', '', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
