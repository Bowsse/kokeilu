<?php
session_start();
$username = $_SESSION['username'];

echo "<header>";

echo "<nav>";
echo "<img src='imgs/logo.png' alt='Logo' id='logo'>";


echo "<h2 style='display: inline;' class='nav'>JAMK - Theses service</h2>";


if(isset($_SESSION['username']))
{
	echo "<a href='logout.php' class='nav'>Sign out</a>";

	echo "<h2 style='display: inline;margin-left:10%;' class='nav'>Logged in as {$_SESSION['username']}</h2>";
}

echo "</nav>";
echo "</header>";
?>
