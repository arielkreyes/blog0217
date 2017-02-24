<?php 
require('login-parser.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login to your account</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/admin-style.css">
</head>
<body class="login">

<h1>Log In to Your Account</h1>

<?php 
echo $feedback; 

?>

<form method="post" action="login.php">

	<label for="the_username">Username</label>
	<input type="text" name="username" id="the_username">

	<label for="the_password">Password</label>
	<input type="password" name="password" id="the_password">

	<input type="submit" value="Log In">

	<input type="hidden" name="did_login" value="true">

</form>

<a href="register.php">Sign up for an account</a>

</body>
</html>