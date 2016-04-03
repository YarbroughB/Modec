
CREATE TABLE IF NOT EXISTS `blog_posts` (
	`id` int(11) NOT NULL,
	`userid` int(10) unsigned NOT NULL,
	`title` varchar(100) NOT NULL,
	`text` text NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY(`userid`) REFERENCES `users`(`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
