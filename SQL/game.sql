-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2013 at 06:09 PM
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
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(50) CHARACTER SET latin1 NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `platform` varchar(16) CHARACTER SET latin1 NOT NULL,
  `filename` varchar(16) CHARACTER SET latin1 NOT NULL,
  `rom` enum('no','yes') CHARACTER SET latin1 NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=50 ;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `group`, `title`, `platform`, `filename`, `rom`) VALUES
(1, 'SNK', 'The King of Fighters ''97', 'GGPO', 'kof97', 'yes'),
(2, 'SNK', 'The King of Fighters ''98', 'GGPO', 'kof98', 'yes'),
(3, 'SNK', 'The King of Fighters 2000', 'GGPO', 'kof2000', 'yes'),
(4, 'SNK', 'The King of Fighters 2002', 'GGPO', 'kof2002', 'yes'),
(5, 'SNK', 'Garou: Mark of the Wolves', 'GGPO', 'garou', 'yes'),
(6, 'SNK', 'Samurai Shodown II', 'GGPO', 'samsho2', 'yes'),
(7, 'SNK', 'Samurai Shodown V Special', 'GGPO', 'samsh5sp', 'yes'),
(8, 'SNK', 'Fatal Fury Special', 'GGPO', 'fatfursp', 'yes'),
(9, 'SNK', 'The Last Blade 2', 'GGPO', 'lastbld2', 'yes'),
(10, 'Capcom', 'Night Warriors: Darkstalkers'' Revenge', 'GGPO', 'nwarr', 'yes'),
(11, 'Capcom', 'Vampire Savior: The Lord of Vampire', 'GGPO', 'vsav', 'yes'),
(12, 'Capcom', 'Cyberbots: Full Metal Madness', 'GGPO', 'cybots', 'yes'),
(13, 'Capcom', 'JoJo''s Bizarre Adventure', 'GGPO', 'jojoba', 'yes'),
(14, 'Capcom', 'Street Fighter Alpha', 'GGPO', 'sfa', 'yes'),
(15, 'Capcom', 'Street Fighter Alpha 2', 'GGPO', 'sfa2', 'yes'),
(16, 'Capcom', 'Street Fighter Alpha 3', 'GGPO', 'sfa3', 'yes'),
(17, 'Capcom', 'Super Street Fighter II Turbo', 'GGPO', 'ssf2t', 'yes'),
(18, 'Capcom', 'Street Fighter III: 3rd Strike', 'GGPO', 'sfiii3', 'yes'),
(19, 'Capcom', 'X-Men: Children of the Atom', 'GGPO', 'xmcota', 'yes'),
(20, 'Capcom', 'X-Men vs. Street Fighter', 'GGPO', 'xmvsf', 'yes'),
(21, 'Capcom', 'Marvel Super Heroes', 'GGPO', 'msh', 'yes'),
(22, 'Capcom', 'Marvel Super Heroes vs. Street Fighter', 'GGPO', 'mshvsf', 'yes'),
(23, 'Capcom', 'Marvel vs. Capcom', 'GGPO', 'mvsc', 'yes'),
(24, 'MISC', 'Breakers Revenge', 'GGPO', 'breakrev', 'yes'),
(25, 'MISC', 'Karnov''s Revenge', 'GGPO', 'karnovr', 'yes'),
(26, 'MISC', 'Galaxy Fight: Universal Warriors', 'GGPO', 'galaxyfg', 'yes'),
(27, 'MISC', 'Waku Waku 7', 'GGPO', 'wakuwak7', 'yes'),
(28, 'MISC', 'Far East of Eden: Kabuki Klash', 'GGPO', 'kabukikl', 'yes'),
(29, 'MISC', 'Ninja Master''s ～覇王忍法帳～', 'GGPO', 'ninjamas', 'yes'),
(30, 'MISC', 'World Heroes', 'GGPO', 'wh1', 'yes'),
(31, 'MISC', '新豪血寺一族 闘婚 -Matrimelee-', 'GGPO', 'matrim', 'yes'),
(32, 'MISC', 'Martial Masters', 'GGPO', 'martmast', 'yes'),
(33, 'MISC', 'Mortal Kombat II', 'GGPO', 'mk2', 'yes'),
(34, 'Beat ''em Ups', 'Ninja Baseball BatMan', 'GGPO', 'nbbatman', 'yes'),
(35, 'Beat ''em Ups', 'Teenage Mutant Ninja Turtles', 'GGPO', 'tmnt', 'yes'),
(36, 'Beat ''em Ups', 'Teenage Mutant Ninja Turtles: Turtles in Time', 'GGPO', 'tmnt2', 'yes'),
(37, 'Beat ''em Ups', 'X-Men', 'GGPO', 'xmen', 'yes'),
(38, 'Beat ''em Ups', 'The Simpsons', 'GGPO', 'simpsons', 'yes'),
(39, 'Beat ''em Ups', 'Alien vs. Predator', 'GGPO', 'avsp', 'yes'),
(40, 'Beat ''em Ups', 'Armored Warriors', 'GGPO', 'armwar', 'yes'),
(41, 'Beat ''em Ups', 'Cadillacs and Dinosaurs', 'GGPO', 'dino', 'yes'),
(42, 'Beat ''em Ups', 'Dungeons & Dragons: Shadow over Mystara', 'GGPO', 'ddsom', 'yes'),
(43, 'Beat ''em Ups', 'Dungeons & Dragons: Tower of Doom', 'GGPO', 'ddtod', 'yes'),
(44, 'Beat ''em Ups', 'Final Fight', 'GGPO', 'ffight', 'yes'),
(45, 'Beat ''em Ups', 'The Punisher', 'GGPO', 'punisher', 'yes'),
(46, 'Beat ''em Ups', 'Knights of the Round', 'GGPO', 'knights', 'yes'),
(47, 'Beat ''em Ups', 'Captain Commando', 'GGPO', 'captcomm', 'yes'),
(48, 'Beat ''em Ups', 'Undercover Cops', 'GGPO', 'uccopsj', 'yes'),
(49, 'Beat ''em Ups', 'Sengoku 3', 'GGPO', 'sengoku3', 'yes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
