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