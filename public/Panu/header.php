<?php
session_start();
$username = $_SESSION['username'];

echo "<header>";

echo "<nav>";
echo "<img src='imgs/logo.png' alt='Logo' id='logo'>";

if(isset($_SESSION['username']))
{
	echo "<a href='logout.php' class='nav'>Sign out</a>";

	echo "<h2 style='display: inline;margin-left:50%' class='nav'>Logged in as {$_SESSION['username']}</h2>";
}
echo "</nav>";
echo "</header>";
?>
