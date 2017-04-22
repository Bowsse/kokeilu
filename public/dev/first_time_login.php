<?php
// gets firstTimeLogin(boolean) value from Person table
$data = firstTimeLogin($username);
$data = $data['firstTimeLogin'];

// first time logging in value is 1
// if value is 1
if ($data == 1) {
	echo "<script type='text/javascript'>alert('First time login - Change your password')</script>";
	// updates value for 0
	updateFirstTimeLogin($username);
}
?>