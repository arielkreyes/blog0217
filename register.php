<?php 
require('register-parser.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign up for an account</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/admin-style.css">
</head>
<body class="login">
	<h1>Create an Account</h1>

	<?php show_feedback( $feedback, $errors ); ?>

	<form action="register.php" method="post">
		<label for="the_username">Choose a Username</label>
		<input type="text" name="username" id="the_username">
		<span class="hint">Between 5 - 50 characters</span>

		<label for="the_email">Your Email Address</label>
		<input type="email" name="email" id="the_email">

		<label for="the_password">Choose a Password</label>
		<input type="password" name="password" id="the_password">
		<span class="hint">At least 8 characters long</span>

		<label>
			<input type="checkbox" name="policy" value="1">
			I agree to the 
			<a href="#" target="_blank">terms of service and privacy policy</a>
		</label>

		<input type="submit" value="Sign Up">
		<input type="hidden" name="did_register" value="1">
	</form>
	<a href="login.php">Already have an account? Log in</a>

</body>
</html>