<?php
include("links.php");
include("header.php");
include("navbar.php");
include("supervisor_permission.php");

$selectedVersion = isset($_GET["versionID"]) ? $_GET["versionID"]: null;
$thesisID = isset($_GET["thesisID"]) ? $_GET["thesisID"]: null;

echo "<section  class='wide'>";

if ($thesisID == null || personHasThesis($_SESSION["username"], $thesisID))
{
    echo "You don't have a permission to view this page or it does not exist.";
    exit;
}


echo "<div><a href='supervisor_thesis.php?thesisID=$thesisID' class='content'>Thesis Information<a> ";
echo "<a href='supervisor_thesis_status.php?thesisID=$thesisID' class='content'>Thesis status</a> ";

$grade = getGrade($_SESSION['username'], $thesisID);

	if (!empty($grade))
	{
		echo " <a href='supervisor_thesis_grade.php?thesisID=$thesisID' class='content'>Thesis review</a>";
	}
echo "</div>";

$thesisGrade = array(
	'field1' => '1. Aiheen ja lähestymistavan valinta',
	'field2' => '2. Tietoperusta ja työn rakenne',
	'field3' => '3. Opinnäytetyön toteutus',
	'field4' => '4. Tulokset/tuotokset ja niiden analysointi',
	'field5' => '5. Raportointi'
);


$grade = getGrade($_SESSION['username'], $thesisID);

echo "<div id='thesisGrade'><h3>Your evaluation</h3>";
foreach($thesisGrade as $key => $field){		
    echo "<label style='width:400px;'>$field: </label><input type='text' readonly value='$grade[$key]'><br>";
}

echo "<br><label style='text-align:center;'>Comment</label><br><textarea cols='80' rows='5' readonly>{$grade['comment']}</textarea><br><br>";

echo "<a href='supervisor_main.php' class='content'>Back</a>";


echo "</section>";
?>