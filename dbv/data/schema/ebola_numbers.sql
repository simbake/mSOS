CREATE TABLE `ebola_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` text NOT NULL,
  `phone_numbers` text NOT NULL,
  `facility_code` text NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1