<?php
include("links.php");
include("header.php");
include("navbar.php");
include("supervisor_permission.php");
include("first_time_login.php");

function printTheses($theses)
{
    echo "<table class='theses' style='width:100%;'><tr><th>Subject</th><th>Student ID</th><th>Name</th><th>Estimated date</th><th>Latest Version</th></tr>";

    foreach ($theses as $thesis)
    {
        $info = getThesisInfo($thesis["thesisID"]);
        $thesisID = $thesis["thesisID"];
        $version = getNewestVersion($thesis["thesisID"]);
		if ($version == null) {
			$version['version'] = "No versions";
		}
        // Sickening, I know
        echo "<tr><td><a href='supervisor_thesis.php?thesisID=$thesisID'>" . $thesis["subject"] . "</a></td><td>" . $info["personID"] . " </td><td>" . $info["firstname"] . " " . $info["lastname"] . " </td><td>" . $thesis["estimatedDate"] . "</td><td>" . $version["version"]. "</td></tr>";
    }
    echo "</table>";
}
echo "<section>";
echo "<div class='content'>";

// gets theses by username and where role is "supervisor1"
$theses = getPersonThesesByRole($username, "supervisor1");
$amount = count($theses);
echo "<br><h3>$amount Theses as first supervisor (18h)</h3>";
printTheses($theses);

// gets theses by username and where role is "supervisor2"
$theses = getPersonThesesByRole($username, "supervisor2");
$amount = count($theses);
echo "<br><h3>$amount Theses as second supervisor (2h)</h3>";
printTheses($theses);

echo "</div>";
echo "</section>";
?>
