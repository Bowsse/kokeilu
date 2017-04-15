<?php
include("links.php");

$versionID = isset($_REQUEST['versionID']) ? $_REQUEST['versionID'] : null;

$versionInfo = array(
	'versionID' => 'versionID',
	'thesisID' => 'thesisID',
	'version' => 'Version',
	'thesisUrl' => 'Url',
	'creationDate' => 'Date',
);
$output = "<div id='versionInfo'>";


if ($versionID != null)
{
	$versions = getVersion($versionID);
	foreach($versions as $version) {
		foreach($versionInfo as $key => $field) {
			$output = $output . $field.": ".$version[$key]."<br>";
		}
	}
}


$output = $output . "</div><h3>Comments</h3><div id='comments'>";


$comments = getComments($versionID);

foreach($comments as $comment) {
	$author = $comment['author_personID'];
	$submissionDate = $comment['submissionDate'];
	$content = $comment['content'];
	$output = $output . "<div>$author - $submissionDate</div><div>$content</div>";  
}

echo $output . "</div>";

?>