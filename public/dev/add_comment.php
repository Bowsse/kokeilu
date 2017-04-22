<?php
include("links.php");
session_start();

if(isset($_POST['addComment'])) {
	$author = $_SESSION['username']; 
	$content = $_POST['content'];
	$submissionDate = date("Y-m-d H:i:s");
	$thesisID = $_POST['thesisID'];
	$versionID = $_POST['versionID'];
	
	$sql = <<<SQLEND
	INSERT INTO Comment (
	content,
	author_personID,
	Version_versionID,
	Version_thesisID,
	submissionDate 
	) 
	VALUES (
	:f1,
	:f2,
	:f3,
	:f4,
	:f5
	);
SQLEND;

	$prepairs = array(':f1' => $content, ':f2' => $author, ':f3' => $versionID, ':f4' => $thesisID, ':f5' => $submissionDate);
	$stmt = $db->prepare($sql);
	$stmt->execute($prepairs);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>