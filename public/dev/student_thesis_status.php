<?php
include("links.php");
include("header.php");
include("navbar.php");
include("student_permission.php");

// gets thesisID by username
$thesisID = getThesisID($_SESSION["username"]);
$thesisID = $thesisID["thesisID"];

function generateStatusForm($thesisID)
{
    $form = <<<FORMEND
	<div id="statusForm">
	<input type="hidden" name="thesisID" value="$thesisID">
FORMEND;
    
    $statuses = getStatuses();
    $currentStatuses = getThesisStatus($thesisID);
    $temp = array();
    foreach($currentStatuses as $s) {
        foreach($s as $f) {
            array_push($temp, $f);
        }

    }
	
    foreach ($statuses as $status) {
        $statusName = $status["statusName"];
        $statusID = $status["statusID"];
        $checked = in_array($statusID, $temp) ? "checked" : "";
        $form = $form . "<input type='checkbox' class='checkbox' disabled name='status[]' id='status' value='$statusID' $checked>$statusName<br>";
    }

    $form = $form . "</div>";
    return $form;
}
echo "<section class='small'>";

echo "<h3>Thesis status</h3>";
echo generateStatusForm($thesisID);
echo "</section>";
?>
