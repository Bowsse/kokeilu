<?php
include("links.php");
include("header.php");
include("navbar.php");
include("supervisor_permission.php");

$thesisID = isset($_REQUEST["thesisID"]) ? $_REQUEST["thesisID"] : null;

function generateStatusForm($thesisID)
{
    $form = <<<FORMEND
<div id="statusForm">
<form action="supervisor_thesis_status.php" method="post">
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
        $form = $form . "<input type='checkbox' class='checkbox' name='status[]' id='status' value='$statusID' $checked> $statusName<br>";
    }

    $form = $form . "<input type='submit' class='button' name='submit' value='Apply changes'></form></div>";
    return $form;
}
echo "<section class='small'>";
echo "<div><a href='supervisor_thesis.php?thesisID=$thesisID' class='content'>Thesis Information<a> ";
echo "<a href='supervisor_thesis_status.php?thesisID=$thesisID' class='content'>Thesis status</a>";

$grade = getGrade($_SESSION['username'], $thesisID);

	if (!empty($grade))
	{
		echo " <a href='supervisor_thesis_grade.php?thesisID=$thesisID' class='content'>Thesis review</a>";
	}
echo "</div>";

if (isset($_POST["submit"])) {
   $statuses = isset($_POST["status"]) ? $_POST["status"] : null;
   
   if ($statuses != null) {
	  $sql = <<<SQLEND
	  REPLACE INTO Thesis_has_Status
	  VALUES (:thesisID, :statusID);
SQLEND;
	  $sql_deletion = <<<SQLEND
	  DELETE FROM Thesis_has_Status
	  WHERE Thesis_thesisID = :thesisID AND Status_statusID = :statusID;
SQLEND;

	  $to_be_removed = getStatuses();
	  foreach($statuses as $statusID) {

		 $stmt = $db->prepare($sql);
		 $stmt->bindValue(':thesisID', $thesisID);
		 $stmt->bindValue(':statusID', $statusID);
		 $stmt->execute();
		 // removes off values
		 unset($to_be_removed[$statusID-1]);
	  }
	   
	  foreach($to_be_removed as $status) {
		 $statusName = $status["statusName"];
		 $statusID = $status["statusID"];
		 $stmt = $db->prepare($sql_deletion);
		 $stmt->bindValue(':thesisID', $thesisID);
		 $stmt->bindValue(':statusID', $statusID);
		 $stmt->execute();
	  }

	  header('Location: ' . $_SERVER['HTTP_REFERER']);
	  exit;
	}
} else if ($thesisID != null) { // TODO: check if current user is supervisor in this thesis
    echo "<h2>Thesis status</h2>";
    echo generateStatusForm($thesisID);
}
echo "<a href='supervisor_main.php' class='content'>Back</a>";
echo "</section>";
?>
