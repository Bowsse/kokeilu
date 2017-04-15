<?php
session_start();
/**
 * Created by PhpStorm.
 * User: NikoWee
 * Date: 5.4.2017
 * Time: 16.01
 */
    if(isset($_SESSION['ses'])) {
        $_session['ses'] = NULL;
        echo "You have been logged out";
        session_destroy();
    }
    header("Location: index.php");