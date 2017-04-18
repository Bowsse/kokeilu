<?php
include_once("header.php");
require_once("links.php");

if(isset($_SESSION['thesisID']))
{

	$duplicateCheck = $db->query("SELECT * FROM Grade WHERE Thesis_thesisID = '".$_SESSION['thesisID']."' AND Person_personID =  '".$_SESSION['username']."'");
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

		if(isset($_SESSION['username']))
			{

				if(isset($_POST['thesisID']))
				{
					$_SESSION['thesisID'] = $_POST['thesisID'];


					$thesis = $db->query("SELECT * FROM Thesis WHERE thesisID = '".$_SESSION['thesisID']."'");


								while($t = $thesis->fetch(PDO::FETCH_ASSOC)) {
						echo "<H2> Reviewing thesis: {$t['thesisID']}  {$t['subject']}</H2>";
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

echo "<a href='supervisor.php' class='content'>Return</a>";

echo "</section>";

include_once("evaluation_form.php");

	}	

}
else
{echo "<a href='supervisor.php' class='content'>Return</a>";}

?>

