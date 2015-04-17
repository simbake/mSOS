CREATE TABLE `incident_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` int(11) NOT NULL,
  `reported` int(11) NOT NULL,
  `national_incident` text,
  `county_incident` text,
  `district_incident` text,
  PRIMARY KEY (`id`),
  KEY `incident_id` (`incident_id`),
  KEY `incident_id_2` (`incident_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1