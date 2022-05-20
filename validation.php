<?php

require_once "session.php";

// The password must be upper and lowercase letters and digits and between 3 and 32 characters
$filters = [
	'email' => FILTER_VALIDATE_EMAIL,
	'password' => [
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' => [
			'regexp' => '/^[A-Za-z0-9]{3,32}$/',
		]
	]
];

// If the email address is invalid, report it as such to cue the user that they need to enter a valid email address
// If the password is invalid, report it as an authentication error - implying that the credentials are invalid to avoid disclosing the validation used by the application
// If the user has tried less than 5 times allow them to try again by redirecting them to the login form from Project Part 1 - Home page and login form
// If the user has tried 5 or more times display a message stating they can try again tomorrow, their account is locked.
// if succeeds, clear the login page counter from Project Part 1 - Home page and login form
if (!empty($_POST)) {
	$filtered = filter_input_array(INPUT_POST, $filters, true);
	if ($_SESSION['count'] <= 5) {
		if ($filtered['email'] === false) {
			echo 'Invalid Email' . PHP_EOL;
		} else if ($filtered['password'] === false) {
			echo 'Authentication Error: Credentials are Invalid' . PHP_EOL;
		} else {
			$mysqli = mysqli_connect("127.0.0.1", "root", "", "login", 3306);
			mysqli_set_charset($mysqli, 'utf8mb4');
			$stmt = mysqli_prepare($mysqli, "SELECT * FROM users");
			mysqli_stmt_execute($stmt);
			/* Read each row of the results as an associative array */
			$result = mysqli_stmt_get_result($stmt);
			$rows = [];
			while ($row = mysqli_fetch_assoc($result)) {
				$userData[] = $row;
			}

			foreach ($userData as $user) {
				if ($filtered['email'] === $user['email'] && $filtered['password'] === $user['password']) {
					$_SESSION['loginSuccess'] = true;
					require_once 'home.php';
?>
					<pre>Welcome <?= $user['first_name'] . ' ' . $user['last_name'] ?></pre>
<?php
				} else if ($filtered['email'] !== $user['email'] && $filtered['password'] === $user['password']) {
					echo 'Bad email' . PHP_EOL;
					$_SESSION['badTries']++;
					header('Location: login.php');
				} else if ($filtered['email'] === $user['email'] && $filtered['password'] !== $user['password']) {
					echo 'Bad password' . PHP_EOL;
					$_SESSION['badTries']++;
					header('Location: login.php');
					break;
				}
			}

			$_SESSION['count'] = 0;
			mysqli_stmt_close($stmt);
			mysqli_close($mysqli);
		}
	} else {
		die('Account Locked - Too Many Tries: Try Again Tomorrow');
	}
}
