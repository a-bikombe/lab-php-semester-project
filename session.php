<?php

// The login page must have a semantically correct login form that will allow a user to login using an email address and a password, the login form must post to Project Part 2 - Form validation / authentication. Include logic to count the number of times the form has been displayed.

// https://www.nashuaweb.net/~abikombe/CSCI206/project/1_home.php
// help: https://www.nashuaweb.net/~hobo/csci206n/csrf.php

session_start();
if (empty($_SESSION['count'])) {
	$_SESSION['count'] = 0;
}

if (empty($_SESSION['badTries'])) {
	$_SESSION['badTries'] = 0;
}

if (empty($_SESSION['loginSuccess'])) {
	$_SESSION['loginSuccess'] = false;
}

$bytes = random_bytes(64);
$csrfToken = bin2hex($bytes);
if (!isset($_SESSION['csrf'])) {
	$_SESSION['csrf'] = '';
}

// Set up the filter with all the expected inputs
$args = [
	'csrf' => [
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' => [
			'regexp' => '/^' . $_SESSION['csrf'] . '$/',
			'default' => ''
		]
	]
];
$_SESSION['csrf'] = $csrfToken;

// Do the filtering
if (!empty($_POST)) {
	$filtered = filter_input_array(INPUT_POST, $args, true);
	if (empty($filtered['csrf'])) {
		//header('Location: https://go-away.com');
		http_response_code(404);
		exit;
	}
} else {
	$filtered = [];
}

// Check if anything was missing and add it as empty 
foreach ($args as $k => $v) {
	if (!isset($_POST[$k])) {
		$filtered[$k] = '';
	}
}

$_SESSION['count']++;

if ($_SESSION['count'] > 5) {
	die('Session Ended: Too Many Refreshes');
}

require_once "validation.php";

?>