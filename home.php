<?php

/* 
Code a semantically correct home page and login form.

The home page must have an <h1>, a <nav> and a link to the login page.

The login page must have a semantically correct login form that will allow a user to login using an email address and a password, the login form must post to Project Part 2 - Form validation / authentication.

Include logic to count the number of times the form has been displayed.
 */

$pageTitle = 'Semester Project: Home';

?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title><?= $pageTitle ?></title>
	<link href="css/main.css" rel="stylesheet">
</head>

<body>
	<h1><?= $pageTitle ?></h1>
	<nav>
		<?php if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess'] === true) { ?>
			<a href="logout.php" alt="">Log Out</a>
		<?php
		} else { ?>
			<a href="login.php" alt="">Login</a>
		<?php } ?>
	</nav>
</body>

</html>