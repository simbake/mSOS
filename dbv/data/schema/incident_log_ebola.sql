CREATE TABLE `incident_log_ebola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(255) NOT NULL,
  `reported` int(11) NOT NULL,
  `Admin_Response` text,
  `RRT_Response` text,
  PRIMARY KEY (`id`),
  KEY `incident_id` (`incident_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1