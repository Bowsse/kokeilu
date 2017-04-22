<?php
include("links.php");
include("header.php");
include("admin_permission.php");

// function from library for hashing password
$passLib = new PasswordLib\PasswordLib();

$personID = isset($_POST['username']) ? $_POST['username'] : '';
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
$role = isset($_POST['roleSelection']) ? $_POST['roleSelection'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (isset($_POST['submit'])) {
	// password hash
	$hash = $passLib->createPasswordHash($password,  '$2a$', array('cost' => 12));
	
    $sql = <<<SQLEND
    INSERT INTO Person (
    personID,
    firstname,
    lastname,
    permission,
    email,
    password
    ) VALUES (
    :f1,
    :f2,
    :f3,
    :f4,
    :f5,
    :f6
    );
SQLEND;
    
    $prepairs = array(':f1' => $personID, ':f2' => $firstname, ':f3' => $lastname, ':f4' => $role, ':f5' => $email, ':f6' => $hash);
    $stmt = $db->prepare($sql);
    $stmt->execute($prepairs);
    header('Location: admin_main.php');
    exit;
}

echo "<section class='small'>";

$form = <<<FORMEND
<div id='addUser'>
    <h3>Add user</h3>
    <form action='' method='post'>
        <label>Username: </label>
        <input type="text" name='username' required autofocus maxlength='10'><br>
        <label>Firstname: </label>
        <input type="text" name='firstname' required maxlength='60'><br>
        <label>Lastname: </label>
        <input type="text" name='lastname' required maxlength='60'><br>
        <label>Role: </label>
        <select name='roleSelection'>
            <option value='0'>Student</option>
            <option value='1'>Supervisor</option>
        </select><br>
        <label>Email: </label>
        <input type="text" name='email' required maxlength='120'><br>
        <label>Password: </label>
        <input type="password" name='password' required maxlength='60'><br>
        <input type="submit" name='submit' value='Add user'>
    </form>
</div>
FORMEND;
echo $form;

echo "<a href='admin_main.php'>Back</a>";

echo "</section>";
?>

