<?php
/**
 * Created by PhpStorm.
 * User: NikoWee
 * Date: 11.4.2017
 * Time: 13.55
 */
?>
</head>
<body>
<h2>Login as </h2>
<form method="post" action="login.php">

    <select name="roles">
        <option value="s1234">Student</option>
        <option value="kilko">Coordinator</option>
        <option value="oiloh">Supervisor 1</option>
        <option value="jaroh">Supervisor 2</option>
    </select>
    <br><br>
    <input type="submit" name='login' value="Login">
</form>