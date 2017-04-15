<?php session_start();
require_once('mysql.php');
include_once('functions.php');

?>
<!DOCTYPE html>
<html>
<head>

    <?php
    /*
    <link href="css/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="css/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
    <link href="css/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->
    */
/**
 * Created by PhpStorm.
 * User: NikoWee
 * Date: 5.4.2017
 * Time: 15.50
 */

if(isset($_SESSION['ses']))
{  $secret = md5($_SESSION['firstname'].$_SESSION['lastname']);?>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log("Ajaxia alotellaan!");
        $.ajax({
            type:"POST",
            url: "./data/notifications.php",
            //force to handle it as text
            data:
                {
                    user:"<?php echo $_SESSION['user']; ?>",
                    secret:"<?php echo $secret; ?>"
                },
            dataType: "JSON",
            success: function(data) {
                var json = data;
                var jsonSize = json.length;
                console.log(data);
                if(jsonSize == 0) {
                    $('#notifications').append('<div class="notification"><h3> No notifications </h3></div>');
                }
                else {
                for (var i=0;i<jsonSize;++i)
                    {
                        var contents = json[i].content;
                        var subject = json[i].subject;
                        var date = json[i].creationDate;
                        var printline = '<div class="notification"><h3>'+subject+'</h3>'+'<span>'+date+'</span><p>'+contents+'</p></div>';
                        console.log(printline);
                        $('#notifications').append(printline);
                    }
                }
            }
            ,
            error: function(xhr) {
                //Do Something to handle error
            }
        });
        });

    </script>

</head>
<body>
<div id="leftbox" style="left:0; float:left; width:18%; padding:0;">&nbsp</div>
<div id='container' style='width:60%; float:left; border:1px solid black; margin: 0 auto; padding:0;'>

    <?php
    if($_SESSION['role'] == "admin") {
        echo
        "
        <ul style:'margin:0 auto;'>
        <li><a href='?s=users'> Users </a></li>
        <li><a href='?s=theses'> Theses </a></li>
        </ul>
        ";
        //show users
         // check if open theses
        if(isset($_GET['s'])) {

            if($_GET['s'] == users) {
                //show all users
                listUsers();
            }
            if($_GET['s'] == theses) {
                listTheses();
                //show theses
            }
        }
        //theses control page
        if(isset($_GET['t'])) {
            //get information about current thesis
            if($_GET['t'] != null) {
                 thesisInfo($_GET['t']);
            }
        }
        if(isset($_GET['u'])) {
            //userinformation
            if($_GET['u'] != null) {
                  userInfo($_GET['u']);
             }
        }




    }


    ?>

</div>
<div id="rightbox" style="right:0; width:18%; float:left; padding:0; margin:0;">
    <?php
    echo $_SESSION['user'].
        "<br>"
        .$_SESSION['firstname']. " " .$_SESSION['lastname']. " " .$_SESSION['email'].
        "<br>"
        .$_SESSION["role"];
    $user = $_SESSION['user'];

    echo "<div id='notifications' style='padding-left: 3px;'></div>"; ?>

    <?php

    echo "<br><a href='logout.php'> Logout </a></div>";
} else {
    include("loginpage.php");
?>
<?php
}
?>

</body>
</html>

