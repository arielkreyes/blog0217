<?php 
error_reporting( E_ALL & ~E_NOTICE ); 

require('db-config.php');
include_once('functions.php');

//begin parser
if( $_POST['did_register'] ){
	//sanitize everything
	$username 	= clean_string( $_POST['username'] );
	$email 		= clean_email( $_POST['email'] );
	$password 	= clean_string( $_POST['password'] );
	$policy 	= clean_integer( $_POST['policy'] );
	//validate:
	$valid = 1;
		//username wrong length
	if( strlen($username) < 5 OR strlen($username) > 50 ){
		$valid = 0;
		$errors['username'] = 'Choose a username between 5 and 50 characters long.';
	}else{
		//username already taken
		$query = "SELECT username FROM users
					WHERE username = '$username'
					LIMIT 1";
		$result = $db->query($query);
		if( $result->num_rows == 1 ){
			$valid = 0;
			$errors['username'] = 'Sorry, That username is already in use. Choose another.';
		}
	}		
		//password wrong length
	if( strlen($password) < 8 ){
		$valid = 0;
		$errors['password'] = 'Your password needs to be at least 8 characters.';
	}
		//email bad format
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = 0;
		$errors['email'] = 'Please provide a valid email';
	}else{
		//email already taken
		$query = "SELECT email FROM users
				WHERE email = '$email'
				LIMIT 1";
		$result = $db->query($query);
		if($result->num_rows == 1){
			$valid = 0;
			$errors['email'] = 'That email is already registered. Do you want to log in?';
		}
	}
		//policy box not checked
	if( $policy != 1 ){
		$valid = 0;
		$errors['policy'] = 'Please agree to our terms before signing up.';
	}
	//if valid, add the user to the users table!
	if($valid){
		//add salt to make it harder to hack passwords
		$password = sha1($password . SALT);
		$query = "INSERT INTO users
				( username, password, email, is_admin, is_approved )
				VALUES 
				( '$username', '$password', '$email', 0, 0 )";
		$result = $db->query($query);
		//if it worked, tell them to wait for confirmation. direct to login
		if( $db->affected_rows == 1 ){
			$feedback = 'You are now signed up!  As soon as you are approved by an admin, you can log in';
		}else{
			//if it failed, show user feedback
			$feedback = 'Sorry, your account was not created. Try again later.';
		}
		
	} //end if valid
	else{
		$feedback = 'There are errors in the form, please fix them and try again';
	}
	
} //end parser 