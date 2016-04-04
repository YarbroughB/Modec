
CREATE TABLE IF NOT EXISTS `navigation` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`label` varchar(50) NOT NULL,
	`route` varchar(100) DEFAULT NULL,
	`params` varchar(250) DEFAULT NULL,
	`uri` varchar(255) DEFAULT NULL,
	`resource` varchar(100) DEFAULT NULL,
	`privilege` varchar(25) DEFAULT NULL,
	`menu` varchar(25) NOT NULL,
	`order` int(11) unsigned NOT NULL,
	`parent` int(11) unsigned DEFAULT NULL,
	`module` varchar(25) NOT NULL DEFAULT 'Core',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

