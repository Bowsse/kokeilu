<?php
include_once("header.php");
require_once("links.php");

?>

<head>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


</head>

<?php
if(isset($_POST["comments"]))
{
	$_SESSION['grade1'] = ($_POST["11"] + $_POST["12"] + $_POST["13"]) / 3;
	$_SESSION['grade2'] = ($_POST["21"] + $_POST["22"] + $_POST["23"] + $_POST["24"]) / 4;
	$_SESSION['grade3'] = ($_POST["31"] + $_POST["32"] + $_POST["33"]) / 3;
	$_SESSION['grade4'] = ($_POST["41"] + $_POST["42"] + $_POST["43"]) / 3;
	$_SESSION['grade5'] = ($_POST["51"] + $_POST["52"] + $_POST["53"]) / 3;

	$_SESSION['comment'] = $_POST["comments"];
}


echo "<section class='wide'>";

if(isset($_SESSION['thesisID']))
{

$duplicateCheck = getGrade($_SESSION['username'], $_SESSION['thesisID']);

	if (empty($duplicateCheck))
	{
	
		$sql = "INSERT INTO Grade (comment, field1, field2, field3, field4, field5, Person_personID, Thesis_thesisID) VALUES ('".$_SESSION['comment']."','".$_SESSION['grade1']."', '".$_SESSION['grade2']."','".$_SESSION['grade3']."', '".$_SESSION['grade4']."',  '".$_SESSION['grade5']."','".$_SESSION['username']."', '".$_SESSION['thesisID']."')";

		$db->exec($sql);
	


echo "<h2>Grades submitted!</h2>";
echo "<a href='supervisor_main.php' class='content'>Return</a>";


}

	
	else
	{

		echo "<h2>You have already given final review.</h2>";
		echo "<a href='supervisor_main.php' class='content'>Return</a>";
	}


	

}

echo "</section>";
echo "<section class='wide'>";


if(isset($_SESSION['thesisID']))
{
	$grades = $db->query("SELECT * FROM Grade WHERE Thesis_thesisID = '".$_SESSION['thesisID']."' AND Person_personID = '".$_SESSION['username']."'");


	echo "<h2>Your evaluation of thesisID {$_SESSION['thesisID']}</h2>";

	echo "<table border='1'>\n";

	echo "<tr><td>ID</td><td>comment</td><td>grade 1</td><td>grade 2</td><td>grade 3</td><td>grade 4</td><td>grade 5</td><td>reviewer</td><td>thesis ID</td></tr>\n";

	while($row = $grades->fetch(PDO::FETCH_ASSOC)) {
	  echo "<tr><td>{$row['gradeID']}</td><td>{$row['comment']}</td><td>{$row['field1']}</td><td>{$row['field2']}</td><td>{$row['field3']}</td><td>{$row['field4']}</td><td>{$row['field5']}</td><td>{$row['Person_personID']}</td><td>{$row['Thesis_thesisID']}</td></tr>\n";
	}

	echo "</table>\n";

	
}


echo "</section>";

?>


