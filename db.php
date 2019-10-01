<?php
	$db = new mysqli('localhost', 'root', '', 'bunkmgr');
	if ($db->connect_errno !== 0) {
	  die ('We are down at the moment, please try again later');
	}
?>