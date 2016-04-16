
CREATE TABLE IF NOT EXISTS `gallery_images` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`userid` int(11) unsigned NOT NULL,
	`title` varchar(100) NOT NULL,
	`description` varchar(200) DEFAULT NULL,
	`extension` char(3) NOT NULL,
	`date` int(11) NOT NULL,
	`editDate` int(11) DEFAULT NULL,
	`editUserid` int(11) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY(`userid`) REFERENCES `users`(`userid`),
	FOREIGN KEY(`editUserid`) REFERENCES `users`(`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
