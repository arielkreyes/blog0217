<?php 
$host 		= 'localhost';
$username 	= 'melissa_blog0217';
$password 	= 'ZaFTQ8NRZ9eJVvFv';
$database 	= 'melissa_blog0217';

//connect to database
$db = new mysqli( $host, $username, $password, $database );

//check to make sure it worked
if( $db->connect_errno > 0 ){
	die( 'Cannot connect to Database. Try again later.' );
}

//salt for making our passwords stronger. keep this a secret!
define('SALT', 'vgrqejun4tge7iuohtr1yhtdkmrsf52318675326gresjiludsvz6yg');

define('ROOT_URL', 'http://localhost/melissa-php-0217/blog/');
define('ROOT_PATH', 'C:\xampp\htdocs\melissa-php-0217\blog');

error_reporting( E_ALL & ~E_NOTICE ); 