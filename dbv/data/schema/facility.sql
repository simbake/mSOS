CREATE TABLE `facility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facility_code` varchar(13) DEFAULT NULL,
  `facility_name` varchar(42) DEFAULT NULL,
  `province` varchar(11) DEFAULT NULL,
  `county` varchar(10) DEFAULT NULL,
  `district` varchar(15) DEFAULT NULL,
  `division` varchar(12) DEFAULT NULL,
  `type` varchar(21) DEFAULT NULL,
  `owner` varchar(47) DEFAULT NULL,
  `phone_number` varchar(14) DEFAULT NULL,
  `alternate` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '0',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `ebola_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8