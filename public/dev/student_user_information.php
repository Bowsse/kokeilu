<?php
include("links.php");
include("header.php");
include("navbar.php");


$user = getPerson($username);
$userInfo = array(
	'personID' => 'Person ID',
	'firstName' => 'First name',
	'lastName' => 'Last name',
	'permission' => 'Permission',
	'email' => 'Email',
);
echo "<section class='small'>";
echo "<h3>User information</h3>";

foreach($user as $u){
	foreach($userInfo as $key => $field){
		echo $field.": ".$u[$key]."<br>";
	}
}
echo "</section>";
?>