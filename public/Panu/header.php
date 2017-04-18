<?php
session_start();
$username = $_SESSION['username'];

echo "<header>";

echo "<nav>";
echo "<img src='imgs/logo.png' alt='Logo' id='logo'>";

echo "<a href='logout.php' class='nav'>Sign out</a>";

echo "</nav>";
echo "</header>";
?>
