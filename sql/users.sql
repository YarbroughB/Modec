
CREATE TABLE IF NOT EXISTS `usergroups` (
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(50) NOT NULL,
	`type` enum('GUEST','REGULAR','ADMIN','BANNED') NOT NULL DEFAULT 'REGULAR',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `usergroups` (`id`, `title`, `type`) VALUES
	(1, 'Unregistered', 'GUEST'),
	(2, 'Registered Users', 'REGULAR'),
	(3, 'Admin', 'ADMIN'),
	(4, 'Banned Users', 'BANNED');

CREATE TABLE IF NOT EXISTS `users` (
	`userid` int(11) unsigned NOT NULL,
	`username` varchar(50) NOT NULL,
	`email` varchar(150) NOT NULL,
	`password` char(32) NOT NULL,
	`passwordSalt` char(32) NOT NULL,
	`usergroup` tinyint(3) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`userid`),
	FOREIGN KEY(`usergroup`) REFERENCES `usergroups`(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
