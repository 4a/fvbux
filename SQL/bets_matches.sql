-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2013 at 11:19 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

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
  `status` enum('open','locked','closed','timeout') NOT NULL,
  `winner` varchar(16) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Event` varchar(50) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `isfeatured` enum('no','yes') NOT NULL DEFAULT 'no',
  `img1` varchar(200) NOT NULL,
  `img2` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `bets_matches`
--

INSERT INTO `bets_matches` (`ID`, `Input 1`, `Input 2`, `Mod`, `IP`, `status`, `winner`, `timestamp`, `Event`, `Description`, `isfeatured`, `img1`, `img2`) VALUES
(1, 'daygo', 'maygo', 'joe', 0, 'timeout', '', '2013-02-28 08:00:00', '', '', '', '', ''),
(22, 'sgs', 'pj', 'foray', 2130706433, 'timeout', '', '2013-02-28 08:00:00', '', '', '', '', ''),
(25, 'daigo', 'jwong', 'joe', 2130706433, 'timeout', '', '2013-02-28 08:00:00', '', '', '', '', ''),
(27, 'Gootecks', 'Loneliness', '4a4a', 1141223399, 'timeout', 'Loneliness', '2013-02-28 08:00:00', '', '', '', '', ''),
(28, 'Maya', '4a', '4a4a', 0, 'timeout', 'Maya', '2013-02-28 08:00:00', '', '', '', '', ''),
(29, 'dwatt21', 'balkanankalkn', 'bobby', 0, 'timeout', 'dwatt21', '2013-02-28 08:00:00', '', '', '', '', ''),
(30, 'kable', 'balkanankalkn', 'bobby', 0, 'timeout', 'balkanankalkn', '2013-02-28 08:00:00', '', '', '', '', ''),
(31, 'F Champ', 'Infiltration', 'bobby', 0, 'timeout', 'Infiltration', '2013-02-28 08:00:00', '', '', '', '', ''),
(32, 'lots of', 'bets', '4a4a', 1141223399, 'timeout', 'bets', '2013-02-28 08:00:00', '', '', '', '', ''),
(33, 'SirRick', 'Site Layout', 'SirRick', 1286226743, 'timeout', '', '2013-02-28 08:00:00', '', '', '', '', ''),
(35, 'Daigo', 'Jwong', '4a4a', 2130706433, 'open', '', '2015-03-05 08:00:24', 'EVO 2013 GF', 'testest\nkamak\njoa\nmoooo\nmo\nmomomo\nasauh\nasoiajssaoijsa\namakmakmkmsakmksamkmsa\naoakosiois', 'no', 'http://i.imgur.com/87287.png', 'http://i.imgur.com/87287.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
