<?php
include("links.php");
include("header.php");
include("navbar.php");

// gets persons information by username
$user = getPerson($username);

$userInfo = array(
	'personID' => 'Person ID',
	'firstname' => 'First name',
	'lastname' => 'Last name',
	'email' => 'Email',
);
echo "<section class='small'>";
echo "<div id='userInfo'><h3>User information</h3>";

foreach($user as $u){
	foreach($userInfo as $key => $field){
		echo "<label>$field: </label><input type='text' readonly value='$u[$key]'><br>";
	}
}

echo "<a href='change_password.php'>Change password</a><br></div>";

echo "</section>";
?>