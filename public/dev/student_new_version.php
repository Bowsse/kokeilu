<?php
include("links.php");
include("header.php");
include("navbar.php");
include("student_permission.php");

// gets thesisID
$thesis = getThesisID($username);
$thesisID = $thesis['thesisID'];

$version = isset($_POST['version']) ? $_POST['version'] : '';
$thesisUrl = isset($_POST['thesisUrl']) ? $_POST['thesisUrl'] : '';
// gets current date and time
$creationDate = date("Y-m-d H:i:s");

// adds new version to db
if(isset($_POST['submit'])){
	$sql = <<<SQLEND
		INSERT INTO Version (
		thesisID,
		version,
		thesisUrl,
		creationDate
		) VALUES (
		:f1,
		:f2,
		:f3,
		:f4
		);
SQLEND;

	$prepairs = array(':f1' => $thesisID, ':f2' => $version, ':f3' => $thesisUrl, ':f4' => $creationDate);

	$stmt = $db->prepare($sql);
	try {
		$stmt->execute($prepairs);	
	} catch (Exception $e) {
		echo $e;
	}
	header("Location: student_thesis.php");
}
echo "<section class='small'>";
echo "<h3>New version</h3>";
?>
<div id="newVersion">
	<form action='' method='post' accept-charset='UTF-8'>
		<label>Version</label><br>
		<input type='text' name='version' value="Version x.x" id='version' maxlength="45" required autofocus/><br>
		<label>Version Url</label><br>
		<input type='text'name='thesisUrl' value="Version Url" id='thesisUrl' maxlength="200" required/><br>
		<input type='submit' name='submit' value='Apply'>
	</form>
	<a href='student_thesis.php'>Back</a>
</div>


</section>