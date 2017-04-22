<?php
include("links.php");
include("header.php");
include("navbar.php");
include("student_permission.php");

// gets thesisID by username
$thesis = getThesisID($username);
$thesisID = $thesis['thesisID'];

// gets supervisor by thesisID and role (superviosr1 and supervisor2)
$supervisor1 = getSupervisors($thesisID, "supervisor1");
$supervisor2 = getSupervisors($thesisID, "supervisor2");

function printSupervisor($supervisor) {
	$userInfo = array(
	'personID' => 'Person ID',
	'firstname' => 'First name',
	'lastname' => 'Last name',
	'email' => 'Email');
	
	if ($supervisor != null) {
		foreach($supervisor as $sv) {
			foreach($userInfo as $key => $field){
				echo "<label>$field: </label><input type='text' readonly value='$sv[$key]'><br>";
			}
		}
	}
	else {
		echo "No supervisors";
	}	
}
echo "<section class='small'>";
echo "<div id='supervisors'><h2>Supervisors</h2>";
echo "<div id='supervisor1'><h3>First Supervisor</h3>";
printSupervisor($supervisor1);
echo "</div><div id='supervisor2'><h3>Second Supervisor</h3>";
printSupervisor($supervisor2);
echo "</div></div>";
echo "</section>";
?>
