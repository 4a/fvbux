-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2013 at 12:08 PM
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
-- Table structure for table `user_meta`
--

CREATE TABLE IF NOT EXISTS `user_meta` (
  `uid` int(11) NOT NULL,
  `gravemail` varchar(50) NOT NULL,
  `location` varchar(16) NOT NULL,
  `lat` decimal(11,8) DEFAULT NULL,
  `long` decimal(11,8) DEFAULT NULL,
  `GGPO` varchar(16) NOT NULL,
  `LIVE` varchar(16) NOT NULL,
  `PSN` varchar(16) NOT NULL,
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`uid`, `gravemail`, `location`, `lat`, `long`, `GGPO`, `LIVE`, `PSN`) VALUES
(5, 'furryforay@gmail.com', 'socal', 33.00000000, -117.00000000, '4a4a', 'AFTERBIRTH WOO', ''),
(6, 'test', '', 0.00000000, 0.00000000, '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
