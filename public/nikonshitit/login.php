<?php
session_start();
require_once("mysql.php");
include_once("functions.php");
$user = $_POST['roles'];
global $debug;
//
echo "Olet kirjautuneena nyt käyttäjänä: $user";
if(isset($_POST['login'])) {
    $username = $user;
    $passwd = " ";
    $_SESSION['user'] = $user;
    $_SESSION['ses'] = $user. "." .time();
    if(isPasswd($username,$passwd)) {
        //echo "\n Tunnus oikein ja salasana oikein"; // vain debuggia varten.

        getUserinfo($user);
        header("Location: index.php");
    }
    else {
        echo "<p>Username or password was wrong!</p>";
    }
}

?>