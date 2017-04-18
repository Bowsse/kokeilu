<?php
include("links.php");
include("header.php");
include("navbar.php");

$selectedVersion = isset($_GET["versionID"]) ? $_GET["versionID"]: null;

function generateVersionSelection($versions) {
	global $selectedVersion;
	$tag = "<select id='versionSelect' onChange='changeVersion();'>";
	foreach($versions as $version)
	{
		$versionText = $version['version'];
		$versionID = $version['versionID'];
		$selected = $selectedVersion == $versionID ? "selected" : "";
		$tag = $tag . "<option $selected name='$versionID'>$versionText</option>";
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
} else {
	$versionID = $selectedVersion;
} 
echo "<section class='small'>";

echo "<script type='text/javascript'> window.onload=changeVersion($versionID); </script>";

$versions = getVersions($thesisID);
echo generateVersionSelection($versions);

echo "<h3>Thesis information</h3>";
$thesisInfo = array(
	'thesisID' => 'ID',
	'estimatedDate' => 'Est. Date', 
	'subject' => 'Subject',
);


$theses = getTheses($username);

foreach($theses as $thesis){
	foreach($thesisInfo as $key => $field){		
		echo $field.": ".$thesis[$key]."<br>";
	}
}

echo "<h3>Version information</h3>";
echo "<div id='versionInfo'></div>";

$form = <<<FORMEND
	<form action="add_comment.php" method="post">
    <input type="hidden" name="thesisID" value='$thesisID'>
	<input type="hidden" id="versionHidden" name="versionID" value='$versionID'>
    <label>Comment:</label><br>
    <textarea cols="30" rows="5" name="content" required></textarea><br>
    <input type="submit" name="addComment" value="Add comment">
	</form>
FORMEND;

echo $form;

echo "<a href='student_new_version.php' class='content'>New version</a> ";
echo "</section>";
?>