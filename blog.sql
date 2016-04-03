CREATE TABLE posts ( 
   `postid` int(11) NOT NULL auto_increment,
   `userid` varchar(50) NOT NULL,
   `posttitle` varchar(100) NOT NULL,
   `posttext` TEXT NOT NULL,
   `dateformat` DATE NOT NULL,
   PRIMARY KEY (`postid`), 
   FOREIGN KEY(`userid`) REFERENCES users(`username`)
 );

 INSERT INTO posts (`userid`, `posttitle`, `posttext`, `dateformat`)
   VALUES  ('Brian', 'Blog #1',  'Welcome to my first blog post', '2016-04-03');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`, `dateformat`)
   VALUES  ('Brian', 'Blog #2',  'Welcome to my second blog post', '2016-04-03');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`, `dateformat`)
   VALUES  ('Brian', 'Blog #3',  'Welcome to my third blog post', '2016-04-03');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`, `dateformat`)
   VALUES  ('Brian', 'Blog #4',  'Welcome to my fourth blog post', '2016-04-03');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`, `dateformat`)
   VALUES  ('Brian', 'Blog #5',  'Welcome to my fifth blog post', '2016-04-03');