CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `rrt_sms` tinyint(1) NOT NULL DEFAULT '0',
  `county` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `facility` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `reset_token` text NOT NULL,
  `token_generated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1