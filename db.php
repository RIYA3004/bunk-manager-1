<?php
	$db = new mysqli('localhost', 'root', '', 'bunkmgr');
	//$db = new mysqli('remotemysql.com', 'RjgWnNv4Ys', 'KGvvfg1iMo', 'RjgWnNv4Ys');
	if ($db->connect_errno !== 0) {
	  die ('We are down at the moment, please try again later');
	}
?>