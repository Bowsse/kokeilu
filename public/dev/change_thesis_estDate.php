<?php
include("links.php");
include("header.php");

// gets thesisID by username
$thesisID = getThesisID($username);
$thesisID = $thesisID["thesisID"];

// sets new estimated date for thesis
if (isset($_POST["changeDate"])) {
    $newDate = $_POST["estDate"];
    $sql = <<<SQLEND
    UPDATE Thesis
    SET estimatedDate = :estDate
    WHERE ThesisID = :thesisID;
SQLEND;
    $stmt = $db->prepare($sql);
    $stmt->execute(array($newDate, $thesisID));
    header('Location: student_thesis.php');
}

$form = <<<FORMEND
<form action="change_thesis_estDate.php" method="post">
		<input type="hidden" name="thesisID" value='$thesisID'>
		<label>New estimated date:</label><br>
		<input type="text" name="estDate" required placeholder="yyyy-mm-dd"></text><br>
		<input type="submit" name="changeDate" value="Change estimated date">
	</form>
FORMEND;

echo $form;
?>
