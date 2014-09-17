-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2013 at 07:07 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `idsr_alert`
--

-- --------------------------------------------------------

--
-- Table structure for table `kemri_response`
--

CREATE TABLE IF NOT EXISTS `kemri_response` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(250) NOT NULL,
  `specimen_received` date NOT NULL,
  `lab_test_begun` datetime NOT NULL,
  `specimen_type` text NOT NULL,
  `other_specimen` text NOT NULL,
  `condition` text NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kemri_response`
--

INSERT INTO `kemri_response` (`Id`, `incident_id`, `specimen_received`, `lab_test_begun`, `specimen_type`, `other_specimen`, `condition`, `comments`) VALUES
(4, '875029193DDCF781275D', '2013-11-22', '2013-11-22 13:17:00', 'Other', 'fasdf', 'fasdfwd', 'fasdfs'),
(5, '0243A26A5AD9FE9CDD3E', '2013-11-24', '2013-11-25 04:22:00', 'Stool', '', 'vdfvdf', 'vdfvfdvd rgfvrdf'),
(6, '6CFAD56964', '2013-11-24', '2013-11-24 10:29:00', 'Stool', '', 'fgdfg', 'gdfgdfgd'),
(7, '3EEA0A0340', '2013-11-25', '2013-11-25 15:29:00', 'Human Tissue', '', 'nice', 'This is war!!'),
(10, '3FB7959701', '2013-11-25', '2013-11-25 14:29:02', 'Stool', '', 'good', 'ththf rdof'),
(12, '8C99ACBE17', '2013-11-25', '2013-11-26 15:38:28', 'Stool', '', 'good', 'We are doomed!!'),
(14, '31035A3D11', '2013-11-25', '2013-11-26 16:31:01', 'Stool', '', 'stainable', 'this is a test');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
