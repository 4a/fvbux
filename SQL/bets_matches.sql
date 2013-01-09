-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2013 at 06:49 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `bets_matches`
--

INSERT INTO `bets_matches` (`ID`, `Input 1`, `Input 2`, `Mod`, `IP`) VALUES
(1, 'daygo', 'maygo', 'foray1', 0),
(22, 'sgs', 'pj', 'foray', 2130706433),
(23, 'ss', '', 'foray', 2130706433),
(24, 'sss', '', 'foray', 2130706433),
(25, 'daigo', 'jwong', 'joe', 2130706433);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
