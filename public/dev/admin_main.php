<?php
include("links.php");
include("header.php");
include("admin_permission.php");

$msg = '';

if(isset($_POST["submit"])) {
    $student = isset($_POST["studentSelect"]) ? $_POST["studentSelect"] : "";
	$subject = isset($_POST["subject"]) ? $_POST["subject"] : "";
    $supervisor1 = isset($_POST["supervisor1Select"]) ? $_POST["supervisor1Select"] : "";
    $supervisor2 = isset($_POST["supervisor2Select"]) ? $_POST["supervisor2Select"] : "";
    $subject = isset($_POST["subject"]) ? $_POST["subject"] : "";
    $estimatedDate = date("Y-m-d");
	
	// cannot add same supervisors for both role (supervisor1 and supervisor2)
	if ($supervisor1 == $supervisor2) {
		$msg = "Cannot set same supervisor for both roles.";
	}
	// gets thesisID by students personID
	$thesisForStudent = getThesisID($student);
	// checks if thesis is not null
	if ($thesisForStudent != null) {
		$msg = "Student has thesis, cannot set a new one.";
	}
	// otherwise adds persons for thesis
	else {
		$sql = <<<SQLEND
			INSERT INTO Thesis (
				estimatedDate,
				subject
			) VALUES (
				:estimated,
				:subject
			);
SQLEND;

		$prepairs = array(
			":estimated" => $estimatedDate,
			":subject" => $subject
		);

		$stmt = $db->prepare($sql);
		$stmt->execute($prepairs);

		$thesisForeingkey1 = $db->lastInsertId();
		$thesisForeingkey2 = $db->lastInsertId();
		$thesisForeingkey3 = $db->lastInsertId();

		$sql = <<<SQLEND
			INSERT INTO Person_has_Thesis (
				personID,
				thesisID,
				role
			) VALUES (
				:studentID,
				:thesisForeingkey1,
				"student"
			), (
				:supervisor1ID,
				:thesisForeingkey2,
				"supervisor1"
			), (
				:supervisor2ID,
				:thesisForeingkey3,
				"supervisor2"
			);       
SQLEND;

		$prepairs = array(
			':thesisForeingkey1' => $thesisForeingkey1,
			':thesisForeingkey2' => $thesisForeingkey2,
			':thesisForeingkey3' => $thesisForeingkey3,
			':studentID' => $student, 
			':supervisor1ID' => $supervisor1,
			':supervisor2ID' => $supervisor2
		);

		$stmt = $db->prepare($sql);
		$stmt->execute($prepairs);
		$msg = "Thesis has been set.";
	}
}

function generatePersonSelection($elementID, $permission=null) {
    // $elementID is the desired id for the generated <select> element
    // $permission if set, include only persons with equal permission 
    $element = "<select name='$elementID'>";
    $persons = getPersons($permission);

    foreach($persons as $person) {
        $personStr = "";
        $personName = $person["lastname"] . " " . $person["firstname"];
        $personID = $person["personID"];
        // $personPerm = $person["permission"];

        $personStr = $personName . " | " . $personID /*. " ". $personPerm*/;
        $element = $element . "<option value='$personID'>$personStr</option>";
    }

    return $element . "</select>";
}

$studentSelect = generatePersonSelection("studentSelect", "0");
$supervisor1Select = generatePersonSelection("supervisor1Select", "1");
$supervisor2Select = generatePersonSelection("supervisor2Select", "1");

echo "<section class='small'>";

$form = <<<ENDFORM
<form id='add_thesis' action='' method='post' accept-charset='UTF-8'>
    Subject: <input type='text' name='subject' id='subject' placeholder='Enter subject' required><br>
    Student: $studentSelect<br>
    Supervisor 1: $supervisor1Select<br>
    Supervisor 2: $supervisor2Select<br>
    <input type='submit' name='submit' value='SUBMIT'>
</form>

ENDFORM;

echo $form;
echo $msg;
echo "<br><a href='admin_add_user.php'>Add user</a>";

echo "</section>";
?>
