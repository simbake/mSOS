CREATE TABLE `diseases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` varchar(20) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `definition` text NOT NULL,
  `sample` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1