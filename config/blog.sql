CREATE TABLE posts ( 
   `postid` int(11) NOT NULL auto_increment,
   `userid` int(10) unsigned NOT NULL,
   `posttitle` varchar(100) NOT NULL,
   `posttext` TEXT NOT NULL,
   PRIMARY KEY (`postid`), 
   FOREIGN KEY(`userid`) REFERENCES users(`userid`)
 );

 INSERT INTO posts (`userid`, `posttitle`, `posttext`)
   VALUES  (1, 'Blog #1',  'Welcome to my first blog post');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`)
   VALUES  (1, 'Blog #2',  'Welcome to my second blog post');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`)
   VALUES  (1, 'Blog #3',  'Welcome to my third blog post');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`)
   VALUES  (1, 'Blog #4',  'Welcome to my fourth blog post');
 INSERT INTO posts (`userid`, `posttitle`, `posttext`)
   VALUES  (1, 'Blog #5',  'Welcome to my fifth blog post');