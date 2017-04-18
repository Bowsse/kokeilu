<?php
include("links.php");
include("header.php");
include("navbar.php");

echo "<section class='small'>";

echo "<h3>Supervisors</h3>";

$thesis = getThesisID($username);
$thesisID = $thesis['thesisID'];

$userInfo = array(
	'personID' => 'Person ID',
	'firstName' => 'First name',
	'lastName' => 'Last name',
	'permission' => 'Permission',
	'email' => 'Email',
	'password' => 'Password',
);
$supervisors1 = getSupervisors($thesisID, "supervisor1");
echo "<h3>Supervisor 1: </h3>";
foreach($supervisors1 as $sv1){
	foreach($userInfo as $key => $field){
		echo $field.": ".$sv1[$key]."<br>";
	}
}

echo "</section>";

echo "<section class='small'>";


$supervisors2 = getSupervisors($thesisID, "supervisor2");
echo "<h3>Supervisor 2: </h3>";
foreach($supervisors2 as $sv2){
	foreach($userInfo as $key => $field){
		echo $field.": ".$sv2[$key]."<br>";
	}
}
echo "</section>";
?>
