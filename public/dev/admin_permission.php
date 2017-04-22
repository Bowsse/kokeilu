<?php
$permission = $_SESSION['permission'];

if ($permission != 1337) {
	session_destroy();
	header("Location: login.php");
	exit;
}
?>
