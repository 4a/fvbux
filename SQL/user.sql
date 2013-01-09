-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2013 at 06:50 PM
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
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(128) NOT NULL,
  `points` int(8) NOT NULL DEFAULT '0',
  `email` varchar(128) NOT NULL,
  `acclevel` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `points`, `email`, `acclevel`) VALUES
(1, 'joe', '$2a$08$JgUoNqpkE2ydQxYFS5EyGur4/G0gjvRQC5zb2.r9PPRmz9eZyNm7a', 362, 'stickystaines@gmail.com', 'admin'),
(2, 'dan', '$2a$08$dWz4W8/RZ1ZOy7eW9f5feeTPcfVJ9m1mpl0LEUTKA2sKbgdbiiO22', 100, '', 'user'),
(5, '4a4a', '$2a$08$D2XOQrChg/0I1Hy8uIu/N.s1tKomKoojdfQ8ew6HoFX5HYJR9q5Me', 103, '', 'user'),
(6, 'bobby', '$2a$08$PPm90BGCTVusXpDDUrn/W.5Cm1pBwrtNdAw.lmUaFQcCc1jq3ip2y', 100, '', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
