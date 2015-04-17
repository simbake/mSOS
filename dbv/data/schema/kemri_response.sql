CREATE TABLE `kemri_response` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(250) NOT NULL,
  `specimen_received` date NOT NULL,
  `lab_test_begun` date NOT NULL,
  `specimen_type` text NOT NULL,
  `other_specimen` text NOT NULL,
  `conditions` text NOT NULL,
  `other_condition` text NOT NULL,
  `comments` text NOT NULL,
  `notified` tinyint(4) NOT NULL DEFAULT '0',
  `date_notified` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1