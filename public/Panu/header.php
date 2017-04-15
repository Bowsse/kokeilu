<?php
session_start();
echo "<h1>JAMK - Theses service</h1>";
echo "<h3>Student view</h3>";

$username = $_SESSION['username'];

echo "<p>Logged as <strong>$username</strong></p>";
echo "<a href='logout.php'>sign out</a> </br>";
?>