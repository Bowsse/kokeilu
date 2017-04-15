<?php
session_start();
include_once("head.php");
require_once("../../../db_init.php");

?>

<head>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


</head>



<section>
<!--  Thesis and user selection for developing purposes -->
			<?php

				if(isset($_POST['thesis']))
				{
					$_SESSION['thesis'] = $_POST['thesis'];

				}
				else
				{
					$_SESSION['thesis'] = 1;

				}

					echo "<H2> Thesis {$_SESSION['thesis']} selected   ";

				if(isset($_POST['person']))
				{
					$_SESSION['person'] = $_POST['person'];

				}
				else
				{
					$_SESSION['person'] = 0;

				}
			    echo ", reviewing as {$_SESSION['person']}</H2>";

			$person = $db->query("SELECT * FROM Person WHERE PersonID = '".$_SESSION['person']."'");

			echo "<h2>Reviewer</h2>";
	echo "<table border='1'>\n";

	echo "<tr><td>ID</td><td>first</td><td>last</td><td>permission</td><td>email</td></tr>\n";

	while($row = $person->fetch(PDO::FETCH_ASSOC)) {
	  echo "<tr><td>{$row['personID']}</td><td>{$row['firstName']}</td><td>{$row['lastName']}</td><td>{$row['permission']}</td><td>{$row['email']}</td></tr>\n";
	}

	echo "</table>\n";

	$thesis = $db->query("SELECT * FROM Thesis WHERE thesisID = '".$_SESSION['thesis']."'");

	echo "<h2>Thesis</h2>";
	echo "<table border='1'>\n";

	echo "<tr><td>ID</td><td>estimated date</td><td>subject</td></tr>\n";

	while($row = $thesis->fetch(PDO::FETCH_ASSOC)) {
	  echo "<tr><td>{$row['thesisID']}</td><td>{$row['estimatedDate']}</td><td>{$row['subject']}</td></tr>\n";
	}

	echo "</table>\n";

			?>

</section>

<?php include_once("evaluation_form.php"); ?>

<?php

//TODO: Count averages by looping through form
//TODO: session shit and confirmation popup?



?>

