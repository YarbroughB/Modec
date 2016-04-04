
CREATE TABLE IF NOT EXISTS `blog_posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`userid` int(11) unsigned NOT NULL,
	`title` varchar(100) NOT NULL,
	`text` text NOT NULL,
	`date` int(11) NOT NULL,
	`editDate` int(11) NULL DEFAULT NULL,
	`editUserid` int(11) unsigned NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY(`userid`) REFERENCES `users`(`userid`),
	FOREIGN KEY(`editUserid`) REFERENCES `users`(`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
