-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2013 at 05:24 AM
-- Server version: 5.5.30-cll
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
-- Table structure for table `user_meta`
--

CREATE TABLE IF NOT EXISTS `user_meta` (
  `uid` varchar(16) NOT NULL,
  `gravemail` varchar(50) NOT NULL,
  `location` varchar(16) NOT NULL,
  `lat` decimal(11,8) DEFAULT NULL,
  `long` decimal(11,8) DEFAULT NULL,
  `GGPO` varchar(16) NOT NULL,
  `LIVE` varchar(16) NOT NULL,
  `PSN` varchar(16) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`uid`, `gravemail`, `location`, `lat`, `long`, `GGPO`, `LIVE`, `PSN`) VALUES
('4a4a', 'furryforay@gmail.com', 'socal', 33.53202920, -117.70214800, '4a4a', 'AFTERBIRTH WOO', ''),
('bobby', 'bobby@aol.com', 'Antarctica', -82.00000000, -135.00000000, '', '', ''),
('dan', '', '', NULL, NULL, '', '', ''),
('joe', 'stickystaines@gmail.com', '', 52.00000000, -1.00000000, '', '', ''),
('SirRiCK', 'rick_danto@hotmail.com', 'Los Angeles', 36.00000000, -119.00000000, 'SirRiCK', 'RickDanto', 'RickDanto');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
