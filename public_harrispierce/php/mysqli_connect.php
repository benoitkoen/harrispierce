<?php
// Opens a connection to the database
// Since it is a php file it won't open in a browser 
// It should be saved outside of the main web documents folder
// and imported when needed

/*
Command that gives the database user the least amount of power
as is needed.
GRANT INSERT, SELECT, DELETE, UPDATE ON test3.* 
TO 'studentweb'@'localhost' 
IDENTIFIED BY 'turtledove';
SELECT : Select rows in tables
INSERT : Insert new rows into tables
UPDATE : Change data in rows
DELETE : Delete existing rows (Remove privilege if not required)
*/
/*
// Defined as constants so that they can't be changed
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'Harrispierce94');
DEFINE ('DB_HOST', '127.0.0.1:/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'); //localhost or 127.0.0.1:3306
DEFINE ('DB_NAME', 'userDirectory'); //userDirectory
*/


DEFINE ('DB_USER', 'dbo677888126');
DEFINE ('DB_PASSWORD', 'Harrispierce94');
DEFINE ('DB_HOST', 'db677888126.db.1and1.com'); ///tmp/mysql5.sock
DEFINE ('DB_NAME', 'db677888126'); 


// $dbc will contain a resource link to the database
// @ keeps the error from showing in the browser

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL: ' .
mysqli_connect_error());
?>