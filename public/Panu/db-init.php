<?php
try {
	$db = new PDO('mysql:host=mysql.labranet.jamk.fi;dbname=K2857;charset=utf8',
              'K2857', '4IwWDpojKKQcd9JY2U3hGsr50SRJaygy');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $ex) {
	echo $ex->getMessage();
}
?>