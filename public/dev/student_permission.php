<?php
$permission = $_SESSION['permission'];

if ($permission != 0) {
	session_destroy();
	header("Location: login.php");
	exit;
}
?>