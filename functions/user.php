<?php
/*
* On this file, we define some function who help us to manage user.
*/
/**
 * We need to know if an email exists in database.
 */
function emailExists($email)
{
	global $db;
	$query = $db->prepare('
		SELECT COUNT(id) FROM `user` WHERE email = :email
	');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    // fetch -> ['COUNT(id)' => 1];
    // fetchColumn -> 1
    return (int) $query->fetchColumn();
}
/**
 * We need to easily register an user in database.
 */
function registerUser($email, $password)
{
	global $db;
	$query = $db->prepare('
		INSERT INTO `user` (username, email, password) VALUES (:username, :email, :password)
	');
    $query->bindValue(':username', strtok($email, '@'), PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    return $query->execute();
}
/**
 * We need to easily valid an user / password on application.
 */
function validUser($email, $password)
{
	global $db;
	$query = $db->prepare('
		SELECT * FROM `user` WHERE email = :email
	');
	$query->bindValue(':email', $email);
	$query->execute();
	$user = $query->fetch();
	if ($user && password_verify($password, $user['password'])) {
		return $user;
	}
	return false;
}
/**
 * We can log an user in application.
 */
function login($user)
{
	if (!isset($user['id'])) {
		return false;
	}
	$_SESSION['user'] = $user;
}
/**
 * We can logout an user in application.
 */
function logout()
{
	unset($_SESSION['user']);
	return true;
}

?>