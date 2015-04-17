CREATE TABLE `weekly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facility_code` int(11) NOT NULL,
  `sys_number` int(11) NOT NULL,
  `facility_no` int(11) NOT NULL,
  `date_week` datetime NOT NULL DEFAULT '2013-09-09 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1