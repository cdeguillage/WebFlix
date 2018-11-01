<?php

/*
* On this file, we define some function who help us to manage global application.
*/

// Don't forget session...
session_start();

/**
 * We need to redirect user sometimes.
 */
function redirect($page)
{
	header('Location: '.$page);
}

/**
 * We need to redirect user sometimes.
 */
function httpNotFound()
{
	http_response_code(404);
	echo '<div class="container"><h1>404</h1></div>';
	require_once(__DIR__.'/../partials/footer.php');
	die();
}

/**
 * We need to know if a form is submitted.
 */
function isSubmit()
{
	return !empty($_POST);
}

/**
 * We need to know if an email is valid.
 */
function isValidEmail($email)
{
	return false !== filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * We need to know if a date is valid.
 */
function isValidDate($date)
{
	preg_match('/(\d*)\-(\d*)\-(\d*)/', $date, $matches);

	if (empty($matches) || count($matches) !== 4) {
		return false;
	}

	$year = (int) $matches[1];
	$month = (int) $matches[2];
	$day = (int) $matches[3];

	if (
		$year < 1900 ||
		($month < 1 || $month > 12) ||
		($day < 1 || $day > 31)
	) {
		return false;
	}

	return $matches;
}

/**
 * We can check if an user is logged.
 */
function isLogged()
{
	// return $_SESSION['user'] ?? false;
	return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

/**
 * Generate a slug from URL.
 * Example : The Amazing Spider-Man = the-amazing-spider-man
 */
function slug($string)
{
	$slug = strtolower($string);
	$slug = str_replace(' ', '-', $slug);

	return $slug;
}

/**
 * I need a function to facilitate upload...
 */
function upload($file, $folder, $name)
{
	$fileTmp = $file['tmp_name'];
	$extension = pathinfo($file['name'])['extension'];
	$fileName = $name.'.'.$extension;
	$destination = $folder.'/'.$fileName;

	if (move_uploaded_file($fileTmp, $destination)) {
		return $fileName;
	}

	return false;
}
