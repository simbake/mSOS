CREATE TABLE `weekly_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_sent` date NOT NULL,
  `time_sent` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1