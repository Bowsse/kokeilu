<?php
include("links.php");

$versionID = isset($_REQUEST['versionID']) ? $_REQUEST['versionID'] : null;

$versionInfo = array(
	'version' => 'Version',
	'thesisUrl' => 'Url',
	'creationDate' => 'Date and time',
);

$output = "<div id='versionInfo'>";

if ($versionID != null) {
	$versions = getVersion($versionID);
	if($versions != null) {
		foreach($versions as $version) {
			foreach($versionInfo as $key => $field) {
				$output = $output."<label>$field: </label><input type='text' readonly value='$version[$key]'><br>";
			}
		}
	}
	else {
		$output = $output . "There is no version selected or there is no versions at all.";
	}
}

$output = $output . "</div><div id='comments'><h3>Comments</h3>";

$comments = getComments($versionID);
if ($comments != null) {
	foreach($comments as $comment) {
		$author = $comment['author_personID'];
		$submissionDate = $comment['submissionDate'];
		$content = $comment['content'];
		$output = $output . "<div>$author - $submissionDate <br><textarea cols='30' rows='5' readonly>$content</textarea></div>";  
	}
}
else {
	$output = $output . "No comments on this version.";
}
echo $output . "</div>";
?>