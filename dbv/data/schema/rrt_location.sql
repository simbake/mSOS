CREATE TABLE `rrt_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) NOT NULL,
  `lat` text NOT NULL,
  `long` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location_name_2` (`location_name`),
  KEY `location_name` (`location_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1