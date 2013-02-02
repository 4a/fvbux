-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2013 at 05:58 PM
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
  `status` enum('open','locked','closed','timeout') NOT NULL,
  `private` tinyint(1) NOT NULL,
  `user1choice` varchar(255) NOT NULL,
  `winner` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `bets_money`
--

INSERT INTO `bets_money` (`ID`, `match`, `username 1`, `username 2`, `value`, `odds`, `IP`, `status`, `private`, `user1choice`, `winner`) VALUES
(1, 0, '', '', 1, 1.500, 0, 'open', 0, '', ''),
(2, 1, 'foray', '4a4a', 500, 1.000, 2130706433, 'locked', 0, '', ''),
(6, 1, 'foray', '', 500, 1.000, 2130706433, 'open', 0, '', ''),
(9, 1, 'joe', '', 21, 1.000, 2130706433, 'open', 1, 'daygo', ''),
(10, 1, '4a4a', '', 1009, 1.000, 2130706433, 'open', 0, 'maygo', ''),
(12, 25, '4a4a', '', 6, 1.000, 2130706433, 'open', 1, 'daigo', ''),
(13, 27, '4a4a', '', 500, 1.000, 2130706433, 'open', 0, 'daygo', '4a4a'),
(14, 28, 'bobby', 'joe', 5, 1.000, 1141223399, 'closed', 0, 'Maya', 'bobby'),
(15, 28, 'dan', 'joe', 8, 1.000, 1141223399, 'closed', 0, 'Maya', 'dan'),
(16, 29, '4a4a', 'joe', 10, 1.000, 1141223399, 'closed', 0, 'dwatt21', '4a4a'),
(17, 30, 'joe', '4a4a', 20, 1.000, 1840246813, 'closed', 0, 'kable', '4a4a'),
(18, 31, 'joe', '4a4a', 100, 1.000, 1840246813, 'closed', 0, 'F Champ', '4a4a'),
(19, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(20, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(21, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(22, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(23, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(24, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(25, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(26, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(27, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(28, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(29, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(30, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(31, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(32, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(33, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(34, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(35, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(36, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(37, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(38, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(39, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(40, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(41, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(42, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(43, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(44, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(45, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(46, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(47, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(48, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(49, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(50, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(51, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(52, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(53, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(54, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(55, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(56, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(57, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(58, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(59, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(60, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(61, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(62, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(63, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(64, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(65, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(66, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(67, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(68, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan'),
(69, 32, 'dan', 'bobby', 1, 1.000, 1840246813, 'locked', 0, 'bets', 'dan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
