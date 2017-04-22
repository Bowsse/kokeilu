<?php
include("links.php");
include("header.php");
include("navbar.php");
include("supervisor_permission.php");

$selectedVersion = isset($_GET["versionID"]) ? $_GET["versionID"]: null;
$thesisID = isset($_GET["thesisID"]) ? $_GET["thesisID"]: null;

echo "<section class='small'>";

if ($thesisID == null || personHasThesis($_SESSION["username"], $thesisID))
{
    echo "You don't have a permission to view this page or it does not exist.";
    exit;
}

// combobox for versions
function generateVersionSelection($versions) {
	global $selectedVersion;
	$tag = "<select id='versionSelect' onChange='changeVersion();'>";
	if ($versions == null) {
		$tag = $tag . "<option value='noVersions'>No versions</option>";
	}
	else { 
		foreach($versions as $version) {		
		$versionText = $version['version'];
		$versionID = $version['versionID'];
		$selected = $selectedVersion;
		$tag = $tag . "<option $selected name='$versionID'>$versionText</option>";
		}
	}
	$tag = $tag . "</select>";
	return $tag;
}

$versionID = null;

if ($selectedVersion == null) {
	$version = getNewestVersion($thesisID);
	$versionID = $version["versionID"];
} 
else {
	$versionID = $selectedVersion;
} 

echo "<div><a href='supervisor_thesis.php?thesisID=$thesisID' class='content'>Thesis Information</a> ";
echo "<a href='supervisor_thesis_status.php?thesisID=$thesisID' class='content'>Thesis status</a>";
/*
$grade = $db->query("SELECT * FROM Grade WHERE Thesis_thesisID = '".$thesisID."' AND Person_personID =  '".$_SESSION['username']."'");
if(isset($grade))
{
		$noRows = $grade->rowCount();

	if ($noRows > 0)
	{
		echo " <a href='supervisor_thesis_grade.php?thesisID=$thesisID' class='content'>Thesis review</a>";
	}
}
*/
$grade = getGrade($_SESSION['username'], $thesisID);

	if (!empty($grade))
	{
		echo " <a href='supervisor_thesis_grade.php?thesisID=$thesisID' class='content'>Thesis review</a>";
	}

echo "</div>";

echo "<script type='text/javascript'> window.onload=changeVersion($versionID); </script>";

$thesisInfo = array(
	'subject' => 'Subject',
	'estimatedDate' => 'Estimated date'
);

$thesis = getThesis($thesisID);

echo "<div id='thesisInfo'><h3>Thesis information</h3>";
foreach($thesisInfo as $key => $field){		
    echo "<label>$field: </label><input type='text' readonly value='$thesis[$key]'><br>";
}

$userInfo = array(
	'firstname' => 'First Name',
	'lastname' => 'Last Name',
    'personID' => 'Student ID',
    'email' => 'Email'
);

$user = getThesisInfo($thesisID);

echo "</div><div id='thesisInfo'><h3>Student information</h3>";

foreach($userInfo as $key => $field){		
    echo "<label>$field: </label><input type='text' readonly value='$user[$key]'><br>";
}

echo "</div><div id='versionInfo'><h3>Version information</h3>";
$versions = getVersions($thesisID);
echo generateVersionSelection($versions);
echo "<div id='versionData'></div></div>";

if ($versionID != null) {
	$form = <<<FORMEND
	<div id='comment'>
		<h3>Add a new comment</h3>
		<form action="add_comment.php" method="post">
			<input type="hidden" name="thesisID" value='$thesisID'>
			<input type="hidden" id="versionHidden" name="versionID" value='$versionID'>
			<label>Comment:</label><br>
			<textarea cols="30" rows="5" name="content" required></textarea><br>
			<input type="submit" class='button' name="addComment" value="Add comment">
		</form>
	</div>
FORMEND;
	echo $form;
}
else {
	echo "No version selected. Can't comment<br>";
}

if (thesisReadyForReview($thesisID)) {
	echo "<a href='final_review.php?thesisID=$thesisID' class='content'><strong>FINAL REVIEW</strong></a><br>";
}


echo "<a href='supervisor_main.php' class='content'>Back</a>";


echo "</section>";
?>