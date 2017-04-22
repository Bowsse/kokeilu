<?php
include("links.php");
include("header.php");
include("navbar.php");
include("student_permission.php");
include("first_time_login.php");

$selectedVersion = isset($_GET["versionID"]) ? $_GET["versionID"]: null;

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

$thesis = getThesisID($username);
$thesisID = $thesis['thesisID'];
$versionID = null;

if ($selectedVersion == null) {
	$version = getNewestVersion($thesisID);
	$versionID = $version["versionID"];
} 
else {
	$versionID = $selectedVersion;
} 

echo "<section class='small'>";

echo "<script type='text/javascript'> window.onload=changeVersion($versionID); </script>";


$thesisInfo = array(
	'subject' => 'Subject',
	'estimatedDate' => 'Estimated date'
);

// gets all theses by username (admin can only set one thesis for each student)
$theses = getTheses($username);

echo "<div id='thesisInfo'><h3>Thesis information</h3>";

// checks if user has theses
if ($theses != null) {
	foreach($theses as $thesis){
		foreach($thesisInfo as $key => $field){		
			echo "<label>$field: </label><input type='text' readonly value='$thesis[$key]'><br>";
		}
	}
	echo "<br><a href='change_thesis_estDate.php' class='content'>Change estimated date</a><br>";
	echo "</div><div id='versionInfo'><h3>Version information</h3>";
	echo "<a href='student_new_version.php' class='content'>New version</a><br>";
	
	$versions = getVersions($thesisID);
	echo generateVersionSelection($versions);
	echo "<div id='versionData'></div></div>";

	// checks if user has versions
	if ($versions != null) {
		$form = <<<FORMEND
		<div id='comment'>
			<h3>Add a new comment</h3>
			<form action="add_comment.php" method="post">
				<input type="hidden" name="thesisID" value='$thesisID'>
				<input type="hidden" id="versionHidden" name="versionID" value='$versionID'>
				<label>Comment:</label><br>
				<textarea cols="30" rows="5" name="content" required></textarea><br>
				<input type="submit" class="button" name="addComment" value="Add comment">
			</form>
		</div>
FORMEND;
		echo $form;
	}	
}
else {
	echo "Thesis has not been set.";
}

// checks if thesis is ready for review (statusID = 4, statusName= "Ready for final review")
if (thesisReadyForReview($thesisID)) {
	echo "<a href='final_review.php?thesisID=$thesisID' class='content'><strong>FINAL REVIEW</strong></a><br>";
}
echo "</section>";


?>
