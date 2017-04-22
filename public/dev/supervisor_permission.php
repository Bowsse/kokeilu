<?php
$permission = $_SESSION['permission'];

if ($permission != 1) {
	session_destroy();
	header("Location: login.php");
	exit;
}
?>