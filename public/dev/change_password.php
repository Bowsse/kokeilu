<?php
include("links.php");
include("header.php");

$passLib = new PasswordLib\PasswordLib();

$permission = $_SESSION['permission'];
$username = $_SESSION['username'];

$oldpassword = isset($_POST['oldpassword']) ? $_POST['oldpassword']: '';
$newpassword1 = isset($_POST['newpassword1']) ? $_POST['newpassword1']: '';
$newpassword2 = isset($_POST['newpassword2']) ? $_POST['newpassword2']: '';

echo "<section class='small'>";

if (isset($_POST['submit'])) {
	// checks if passwords are not empty
	if (!empty($oldpassword) and !empty($newpassword1) and !empty($newpassword2)) {
		// checks if new passwords are the same
		if ($newpassword1 == $newpassword2) {
			// gets logindata (username and password) by username
			$data = getLoginData($username);
			// checks if username and hashed password matches in database
			// if yes - changes password
			if ($username == $data['personID'] and $passLib->verifyPasswordHash($oldpassword, $data['password'])) {
				$hash = $passLib->createPasswordHash($newpassword1, '$2a$', array('cost' => 12));
				
				$sql = "UPDATE Person SET Password = :f1 WHERE personID = :f2";
				$prepairs = array(':f1' => $hash, ':f2' => $username);
				$stmt = $db->prepare($sql);
				$stmt->execute($prepairs);
				header('Location: user_information.php');
				exit;
			}
			else {
				echo "Old password is incorrect";
			}
		}
		else {
			echo "New password not matching";
		}	
	}
}
?>

<div id="change password">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<label>Old password</label><br>
		<input type="password" name="oldpassword" autofocus="on" required><br>
		<label>New password</label><br>
		<input type="password" name="newpassword1" required><br>
		<label>Repeat new password</label><br>
		<input type="password" name="newpassword2" required><br>
		<input type="submit" name="submit" value="Change password">
	</form>
</div>

<a href="user_information.php">Back</a>

</section>