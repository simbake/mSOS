CREATE TABLE `session_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` text NOT NULL,
  `logi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` datetime NOT NULL,
  `active` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1