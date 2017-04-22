<?php
include("links.php");
include_once("header.php");

$passLib = new PasswordLib\PasswordLib();

// username and password can't be empty
if (!empty($_POST['username']) AND !empty($_POST['password'])) {
	$username = $_POST['username'];
   	$password = $_POST['password'];
	
	// gets username and password
	$data = getLoginData($username);
	
	// checks if username and password is same in the db
	if ($username == $data['personID'] and $passLib->verifyPasswordHash($password, $data['password'])) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['loggedin'] = true;
		
		// gets permission value
		$permission = getPersonPermission($username);
		$permission = $permission['permission'];
		
		$_SESSION['permission'] = $permission;
		
		// student permission 		id = 0
		// supervisor permission 	id = 1
		// admin permission 		id = 1337
        
		if ($permission == 0) { 
			header("Location: student_thesis.php");
			exit;
		}
		else if ($permission == 1) {
			header("Location: supervisor_main.php");
			exit;
		}
        else if ($permission == 1337) {
            header("Location: admin_main.php");
            exit;
        }
	}
	else {
		echo "Error: Username or password wrong<br>";
	}	
}
?>
<section class='small'>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<label>Username:</label><br>
	<input type="text" name="username" autofocus="on" required><br>
	<label>Password:</label><br>
	<input type="password" name="password" autocomplete="off" required><br>
	<br><input type="submit" class="button" value="Login"><br>
</form>

</section>
