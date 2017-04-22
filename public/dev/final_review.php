<?php
include("links.php");
include("header.php");

$thesisID = isset($_GET["thesisID"]) ? $_GET["thesisID"]: null;

if ($thesisID == null || personHasThesis($_SESSION["username"], $thesisID))
{
	echo "<section class='small'>";
    echo "You don't have a permission to view this page or it does not exist.";
    echo "</section>";
    exit;
}


if(isset($thesisID))
{

	$duplicateCheck = $db->query("SELECT * FROM Grade WHERE Thesis_thesisID = '".$thesisID."' AND Person_personID =  '".$_SESSION['username']."'");
	if(isset($duplicateCheck))
	{
		$noRows = $duplicateCheck->rowCount();

	if ($noRows != 0)
	{
		Header("Location: confirmation_page.php");
	}
}
}

?>

<head>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


</head>



<section class="wide">


<!--  Thesis and user selection for developing purposes -->
			<?php

			if ($permission == 1) {
	echo "<a href='supervisor_main.php' class='content'>Return</a>";
}
else if($permission == 0)
{
	echo "<a href='student_thesis.php' class='content'>Return</a>";
}


		if(isset($_SESSION['username']))
			{

				if(isset($thesisID))
				{

					$thesis = $db->query("SELECT * FROM Thesis WHERE thesisID = '".$thesisID."'");


								while($t = $thesis->fetch(PDO::FETCH_ASSOC)) {
						echo "<H2> Reviewing thesis: {$t['thesisID']}  {$t['subject']}</H2>";

						$_SESSION['thesisID'] = $thesisID;
					}


/*
			$person = $db->query("SELECT * FROM Person WHERE PersonID = '".$_SESSION['username']."'");

			echo "<h2>Reviewer</h2>";

	echo "<table border='1'>\n";

	echo "<tr><td>ID</td><td>first</td><td>last</td><td>permission</td><td>email</td></tr>\n";

	while($row = $person->fetch(PDO::FETCH_ASSOC)) {
	  echo "<tr><td>{$row['personID']}</td><td>{$row['firstName']}</td><td>{$row['lastName']}</td><td>{$row['permission']}</td><td>{$row['email']}</td></tr>\n";
	}


	echo "</table>\n";

	*/



echo "</section>";

include_once("evaluation_form.php");

	}	

}

?>

