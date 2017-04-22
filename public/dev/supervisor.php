<?php
include("links.php");
include("header.php");



$username = $_SESSION['username'];
echo "<section>";
echo "<div class='header'><h1>JAMK - Theses service</h1></div>";
echo "<div class='navigation'>";


echo "</div>";
echo "<div class='content'>";



function printTheses($theses)
{
    echo "<table style='width:100%;'><tr><th>Thesis ID</th><th>Student ID</th><th>Name</th><th>Email</th><th>Estimated date</th><th>Version</th><th>Url</th><th>Status</th></tr>";

    foreach ($theses as $thesis)
    {
        $info = getThesisInfo($thesis["thesisID"]);
        $version = getNewestVersion($thesis["thesisID"]);
        // Sickening, I know
        echo "<tr><td>" . $thesis["thesisID"] . "</td><td>" . $info[0]["personID"] . " </td><td>" . $info[0]["firstName"] . " " . $info[0]["lastName"] . " </td><td>" . $info[0]["email"] . "</td><td>" . $thesis["estimatedDate"] . "</td><td>" . $version["version"]. "</td><td><a href=" . $version["thesisUrl"]. " target='_blank'>Link</a></td><td><form action='review_page.php' method='POST'><input type='hidden' name='thesisID' value='" . $thesis["thesisID"]. "'><input type=submit value='Review'></form></td></tr>";
    }
    echo "</table>";
}


$theses = getPersonThesesByRole($username, "supervisor1");
$amount = count($theses);
echo "<br><h3>$amount Theses as first supervisor (18h)</h3>";
printTheses($theses);

$theses = getPersonThesesByRole($username, "supervisor2");
$amount = count($theses);
echo "<br><h3>$amount Theses as second supervisor (2h)</h3>";
printTheses($theses);

echo "</div>";
echo "</section>";

?>
