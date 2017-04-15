<?php
include("../mysql.php");
if(isset($_POST['user'])) {
    global $db;
    $secret = $_POST['secret'];
    $user = $_POST['user'];
    //    if (validateSecret($user, $secret) == "OK") {

        $getnotifications = $db->prepare("SELECT notificationID,content, subject, creationDate FROM Notification WHERE receiver_userID = '$user' AND seen = 0");
        $getnotifications->execute();
        $results = $getnotifications->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
      //  $json = str_replace("&quot;", "", $json);
        echo $json;
 //  }
}

function validateSecret($usr, $secret) {
    global $db;
    $validate = $db->prepare("SELECT * From User WHERE userID = $usr");
    $fromDb = null;
    $validate->execute();
    while ($row = $db->fetchAll(PDO::FETCH_ASSOC)) {
        $lName = $row['lastName'];
        $fName = $row['firstName'];
        $fromDb= md5($fName.$lName);
    }
	if($secret = fromDb) {
    return "OK";
}
    else {
    return "NOOK";
}
}

