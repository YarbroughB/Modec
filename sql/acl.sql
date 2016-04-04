
CREATE TABLE IF NOT EXISTS `acl_resources` (
	`id` varchar(100) NOT NULL,
	`parent` varchar(100) DEFAULT NULL,
	`module` varchar(25) NOT NULL DEFAULT 'Core',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `acl_rules` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usergroup` tinyint(3) unsigned NOT NULL,
	`resource` varchar(100) NOT NULL,
	`privilege` varchar(25) DEFAULT NULL,
	`action` enum('ALLOW','DENY','INHERIT') NOT NULL DEFAULT 'INHERIT',
	PRIMARY KEY (`id`),
	FOREIGN KEY(`resource`) REFERENCES `acl_resources`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`usergroup`) REFERENCES `usergroups`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
