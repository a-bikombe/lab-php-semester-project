<?php

require_once 'session.php';

$pageTitle = 'Semester Project: Login';

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
		<a href="home.php" alt="">Home</a>
	</nav>

	<form action="validation.php" method="post">
		<div class="input-block hidden">
			<label for="csrf"><?= $csrfToken ?></label>
			<input type="hidden" name="csrf" value="<?= $csrfToken ?>" id="csrf">
		</div>
		<div class="input-block">
			<label for="email">Email Address</label>
			<input type="email" name="email" id="email" placeholder="Email Address" required>
		</div>
		<div class="input-block">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="Password" required>
		</div>
		<div>
			<button type="submit">Submit</button>
		</div>
		<div>
			<a href="forgot.php">Forgot Your Password?</a>
		</div>
	</form>

</body>

</html>

<?php

echo 'Session Visit: ' . $_SESSION['count'] . PHP_EOL;
echo 'Session ID: ' . session_id() . PHP_EOL;

?>