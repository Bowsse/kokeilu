<?php
/**
 * Created by PhpStorm.
 * User: NikoWee
 * Date: 5.4.2017
 * Time: 15.18
 */
function isPasswd($username,$passwd) {
    global $db;
    //tilapäisesti näin koska ei ole salasanoja tallennettuna kantaan.
    $ispasswd = $db->prepare("SELECT * FROM User WHERE userID = '".$username."'");
    $ispasswd->execute();
    $rows = $ispasswd->rowCount();
    if($rows > 0) {

        return TRUE; // OIKEIN
    }
    else {
        return FALSE; // VÄÄRIN
    }
}
function getUserinfo($username) {
    global $db;
    //tilapäisesti näin koska ei ole salasanoja tallennettuna kantaan.
    $getuserinfo = $db->prepare("SELECT * FROM User WHERE userID = '".$username."'");
    $getuserinfo->execute();
    $rows = $getuserinfo->rowCount();
    while($row = $getuserinfo->fetch()) {
    $_SESSION['firstname'] = $row['firstName'];
    $_SESSION['lastname'] = $row['lastName'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['email'] = $row['email'];
    }

}
function sendNotification($userid, $subject, $content) {

    global $db;
    $emailState = getEmailSettings($userid);
    if($emailState != FALSE) {
    //sendEmailNotification($userid, $subject, $content)//
    }
    else {
        //we dont send email notification
    }
    $line = "INSERT INTO Notification (content, subject, seen, creationDate, receiver_userID) VALUES ('".$content."', '".$subject."', 0, CURDATE(), '".$userid."')";
    $noti = $db->prepare($line);
    $noti->execute();

}
function getEmailSettings($userid) {
    return false;
}

function listUsers() {
    global $db;
    $userList = $db->prepare("SELECT * FROM User");
    $userList->execute();

    echo "<table border='0'><tr><td>UserID</td> <td>Firstname</td><td>Lastname</td><td>Email</td><td>Role</td></tr>";
    while ($rows = $userList->fetch()) {
        if($rows['role'] == "admin") {

            $role = "Coordinator";
        }
        else {
            $role = $rows['role'];
        }
        echo"<tr> 
      <td><a href='?u=".$rows['userID']."'>".$rows['userID']."</a></td>
      <td>".$rows['firstName']."</td>
      <td>".$rows['lastName']."</td>
      <td>".$rows['email']."</td>
      <td>".$role."</td>
      <td><a href='?u=".$rows['userID']."'>Open</a></td>
        </tr>";
    }
    echo "</table>";

}
function listTheses() {
    global $db;
    $thesisList = $db->prepare("SELECT * FROM Thesis");
    $thesisList->execute();
    echo "<table border='0'><tr><td>ThesisID</td> <td>Author</td><td>Supervisor 1</td><td>Supervisor 2</td><td>Estimated Date</td></tr>";
    while ($rows = $thesisList->fetch()) {
        echo"<tr> 
      <td><a href='?t=".$rows['thesisID']."'>".$rows['thesisID']."</a></td>
      <td><a href='?u=".$rows['author_userID']."'>".$rows['author_userID']."</a></td>
      <td><a href='?u=".$rows['supervisor1_userID']."'>".$rows['supervisor1_userID']."</a></td>
         <td><a href='?u=".$rows['supervisor2_userID']."'>".$rows['supervisor2_userID']."</a></td>
      <td>".$rows['estimatedDate']."</td>
      <td><a href='?u=".$rows['thesisID']."'> Open </a></td>
        </tr>";
    }
    echo "</table>";
}

function userInfo($user) {

    if($user != $_SESSION['user']) {
        if($_SESSION['role']) {
            //create table:
            //UserID
            //fName
            //lName
            //Email
            //
            //Connections: (if open thesis)
            ////
        }
    }
    else {

    }
    //TODO:
    /*
     -- show userinfo /name, role, email etc.
    -- If supervisor show current theses
    -- if student show if thesis active and supervisors
     User connections (theses etc)
    */
}
function thesisInfo($thesis) {

    //TODO:
    /*
     4 admin:
      Full info about thesis (textboxes and dropdowns)
    --Author
    --Supervisor 1 (dropdown: "Kalle Kalmaton (5/10)")
    -- Supervisor 2 (dropdown: "Erkki Esim (3/10)")
    -- Urkund, maturity, language and seminar status
    */

}