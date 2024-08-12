<?php

require ('../mysqli_connect_FYP.php');

session_start();

$errors   = array();

function e($val){
	global $dbc;
	return mysqli_real_escape_string($dbc, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

if (isset($_POST['login_btn'])) {
	login();
}

function login(){
	global $dbc, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {

		$q = "SELECT * FROM users WHERE username='$username' AND password=SHA1('$password') LIMIT 1";
		$r = mysqli_query($dbc, $q);

		if (mysqli_num_rows($r) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($r);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in. Welcome back, <b>$username!</b>";
				//$_SESSION['username'] = $data['username'];

				header('location: admin_dashboard.php');
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in. Welcome back, <b> $username! </b>";
				//$_SESSION['username'] = $data['username'];

				header('location: user_home.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}


?>
