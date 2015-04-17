CREATE TABLE `logi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(15) NOT NULL,
  `ip_address` text NOT NULL,
  `user_agent` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `t_login` datetime NOT NULL,
  `t_logout` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1