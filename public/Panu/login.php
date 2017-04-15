<?php
include("links.php");
session_start();

if (!empty($_POST['username']) AND !empty($_POST['password'])) {
	$username = $_POST['username'];
   	$password = $_POST['password'];
	
	// gets username and password
	$data = getLoginData($username, $password);
	
	if ($username == $data['personID'] and $password == $data['password']) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['loggedin'] = true;
		
		// gets permission value
		$permission = getPersonPermission($username);
		$permission = $permission['permission'];
		// student permission 		id = 0
		// supervisor permission 	id = 1
		// admin permission 		id = 2
		if ($permission == 0) { 
			header("Location: student_thesis.php");
			exit;
		}
		else if ($permission == 1) {
			header("Location: supervisor.php");
			exit;
		}
		else if ($permission == 2) {
			header("Location: admin.php");
			exit;
		}
	}
	else {
		echo "Error: Username or password wrong<br>";
	}
	
}

		

?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<label>Username:</label><br>
	<input type="text" name="username" autofocus="on" required><br>
	<label>Password:</label><br>
	<input type="password" name="password" autocomplete="off" required><br>
	<br><input type="submit" value="Login"><br>
</form>
